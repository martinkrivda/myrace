//var is_ajax_fire = 0;

manageData();

/* manage data list */
function manageData() {
    $.ajax({
        dataType: 'json',
        url: url
    }).done(function(data) {
    	manageRow(data.data);
        $('#clubs-table').DataTable({
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
	  	rows = rows + '<td>'+value.club_ID+'</td>';
	  	rows = rows + '<td>'+value.clubname+' '+value.clubname2+'</td>';
        rows = rows + '<td>'+value.clubabbr+'</td>';
        rows = rows + '<td>'+value.street+'</td>';
        rows = rows + '<td>'+value.city+'</td>';
        rows = rows + '<td>'+value.postalcode+'</td>';
        rows = rows + '<td>'+value.country+'</td>';
        rows = rows + '<td>'+value.taxid+'</td>';
        rows = rows + '<td>'+value.vatid+'</td>';
        rows = rows + '<td>'+value.web+'</td>';
        rows = rows + '<td>'+value.email+'</td>';
        rows = rows + '<td>'+value.phone+'</td>';
	  	rows = rows + '<td data-id="'+value.club_ID+'">';
        rows = rows + '<button data-toggle="modal" data-target="#edit-club" class="btn btn-primary edit-club"><i class="fa fa-pencil"></i></button> ';
        rows = rows + '<button class="btn btn-danger remove-club"><i class="fa fa-trash-o"></i></button>';
        rows = rows + '</td>';
	  	rows = rows + '</tr>';
	});
	$("tbody").html(rows);
}

/* Create new Post */
$(".crud-submit").click(function(e) {
    if($(this).closest('form')[0].checkValidity()){
    e.preventDefault();
    var form_action = $("#create-club").find("form").attr("action");
    var clubname = $("#create-club").find("input[name='clubname']").val();
    var clubname2 = $("#create-club").find("input[name='clubname2']").val();
    var clubabbr = $("#create-club").find("input[name='clubabbr']").val();
    var street = $("#create-club").find("input[name='street']").val();
    var city = $("#create-club").find("input[name='city']").val();
    var postalcode = $("#create-club").find("input[name='postalcode']").val();
    var email = $("#create-club").find("input[name='email']").val();
    var web = $("#create-club").find("input[name='web']").val();
    var phone = $("#create-club").find("input[name='phone']").val();
    var taxid = $("#create-club").find("input[name='taxid']").val();
    var vatid = $("#create-club").find("input[name='vatid']").val();
    var country = $("#create-club").find("select[name='country']").val();
    if (clubname != '' && clubabbr !='' && country != null){
        $.ajax({
            dataType: 'json',
            type:'POST',
            url: form_action,
            data:{clubabbr:clubabbr, clubname:clubname, clubname2:clubname2, taxid:taxid, vatid:vatid, street:street, city:city, postalcode:postalcode, country:country, web:web, email:email, phone:phone},
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
            toastr.success('New club was created.', 'Success', {timeOut: 5000});
            $(".formclub").trigger("reset");
        });
    }  else {
        toastr.warning('Select country.', 'Country field must be chosen!', {timeOut: 5000});
    }
}
});

/* Remove Post */
$("body").on("click",".remove-club",function(e) {
    var club_ID = $(this).parent("td").data('id');
    var c_obj = $(this).parents("tr");
          SwalDelete(club_ID, c_obj);
          e.preventDefault();
});

function SwalDelete(club_ID, c_obj){
             swal({
                 title: 'Delete club?',
                 text: "Delete club with ID: "+club_ID+" ?",
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
                            url: url + '/' + club_ID,
                            data: {club_ID, club_ID},
                        })
                        .done(function(response){
                            c_obj.remove();
                            toastr.success('Club Deleted Successfully.', 'Success Alert', {timeOut: 5000});
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
$("body").on("click",".edit-club",function() {
    var club_ID = $(this).parent("td").data('id');
    var row = $(this).closest('tr');
    var columns = row.find('td');
    var clubname = columns[1].innerHTML;
    var clubname2 = columns[2].innerHTML;
    var clubabbr = columns[3].innerHTML;
    var street = columns[4].innerHTML;
    var city = columns[5].innerHTML;
    var postalcode = columns[6].innerHTML;
    var email = columns[7].innerHTML;
    var phone = columns[8].innerHTML;
    var taxid = columns[9].innerHTML;
    var vatid = columns[10].innerHTML;
    var country = columns[11].innerHTML;
    var web = columns[12].innerHTML;
    $("#edit-club").find("input[name='clubname']").val(clubname);
    $("#edit-club").find("input[name='clubname2']").val(clubname2);
    $("#edit-club").find("input[name='clubabbr']").val(clubabbr);
    $("#edit-club").find("input[name='street']").val(street);
    $("#edit-club").find("input[name='city']").val(city);
    $("#edit-club").find("input[name='postalcode']").val(postalcode);
    $("#edit-club").find("input[name='email']").val(email);
    $("#edit-club").find("input[name='phone']").val(phone);
    $("#edit-club").find("input[name='taxid']").val(taxid);
    $("#edit-club").find("input[name='vatid']").val(vatid);
    $("#edit-club").find("select[name='country']").val(country);
    $("#edit-club").find("input[name='web']").val(web);
    $("#edit-club").find("form").attr("action",url + '/' + club_ID);
});

/* Updated new Post */
$(".crud-submit-edit").click(function(e) {
    if($(this).closest('form')[0].checkValidity()){
    e.preventDefault();
    var form_action = $("#create-club").find("form").attr("action");
    var clubname = $("#create-club").find("input[name='clubname']").val();
    var clubname2 = $("#create-club").find("input[name='clubname2']").val();
    var clubabbr = $("#create-club").find("input[name='clubabbr']").val();
    var street = $("#create-club").find("input[name='street']").val();
    var city = $("#create-club").find("input[name='city']").val();
    var postalcode = $("#create-club").find("input[name='postalcode']").val();
    var email = $("#create-club").find("input[name='email']").val();
    var web = $("#create-club").find("input[name='web']").val();
    var phone = $("#create-club").find("input[name='phone']").val();
    var taxid = $("#create-club").find("input[name='taxid']").val();
    var vatid = $("#create-club").find("input[name='vatid']").val();
    if (clubname != '' && clubabbr !='' && country != null){
        $.ajax({
        dataType: 'json',
        type:'PUT',
        url: form_action,
        data:{clubabbr:clubabbr, clubname:clubname, clubname2:clubname2, taxid:taxid, vatid:vatid, street:street, city:city, postalcode:postalcode, country:country, web:web, email:email, phone:phone},
    }).done(function(data){
        manageData();
        $(".modal").modal('hide');
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
        toastr.success('Club updated successfully.', 'Success', {timeOut: 5000});
    });
    }  else {
        toastr.warning('Select country.', 'Country field must be chosen!', {timeOut: 5000});
    }
}
});	