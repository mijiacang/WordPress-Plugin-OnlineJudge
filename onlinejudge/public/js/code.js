jQuery(document).ready(function($) {
	
	var editor = ace.edit("code_editor");
	editor.setTheme("ace/theme/chrome");
	editor.setShowPrintMargin(false) ;
	editor.getSession().setMode("ace/mode/c_cpp");
	editor.on("change",function() {$("#code_wrapper #left_menu #draft .backtitle.saved").removeClass("saved").addClass("unsaved") ;});

	var $lastsavedcode = '' ;

	function jsoncallback(data) {
		$("#problemid").html(data.problemdata.id) ;
		$("#problemtitle").html(data.problemdata.title) ;
		$lastsavedcode = data.draft.code ;
		editor.setValue($('<div/>').html($lastsavedcode).text(),-1) ;
		$("#code_wrapper #left_menu #draft .backtitle.unsaved").removeClass("unsaved").addClass("saved") ;
		$("#code_wrapper #left_menu #draft .info span#last_saved").html(data.draft.modified) ;
	}

	function loadsubmissions(data) {
		$("#code_wrapper #left_menu #submissions").html() ;
		$.each(data, function(key,val) {
			var $id = val.id ;
			var $created = val.created ;
			// var $verdict ;
			var $language = val.language ;
			$("#code_wrapper #left_menu #submissions").append('<div id="'+$id+'" class="submission"><div class="info">'+$id+'<br/><span id="last_saved">'+$created+'</span><br/><span id="language">'+$language+'</span></div><div class="loadcode"><i class="fa fa-arrow-right fa-2x" title="Load this code into the editor"></i></div></div>') ;
		});
	}

	$.getJSON("/api/draft/"+$ojid,jsoncallback) ;
	$.getJSON("/api/submissions/0/"+$ojid+"/C/0/",loadsubmissions) ;

	$("#save_draft").on("click",function() {
		var data = {
			draftcode: $('<div/>').text(editor.getValue()).html()
		} ;
		$.post("/api/draft/"+$ojid,data,jsoncallback,'json') ;
	});

	$(".loadcode").on("click",function() {
		editor.setValue($('<div/>').html($lastsavedcode).text(),-1) ;
		$("#code_wrapper #left_menu #draft .backtitle.unsaved").removeClass("unsaved").addClass("saved") ;
	});
});
