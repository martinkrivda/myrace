selectLastFinish();

function selectLastFinish() {
	var url = $('#readtags-table').attr('url');
    var gateway = $('#gateway').val();
    var edition_ID = $("#rfidreader").data("resource");

	$.ajax({                                      
	  url: url,         //the script to call to get data
	  dataType: 'json',
	  method: 'GET',
	  data: {gateway:gateway, edition_ID:edition_ID},    //data format   
	  error: function(xhr, status, error) {
                console.log("error", xhr.responseText);
                var err = JSON.parse(xhr.responseText);
                swal(err.message,JSON.stringify(err.errors),'error');
            }
       }).done(function(data){
            var	rows = '';
			$.each( data, function( key, value ) {
			  	rows = rows + '<tr>';
			  	rows = rows + '<td>'+value.read_ID+'</td>';
			  	rows = rows + '<td>'+value.EPC+'</td>';
		        rows = rows + '<td>'+value.gateway+'</td>';
		        rows = rows + '<td>'+value.rfid_reader+'</td>';
		        rows = rows + '<td>'+value.time+'</td>';
			  	rows = rows + '</tr>';
			});
			$("tbody").html(rows);
            toastr.success('Refresh successfull.', 'Success', {timeOut: 5000});
        });
};


$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

/* Create new Post */
$("#submit").click(function(e) {
    if($(this).closest('form')[0].checkValidity()){
    e.preventDefault();
    var form_action = $("#insert-reader").find("form").attr("action");
    console.log("click");
    var rfidtag = $("#insert-reader").find("input[name='rfid']").val();
    var gateway = $('#gateway').val();
    var edition_ID = $("#rfidreader").data("resource");
    var date = new Date();
    var y = addZero(date.getFullYear(), 2);
    var m = addZero(date.getMonth(), 2);
    var d = addZero(date.getDay(), 2);
    var h = addZero(date.getHours(), 2);
    var i = addZero(date.getMinutes(), 2);
    var s = addZero(date.getSeconds(), 2);
    var ms = addZero(date.getMilliseconds(), 3);
    var time = y + "-" + m + "-" + d + " " + h + ":" + i + ":" + s + "." + ms;
    var _token = $('input[name="_token"]').val();
    if (rfidtag != ''){
        $.ajax({
            dataType: 'json',
            type:'POST',
            url: form_action,
            data:{rfidtag:rfidtag, gateway:gateway, edition_ID:edition_ID, time:time, _token:_token},
            error: function(xhr, status, error) {
                console.log("error", xhr.responseText);
                var err = JSON.parse(xhr.responseText);
                swal(err.message,JSON.stringify(err.errors),'error');
                //alert(err.message);
            }
        }).done(function(data){
            $("#rfid").val('');
            $("#result").html(data);
            clearInput();
            selectLastFinish();
        });
    }  else {
        toastr.warning('Fill RFID tag.', 'RFID tag must be filled!', {timeOut: 5000});
    }
}
});

$("#rfidtag").submit(function() {
	return false;
});

function clearInput(){
	$("#rfidtag :input").each( function(){
		$(this).val('');
	});
}

function addZero(x,n) {
  while (x.toString().length < n) {
    x = "0" + x;
  }
  return x;
}

