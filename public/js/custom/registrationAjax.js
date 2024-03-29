$(document).ready(function(){
 // console.log(userID);
	$("#yearofbirth").change(function(){
		var year = $(this).val();
		var gender = $( "#gender" ).val();
		selectCategory(edition_ID, year, gender);  
	});
  $("#gender").change(function(){
    var year = $("#yearofbirth").val();
    var gender = $(this).val();
    selectCategory(edition_ID, year, gender);  
  });
  $("#category").change(function(){
    var category_ID = $(this).val();
    setEntryFee(edition_ID, category_ID);  
  });

	function selectCategory(edition_ID, year, gender){
        if(year != '')
        {
         var _token = $('input[name="_token"]').val();
         $.ajax({
          url:"/race/category-data",
          method:"POST",
          data:{edition_ID:edition_ID, year:year, gender:gender, _token:_token},
          success:function(data){
          console.log(data);
          console.log(data.data.length);
          if (data.data.length > 1) {
            data.data.sort();
            data.data.reverse();
          }
          var categorybox = document.getElementById("category");
          var category_ID = data.data[0].category_ID;
          categorybox.value = category_ID;
          if (data.data.length >= 1) {
              var chosenCategory = data.data.filter(x => x.category_ID === category_ID);
              $("#entryfee").val(chosenCategory[0].entryfee);
          }
        }
        });
        }
 	}

  function setEntryFee (edition_ID, category_ID) {
    var _token = $('input[name="_token"]').val();
         $.ajax({
          url:"/race/categoryid-data",
          method:"POST",
          data:{edition_ID:edition_ID, category_ID:category_ID, _token:_token},
          success:function(data){
            if (data.data.length = 1) {
              $("#entryfee").val(data.data[0].entryfee);
          }
        }
          });
  }
  $("[name='notcompeting']").bootstrapSwitch();
  $("[name='paid']").bootstrapSwitch();
  $(document).ready(function() {
  $('#registrationsum').select2();
  document.getElementById("searchdirectory").focus();
});

  $('#searchdirectory').keyup(function(){ 
        var query = $(this).val();
        searchrunner(query);  
    });
    $('#searchdirectory').click(function(){
        var query = $(this).val();
        var runner_ID = $("#runner_ID").val();
        if (runner_ID >= 1 || runner_ID == null){
          $("#searchdirectory").val("");
        }
        searchrunner(query);  
    });
    $(document).on('click', 'div', function(){  
        $('#livesearchrunners').fadeOut();  
    });
    $('#livesearchrunners').on('click', 'li', function(){
        var string = $(this).text();
        if(string != null){
          var matched = string.match(/\([0-9]{1,}\)/g).toString();
          var runner_ID = matched.replace(/[()]{1}/, "").replace(/[()]{1}/, "");
        }
        $('#searchdirectory').val(string);
        var _token = $('input[name="_token"]').val();
         $.ajax({
          url:"/runners/searchrunnerid",
          method:"POST",
          data:{runner_ID:runner_ID, _token:_token},
          success:function(data){
            $('#firstname').val(data.data[0].firstname);
            $('#lastname').val(data.data[0].lastname);
            $('#runner_ID').val(data.data[0].runner_ID);
            $('#gender').val(data.data[0].gender);
            $('#yearofbirth').val(data.data[0].yearofbirth);
            $('#email').val(data.data[0].email);
            $('#phone').val(data.data[0].phone);
            $('#country').val(data.data[0].country);
            $('#club').val(data.data[0].clubname);
            $('#club_ID').val(data.data[0].club_ID);
            $('#importid').val(data.data[0].importid);
            var year = $("#yearofbirth").val();
            var gender = $( "#gender" ).val();
            selectCategory(edition_ID, year, gender);

          }
         });
        $('#livesearchrunners').fadeOut();
    });

    function searchrunner(query){
        if(query != '')
        {
         var _token = $('input[name="_token"]').val();
         $.ajax({
          url:"/runners/searchrunner",
          method:"POST",
          data:{query:query, _token:_token},
          success:function(data){
           $('#livesearchrunners').fadeIn();  
                    $('#livesearchrunners').html(data);
          }
         });
        }
    }

    $('#club').keyup(function(){ 
        var query = $(this).val();
        searchclub(query);  
    });
    $('#club').click(function(){
        var query = $(this).val();
        searchclub(query);  
    });
    $('#livesearchclubs').on('click', 'li', function(){
        var clubname = $(this).text();
        var club = clubname.split(" - ",3);
        $('#club').val(club[0]);
        $('#club_ID').val(club[2]);  
        $('#livesearchclubs').fadeOut();  
    });
    $(document).on('click', 'div', function(){  
        $('#livesearchclubs').fadeOut();  
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

});

/* Create new Post */
$(".crud-submit").click(function(e) {
    if($(this).closest('form')[0].checkValidity()){
      e.preventDefault();
      var edition_ID = $("#create-registration").data("resource");
      var runner_ID = $("#create-registration").find("input[name='runner_ID']").val();
      var firstname = $("#create-registration").find("input[name='firstname']").val();
      var lastname = $("#create-registration").find("input[name='lastname']").val();
      var yearofbirth = $("#create-registration").find("input[name='yearofbirth']").val();
      var gender = $("#create-registration").find("select[name='gender']").val();
      var club = $("#create-registration").find("input[name='club']").val();
      var club_ID = $("#create-registration").find("input[name='club_ID']").val();
      var email = $("#create-registration").find("input[name='email']").val();
      var phone = $("#create-registration").find("input[name='phone']").val();
      var country = $("#create-registration").find("select[name='country']").val();
      var entryfee = $("#create-registration").find("input[name='entryfee']").val();
      var bib_nr = $("#create-registration").find("input[name='bib_nr']").val();
      var category = $("#create-registration").find("select[name='category']").val();
      var importid = $("#create-registration").find("input[name='importid']").val();
      var notcompeting = $('#notcompeting:checked').val()?1:0;
      var paid = $('#paid:checked').val()?1:0;
      var note = $("#create-registration").find("textarea[name='note']").val();
      var registrationsum = $("#create-registration").find("select[name='registrationsum']").val();
      var form_action = $("#create-registration").attr("action");
      var _token = $('meta[name=csrf-token]').attr('content');
      if (firstname != '' && lastname !='' && yearofbirth != '' && category != null && country != null && gender != null){
        var formData = {edition_ID, runner_ID, firstname, lastname, yearofbirth, gender, club, club_ID, email, phone, country, entryfee, bib_nr, category, notcompeting, paid, importid, note, registrationsum, _token, form_action};
        $.ajax({
            dataType: 'json',
            type:'POST',
            url: '/registrations/searchexisting',
            data:{firstname, lastname, yearofbirth, edition_ID, runner_ID, _token:_token},
            error: function(xhr, status, error) {
                console.log("error", xhr.responseText);
                var err = JSON.parse(xhr.responseText);
                swal(err.message,JSON.stringify(err.errors),'error');
            }
        }).done(function(data){
          if (data != 'null'){
            toastr.warning('The same registration already exists.', 'Warning', {timeOut: 5000});
            const swalWithBootstrapButtons = Swal.mixin({
              confirmButtonClass: 'btn btn-success',
              cancelButtonClass: 'btn btn-danger',
              buttonsStyling: false,
            })
            swalWithBootstrapButtons.fire({
              title: 'Are you sure?',
              text: "It seems that the same registration already exists!",
              type: 'warning',
              showCancelButton: true,
              confirmButtonText: 'Yes, create new one!',
              cancelButtonText: 'No, cancel!',
              reverseButtons: true
            }).then((result) => {
              if (result.value) {
                storeToDatabase(formData);
              } else if (
                // Read more about handling dismissals
                result.dismiss === Swal.DismissReason.cancel
              ) {
                swalWithBootstrapButtons.fire(
                  'Cancelled',
                  'The action was cancelled',
                  'warning'
                )
                return;
              }
            });
          } else {
            storeToDatabase(formData);
          }
        });

    }  else {
        toastr.warning('Select gender, category and country.', 'Gender, category and country fields must be chosen!', {timeOut: 5000});
    }
  }
});

/* Create new Post */
$(".crud-edit").click(function(e) {
    if($(this).closest('form')[0].checkValidity()){
      e.preventDefault();
      var edition_ID = $("#create-registration").data("resource");
      var runner_ID = $("#create-registration").find("input[name='runner_ID']").val();
      var firstname = $("#create-registration").find("input[name='firstname']").val();
      var lastname = $("#create-registration").find("input[name='lastname']").val();
      var yearofbirth = $("#create-registration").find("input[name='yearofbirth']").val();
      var gender = $("#create-registration").find("select[name='gender']").val();
      var club = $("#create-registration").find("input[name='club']").val();
      var club_ID = $("#create-registration").find("input[name='club_ID']").val();
      var email = $("#create-registration").find("input[name='email']").val();
      var phone = $("#create-registration").find("input[name='phone']").val();
      var country = $("#create-registration").find("select[name='country']").val();
      var entryfee = $("#create-registration").find("input[name='entryfee']").val();
      var bib_nr = $("#create-registration").find("input[name='bib_nr']").val();
      var category = $("#create-registration").find("select[name='category']").val();
      var notcompeting = $('#notcompeting:checked').val()?1:0;
      var paid = $('#paid:checked').val()?1:0;
      var note = $("#create-registration").find("textarea[name='note']").val();
      var registrationsum = $("#create-registration").find("select[name='registrationsum']").val();
      var form_action = $("#create-registration").attr("action");
      var _token = $('meta[name=csrf-token]').attr('content');
      if (firstname != '' && lastname !='' && yearofbirth != '' && category != null && country != null && gender != null){
        var formData = {edition_ID, runner_ID, firstname, lastname, yearofbirth, gender, club, club_ID, email, phone, country, entryfee, bib_nr, category, notcompeting, paid, note, registrationsum, _token, form_action};
        $.ajax({
            dataType: 'json',
            type:'POST',
            url: '/registrations/ischangedname',
            data:{firstname, lastname, yearofbirth, runner_ID, _token:_token},
            error: function(xhr, status, error) {
                console.log("error", xhr.responseText);
                var err = JSON.parse(xhr.responseText);
                swal(err.message,JSON.stringify(err.errors),'error');
            }
        }).done(function(data){
          if (data == true){
            toastr.warning('Name of runner is different than in the database.', 'Warning', {timeOut: 5000});
            const swalWithBootstrapButtons = Swal.mixin({
              confirmButtonClass: 'btn btn-success',
              cancelButtonClass: 'btn btn-danger',
              buttonsStyling: false,
            })
            swalWithBootstrapButtons.fire({
              title: 'Are you sure?',
              text: "Do you really want rewrite the name in the runner table?",
              type: 'warning',
              showCancelButton: true,
              confirmButtonText: 'Yes, rewrite it!',
              cancelButtonText: 'No, cancel!',
              reverseButtons: true
            }).then((result) => {
              if (result.value) {
                updateToDatabase(formData);
              } else if (
                // Read more about handling dismissals
                result.dismiss === Swal.DismissReason.cancel
              ) {
                swalWithBootstrapButtons.fire(
                  'Cancelled',
                  'The action was cancelled',
                  'warning'
                )
                return;
              }
            });
          } else {
            updateToDatabase(formData);
          }
        });
    }  else {
        toastr.warning('Select gender, category and country.', 'Gender, category and country fields must be chosen!', {timeOut: 5000});
    }
  }
});

function storeToDatabase (formData) {
  console.log(formData.runner_ID);
  if(formData.runner_ID == '-1' || formData.runner_ID == ''){
        $.ajax({
            dataType: 'json',
            type:'POST',
            url: '/runners/searchsimilar',
            data:{firstname:formData.firstname, lastname:formData.lastname, yearofbirth:formData.yearofbirth, _token:formData._token},
            error: function(xhr, status, error) {
                console.log("error", xhr.responseText);
                var err = JSON.parse(xhr.responseText);
                swal(err.message,JSON.stringify(err.errors),'error');
                //alert(err.message);
            }
        }).done(function(data){
          console.log(data);
          if (data != 'null'){
            toastr.warning('Found existing runner.', 'Warning', {timeOut: 5000});
            formData.runner_ID = data.runner_ID;
            if(formData.email == ''){formData.email = data.email}
          }
        });
      }
        $.ajax({
            dataType: 'json',
            type:'POST',
            url: formData.form_action,
            data:{edition_ID:formData.edition_ID, runner_ID:formData.runner_ID, firstname:formData.firstname, lastname:formData.lastname, yearofbirth:formData.yearofbirth, gender:formData.gender, club:formData.club, club_ID:formData.club_ID, email:formData.email, phone:formData.phone, country:formData.country, entryfee:formData.entryfee, bib_nr:formData.bib_nr, category:formData.category, registrationsum:formData.registrationsum, notcompeting:formData.notcompeting, paid:formData.paid, importid:formData.importid, note:formData.note, _token:formData._token},
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
            toastr.success('Registration was updated successfully.', 'Success', {timeOut: 5000});
            $("#create-registration").find("input[name='club_ID']").val(null);
            $("#create-registration").find("input[name='runner_ID']").val(null);
        });
}

function updateToDatabase (formData) {
  if(formData.runner_ID == '-1' || formData.runner_ID == ''){
        $.ajax({
            dataType: 'json',
            type:'POST',
            url: '/runners/searchsimilar',
            data:{firstname:formData.firstname, lastname:formData.lastname, yearofbirth:formData.yearofbirth, _token:formData._token},
            error: function(xhr, status, error) {
                console.log("error", xhr.responseText);
                var err = JSON.parse(xhr.responseText);
                swal(err.message,JSON.stringify(err.errors),'error');
                //alert(err.message);
            }
        }).done(function(data){
          if (data != 'null'){
            toastr.warning('Found existing runner.', 'Warning', {timeOut: 5000});
            formData.runner_ID = data.runner_ID;
            if(formData.email == ''){formData.email = data.email}
          }
        });
      }
        $.ajax({
            dataType: 'json',
            type:'PUT',
            url: formData.form_action,
            data:{edition_ID:formData.edition_ID, runner_ID:formData.runner_ID, firstname:formData.firstname, lastname:formData.lastname, yearofbirth:formData.yearofbirth, gender:formData.gender, club:formData.club, club_ID:formData.club_ID, email:formData.email, phone:formData.phone, country:formData.country, entryfee:formData.entryfee, bib_nr:formData.bib_nr, category:formData.category, registrationsum:formData.registrationsum, notcompeting:formData.notcompeting, paid:formData.paid, note:formData.note, _token:formData._token},
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
            toastr.success('Registration was updated successfully.', 'Success', {timeOut: 5000});
        });
}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
