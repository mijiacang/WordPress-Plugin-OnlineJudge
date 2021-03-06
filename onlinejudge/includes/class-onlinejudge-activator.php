<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/UVaOJ/WordPress-Plugin-OnlineJudge
 * @since      0.0.1
 *
 * @package    OnlineJudge
 * @subpackage OnlineJudge/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      0.0.1
 * @package    OnlineJudge
 * @subpackage OnlineJudge/includes
 * @author     Miguel Revilla <yo@miguelrevilla.com>
 */
class OnlineJudge_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    0.0.1
	 */
	public function activate() {
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();

		$db_version = 36 ;  				// INCREASE EVERYTIME A DB CHANGE STRUCTURE HAPPENS

		$installed_version = get_option('onlinejudge_db_version') ;

		if($db_version != $installed_version) {
			self::languagesTable($wpdb,$charset_collate) ;
			self::verdictsTable($wpdb,$charset_collate) ;
			self::categoriesTable($wpdb,$charset_collate) ;
			self::problemtypesTable($wpdb,$charset_collate) ;
			self::problemsTable($wpdb,$charset_collate) ;
			self::probcatTable($wpdb,$charset_collate) ;
			self::codedraftsTable($wpdb,$charset_collate) ;
			self::submissionsTable($wpdb,$charset_collate) ;
			self::judgehistoryTable($wpdb,$charset_collate) ;

			update_option('onlinejudge_db_version',$db_version) ;
		}
	}

	private function languagesTable($wpdb,$charset_collate) {
		$table_name = $wpdb->prefix . 'oj_languages' ;

		$sql = 	"CREATE TABLE $table_name (
				 id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
				 shortname TINYTEXT NOT NULL,
				 version TINYTEXT NOT NULL,
				 PRIMARY KEY (id)
				 ) $charset_collate;";

		dbDelta( $sql ) ;
	}

	private function verdictsTable($wpdb,$charset_collate) {
		$table_name = $wpdb->prefix . 'oj_verdicts' ;

		$sql = "CREATE TABLE $table_name (
				id SMALLINT UNSIGNED NOT NULL,
				shortname TINYTEXT NOT NULL,
				name TINYTEXT NOT NULL,
				PRIMARY KEY (id)
				) $charset_collate;";

		dbDelta( $sql ) ;
	}

	private function categoriesTable($wpdb,$charset_collate) {
		$table_name = $wpdb->prefix . 'oj_categories' ;

		$sql = 	"CREATE TABLE $table_name (
				 id MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
				 name TINYTEXT NOT NULL,
				 parent MEDIUMINT UNSIGNED,
				 permalink TINYTEXT NOT NULL,
				 listorder SMALLINT UNSIGNED,
				 PRIMARY KEY (id),
				 UNIQUE KEY listorder (parent,listorder),
				 FOREIGN KEY (parent) REFERENCES $table_name(id) ON DELETE NO ACTION ON UPDATE NO ACTION
				 ) $charset_collate;";

		dbDelta( $sql ) ;

