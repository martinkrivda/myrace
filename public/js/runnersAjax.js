//var is_ajax_fire = 0;

manageData();

/* manage data list */
function manageData() {
    $.ajax({
        dataType: 'json',
        url: url
    }).done(function(data) {
    	manageRow(data.data);
        $('#runners-table').DataTable({
            retrieve: true,
            "columnDefs": [
               { "orderable": false, "targets": 8 }
            ]
        });
        //is_ajax_fire = 1;
    });
}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
/* Add new Post table row */
function manageRow(data) {
	var	rows = '';
	$.each( data, function( key, value ) {
	  	rows = rows + '<tr>';
	  	rows = rows + '<td>'+value.runner_ID+'</td>';
	  	rows = rows + '<td>'+value.firstname+'</td>';
        rows = rows + '<td>'+value.lastname+'</td>';
        rows = rows + '<td>'+value.vintage+'</td>';
        rows = rows + '<td>'+value.gender+'</td>';
        rows = rows + '<td>'+value.country+'</td>';
        rows = rows + '<td>'+value.email+'</td>';
        rows = rows + '<td>'+value.phone+'</td>';
	  	rows = rows + '<td data-id="'+value.runner_ID+'">';
        rows = rows + '<button data-toggle="modal" data-target="#edit-item" class="btn btn-primary edit-item">Edit</button> ';
        rows = rows + '<button class="btn btn-danger remove-item">Delete</button>';
        rows = rows + '</td>';
	  	rows = rows + '</tr>';
	});
	$("tbody").html(rows);
}

/* Create new Post */
$(".crud-submit").click(function(e) {
    e.preventDefault();
    var form_action = $("#create-runner").find("form").attr("action");
    var firstname = $("#create-runner").find("input[name='firstname']").val();
    var lastname = $("#create-runner").find("input[name='lastname']").val();
    var vintage = $("#create-runner").find("input[name='vintage']").val();
    var gender = $("#create-runner").find("select[name='gender']").val();
    var club = $("#create-runner").find("input[name='club']").val();
    var email = $("#create-runner").find("input[name='email']").val();
    var phone = $("#create-runner").find("input[name='phone']").val();
    var country = $("#create-runner").find("select[name='country']").val();
    $.ajax({
        dataType: 'json',
        type:'POST',
        url: form_action,
        data:{firstname:firstname, lastname:lastname, vintage:vintage, gender:gender, club:club, email:email, phone:phone, country:country}
    }).done(function(data){
        manageData();
        $(".modal").modal('hide');
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
        toastr.success('Post Created Successfully.', 'Success Alert', {timeOut: 5000});
    });
});

/* Remove Post */
$("body").on("click",".remove-item",function() {
    var id = $(this).parent("td").data('id');
    var c_obj = $(this).parents("tr");
    $.ajax({
        dataType: 'json',
        type:'delete',
        url: url + '/' + id,
    }).done(function(data) {
        c_obj.remove();
        toastr.success('Post Deleted Successfully.', 'Success Alert', {timeOut: 5000});
        getPageData();
    });
});

/* Edit Post */
$("body").on("click",".edit-item",function() {
    var id = $(this).parent("td").data('id');
    var title = $(this).parent("td").prev("td").prev("td").text();
    var details = $(this).parent("td").prev("td").text();
    $("#edit-item").find("input[name='title']").val(title);
    $("#edit-item").find("textarea[name='details']").val(details);
    $("#edit-item").find("form").attr("action",url + '/' + id);
});

/* Updated new Post */
$(".crud-submit-edit").click(function(e) {
    e.preventDefault();
    var form_action = $("#edit-item").find("form").attr("action");
    var title = $("#edit-item").find("input[name='title']").val();
    var details = $("#edit-item").find("textarea[name='details']").val();
    $.ajax({
        dataType: 'json',
        type:'PUT',
        url: form_action,
        data:{title:title, details:details}
    }).done(function(data){
        getPageData();
        $(".modal").modal('hide');
        toastr.success('Post Updated Successfully.', 'Success Alert', {timeOut: 5000});
    });
});	