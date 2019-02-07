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
            rows = rows + '<td><input type="checkbox" id="activebox" checked></td>';
        } else {
            rows = rows + '<td><input type="checkbox" id="activebox"></td>';
        }
        rows = rows + '<td>'+value.lastlogin+'</td>';
        rows = rows + '<td data-id="'+value.id+'">';
        rows = rows + '<button data-toggle="modal" data-target="#edit-user" class="btn btn-small btn-info edit-user"><i class="fa fa-pencil"></i></button> ';
        rows = rows + '<button class="btn btn-danger remove-user"><i class="fa fa-trash-o"></i></button>';
        rows = rows + '</td>';
        rows = rows + '</tr>';
    });
    $("#users-table").find("tbody").html(rows);
}

/* Create new Post */
$(".crud-submit").click(function(e) {
    if($(this).closest('form')[0].checkValidity()){
    e.preventDefault();
    var form_action = $("#create-runner").find("form").attr("action");
    var firstname = $("#create-runner").find("input[name='firstname']").val();
    var lastname = $("#create-runner").find("input[name='lastname']").val();
    var yearofbirth = $("#create-runner").find("input[name='yearofbirth']").val();
    var gender = $("#create-runner").find("select[name='gender']").val();
    var club = $("#create-runner").find("input[name='club']").val();
    var club_ID = $("#create-runner").find("input[name='club_ID']").val();
    var email = $("#create-runner").find("input[name='email']").val();
    var phone = $("#create-runner").find("input[name='phone']").val();
    var country = $("#create-runner").find("select[name='country']").val();
    if (firstname != '' && lastname !='' && yearofbirth != '' && country != null && gender != null){
        $.ajax({
            dataType: 'json',
            type:'POST',
            url: form_action,
            data:{firstname:firstname, lastname:lastname, yearofbirth:yearofbirth, gender:gender, club:club, club_ID:club_ID, email:email, phone:phone, country:country},
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
            $("#create-runner").find("input[name='club_ID']").val(null);
            toastr.success('New runner was created.', 'Success', {timeOut: 5000});
            $(".formrunner").trigger("reset");
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
                            toastr.success('Runner Deleted Successfully.', 'Success Alert', {timeOut: 5000});
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
    var yearofbirth = columns[3].innerHTML;
    var club = columns[4].innerHTML;
    var club_ID = columns[4].id;
    var gender = columns[5].innerHTML;
    var country = columns[6].innerHTML;
    var email = columns[7].innerHTML;
    var phone = columns[8].innerHTML;
    if (email == 'null'){email = ''};
    if (phone == 'null'){phone = ''};
    $("#edit-runner").find("input[name='firstname']").val(firstname);
    $("#edit-runner").find("input[name='lastname']").val(lastname);
    $("#edit-runner").find("input[name='yearofbirth']").val(yearofbirth);
    $("#edit-runner").find("input[name='club']").val(club);
    $("#edit-runner").find("input[name='club_ID']").val(club_ID);
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
    var yearofbirth = $("#edit-runner").find("input[name='yearofbirth']").val();
    var gender = $("#edit-runner").find("select[name='gender']").val();
    var club = $("#create-runner").find("input[name='club']").val();
    var club_ID = $("#create-runner").find("input[name='club_ID']").val();
    var email = $("#edit-runner").find("input[name='email']").val();
    var phone = $("#edit-runner").find("input[name='phone']").val();
    var country = $("#edit-runner").find("select[name='country']").val();
    if (firstname != '' && lastname !='' && yearofbirth != '' && country != null && gender != null){
        $.ajax({
        dataType: 'json',
        type:'PUT',
        url: form_action,
        data:{firstname:firstname, lastname:lastname, yearofbirth:yearofbirth, gender:gender, club:club, club_ID:club_ID, email:email, phone:phone, country:country},
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

$(document).ready(function(){

    $('#club').keyup(function(){ 
        var query = $(this).val();
        searchclub(query);  
    });
    $('#club').click(function(){
        var query = $(this).val();
        searchclub(query);  
    });

     $('#clubedit').keyup(function(){ 
        var query = $(this).val();
        searchclubedit(query);  
    });
    $('#clubedit').click(function(){
        var query = $(this).val();
        searchclubedit(query);  
    });

    $(document).on('click', 'li', function(){
        var string = $(this).text();
        var club = string.split(" - ",3);
        $('#club').val(club[0]);
        $('#club_ID').val(club[2]);  
        $('#livesearchclubs').fadeOut();  
    });
    $(document).on('click', 'div', function(){  
        $('#livesearchclubs').fadeOut();  
    });
    $(document).on('click', 'li', function(){
        var string = $(this).text();
        var club = string.split(" - ",3);
        $('#clubedit').val(club[0]);
        $('#club_ID').val(club[2]);  
        $('#livesearchclubsedit').fadeOut();  
    });
    $(document).on('click', 'div', function(){  
        $('#livesearchclubsedit').fadeOut();  
    });  

    function searchclub(query){
        if(query != '')
        {
         var _token = $('input[name="_token"]').val();
         $.ajax({
          url:"/clubs/searchclub",
          method:"POST",
          data:{query:query, _token:_token},
          success:function(data){
           $('#livesearchclubs').fadeIn();  
                    $('#livesearchclubs').html(data);
          }
         });
        }
    }

    function searchclubedit(query){
        if(query != '')
        {
         var _token = $('input[name="_token"]').val();
         $.ajax({
          url:"/clubs/searchclub",
          method:"POST",
          data:{query:query, _token:_token},
          success:function(data){
           $('#livesearchclubsedit').fadeIn();  
                    $('#livesearchclubsedit').html(data);
          }
         });
        }
    }

});