// FIXME		$wpdb->insert($table_name,array('id'=>0,'name'=>'root','permalink'=>'root','listorder'=>0)) ;
	}

	private function problemtypesTable($wpdb,$charset_collate) {
		$table_name = $wpdb->prefix . 'oj_problemtypes' ;

		$sql = 	"CREATE TABLE $table_name (
				id MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
				name TINYTEXT NOT NULL,
				PRIMARY KEY (id)
				) $charset_collate;";

		dbDelta ( $sql ) ;
	}

	private function problemsTable($wpdb,$charset_collate) {
		$table_name = $wpdb->prefix . 'oj_problems' ;
		$problemtypes = $wpdb->prefix . 'oj_problemtypes' ;

		$sql = 	"CREATE TABLE $table_name (
				id MEDIUMINT UNSIGNED NOT NULL,
				title TINYTEXT NOT NULL,
				problemtype MEDIUMINT UNSIGNED NOT NULL,
				timelimit SMALLINT UNSIGNED NOT NULL,
				memorylimit MEDIUMINT UNSIGNED NOT NULL,
				uri TINYTEXT NOT NULL,
				created DATETIME NOT NULL,
				modified DATETIME NOT NULL,
				PRIMARY KEY (id),
				FOREIGN KEY (problemtype) REFERENCES $problemtypes(id) ON DELETE NO ACTION ON UPDATE NO ACTION
				) $charset_collate;";

		dbDelta( $sql ) ;
	}

	private function probcatTable($wpdb,$charset_collate) {
		$table_name = $wpdb->prefix . 'oj_probcat' ;
		$categories = $wpdb->prefix . 'oj_categories' ;
		$problems = $wpdb->prefix . 'oj_problems' ;

		$sql = 	"CREATE TABLE $table_name (
				category MEDIUMINT UNSIGNED NOT NULL,
				problem MEDIUMINT UNSIGNED NOT NULL,
				listorder SMALLINT UNSIGNED NOT NULL,
				PRIMARY KEY (category,problem),
				UNIQUE KEY listorder (category,problem,listorder),
				FOREIGN KEY (category) REFERENCES $categories(id) ON DELETE NO ACTION ON UPDATE NO ACTION,
				FOREIGN KEY (problem) REFERENCES $problems(id) ON DELETE NO ACTION ON UPDATE NO ACTION
				) $charset_collate;";

		dbDelta( $sql ) ;
	}

	private function codedraftsTable($wpdb,$charset_collate) {
		$table_name = $wpdb->prefix . 'oj_codedrafts' ;
		$users = $wpdb->prefix . 'users' ;
		$problems = $wpdb->prefix . 'oj_problems' ;
		$languages = $wpdb->prefix . 'oj_languages' ;

		$sql = 	"CREATE TABLE $table_name (
				problem MEDIUMINT UNSIGNED NOT NULL,
				user BIGINT(20) UNSIGNED NOT NULL,
				language SMALLINT UNSIGNED NOT NULL,
				code TEXT,
				created DATETIME NOT NULL,
				modified DATETIME NOT NULL,
				PRIMARY KEY (user,problem),
				FOREIGN KEY (problem) REFERENCES $problems(id) ON DELETE NO ACTION ON UPDATE NO ACTION,
				FOREIGN KEY (user) REFERENCES $users(id) ON DELETE NO ACTION ON UPDATE NO ACTION,
				FOREIGN KEY (language) REFERENCES $languages(id) ON DELETE NO ACTION ON UPDATE NO ACTION
				) $charset_collate;";

		dbDelta( $sql ) ;
	}

	private function submissionsTable($wpdb,$charset_collate) {
		$table_name = $wpdb->prefix . 'oj_submissions' ;
		$users = $wpdb->prefix . 'users' ;
		$problems = $wpdb->prefix . 'oj_problems' ;
		$languages = $wpdb->prefix . 'oj_languages' ;

		$sql = 	"CREATE TABLE $table_name (
				id INT UNSIGNED NOT NULL AUTO_INCREMENT,
				user BIGINT(20) UNSIGNED NOT NULL,
				problem MEDIUMINT UNSIGNED NOT NULL,
				language SMALLINT UNSIGNED NOT NULL,
				created DATETIME NOT NULL,
				PRIMARY KEY (id),
				FOREIGN KEY (user) REFERENCES $users(id) ON DELETE NO ACTION ON UPDATE NO ACTION,
				FOREIGN KEY (problem) REFERENCES $problems(id) ON DELETE NO ACTION ON UPDATE NO ACTION,
				FOREIGN KEY (language) REFERENCES $languages(id) ON DELETE NO ACTION ON UPDATE NO ACTION
				) $charset_collate;";

		dbDelta( $sql ) ;
	}

	private function judgehistoryTable($wpdb,$charset_collate) {
		$table_name = $wpdb->prefix . 'oj_judgehistory' ;
		$submissions = $wpdb->prefix . 'oj_submissions' ;
		$verdicts = $wpdb->prefix . 'oj_verdicts' ;

		$sql = 	"CREATE TABLE $table_name (
				submission INT UNSIGNED NOT NULL,
				verdict SMALLINT UNSIGNED NOT NULL,
				timeusage SMALLINT UNSIGNED NOT NULL,
				memoryusage MEDIUMINT UNSIGNED NOT NULL,
				created DATETIME NOT NULL,
				reason TINYTEXT NOT NULL,
				PRIMARY KEY (submission,created),
				FOREIGN KEY (submission) REFERENCES $submissions(id) ON DELETE NO ACTION ON UPDATE NO ACTION,
				FOREIGN KEY (verdict) REFERENCES $verdicts(id) ON DELETE NO ACTION ON UPDATE NO ACTION
				) $charset_collate;";

		dbDelta( $sql ) ;
	}
}
