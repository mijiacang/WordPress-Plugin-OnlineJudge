<?php
class OnlineJudge_AdminInputMedia {

	public function __construct() {

		add_action( 'admin_enqueue_scripts', function () {
			if (is_admin())
				wp_enqueue_media();
		} );

		add_action('admin_footer',array(&$this,'printscript')) ;
	}

	public function getMedia() {

		$returnstr  = '<p>' ;
		$returnstr .= '<input type="number" value="" class="regular-text process_custom_images" id="process_custom_images" name="" max="" min="1" step="1">' ;
		$returnstr .= '<button class="set_custom_images button">Set Image ID</button>' ;
		$returnstr .= '</p>' ;

		return $returnstr;
	}

	public function printscript() { ?>

		<script type="text/javascript">
		if (jQuery('.set_custom_images').length > 0) {
			if ( typeof wp !== 'undefined' && wp.media && wp.media.editor) {
                                jQuery('.wrap').on('click', '.set_custom_images', function(e) {
                                e.preventDefault();
                                var button = jQuery(this);
                                var id = button.prev();
                                wp.media.editor.send.attachment = function(props, attachment) {
                                id.val(attachment.id);
                                };
                                wp.media.editor.open(button);
                                return false;
                                });
                                }
                                };
		</script>
	<?php }
}
?>
