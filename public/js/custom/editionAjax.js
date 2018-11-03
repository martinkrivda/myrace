//var is_ajax_fire = 0;

manageEditionData();

/* manage data list */
function manageEditionData() {
    $.ajax({
        dataType: 'json',
        url: editionurl
    }).done(function(data) {
    	manageEditionRow(data.data);
    });
}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
/* Add new Post table row */
function manageEditionRow(data) {
	var	rows = '';
	$.each( data, function( key, value ) {
	  	rows = rows + '<tr>';
	  	rows = rows + '<td>'+value.edition_ID+'</td>';
	  	rows = rows + '<td>'+value.editionname+'</td>';
        rows = rows + '<td>'+value.edition_nr+'</td>';
        rows = rows + '<td>'+value.racename+'</td>';
        rows = rows + '<td>'+value.orgname+'</td>';
        rows = rows + '<td>'+value.date+'</td>';
        rows = rows + '<td>'+value.location+'</td>';
        rows = rows + '<td>'+value.web+'</td>';
	  	rows = rows + '<td data-id="'+value.edition_ID+'">';
        rows = rows + '<button data-toggle="modal" data-target="#edit-edition" class="btn btn-small btn-info edit-edition"><i class="fa fa-pencil"></i></button> ';
        rows = rows + '<button class="btn btn-danger remove-edition"><i class="fa fa-trash-o"></i></button>';
        rows = rows + '</td>';
	  	rows = rows + '</tr>';
	});
	$("#editions-table").find("tbody").html(rows);
}

/* Create new Post */
$(".crud-edition-submit").click(function(e) {
    if($(this).closest('form')[0].checkValidity()){
    e.preventDefault();
    var form_action = $("#create-edition").find("form").attr("action");
    var editionname = $("#create-edition").find("input[name='editionname']").val();
    var edition_nr = $("#create-edition").find("input[name='edition_nr']").val();
    var race = $("#create-edition").find("select[name='race']").val();
    var date = $("#create-edition").find("input[name='date']").val();
    var firststart = $("#create-edition").find("input[name='firststart']").val();
    var location = $("#create-edition").find("input[name='location']").val();
    var gps = $("#create-edition").find("input[name='gps']").val();
    var eventoffice = $("#create-edition").find("input[name='eventoffice']").val();
    var web = $("#create-edition").find("input[name='web']").val();
    var entrydate1 = $("#create-edition").find("input[name='entrydate1']").val();
    var competition = $("#create-edition").find("input[name='competition']").val();
    var eventdirector = $("#create-edition").find("input[name='eventdirector']").val();
    var mainreferee = $("#create-edition").find("input[name='mainreferee']").val();
    var entriesmanager = $("#create-edition").find("input[name='entriesmanager']").val();
    var jury1 = $("#create-edition").find("input[name='jury1']").val();
    var jury2 = $("#create-edition").find("input[name='jury2']").val();
    var jury3 = $("#create-edition").find("input[name='jury3']").val();
    if (editionname != '' && edition_nr !='' && race != null && date != '' && firststart != ''){
        $.ajax({
            dataType: 'json',
            type:'POST',
            url: form_action,
            data:{editionname:editionname, edition_nr:edition_nr, race_ID:race, date:date, firststart:firststart, location:location, gps:gps, eventoffice:eventoffice, web:web, entrydate1:entrydate1, competition:competition, eventdirector:eventdirector, mainreferee:mainreferee, entriesmanager:entriesmanager, jury1:jury1, jury2:jury2, jury3:jury3},
            error: function(xhr, status, error) {
                console.log("error", xhr.responseText);
                var err = JSON.parse(xhr.responseText);
                swal(err.message,JSON.stringify(err.errors),'error');
                //alert(err.message);
            }
        }).done(function(data){
            manageEditionData();
            $(".modal").modal('hide');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            if (typeof data === 'object'){
                toastr.success('New race edition was created.', 'Success', {timeOut: 5000});
                $(".formedition").trigger("reset");
                location.reload();
            } else {
                swal('Error', data,'error');
            }
        });
    }  else {
        toastr.warning('Select race.', 'Race field must be chosen!', {timeOut: 5000});
    }
}
});

/* Remove Post */
$("body").on("click",".remove-edition",function(e) {
    var edition_ID = $(this).parent("td").data('id');
    var c_obj = $(this).parents("tr");
          SwalDelete(edition_ID, c_obj);
          e.preventDefault();
});

