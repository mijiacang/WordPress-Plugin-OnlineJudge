jQuery(document).ready(function($) {
    $("#oj_categories ul li").addClass("expand").find("ul").hide();
    $("#oj_categories ul").on("click", "li a", function() {
        window.history.pushState("state", "Title", $(this).data("permalink"));
        $.getJSON("/api/problems/" + $(this).parent("li").val(), function(data) {
            if (data.length == 0) {
                $("#oj_problems").html("No problems in this category.");
            } else {
                $("#oj_problems").html("");
                $.each(data, function(key, value) {
                    $("#oj_problems").append('<div class="oj_problem" data-ojid="' + value.ojid + '"><div class="oj_problem_title">' + value.ojid + " - " + value.title + '</div><div class="oj_problem_stats">Submissions: XX Solving rate: XX Users that tried: XX User solving rate: XX</div></div>');
                });
                $(".oj_problem").on("click", function() {
                    window.location = "/problem/" + $(this).data("ojid");
                });
            }
        });
    });
    $("#oj_categories ul").on("click", "li.collapse a", function(e) {
        $(this).parent("li").addClass("expand").removeClass("collapse").find(">ul").slideUp();
        e.stopImmediatePropagation();
    });
    $("#oj_categories ul").on("click", "li.expand a", function(e) {
        $(this).parent("li").addClass("collapse").removeClass("expand").find(">ul").slideDown();
        $(this).parent("li").siblings("li").removeClass("collapse").addClass("expand").find(">ul").slideUp();
        e.stopImmediatePropagation();
    });
    $("#oj_categories ul").on("click", "li.collapse li:not(.collapse)", function(e) {
        e.stopImmediatePropagation();
    });
	var $currentcat = window.location.href.substring(window.location.href.lastIndexOf('/') + 1);
	if($currentcat != '*') {
		if($currentcat.substring($currentcat.length-1,$currentcat.length)=='#') {
			$currentcat = $currentcat.substring(0,$currentcat.length-1);
		}
		$('#oj_categories a[data-name="'+$currentcat+'"]').click() ;
	}
});
