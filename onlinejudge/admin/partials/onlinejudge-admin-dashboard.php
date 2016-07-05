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

	public function dependenciesMB() { ?>
		<div class="inside">
		<div class="main">
		Running plugins:
		<table>
		<tr><td>Buddypress</td><td>Yes</td></tr>
		<tr><td>Yoast SEO</td><td>Yes</td></tr>
		<tr><td>bbPress</td><td>Yes</td><tr>
		</table>
		</div>
		<div class="sub">
		Check plugin dependencies status, and lets plug a looooong sentence here
		</div>
		</div>

	<?php }

	public function statusMB() { ?>
		<div class="inside">
		<div class="main">
		The system status goes here
		</div>
		<div class="sub">
		</div>
		</div>
	<?php }

	public function activityMB() { ?>
		<div class="inside">
		<div class="main">
		Latest activity
		</div>
		<div class="sub">
		</div>
		</div>
	<?php }

	public function oj_add_metaboxes() {
		add_meta_box('oj-mb-depend','Dependencies',array(&$this,'dependenciesMB'),$this->dashboard_slug,'normal') ;
		add_meta_box('oj-mb-status','System Status',array(&$this,'statusMB'),$this->dashboard_slug,'normal') ;
		add_meta_box('oj-mb-activity','Latest Activity',array(&$this,'activityMB'),$this->dashboard_slug,'side') ;
	}
}

?>
