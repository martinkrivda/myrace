import config from './tag.config.js';
import BufferModule from 'buffer/';

const getCurrentUnixTime = () => Math.floor(new Date().valueOf() / 1000);
let scannedTags = [];
const Buffer = BufferModule.Buffer;

// ******************************
// Start of exported functions
// ******************************

async function readEPC(tagReader) {
  // Preparing command
  const command = Buffer.from([0x04, 0x00, 0x01]);
  const packet = Buffer.concat([command, crc(command)]);
  // Sending command packet
  await sendCommand(tagReader, packet);
  // Reading response
  const data = await readResponse(tagReader);
  // Parsing response
  if (!data) return { status: 'error' };
  const epc = await parseEPC(data);
  if (epc.status === 'ok') return { status: 'ok', epcs: epc.epcs[0].epc };
  else {
    if (epc.error !== 'fb') {
      console.log('EPC error:', epcStatus(epc.error));
    }
    return { status: 'error' };
  }
}
export default { readEPC };

// ******************************
// End of exported functions
// ******************************

async function sendCommand(tagReader, packet) {
  const writer = tagReader.writable.getWriter();
  await writer.write(packet);
  writer.releaseLock();
}

async function readResponse(tagReader) {
  const reader = tagReader.readable.getReader();
  try {
    const response = await reader.read();
    console.log(response);
    return response.value;
  } catch (error) {
    console.log(error);
  } finally {
    reader.releaseLock();
  }
}

let lastReadout = '';

async function parseEPC(Uint8Array) {
  // Convert Uint8Array to array
  const dirtyData = Array.prototype.slice.call(Uint8Array, 0);
  const data = stripFaultyBytes(dirtyData);
  // Evaluate status
  if (data.length < 4) {
    return { status: 'error', error: 'fb' };
  }
  // Skip duplicated success readings, reading bug?
  const isSame = checkAndSetLastReadout(data);
  if (isSame) {
    return { status: 'error', error: 'fu' };
  }
  // Parse packet
  // const packet_length = data[0];
  // const packet_addr = await twoPlacesHex(data[1].toString(16));
  // const packet_cmd = await twoPlacesHex(data[2].toString(16));
  const packetStatus = data[3].toString(16);
  if (packetStatus === 'fb' || packetStatus === 'f2') {
    return { status: 'error', error: 'fb' };
  } // Return status 0xFB when there is no tag in the effective field.
  // Evaulate number of scanned TAGs
  const epcCount = data[4];
  // Bad readings catch
  if (epcCount > data.length - 5 || epcCount === 0)
    return { status: 'error', error: 'fb' };
  // Parse scanned TAGs EPCs
  const epcLength = [];
  const epc = [];
  let epcPosition = 5;
  let count = 0;
  let faulty = false;
  scannedTags = [];
  for (count = 0; count < epcCount && !faulty; count++) {
    epcLength[count] = data[epcPosition];
    if (epcLength[count] > data.length - epcPosition) faulty = true;
    epcPosition += 1;
    if (!faulty) {
      epc[count] = '';
      for (let i = epcPosition; i < epcPosition + epcLength[count]; i++) {
        epc[count] += await twoPlaces(data[i]);
      }
      epcPosition = epcPosition + epcLength[count];
      // Saving scanned EPC to local array
      await updateEPC(epc[count]);
    }
  }

  if (faulty) return { status: 'error', error: 'fb' };
  return { status: 'ok', count, epcs: scannedTags };
}

// Prevent disconnected readings error, clear trailing bytes from last read
const EXPECTED_FIRST_BYTES = [19, 0, 1].join('');
const EXPECTED_FIRST_BYTES_NO_DATA = [5, 0, 1].join('');
const EXPECTED_LENGTH_OK = 20;
const EXPECTED_LENGTH_NOK = 6;
const FIRST_BYTE = 19;
// const EXPECTED_LAST_BYTE = 182;
// const EXPECTED_LAST_BYTE_NO_DATA = 61;
function stripFaultyBytes(data) {
  let parsed = [...data];
  let success = false;
  while (parsed.length > 3 && !success) {
    const threeBytesString = parsed.slice(0, 3).join('');
    if (
      threeBytesString === EXPECTED_FIRST_BYTES ||
      threeBytesString === EXPECTED_FIRST_BYTES_NO_DATA
    ) {
      success = true;
    } else parsed.shift();
  }
  if (parsed.length === 0) return parsed;
  if (parsed[0] === FIRST_BYTE)
    return parsed.length === EXPECTED_LENGTH_OK ? parsed : [];
  else
    return parsed.length === EXPECTED_LENGTH_NOK ? parsed : [];
}

// Check if data is same as in last readout
function checkAndSetLastReadout(data) {
  const dataString = data.join('');
  if (dataString === lastReadout) return true;
  lastReadout = dataString;
  return false;
}

async function updateEPC(epc) {
  const currentUnixtime = getCurrentUnixTime();
  // Check, if epc is allready scanned
  const epcIndex = isKnownEpc(epc);
  if (epcIndex > -1) {
    // Tag was previously scanned, checking his old
    const time = currentUnixtime - scannedTags[epcIndex].unixtime;
    if (time > config.scanTimeout) {
      // Is timeouted
      // Deleting old record
      scannedTags.splice(epcIndex, 1);
      // Storing new record
      saveEPC(epc, currentUnixtime);
    } else {
      // Not timeouted
      return 'exists';
    }
  } else {
    // Tag is new, lets store them
    saveEPC(epc, currentUnixtime);
  }
  return 'stored';
}

function saveEPC(epc, unixtime) {
  const data = {
    epc,
    unixtime,
  };
  scannedTags.push(data);
}

function isKnownEpc(epc) {
  return scannedTags.findIndex((tag) => tag.epc == epc);
}

const epcStatuses = {
  '01': 'Command over, and return inventoried tag’s EPC.',
  '02': 'The reader does not get all G2 tags’ EPC before user-defined Inventory-ScanTime overflows. Command force quit, and returns inventoried tags’ EPC. ',
  '03': 'The reader executes an Inventory command and gets many G2 tags’ EPC. Data can not be completed within in a message, and then send in multiple.',
  '04': 'The reader executes an Inventory command and gets G2 tags’ EPC too much, more than the storage capacity of reader, and returns inventoried tags’ EPC.',
  fb: 'Returns status 0xFB when there is no tag in the effective field.',
  f2: 'Unknown error', //TODO wtf?
  fu: 'Reader output unchanged from last reading',
};

function epcStatus(status) {
  return epcStatuses[status];
}

async function twoPlaces(number) {
  const data = number.toString(16);
  return data.length === 1 ? '0' + data : data;
}

function crc(data) {
  const PRESET_VALUE = 0xffff;
  const POLYNOMIAL = 0x8408;
  let uiCrcValue = PRESET_VALUE;
  for (let i = 0; i < data.length; i++) {
    uiCrcValue = uiCrcValue ^ data[i];
    for (let j = 0; j < 8; j++) {
      if (uiCrcValue & 0x0001) {
        uiCrcValue = (uiCrcValue >> 1) ^ POLYNOMIAL;
      } else {
        uiCrcValue = uiCrcValue >> 1;
      }
    }
  }
  const tempBuf = Buffer.from(uiCrcValue.toString(16), 'hex');
  const buf = Buffer.from([tempBuf[1], tempBuf[0]], 'hex');
  return buf;
}
