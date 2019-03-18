$("#btnGenerate").click(function(e){
    console.log("Generate start time modal")
    $.ajax({
            dataType: 'json',
            type:'POST',
            url: categoryListUrl,
            error: function(xhr, status, error) {
                console.log("error", xhr.responseText);
                var err = JSON.parse(xhr.responseText);
                swal(err.message,JSON.stringify(err.errors),'error');
                //alert(err.message);
            }
        }).done(function(data){
console.log(Object.values(data.data)[0]);
var rows = '';
$.each( data.data, function( key, value ) {
        rows = rows + '<div class="form-group"> <label for="'+value.category_ID+'">'+value.categoryname+'</label> <input type="number" step="1" min="0" max="1000" size=1000 class="form-control vacants" placeholder="Number of vacants" name="'+value.category_ID+'" id="'+value.category_ID+'"> </div>';
    });
console.log()
$("#vacants").html(rows);
        });
});

/* Generate start times */
$("#generate-submit").click(function(e) {
    $('.vacants').each(function() {
        if ($(this).val() == '') {
            $(this).val(0);
        }
    });
    var formValues = $('.vacants').serialize();
    console.log(formValues);
            $.ajax({
            dataType: 'json',
            type:'POST',
            url: generateTimeUrl,
            data: formValues,
            error: function(xhr, status, error) {
                console.log("error", xhr.responseText);
                var err = JSON.parse(xhr.responseText);
                swal(err.message,JSON.stringify(err.errors),'error');
                //alert(err.message);
            }
        }).done(function(data){
            $(".modal").modal('hide');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
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
            if(data.updates == 'Unsatisfactory number of free tags!'){
                swal('Warning!','Unsatisfactory number of free tags!', 'warning');
            }
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