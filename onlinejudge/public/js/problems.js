jQuery(document).ready(function($) {
    function print_cat(data) {
        if (data.length == 0) return;
        var tmpstr = "";
        tmpstr += "<ul>";
        $.each(data, function(key, value) {
            tmpstr += '<li value="' + value.id + '"><a href="#" data-permalink="' + value.permalink + '">' + value.name + "</a>";
            if (value.children.length != 0) tmpstr += print_cat(value.children);
            tmpstr += "</li>";
        });
        tmpstr += "</ul>";
        return tmpstr;
    }
    function gen_cat(data) {
        $("#oj_categories").append(print_cat(data));
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

        if($currentcat) {
            $('#oj_categories a[data-permalink="' + $currentcat + '"]').click();
        } 

    }
    $.getJSON("/api/categories/", gen_cat);
});
