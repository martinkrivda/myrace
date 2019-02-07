$(document).ready(function(){
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
    $(document).on('click', 'li', function(){
        var string = $(this).text();
        var matched = string.match(/\([0-9]{1,}\)/g).toString();
        var runner_ID = matched.replace(/[()]{1}/, "").replace(/[()]{1}/, "");
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

});
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
