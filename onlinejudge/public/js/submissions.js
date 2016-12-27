jQuery(document).ready(function($) {

function fill_table(data) {
	$('#submissions_body').html('') ;
	var $bgcolor = 0 ;
	$.each(data,function(key,val){
		$('#submissions_body').append('<tr class="color'+$bgcolor+'"><td>'+val.id+'</td><td>'+val.problem+'</td><td>'+val.user+'</td><td>N/A</td><td>'+val.language+'</td><td>N/A</td><td>'+val.created+'</td></tr>') ;
		$bgcolor = ($bgcolor==0?1:0) ;
	});
}

function call_json() {
	$.getJSON('/api/submissions/0/0/0/0/',fill_table);
}

setInterval(call_json(),1000) ;


}) ;
