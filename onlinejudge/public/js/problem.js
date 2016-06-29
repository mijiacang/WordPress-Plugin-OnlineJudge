jQuery(document).ready(function($) {
    "use strict";

	$.getJSON("/api/problem/"+$problem_id,function(data) {
		if(data.length==0) {
			// PROBLEM DOESN'T EXIST
		} else {
			$.each(data,function(key,value) {
				$("#oj_problem_title").html(value.title) ;
				$("#oj_problem_problemtype").html(value.problemtype) ;
				$("#oj_problem_timelimit").html(value.timelimit) ;
			}) ;
		}
	}) ;

/*
    PDFJS.getDocument($pdfsrc).then(function(pdf) {
        pdf.getPage(1).then(function(page) {
            var scale = 1.5;
            var viewport = page.getViewport(scale);
            var $canvas = jQuery("<canvas></canvas>");
            var canvas = $canvas.get(0);
            var context = canvas.getContext("2d");
            canvas.height = viewport.height;
            canvas.width = viewport.width;
            jQuery("#pdfContainer").append($canvas);

			var canvasOffset = $canvas.offset() ;
			var $textLayerDiv = jQuery("<div/>")
				.addClass("textLayer")
				.css("height", viewport.height + "px")
				.css("width", viewport.width + "px")
				.offset({
					top: canvasOffset.top,
					left: canvasOffset.left
				}) ;

			jQuery("#pdfContainer").append($textLayerDiv) ;

			/*page.getTextContent().then(function(textContent) {
				var textLayer = new TextLayerBuilder($textLayerDiv.get(0),0) ;
				textLayer.setTextContent(textContent) ;

            	var renderContext = {
                	canvasContext: context,
	                viewport: viewport,
					textLayer: textLayer
    	        };

        	    page.render(renderContext);
			});////////

			var renderContext = {
				canvasContext: context,
				viewport: viewport
			} ;
			page.render(renderContext) ;
        });
    });

*/

    var ctx = $("#langChart");
    var data = {
	datasets: [{
	    data: [
		300,
		50,
		100
	    ],
	    backgroundColor: [
		"#F7464A",
		"#46BFBD",
		"#FDB45C"
	    ],
	    label: 'Problem stats'
	}],
	labels: [
	    "Red",
	    "Green",
	    "Yellow"
	]
    };

	var myDoughnutChart = new Chart(ctx,{
		type: 'doughnut',
		data: data
	});
});
