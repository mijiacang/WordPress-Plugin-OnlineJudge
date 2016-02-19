<?php

if( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Verdicts_List_Table extends WP_List_Table {

	var $sample_data = array(
		array('id' => 10, 'shortname' => 'SE', 'name' => 'Submission Error'),
		array('id' => 90, 'shortname' => 'AC', 'name' => 'Accepted')
	) ;

	public function get_columns() {
		$columns = array(
			'id' => 'ID',
			'shortname' => 'Shortname',
			'name' => 'Name'
		) ;

		return $columns ;
	}

	public function prepare_items() {
		$columns = $this->get_columns() ;
		$hidden = array() ;
		$sortable = array() ;
		$this->_column_headers = array($columns,$hidden,$sortable) ;
		$this->items = $this->sample_data ;
	}

	public function column_default($item, $column_name) {
		switch($column_name) {
			case 'id':
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
