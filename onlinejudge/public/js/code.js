jQuery(document).ready(function($) {
	
	var editor = ace.edit("code_editor");
	editor.setTheme("ace/theme/chrome");
	editor.setShowPrintMargin(false) ;
	editor.getSession().setMode("ace/mode/c_cpp");

	var $lastsavedcode = '' ;

	$.getJSON("/api/draft/"+$ojid,function(data) {
		$.each(data, function(key,val) {
			if(key == 'problemdata') {
				$.each(val,function(key,val) {
					if(key=='id') $("#problemid").html(val) ;
					if(key=='title') $("#problemtitle").html(val) ;
				});
			} else if(key == 'draft') {
				$.each(val,function(key,val) {
					if(key == 'code') {
						$lastsavedcode = val ;
						editor.setValue($('<div/>').html(val).text()) ;
						editor.on("change",function() {
							$("#code_wrapper #left_menu #draft .backtitle.saved").removeClass("saved").addClass("unsaved") ;
						}) ;
					} else if(key == 'modified') {
						$("#code_wrapper #left_menu #draft .info span#last_saved").html(val) ;
					}
				});
			}
		});
	});

/*	$.getJSON("/api/submission/problem/"+$ojid+"/user/"+$userid,function(data) {
		$.each(data, function(key,val) {
			var $id ;
			var $created ;
			var $verdict ;
			var $language ;
			$.each(val, function(key,val) {
				if(key == 'id') { $id=val ; }
				else if(key == 'created') { $created=val ; }
				else if(key == 'verdict') { $verdict=val ; }
			});
			$("#code_wrapper #left_menu #submissions").append('<div id="'+$id+'" class="submission"><div class="info">'+$id+'<br/><span id="last_saved">'+$created+'</span><br/><span id="language">'+$verdict+'</span></div><div class="loadcode"><i class="fa fa-arrow-right fa-2x" title="Load this code in the editor"></i></div></div>') ;
		});
	});
*/

	$("#save_draft").on("click",function() {
		var data = {
			code: $('<div/>').text(editor.getValue()).html()
		} ;
		$.getJSON("/api/draft/"+$ojid,data,function(data) {
			$.each(data, function(key,val) {
				if(key == 'code') {
					$lastsavedcode = val ;
				} else if(key == 'modified') {
					$("#code_wrapper #left_menu #draft .info span#last_saved").html(val) ;
				}
			});
			$("#code_wrapper #left_menu #draft .backtitle.unsaved").removeClass("unsaved").addClass("saved") ;
		});
	});

	$(".loadcode").on("click",function() {
		editor.setValue($('<div/>').html($lastsavedcode).text()) ;
		$("#code_wrapper #left_menu #draft .backtitle.unsaved").removeClass("unsaved").addClass("saved") ;
	});
});
