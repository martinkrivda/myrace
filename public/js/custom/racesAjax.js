$(document).ready(function(){
	viewData();     
	function viewData(){
		$.ajax({
        	dataType: 'json',
        	url: url
    	}).done(function(data) {
    		manageRow(data.data);
			race_tableData()
        	//is_ajax_fire = 1;
    	});
	}
	/* Add new Post table row */
	function manageRow(data) {
		var	rows = '';
		$.each( data, function( key, value ) {
		  	rows = rows + '<tr>';
		  	rows = rows + '<td>'+value.race_ID+'</td>';
		  	rows = rows + '<td>'+value.racename+'</td>';
		  	rows = rows + '<td>'+value.race_abbr+'</td>';  
		  	rows = rows + '<td>'+value.location+'</td>';
		  	rows = rows + '<td>'+value.orgname+'</td>';     
	        rows = rows + '<td>'+value.web+'</td>';
	        if(value.email != null){
				rows = rows + '<td>'+value.email+'</td>';
	        } else {
	        	rows = rows + '<td></td>';
	        }
	        if(value.phone != null){
				rows = rows + '<td>'+value.phone+'</td>';
	        } else {
	        	rows = rows + '<td></td>';
	        }
		  	rows = rows + '</tr>';
		});
		$("#races-table").find("tbody").html(rows);
	}
	function race_tableData(){
		//var	data = '';
		const data = [];
		const organisers = {};
		$.ajax({
        	dataType: 'json',
        	url: orgurl,
        }).done(function(data){
        	$.each( data, function( key, value ) {
        		var organiser_ID = value.organiser_ID;
        		var orgname = value.orgname;
        		organisers[organiser_ID] = orgname;	
        	}) 
			$('#races-table').Tabledit({
			    url: 'races-update',
			    eventType: 'dblclick',
			    columns: {
			        identifier: [0, 'race_ID'],
			        editable: [[1, 'racename'], [2, 'race_abbr'], [3, 'location'], [4, 'orgname', JSON.stringify(organisers)], [5, 'web'], [6, 'email'], [7, 'phone']]
			    },
			    onDraw: function() {
			        console.log('onDraw()');
			    },
			    onSuccess: function(data, textStatus, jqXHR) {
			        console.log('onSuccess(data, textStatus, jqXHR)');
			        console.log(data);
			        console.log(textStatus);
			        console.log(jqXHR);
			        toastr.success('Race was updated.', 'Success', {timeOut: 5000});
			        viewData()
			    },
			    onFail: function(jqXHR, textStatus, errorThrown) {
			        console.log('onFail(jqXHR, textStatus, errorThrown)');
			        console.log(jqXHR);
			        console.log(textStatus);
			        console.log(errorThrown);
			        swal('Error', data,'error');
			    },
			    onAlways: function() {
			        console.log('onAlways()');
			    },
			    onAjax: function(action, serialize) {
			        console.log('onAjax(action, serialize)');
			        console.log(action);
			        console.log(serialize);
			    }
			});
		});
	}
	/* Create new Post */
	$(".crud-race-submit").click(function(e) {
	    if($(this).closest('form')[0].checkValidity()){
	    e.preventDefault();
	    var form_action = $("#create-race").find("form").attr("action");
	    var racename = $("#create-race").find("input[name='racename']").val();
	    var location = $("#create-race").find("input[name='location']").val();
	    var organiser = $("#create-race").find("select[name='organiser']").val();
	    var race_abbr = $("#create-race").find("input[name='race_abbr']").val();
	    var web = $("#create-race").find("input[name='web']").val();
	    var email = $("#create-race").find("input[name='email']").val();
	    var phone = $("#create-race").find("input[name='phone']").val();
	    if (racename != '' && location !='' && race_abbr !='' && userID != '' && organiser != null){
	        $.ajax({
	            dataType: 'json',
	            type:'POST',
	            url: form_action,
	            data:{racename:racename, location:location, organiser_ID:organiser, race_abbr:race_abbr, web:web, email:email, phone:phone, creator_ID:userID},
	            error: function(xhr, status, error) {
	                console.log("error", xhr.responseText);
	                var err = JSON.parse(xhr.responseText);
	                swal(err.message,JSON.stringify(err.errors),'error');
	                //alert(err.message);
	            }
	        }).done(function(data){
	            viewData();
	            $(".modal").modal('hide');
	            $('body').removeClass('modal-open');
	            $('.modal-backdrop').remove();
	            toastr.success('New race was created.', 'Success', {timeOut: 5000});
	            $(".formrace").trigger("reset");
	        });
	    }  else {
	        toastr.warning('Select organiser.', 'Organiser field must be chosen!', {timeOut: 5000});
	    }
	}
	});
});