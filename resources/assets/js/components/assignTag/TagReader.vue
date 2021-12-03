<template>
  <div class="row">
    <div class="col">
      <div class="box box-default">
        <div class="box-header with-border">
          <i aria-hidden="true" class="fa fa-newspaper-o"></i>

          <h3 class="box-title"></h3>
        </div>
        <!-- /.box-header -->
        <button
          v-if="!tagReaderPort"
          class="btn btn-secondary"
          type="button"
          @click="requestConnection()"
        >
          Connect
        </button>
        <span v-else>Connected!</span>
        <span v-if="tagReading">Looking for tag</span>
        <strong v-else-if="tag">Tag: {{ tag }}</strong>
        <div v-if="connectionError" class="text-danger">
          {{ connectionError }}
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
</template>

<script>
// Extra import - REMOVE FOR LARAVEL

// Added imports
import tagConfig from './tag.config.js';
import tagDriver from './tag-ru-driver.js';

export default {
  name: 'TagReader',
  components: {},
  props: {
    tag: {
      type: String,
      default: null,
    },
  },
  data() {
    return {
      tagReaderPort: null,
      portSetup: false,
      connectionError: null,
      tagReading: false,
    };
  },
  computed: {
    couldTagRead() {
      return this.tagReaderPort && !this.tagReading;
    },
  },
  watch: {
    tag: {
      handler: function (newTag) {
        if (newTag || !this.couldTagRead) return;
        this.readTag();
      },
    },
  },
  mounted() {
    this.getConnection();
    navigator.serial.addEventListener('connect', this.onConnect);
    navigator.serial.addEventListener('disconnect', this.onDisconnect);
  },
  unmounted() {
    this.closeTagPort(this.tagReaderPort);
    navigator.serial.removeEventListener('connect', this.onConnect);
    navigator.serial.removeEventListener('disconnect', this.onDisconnect);
  },
  methods: {
    onConnect(e) {
      if (this.tagReaderPort || this.portSetup) return;
      const port = e.target;
      this.checkAndOpenTagPort(port);
    },
    onDisconnect(e) {
      const port = e.target;
      if (port === this.tagReaderPort) {
        this.tagReaderPort = null;
        this.connectionError =
          'Tag reader device was disconnected. Check connection for tag reading.';
      }
    },
    async requestConnection() {
      try {
        const port = await navigator.serial.requestPort();
        this.checkAndOpenTagPort(port);
      } catch (error) {
        this.connectionError = 'No device selected for connection.';
      }
    },
    async getConnection() {
      const ports = await navigator.serial.getPorts();
      const portToUse = ports.find(
        (port) => port.getInfo().usbVendorId === tagConfig.usbVendorId
      );
      if (portToUse) this.checkAndOpenTagPort(portToUse);
    },
    async checkAndOpenTagPort(port) {
      this.portSetup = true;
      this.connectionError = null;
      const portInfo = port.getInfo();
      if (portInfo.usbVendorId === tagConfig.usbVendorId) {
        try {
          await port.open({ baudRate: tagConfig.baudRate });
          this.tagReaderPort = port;
        } catch (error) {
          console.log(error);
          this.connectionError =
            'Could not open port to tag reader. Try to reconnect.';
          this.closeTagPort(port);
          return;
        }
      } else
        this.connectionError =
          'Device connected on port not recognized as tag reader.';
      this.portSetup = false;
      if (this.couldTagRead) this.readTag();
    },
    async closeTagPort(port) {
      this.portSetup = true;
      if (port) {
        if (port.readable) await port.readable.getReader().cancel();
        if (port.writeable) await port.writeable.getWriter().cancel();
        await port.close();
      }
      this.portSetup = false;
    },
    readTag() {
      this.tagReading = true;
      setTimeout(() => this.readTagCallback(), tagConfig.readInterval);
    },
    async readTagCallback() {
      const readerResponse = await tagDriver.readEPC(this.tagReaderPort);
      if (readerResponse.status == 'ok') {
        console.log('We have this EPCs:', readerResponse.epcs);
        this.tagReading = false;
        this.$emit('tag:changed', readerResponse.epcs);
      } else {
        setTimeout(() => this.readTagCallback(), tagConfig.readInterval);
      }
    },
  },
};
</script>
