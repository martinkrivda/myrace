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
            serverSide: false,
            responsive: true,
            "paging": true,
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
        rows = rows + '<button data-toggle="modal" data-target="#edit-runner" class="btn btn-primary edit-runner"><i class="fa fa-pencil"></i></button> ';
        rows = rows + '<button class="btn btn-danger remove-runner"><i class="fa fa-trash-o"></i></button>';
        rows = rows + '</td>';
	  	rows = rows + '</tr>';
	});
	$("tbody").html(rows);
}

/* Create new Post */
$(".crud-submit").click(function(e) {
    if($(this).closest('form')[0].checkValidity()){
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
    if (firstname != '' && lastname !='' && vintage != '' && country != null && gender != null){
        $.ajax({
            dataType: 'json',
            type:'POST',
            url: form_action,
            data:{firstname:firstname, lastname:lastname, vintage:vintage, gender:gender, club:club, email:email, phone:phone, country:country},
            error: function(xhr, status, error) {
                console.log("error", xhr.responseText);
                var err = JSON.parse(xhr.responseText);
                swal(err.message,JSON.stringify(err.errors),'error');
                //alert(err.message);
            }
        }).done(function(data){
            manageData();
            $(".modal").modal('hide');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            toastr.success('New runner was created.', 'Success', {timeOut: 5000});
        });
    }  else {
        toastr.warning('Select gender and country.', 'Gender and country fields must be chosen!', {timeOut: 5000});
    }
}
});

/* Remove Post */
$("body").on("click",".remove-runner",function(e) {
    var runner_ID = $(this).parent("td").data('id');
    var c_obj = $(this).parents("tr");
          SwalDelete(runner_ID, c_obj);
          e.preventDefault();
});

function SwalDelete(runner_ID, c_obj){
             swal({
                 title: 'Delete runner?',
                 text: "Delete runner with ID: "+runner_ID+" ?",
                 type: 'warning',
                 showCancelButton: true,
                 confirmButtonColor: '#3085d6',
                 cancelButtonColor: '#d33',
                 confirmButtonText: 'Delete',
                 showLoaderOnConfirm: true,
    
                preConfirm: function() {
                    return new Promise(function(resolve){
                        $.ajax({
        dataType: 'json',
        type:'delete',
        url: url + '/' + runner_ID,
        data: {runner_ID, runner_ID},
                        })
                        .done(function(response){
                            c_obj.remove();
                            toastr.success('Item Deleted Successfully.', 'Success Alert', {timeOut: 5000});
                            swal('Smazáno',response.message, response.status)
                            manageData();
                            
                        })
                        .fail(function(){
                            swal('Oops...', 'Something went wrong with ajax !', 'error');
                        });
                });
            },
            allowOutsideClick: true
         });
        }
/* Edit Post */
$("body").on("click",".edit-runner",function() {
    var runner_ID = $(this).parent("td").data('id');
    var row = $(this).closest('tr');
    var columns = row.find('td');
    var firstname = columns[1].innerHTML;
    var lastname = columns[2].innerHTML;
    var vintage = columns[3].innerHTML;
    var gender = columns[4].innerHTML;
    var country = columns[5].innerHTML;
    var email = columns[6].innerHTML;
    var phone = columns[7].innerHTML;
    $("#edit-runner").find("input[name='firstname']").val(firstname);
    $("#edit-runner").find("input[name='lastname']").val(lastname);
    $("#edit-runner").find("input[name='vintage']").val(vintage);
    $("#edit-runner").find("select[name='gender']").val(gender);
    $("#edit-runner").find("select[name='country']").val(country);
    $("#edit-runner").find("input[name='email']").val(email);
    $("#edit-runner").find("input[name='phone']").val(phone);
    $("#edit-runner").find("form").attr("action",url + '/' + runner_ID);
});

/* Updated new Post */
$(".crud-submit-edit").click(function(e) {
    if($(this).closest('form')[0].checkValidity()){
    e.preventDefault();
    var form_action = $("#edit-runner").find("form").attr("action");
    var firstname = $("#edit-runner").find("input[name='firstname']").val();
    var lastname = $("#edit-runner").find("input[name='lastname']").val();
    var vintage = $("#edit-runner").find("input[name='vintage']").val();
    var gender = $("#edit-runner").find("select[name='gender']").val();
    var club = $("#edit-runner").find("input[name='club']").val();
    var email = $("#edit-runner").find("input[name='email']").val();
    var phone = $("#edit-runner").find("input[name='phone']").val();
    var country = $("#edit-runner").find("select[name='country']").val();
    if (firstname != '' && lastname !='' && vintage != '' && country != null && gender != null){
        $.ajax({
        dataType: 'json',
        type:'PUT',
        url: form_action,
        data:{firstname:firstname, lastname:lastname, vintage:vintage, gender:gender, club:club, email:email, phone:phone, country:country},
    }).done(function(data){
        manageData();
        $(".modal").modal('hide');
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
        toastr.success('Runner updated successfully.', 'Success', {timeOut: 5000});
    });
    }  else {
        toastr.warning('Select gender and country.', 'Gender and country fields must be chosen!', {timeOut: 5000});
    }
}
});	