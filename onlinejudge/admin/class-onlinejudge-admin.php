<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/UVaOJ/WordPress-Plugin-OnlineJudge
 * @since      0.0.1
 *
 * @package    OnlineJudge
 * @subpackage OnlineJudge/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    OnlineJudge
 * @subpackage OnlineJudge/admin
 * @author     UVa Online Judge
 */
class OnlineJudge_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.0.1
	 * @access   private
	 * @var      string    $onlinejudge    The ID of this plugin.
	 */
	private $onlinejudge;

	/**
	 * The version of this plugin.
	 *
	 * @since    0.0.1
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.0.1
	 * @param      string    $onlinejudge       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $onlinejudge, $version ) {

		$this->onlinejudge = $onlinejudge;
		$this->version = $version;

		add_action('admin_menu', array($this,'create_admin_menu')) ;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    0.0.1
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in OnlineJudge_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The OnlineJudge_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->onlinejudge, plugin_dir_url( __FILE__ ) . 'css/onlinejudge-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    0.0.1
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in OnlineJudge_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The OnlineJudge_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->onlinejudge, plugin_dir_url( __FILE__ ) . 'js/onlinejudge-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function create_admin_menu() {
		add_menu_page( 'OnlineJudge Dashboard' , 'OnlineJudge' , 'manage_options' , 'onlinejudge' , array($this,'onlinejudge_dashboard') ,'' ,4 ) ;
		add_submenu_page( 'onlinejudge', 'OnlineJudge Languages', 'Languages', 'manage_options', 'onlinejudge_languages', array($this,'onlinejudge_languages')) ;
		add_action('admin_init', array($this,'onlinejudge_register_settings')) ;
	}

	public function onlinejudge_dashboard() {
		?>
		<div class="wrap">
		<h2>OnlineJudge Dashboard</h2>
		</div>
		<?php
	}

	public function onlinejudge_languages() {
		?>
		<div class="wrap">
		<h2>OnlineJudge Languages</h2>
		</div>
		<?php
	}

	public function onlinejudge_options() {
		?>  
		<div class="wrap">
		<h2>OnlineJudge Dashboard</h2>
		<form method="post" action="options.php">
		<?php settings_fields('onlinejudge') ; ?>
		<?php do_settings_sections('onlinejudge_settings') ; ?>
		</form>
		</div>
		<?php
	}

	public function onlinejudge_register_settings() {
		register_setting('onlinejudge','onlinejudge') ;

		add_settings_section('onlinejudge_integration','Plugins to integrate OnlineJudge with',array($this,'onlinejudge_integration_text'),'onlinejudge_settings') ;
		add_settings_field('bpgroupsIntegration','BuddyPress Groups',array($this,'onlinejudge_bpgroupsIntegration'),'onlinejudge_settings','onlinejudge_integration') ;
		add_settings_field('bpglobalsearchIntegration','BuddyPress Global Search',array($this,'onlinejudge_bpglobalsearchIntegration'),'onlinejudge_settings','onlinejudge_integration') ;
		add_settings_field('submit','',array($this,'onlinejudge_submit'),'onlinejudge_settings','onlinejudge_integration') ;
	}

	public function onlinejudge_integration_text() {
		    ?><p>Select the plugins to integrate OnlineJudge with</p><?php
	}

	public function onlinejudge_submit() {
		    submit_button() ;
	}

	public function onlinejudge_bpgroupsIntegration() {
		$setting_value = get_option('onlinejudge') ;
		$setting_value = (isset($setting_value['bpgroupsIntegration']) ? $setting_value['bpgroupsIntegration'] : null ) ;
		if($setting_value) { $checked = ' checked="checked" '; }
		?><input type="checkbox" name="onlinejudge[bpgroupsIntegration]" <?php echo $checked ; ?> id="bpgroupsIntegration"/><label for="bpgroupsIntegration">Add OnlineJudge functions to BP Groups</label><?php
	}

	public function onlinejudge_bpglobalsearchIntegration() {
		$setting_value = get_option('onlinejudge') ;
		$setting_value = (isset($setting_value['bpglobalsearchIntegration']) ? $setting_value['bpglobalsearchIntegration'] : null );
		if($setting_value) { $checked = ' checked="checked" '; }
		?><input type="checkbox" name="onlinejudge[bpglobalsearchIntegration]" <?php echo $checked ; ?> id="bpglobalsearchIntegration"/><label for="bpglobalsearchIntegration">Find problems using BP Global Search</label><?php
	}
}
