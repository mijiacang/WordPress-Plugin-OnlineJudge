<?php

class OnlineJudge_Dashboard {

	private $dashboard_slug ;

	public function __construct($slug) {

		wp_enqueue_script( 'common' );
		wp_enqueue_script( 'wp-lists' );
		wp_enqueue_script( 'postbox' );

		$this->dashboard_slug = $slug ;
		$this->oj_add_metaboxes() ;
	}

	public function getDashboard() {
		?>
                <div class="wrap">
                <h1>OnlineJudge Dashboard</h1>
                </div>

		<?php
		global $screen_layout_columns;
		wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false );
		wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false ); ?>
		<div id="oj-dashboard-widgets" class="metabox-holder">
		<div id="postbox-container-1" class="postbox-container">
		<?php $meta_boxes = do_meta_boxes($this->dashboard_slug, 'normal', ''); ?>
		</div>
		<br class="clear"/>
		<div id="postbox-container-2" class="postbox-container">
		<?php $meta_boxes = do_meta_boxes($this->dashboard_slug, 'side', ''); ?>
		</div>
		</div>

		<script type="text/javascript">
		//<![CDATA[
		jQuery(document).ready( function($) { 
		postboxes.add_postbox_toggles('<?php echo $this->dashboard_slug;?>') ;
		});
		//]]>
		</script>
	<?php
	}

	public function dependenciesMB() {

		echo "Dependencies" ;
	}

	public function oj_add_metaboxes() {
		add_meta_box('oj-mb-depend','Dependencies',array(&$this,'dependenciesMB'),$this->dashboard_slug,'normal') ;
	}
}

?>
