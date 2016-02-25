jQuery(document).ready(function($) {
    "use strict";
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
			});*/
			var renderContext = {
				canvasContext: context,
				viewport: viewport
			} ;
			page.render(renderContext) ;
        });
    });



    var ctx = $("#langChart").get(0).getContext("2d");
    var data = [ {
        value: 300,
        color: "#F7464A",
        highlight: "#FF5A5E",
        label: "Red"
    }, {
        value: 50,
        color: "#46BFBD",
        highlight: "#5AD3D1",
        label: "Green"
    }, {
        value: 100,
        color: "#FDB45C",
        highlight: "#FFC870",
        label: "Yellow"
    } ];
	var myDoughnutChart = new Chart(ctx).Doughnut(data) ;
//    var myDoughnutChart = new Chart(ctx).Doughnut(data, {
//        animationEasing: null
//    });
    document.getElementById("langLegend").innerHTML = myDoughnutChart.generateLegend();
});