function SwalDelete(edition_ID, c_obj){
             swal({
                 title: 'Delete edition?',
                 text: "Delete edition with ID: "+edition_ID+" ?",
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
                            url: editionurl + '/' + edition_ID,
                            data: {edition_ID, edition_ID},
                        })
                        .done(function(response){
                            c_obj.remove();
                            toastr.success('Race Edition Deleted Successfully.', 'Success Alert', {timeOut: 5000});
                            swal('Smazáno',response.message, response.status)
                            manageEditionData();
                            
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
$("body").on("click",".edit-edition",function() {
    var edition_ID = $(this).parent("td").data('id');
    $.ajax({
        dataType: 'json',
        url: editionurl + '/' + edition_ID,
        data: {edition_ID, edition_ID}
    }).done(function(data) {
        var edition_ID = data.edition_ID;
        var editionname = data.editionname;
        var edition_nr = data.edition_nr;
        var race = data.race_ID;
        var date = data.date;
        var firststart = data.firststart;
        var location = data.location;
        var gps = data.gps;
        var eventoffice = data.eventoffice.replace(" ", "T");
        var web = data.web;
        var entrydate1 = data.entrydate1.replace(" ", "T");
        var competition = data.competition;
        var eventdirector = data.eventdirector;
        var mainreferee = data.mainreferee;
        var entriesmanager = data.entriesmanager;
        var jury1 = data.jury1;
        var jury2 = data.jury2;
        var jury3 = data.jury3;
        if (eventoffice == 'null'){eventoffice = ''};
        if (web == 'null'){web = ''};
        if (entrydate1 == 'null'){entrydate1 = ''};
        if (competition == 'null'){competition = ''};
        if (eventdirector == 'null'){eventdirector = ''};
        if (mainreferee == 'null'){mainreferee = ''};
        if (entriesmanager == 'null'){entriesmanager = ''};
        if (jury1 == 'null'){jury1 = ''};
        if (jury2 == 'null'){jury2 = ''};
        if (jury3 == 'null'){jury3 = ''};
        $("#edit-edition").find("input[name='editionname']").val(editionname);
        $("#edit-edition").find("input[name='edition_nr']").val(edition_nr);
        $("#edit-edition").find("input[select='race']").val(race);
        $("#edit-edition").find("input[name='date']").val(date);
        $("#edit-edition").find("input[name='firststart']").val(firststart);
        $("#edit-edition").find("input[name='location']").val(location);
        $("#edit-edition").find("input[name='gps']").val(gps);
        $("#edit-edition").find("input[name='eventoffice']").val(eventoffice);
        $("#edit-edition").find("input[name='web']").val(web);
        $("#edit-edition").find("input[name='entrydate1']").val(entrydate1);
        $("#edit-edition").find("input[name='competition']").val(competition);
        $("#edit-edition").find("input[name='eventdirector']").val(eventdirector);
        $("#edit-edition").find("input[name='mainreferee']").val(mainreferee);
        $("#edit-edition").find("input[name='entriesmanager']").val(entriesmanager);
        $("#edit-edition").find("input[name='jury1']").val(jury1);
        $("#edit-edition").find("input[name='jury2']").val(jury2);
        $("#edit-edition").find("input[name='jury3']").val(jury3);
        $("#edit-edition").find("form").attr("action",editionurl + '/' + edition_ID);
    });
});

/* Updated new Post */
$(".crud-edition-submit-edit").click(function(e) {
    if($(this).closest('form')[0].checkValidity()){
    e.preventDefault();
    var form_action = $("#edit-edition").find("form").attr("action");
    var editionname = $("#edit-edition").find("input[name='editionname']").val();
    var edition_nr = $("#edit-edition").find("input[name='edition_nr']").val();
    var race = $("#edit-edition").find("select[name='race']").val();
    var date = $("#edit-edition").find("input[name='date']").val();
    var firststart = $("#edit-edition").find("input[name='firststart']").val();
    var location = $("#edit-edition").find("input[name='location']").val();
    var gps = $("#edit-edition").find("input[name='gps']").val();
    var eventoffice = $("#edit-edition").find("input[name='eventoffice']").val();
    var web = $("#edit-edition").find("input[name='web']").val();
    var entrydate1 = $("#edit-edition").find("input[name='entrydate1']").val();
    var competition = $("#edit-edition").find("input[name='competition']").val();
    var eventdirector = $("#edit-edition").find("input[name='eventdirector']").val();
    var mainreferee = $("#edit-edition").find("input[name='mainreferee']").val();
    var entriesmanager = $("#edit-edition").find("input[name='entriesmanager']").val();
    var jury1 = $("#edit-edition").find("input[name='jury1']").val();
    var jury2 = $("#edit-edition").find("input[name='jury2']").val();
    var jury3 = $("#edit-edition").find("input[name='jury3']").val();
    if (editionname != '' && edition_nr !='' && race != null && date != '' && firststart != ''){
        $.ajax({
        dataType: 'json',
        type:'PUT',
        url: form_action,
        data:{editionname:editionname, edition_nr:edition_nr, race_ID:race, date:date, firststart:firststart, location:location, gps:gps, eventoffice:eventoffice, web:web, entrydate1:entrydate1, competition:competition, eventdirector:eventdirector, mainreferee:mainreferee, entriesmanager:entriesmanager, jury1:jury1, jury2:jury2, jury3:jury3},
    }).done(function(data){
        manageEditionData();
        $(".modal").modal('hide');
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
        toastr.success('Race Edition updated successfully.', 'Success', {timeOut: 5000});
    });
    }  else {
        toastr.warning('Select race.', 'Race field must be chosen!', {timeOut: 5000});
    }
}
});