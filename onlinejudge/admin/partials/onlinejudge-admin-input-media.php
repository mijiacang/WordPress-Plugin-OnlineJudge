<?php
class OnlineJudge_AdminInputMedia {

	public function __construct() {

		add_action('admin_footer',array(&$this,'printscript')) ;
	}

	public function getMedia($value="") {

		$returnstr  = '<p>' ;
		$returnstr .= '<input type="text" value="'.$value.'" class="regular-text process_custom_images" id="process_custom_images" name="uri" readonly>' ;
		$returnstr .= '<button class="select_pdf_uri button">Select PDF</button>' ;
		$returnstr .= '</p>' ;

		return $returnstr;
	}

	public function printscript() { 

?>

		<script type="text/javascript">
			jQuery('.wrap').on('click','.select_pdf_uri', function(e) {
				e.preventDefault();
				var button = jQuery(this);
				var uri = button.prev();
				wp.media.editor.send.attachment = function(props, attachment) {
				uri.val(attachment.url);
				};
				wp.media.editor.open(button);
				return false;
			});
		</script>
	<?php }
}
?>
