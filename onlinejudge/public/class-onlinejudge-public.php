<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/UVaOJ/WordPress-Plugin-OnlineJudge
 * @since      0.0.1
 *
 * @package    OnlineJudge
 * @subpackage OnlineJudge/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    OnlineJudge
 * @subpackage OnlineJudge/public
 * @author     UVa Online Judge
 */
class OnlineJudge_Public {

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

	private $post_types;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.0.1
	 * @param      string    $onlinejudge       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $onlinejudge, $version ) {

		$this->onlinejudge = $onlinejudge;
		$this->version = $version;

		$this->post_types = array() ;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    0.0.1
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->onlinejudge, plugin_dir_url( __FILE__ ) . 'css/onlinejudge-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    0.0.1
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( 'oj_pouchdb', plugin_dir_url( __FILE__ ) . 'js/pouchdb-6.1.0.js', array(), '6.1.0', false );
		wp_enqueue_script( 'oj_pouchdb_memory', plugin_dir_url( __FILE__ ) . 'js/pouchdb.memory.js', array( 'oj_pouchdb' ), '6.1.0', false );
		wp_enqueue_script( $this->onlinejudge, plugin_dir_url( __FILE__ ) . 'js/onlinejudge-public.js', array( 'jquery' ), $this->version, false );

	}

	private function register_api_post() {

		array_push($this->post_types,'api') ;

		register_post_type('api',
			array(
				'public' => true,
				'has_archive' => true,
				'show_ui' => false,
				'exclude_from_search' => true,
				'hierarchical' => false,
			)
		) ;

		add_rewrite_rule("api/submissions/([0-9]{1,})/([0-9]{1,})/([0-9C]{1,})/(-?[0-9]{1,})/?",
			'index.php?post_type=api&api=submissions&page=$matches[1]&problemid=$matches[2]&userid=$matches[3]&listlength=$matches[4]','top') ;

		add_filter('query_vars',function($vars){
			$vars[] = 'problemid' ;
			$vars[] = 'userid' ;
			$vars[] = 'listlength' ;
			return $vars ;
		});
	}

	private function register_problems_post() {

		array_push($this->post_types,'problems') ;

		register_post_type('problems',
			array(
				'labels' => array(
					'name' => 'Problems',
					'singular_name' => 'Problem'
				),
				'public' => true,
				'has_archive' => true,
				'show_ui' => false,
				'exclude_from_search' => true,
				'hierarchical' => true,
			)
		) ;
	}

	private function register_problem_post() {
	
		array_push($this->post_types,'problem') ;

		register_post_type('problem',
			array(
				'labels' => array(
					'name' => 'Problems',
					'singular_name' => 'Problem',
				),
				'public' => true,
				'has_archive' => false,
				'show_ui' => false,
				'exclude_from_search' => true,
				'hierarchical' => false,
			)
		) ;
	}

	private function register_contests_post() {

		array_push($this->post_types,'contests') ;

		register_post_type('contests',
			array(
				'labels' => array(
					'name' => 'Contests',
					'singular_name' => 'Contest'
				),
				'public' => true,
				'has_archive' => true,
				'show_ui' => false,
				'exclude_from_search' => true,
				'hierarchical' => true,
			)
		) ;
	}

	private function register_submissions_post() {

		array_push($this->post_types,'submissions') ;

		register_post_type('submissions',
			array(
				'labels' => array(
					'name' => 'Submissions',
					'singular_name' => 'Submission'
				),
				'public' => true,
				'has_archive' => true,
				'show_ui' => false,
				'exclude_from_search' => true,
				'hierarchical' => true,
			)
		) ;
	}

	private function register_submit_post() {

		array_push($this->post_types,'submit') ;

		register_post_type('submit',
			array(
				'labels' => array(
					'name' => 'Quick Submit',
					'singular_name' => 'Submit'
				),
				'public' => true,
				'has_archive' => true,
				'show_ui' => false,
				'exclude_from_search' => true,
				'hierarchical' => true,
			)
		) ;
	}

	private function register_code_post() {

		array_push($this->post_types,'code') ;

		register_post_type('code',
			array(
				'labels' => array(
					'name' => 'Code',
					'singular_name' => 'Code'
				),
				'public' => true,
				'has_archive' => false,
				'show_ui' => false,
				'exclude_from_search' => true,
				'hierarchical' => false,
			)
		) ;
	}

	public function custom_post_template_archive($archive_template) {
		if(is_post_type_archive('api')) {
			$archive_template = dirname(__FILE__) . '/templates/archive-api.php' ;
		} elseif(is_post_type_archive('problems')) {
			$archive_template = dirname(__FILE__) . '/templates/archive-problems.php' ;
		} elseif(is_post_type_archive('contests')) {
			$archive_template = dirname(__FILE__) . '/templates/archive-contests.php' ;
		} elseif(is_post_type_archive('submissions')) {
			$archive_template = dirname(__FILE__) . '/templates/archive-submissions.php' ;
		} elseif(is_post_type_archive('submit')) {
			$archive_template = dirname(__FILE__) . '/templates/archive-submit.php' ;
		}
		return $archive_template ;
	}

	public function custom_404_template($template) {
		global $wp_query ;

		if(is_404() && in_array(get_query_var('post_type'),$this->post_types)) {
			status_header('200');
			$wp_query->is_page = true ;
			$wp_query->is_singular = true ;
			$wp_query->is_404 = false ;
			switch(get_query_var('post_type')) {
				case 'api':
					$template = dirname(__FILE__) . '/templates/archive-api.php' ;
					break ;
				case 'problems':
					$template = dirname(__FILE__) . '/templates/archive-problems.php' ;
					break ;
				case 'problem':
					$template = dirname(__FILE__) . '/templates/single-problem.php' ;
					break ;
				case 'contests':
					$template = dirname(__FILE__) . '/templates/single-contests.php' ;
					break ;
				case 'submissions':
					$template = dirname(__FILE__) . '/templates/single-submissions.php' ;
					break ;
				case 'submit':
					$template = dirname(__FILE__) . '/templates/single-submit.php' ;
					break ;
				case 'code':
					$template = dirname(__FILE__) . '/templates/single-code.php' ;
					break ;
			}
		}

		return $template ;
	}

	public function register_post_types() {
		$this->register_api_post() ;
		$this->register_problems_post() ;
		$this->register_problem_post() ;
		$this->register_contests_post() ;
		$this->register_submissions_post() ;
		$this->register_submit_post() ;
		$this->register_code_post() ;
	}
}
