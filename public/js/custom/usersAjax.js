//var is_ajax_fire = 0;

manageData();

/* manage data list */
function manageData() {
    $.ajax({
        dataType: 'json',
        url: url
    }).done(function(data) {
    	manageRow(data.data);
        $('#users-table').DataTable({
            retrieve: true,
            serverSide: false,
            responsive: true,
            "paging": true,
            "columnDefs": [
               { "orderable": false, "targets": 6 }
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
    var rows = '';
    $.each( data, function( key, value ) {
        rows = rows + '<tr>';
        rows = rows + '<td>'+value.id+'</td>';
        rows = rows + '<td>'+value.username+'</td>';
        rows = rows + '<td>'+value.lastname+' '+value.firstname+'</td>';
        rows = rows + '<td>Administrator</td>';
        if (value.active == 1){
            rows = rows + '<td><input type="checkbox" name="activebox" id="activebox" checked data-toggle="toggle" data-size="mini"></td>';
        } else {
            rows = rows + '<td><input type="checkbox" name="activebox" id="activebox" data-toggle="toggle" data-size="mini"></td>';
        }
        rows = rows + '<td>'+value.lastlogin+'</td>';
        rows = rows + '<td data-id="'+value.id+'">';
        rows = rows + '<button data-toggle="modal" data-target="#update-user" class="btn btn-small btn-info update-user"><i class="fa fa-pencil"></i></button> ';
        rows = rows + '<button class="btn btn-danger remove-user"><i class="fa fa-trash-o"></i></button>';
        rows = rows + '</td>';
        rows = rows + '</tr>';
    });
    $("#users-table").find("tbody").html(rows);
}

/* Edit Post */
$("body").on("click",".update-user",function() {
    var user_ID = $(this).parent("td").data('id');
    console.log(user_ID);
    if(user_ID > 0) {
            $.ajax({
                dataType: 'json',
                type:'GET',
                url: "/users-data/"+user_ID+"/edit",
                data:{user_ID},
                error: function(xhr, status, error) {
                    console.log("error", xhr.responseText);
                    var err = JSON.parse(xhr.responseText);
                }
            }).done(function(data){
              if (data != 'null'){
                var username = data.data.username;
                var userID = data.data.id;
                var lastname = data.data.lastname;
                var firstname = data.data.firstname;
                var email = data.data.email;
                var active = data.data.active;
                var lastlogin = data.data.lastlogin;
                 $("#update-user").find("input[name='userID']").val(userID);
                $("#update-user").find("input[name='username']").val(username);
                $("#update-user").find("input[name='lastname']").val(lastname);
                $("#update-user").find("input[name='firstname']").val(firstname);
                $("#update-user").find("input[name='email']").val(email);
                $("#update-user").find("input[name='lastlogin']").val(lastlogin);

                if(active == 1){
                    $('#active').prop('checked', true);
                } else {
                    $("#update-user").find("input[name='active']").prop('checked', false);
                }
              }
        });
    }
});

/* Updated new Post */
$(".crud-submit-edit").click(function(e) {
    if($(this).closest('form')[0].checkValidity()){
    e.preventDefault();
    var userID = $("#update-user").find("input[name='userID']").val();
    var username = $("#update-user").find("input[name='username']").val();
    var lastname = $("#update-user").find("input[name='lastname']").val();
    var firstname = $("#update-user").find("input[name='firstname']").val();
    var email = $("#update-user").find("input[name='email']").val();
    var active = $('#active:checked').val()?1:0;
    if (firstname != '' && lastname !='' && email != '' && username != '' && userID > 0){
        $.ajax({
        dataType: 'json',
        type:'PUT',
        url: /users-data/+userID,
        data:{firstname:firstname, lastname:lastname, username:username, userID:userID, email:email, active:active},
        error: function(xhr, status, error) {
                console.log("error", xhr.responseText);
                var err = JSON.parse(xhr.responseText);
                var message = "";
                Object.keys(err).forEach(function(k){
                  message += err[k];
                });
                swal('Ooops, something went wrong!',message,'error');
            }
    }).done(function(data){
        manageData();
        $(".modal").modal('hide');
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
        toastr.success('User was updated successfully.', 'Success', {timeOut: 5000});
    });
    }  else {
        toastr.warning('Fill required fields.', 'Check if it are every required field fills!', {timeOut: 5000});
    }
}
});

