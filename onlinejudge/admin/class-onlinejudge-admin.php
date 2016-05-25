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

require_once('partials/onlinejudge-admin-ojlisttable.php') ;
require_once('partials/onlinejudge-admin-addedit.php') ;

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

		wp_enqueue_style( $this->onlinejudge, plugin_dir_url( __FILE__ ) . 'css/onlinejudge-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    0.0.1
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->onlinejudge, plugin_dir_url( __FILE__ ) . 'js/onlinejudge-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function create_admin_menu() {
		add_menu_page( 'OnlineJudge Dashboard' , 'OnlineJudge' , 'manage_options' , 'onlinejudge' , array($this,'onlinejudge_dashboard') ,'' ,4 ) ;
		add_submenu_page( 'onlinejudge', 'OnlineJudge Languages', 'Languages', 'manage_options', 'onlinejudge_languages', array($this,'onlinejudge_languages')) ;
		add_submenu_page( 'onlinejudge', 'OnlineJudge Categories', 'Categories', 'manage_options', 'onlinejudge_categories', array($this,'onlinejudge_categories')) ;
		add_submenu_page( 'onlinejudge', 'OnlineJudge Problems', 'Problems', 'manage_options', 'onlinejudge_problems', array($this,'onlinejudge_problems')) ;
		add_submenu_page( 'onlinejudge', 'OnlineJudge Contests', 'Contests', 'manage_contest', 'onlinejudge_contests', array($this,'onlinejudge_contests')) ;
		add_submenu_page( 'onlinejudge', 'OnlineJudge Submissions', 'Submissions', 'manage_options', 'onlinejudge_submissions', array($this,'onlinejudge_submissions')) ;
		add_submenu_page( 'onlinejudge', 'OnlineJudge Problem Types', 'Problem Types', 'manage_options', 'onlinejudge_problemtypes', array($this,'onlinejudge_problemtypes')) ;
		add_submenu_page( 'onlinejudge', 'OnlineJudge Verdicts', 'Verdicts', 'manage_options', 'onlinejudge_verdicts', array($this,'onlinejudge_verdicts')) ;
		add_submenu_page( 'onlinejudge', 'OnlineJudge Settings', 'Settings', 'manage_options', 'onlinejudge_settings', array($this,'onlinejudge_settings')) ;
		add_action('admin_init', array($this,'onlinejudge_register_settings')) ;
	}

	public function onlinejudge_dashboard() {
		?>
		<div class="wrap">
		<h1>OnlineJudge Dashboard</h1>
		</div>
		<?php
		echo plugins_url("/",__FILE__);

	}

	public function onlinejudge_languages() {
		if(isset($_GET['action'])) {
			switch($_GET['action']) {
				case 'add':
					$languages_add = new OnlineJudge_AdminAddEdit('Add OnlineJudge Language') ;
					$languages_add->getAddEdit() ;
			}
			return ;
		}

		$languages_admin = new OnlineJudge_AdminPage('OnlineJudge Languages',
				array('id'=>'ID','shortname'=>'Shortname','version'=>'Version'),
				'oj_languages',
				'language',
				'id ASC') ;
		$languages_admin->getAdminPage() ;
	}

	public function onlinejudge_categories() {
		if(isset($_GET['action'])) {
			switch($_GET['action']) {
				case 'add':
					$categories_add = new OnlineJudge_AdminAddEdit('Add OnlineJudge Category') ;
					$categories_add->getAddEdit() ;
			}
			return ;
		}

		$categories_admin = new OnlineJudge_AdminPage('OnlineJudge Categories',
				array('id'=>'ID','name'=>'Name','permalink'=>'Permalink'),
				'oj_categories',
				'category',
				'id ASC') ;
		$categories_admin->getAdminPage() ;
	}

	public function onlinejudge_problems() {
		if(isset($_GET['action'])) {
			switch($_GET['action']) {
				case 'add':
					$problems_add = new OnlineJudge_AdminAddEdit('Add OnlineJudge Problem') ;
					$problems_add->getAddEdit() ;
			}
			return ;
		}

		$problems_admin = new OnlineJudge_AdminPage('OnlineJudge Problems',
					array('id'=>'ID','title'=>'Title','problemtype'=>'Type','timelimit' => 'Time Limit (ms)',
					'memorylimit' => 'Mem Limit (kb)','created' => 'Created','modified' => 'Modified'),
					'oj_problems',
					'problem',
					'id ASC') ;
		$problems_admin->getAdminPage() ;
	}

	public function onlinejudge_submissions() {
		?>
		<div class="wrap">
		<h1>OnlineJudge Submissions</h1>
		</div>
		<?php
	}

	public function onlinejudge_problemtypes() {
		if(isset($_GET['action'])) {
			switch($_GET['action']) {
				case 'add':
					$problemtypes_add = new OnlineJudge_AdminAddEdit('Add OnlineJudge Problem Type') ;
					$problemtypes_add->getAddEdit() ;
			}
			return ;
		}

		$problemtypes_admin = new OnlineJudge_AdminPage('OnlineJudge Problem Types',
												array('id'=>'ID','name'=>'Name'),
												'oj_problemtypes',
												'problemtype',
												'id ASC') ;
		$problemtypes_admin->getAdminPage() ;
	}

	public function onlinejudge_verdicts() {
		if(isset($_GET['action'])) {
			switch($_GET['action']) {
				case 'add':
					$verdicts_add = new OnlineJudge_AdminAddEdit('Add OnlineJudge Verdict') ;
					$verdicts_add->getAddEdit() ;
			}
			return ;
		}

		$verdicts_admin = new OnlineJudge_AdminPage('OnlineJudge Verdicts',
				array('id'=>'ID','shortname'=>'Shortname','name'=>'Name'),
				'oj_verdicts',
				'verdict',
				'id ASC') ;
		$verdicts_admin->getAdminPage() ;
	}

	public function onlinejudge_settings() {
		?>
		<div class="wrap">
		<h1>OnlineJudge Settings</h1>
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
