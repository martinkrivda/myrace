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
		  	rows = rows + '<td>'+value.location+'</td>';
		  	rows = rows + '<td>'+value.orgname+'</td>';    
	        rows = rows + '<td>'+value.web+'</td>';
	        rows = rows + '<td>'+value.email+'</td>';
	        rows = rows + '<td>'+value.phone+'</td>';
		  	rows = rows + '</tr>';
		});
		$("tbody").html(rows);
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
        		//organisers = new Object();
        		var organiser_ID = value.organiser_ID;
        		var orgname = value.orgname;
        		organisers[organiser_ID] = orgname;	
        	}) 
			$('#races-table').Tabledit({
			    url: 'races-update',
			    eventType: 'dblclick',
			    columns: {
			        identifier: [0, 'race_ID'],
			        editable: [[1, 'racename'], [2, 'location'], [3, 'orgname', JSON.stringify(organisers)], [4, 'web'], [5, 'email'], [6, 'phone']]
			    },
			    onDraw: function() {
			        console.log('onDraw()');
			    },
			    onSuccess: function(data, textStatus, jqXHR) {
			        console.log('onSuccess(data, textStatus, jqXHR)');
			        console.log(data);
			        console.log(textStatus);
			        console.log(jqXHR);
			        viewData()
			    },
			    onFail: function(jqXHR, textStatus, errorThrown) {
			        console.log('onFail(jqXHR, textStatus, errorThrown)');
			        console.log(jqXHR);
			        console.log(textStatus);
			        console.log(errorThrown);
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
});