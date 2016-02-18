<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
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
 * @author     Your Name <email@example.com>
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

		$db_version = 18 ;  				// INCREASE EVERYTIME A DB CHANGE STRUCTURE HAPPENS

		$installed_version = get_option('onlinejudge_db_version') ;

		if($db_version != $installed_version) {
			self::languagesTable($wpdb,$charset_collate) ;
			self::categoriesTable($wpdb,$charset_collate) ;

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

}
