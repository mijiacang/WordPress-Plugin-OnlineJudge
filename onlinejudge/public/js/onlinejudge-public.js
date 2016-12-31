(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

})( jQuery );

function oj_language(id,retry=false) {
	var db = new PouchDB('oj_languages',{adapter: 'memory'}) ;
	db.get(id.toString(),function(err,doc){
		if(err) {
			if(err.status==404 && retry == false) {
				$.getJSON('/api/languages/',function(data) {
					$.each(data,function(key,value) {
						db.put({
							_id: value.id.toString(),
							shortname: value.shortname
						});
					});
				}).done(function() {
					oj_language(id,true) ;
				});
			} else {
				return console.log(err) ;
			}
		}
			
		return console.log(doc) ;
	});
}
