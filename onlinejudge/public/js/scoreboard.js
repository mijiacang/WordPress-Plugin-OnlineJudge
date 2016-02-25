jQuery(document).ready(function($) {
    var $alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    var $problems = 10;
    var $items = 20;
    var $totaltime = 18000;

    function scrollToBottom() {
        $("html, body").animate({
            scrollTop: $(document).height() - $(window).height()
        }, {
            queue: false,
            duration: $items * 1000,
            easing: "linear",
            complete: scrollToTop
        });
    }

    function scrollToTop() {
        $("html, body").animate({
            scrollTop: 0
        }, {
            queue: false,
            duration: $items * 1000,
            easing: "linear",
            complete: scrollToBottom
        });
    }

    function buildPage() {
        var $i;
        $("#scoreboardheader .header").append($("<div/>").addClass("cell").addClass("avatar").html(""));
        for ($i = 0; $i < $problems; $i++) {
            $("#scoreboardheader .header").append($("<div/>").addClass("cell").html($alphabet.substr($i, 1)));
        }
        $("#scoreboardheader .header").append($("<div/>").addClass("cell").addClass("solved").html("Solved"));
        $("#scoreboardheader .header").append($("<div/>").addClass("cell").addClass("time").html("Time"));
        for ($i = 0; $i < $items; $i++) {
            var $newrow = $("<div/>").addClass("row").attr("data-user", $i).attr("data-order", $i).attr("data-position", $i);
            if ($i % 2 == 0) {
                $newrow.addClass("color-0");
            } else {
                $newrow.addClass("color-1");
            }
            $newrow.append($("<div/>").addClass("cell").addClass("position").html($i + 1));
            $newrow.append($("<div/>").addClass("cell").addClass("avatar").html(""));
            var $contestantblock = $("<div/>").addClass("contestantblock");
            $contestantblock.append($("<div/>").addClass("contestant").html("The contestant name"));
            var $results = $("<div/>").addClass("results");
            var $j;
            for ($j = 0; $j < $problems; $j++) {
                $results.append($("<div/>").addClass("cell").addClass("submit").addClass("not").html($alphabet.substr($j, 1)));
            }
            $contestantblock.append($results);
            $newrow.append($contestantblock);
            $newrow.append($("<div/>").addClass("cell").addClass("solved").html("0"));
            $newrow.append($("<div/>").addClass("cell").addClass("time").html("0"));
            $("#scoreboard").append($newrow);
        }
        $(".cell").width(($(window).width() - 360 - ($problems + 4) * 12) / $problems);
        $(".cell.position").width(80);
        $(".cell.avatar").width(80);
        $(".cell.solved").width(80);
        $(".cell.time").width(120);
        $("#scoreboard").mixItUp({
            selectors: {
                target: ".row"
            }
        });
        $("#rightfiller").TimeCircles({
            animation: "smooth",
            circle_bg_color: "#222222",
            count_past_zero: false,
            bg_width: 1.8,
            fg_width: .05,
            text_size: .1,
            time: {
                Days: {
                    show: false
                }
            },
            total_duration: $totaltime
        });
        $("#scoreboard").css("margin-top", $("#header").height());
    }

	buildPage() ;

    $("html, body").scrollTop(0);

    $("#scoreboard").mixItUp("sort", "order:asc");
//    $("#scoreboard").mixItUp("sort", "random");

});
