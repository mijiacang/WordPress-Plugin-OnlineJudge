<?php

if( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class OnlineJudge_List_Table extends WP_List_Table {

	public function __construct($columns,$fields,$table,$item,$order) {

		global $wpdb ;

		parent::__construct() ;

		$this->ojcolumns = $columns ;
		$this->fields = $fields ;
		$this->table = $wpdb->prefix.$table ;
		$this->item = $item ;
		$this->order = $order ;

		print_r($this->ojcolumns) ;
		echo $fields ;
	}

	public function get_columns() {
		return $this->columns ;
	}

	public function prepare_items() {

		global $wpdb ;

		$columns = $this->get_columns() ;
		$hidden = array() ;
		$sortable = array() ;
		$this->_column_headers = array($columns,$hidden,$sortable) ;
		$this->items = $wpdb->get_results("SELECT " . $this->fields . " FROM " . $this->table . ($this->order != '' ? " ORDER BY ".$this->order : ''),ARRAY_A) ;
	}

	public function column_id($item) {
		$actions = array(
			'edit' => sprintf('<a href="?page=%s&action=%s&' . $this->item .'=%s">Edit</a>',$_REQUEST['page'],'edit',$item['id']),
			'delete' => sprintf('<a href="?page=%s&action=%s&' . $this->item .'=%s">Delete</a>',$_REQUEST['page'],'delete',$item['id'])
		) ;

		return sprintf('%1$s %2$s', $item['id'], $this->row_actions($actions)) ;
	}

	public function column_default($item, $column_name) {
		return $item[$column_name] ;
	}

}

class OnlineJudge_AdminPage {

	public function __construct($title,$columns,$fields,$table,$item,$order = '') {
		$this->title = $title ;
		$this->columns = $columns ;
		$this->fields = $fields ;
		$this->table = $table ;
		$this->item = $item ;
		$this->order = $order ;
	}

	public function getAdminPage() {
		$list = new OnlineJudge_List_Table($this->columns,$this->fields,$this->table,$this->item,$this->order) ;
		?>
		<div class="wrap">
		<h2><?php echo $this->title ;?></h2>
		<?php
		$list->prepare_items() ;
		$list->display() ;
		?>
		</div>
		<?php
	}

}
?>
