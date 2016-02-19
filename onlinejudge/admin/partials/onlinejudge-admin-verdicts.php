<?php

if( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Verdicts_List_Table extends WP_List_Table {

	public function get_columns() {
		$columns = array(
			'id' => 'ID',
			'shortname' => 'Shortname',
			'name' => 'Name'
		) ;

		return $columns ;
	}

	public function prepare_items() {

		global $wpdb ;
		$verdicts_table = $wpdb->prefix.'oj_verdicts' ;

		$columns = $this->get_columns() ;
		$hidden = array() ;
		$sortable = array() ;
		$this->_column_headers = array($columns,$hidden,$sortable) ;
		$this->items = $wpdb->get_results("SELECT id,shortname,name FROM $verdicts_table ORDER BY id ASC",ARRAY_A) ;
	}

	public function column_id($item) {
		$actions = array(
			'edit' => sprintf('<a href="?page=%s&action=%s&verdict=%s">Edit</a>',$_REQUEST['page'],'edit',$item['id']),
			'delete' => sprintf('<a href="?page=%s&action=%s&verdict=%s">Delete</a>',$_REQUEST['page'],'delete',$item['id'])
		) ;

		return sprintf('%1$s %2$s', $item['id'], $this->row_actions($actions)) ;
	}

	public function column_default($item, $column_name) {
		switch($column_name) {
			case 'shortname':
			case 'name':
				return $item[$column_name] ;
		}
	}

}

class Verdicts_Admin {

	public function __construct() {

	}

	public function getAdminPage() {
		$verdicts_list = new Verdicts_List_Table() ;
		?>
		<div class="wrap">
		<h2>OnlineJudge Verdicts</h2>
		<?php
		$verdicts_list->prepare_items() ;
		$verdicts_list->display() ;
		?>
		</div>
		<?php
	}

}
?>
