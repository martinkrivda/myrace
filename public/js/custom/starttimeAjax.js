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
                toastr.error(err, 'Error!', {timeOut: 5000});
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
                toastr.error(err, 'Error!', {timeOut: 5000});
                //alert(err.message);
            }
        }).done(function(data){
            $(".modal").modal('hide');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            if (data.updates == 0){
                toastr.warning('Times have been already generated.', 'Nothing to generate.', {timeOut: 5000});
            } else {
                toastr.success('Start times generated.', 'Success', {timeOut: 5000});
            }
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
                swal('Warning!','Unsatisfactory number of free tags! <br /> Please add tags to database.', 'warning');
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
                toastr.error(err, 'Error!', {timeOut: 5000});
                //alert(err.message);
            }
        }).done(function(data){
            if (data.updates == 0){
                toastr.warning('Nothing to draw.', 'No times for drawing', {timeOut: 5000});
            } else {
                toastr.success('Draw start list successfull.', 'Success', {timeOut: 5000});
            }
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

$(function () {
    $('#datetimepicker1').datetimepicker({
        defaultDate: new Date(),
        format: 'YYYY-MM-DD HH:mm:ss',
        sideBySide: true
    });
});

/* Create new Post */
$(".starttime-submit").click(function(e) {
    if($(this).closest('form')[0].checkValidity()){
    e.preventDefault();
    var form_action = $("#create-starttime").find("form").attr("action");
    var start_nr = $("#create-starttime").find("input[name='start_nr']").val();
    var stime = $("#create-starttime").find("input[name='starttime']").val();
    var category = $("#create-starttime").find("select[name='category']").val();
    if (start_nr != '' && stime !='' && category != null){
        $.ajax({
            dataType: 'json',
            type:'POST',
            url: form_action,
            data:{start_nr:start_nr, stime:stime, category_ID:category},
            error: function(xhr, status, error) {
                console.log("error", xhr.responseText);
                var err = JSON.parse(xhr.responseText);
                swal(err.message,JSON.stringify(err.errors),'error');
                toastr.error(err, 'Error!', {timeOut: 5000});
                //alert(err.message);
            }
        }).done(function(data){
            $(".modal").modal('hide');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            toastr.success('New start time was created.', 'Success', {timeOut: 5000});
            var table = $('#dataTableBuilder').DataTable();
            table.ajax.reload();
            $(".formstarttime").trigger("reset");
        });
    }  else {
        toastr.warning('Select category.', 'Category field must be chosen!', {timeOut: 5000});
    }
}
});