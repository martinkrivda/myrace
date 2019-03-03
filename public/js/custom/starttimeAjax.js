/* Generate start times */
$("#generateStartTime").click(function(e) {
    console.log(generateTimeUrl);
            $.ajax({
            dataType: 'json',
            type:'POST',
            url: generateTimeUrl,
            error: function(xhr, status, error) {
                console.log("error", xhr.responseText);
                var err = JSON.parse(xhr.responseText);
                swal(err.message,JSON.stringify(err.errors),'error');
                //alert(err.message);
            }
        }).done(function(data){
            toastr.success('Start times generated.', 'Success', {timeOut: 5000});
            var table = $('#dataTableBuilder').DataTable();
            table.ajax.reload();
        });
});

/* Assign rfid tags */
$("#assignTags").click(function(e) {
    console.log(generateTimeUrl);
            $.ajax({
            dataType: 'json',
            type:'POST',
            url: assignTagsUrl,
            error: function(xhr, status, error) {
                console.log("error", xhr.responseText);
                var err = JSON.parse(xhr.responseText);
                swal(err.message,JSON.stringify(err.errors),'error');
                //alert(err.message);
            }
        }).done(function(data){
            toastr.success('RFID tags assigned to start times.', 'Success', {timeOut: 5000});
            var table = $('#dataTableBuilder').DataTable();
            table.ajax.reload();
        });
});

/* Draw start list */
$("#drawStartList").click(function(e) {
            $.ajax({
            dataType: 'json',
            type:'POST',
            url: drawStartListUrl,
            error: function(xhr, status, error) {
                console.log("error", xhr.responseText);
                var err = JSON.parse(xhr.responseText);
                swal(err.message,JSON.stringify(err.errors),'error');
                //alert(err.message);
            }
        }).done(function(data){
            toastr.success('Draw start list successfull.', 'Success', {timeOut: 5000});
            var table = $('#dataTableBuilder').DataTable();
            table.ajax.reload();
        });
});

/* Refresh */
$("#refresh").click(function(e) {
    toastr.success('Refresh.', 'Success', {timeOut: 5000});
    var table = $('#dataTableBuilder').DataTable();
    table.ajax.reload();
});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});