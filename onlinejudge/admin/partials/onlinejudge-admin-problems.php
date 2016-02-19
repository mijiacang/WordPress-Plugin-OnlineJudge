<?php

if( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Problems_List_Table extends WP_List_Table {

	public function get_columns() {
		$columns = array(
			'id' => 'ID',
			'title' => 'Title',
			'problemtype' => 'Type',
			'timelimit' => 'Time Limit (ms)',
			'memorylimit' => 'Mem Limit (kb)',
			'created' => 'Created',
			'modified' => 'Modified'
		) ;

		return $columns ;
	}

	public function prepare_items() {

		global $wpdb ;
		$problems_table = $wpdb->prefix.'oj_problems' ;

		$columns = $this->get_columns() ;
		$hidden = array() ;
		$sortable = array() ;
		$this->_column_headers = array($columns,$hidden,$sortable) ;
		$this->items = $wpdb->get_results("SELECT id,title,problemtype,timelimit,memorylimit,created,modified FROM $problems_table ORDER BY id ASC",ARRAY_A) ;
	}

	public function column_id($item) {
		$actions = array(
			'edit' => sprintf('<a href="?page=%s&action=%s&problem=%s">Edit</a>',$_REQUEST['page'],'edit',$item['id']),
			'delete' => sprintf('<a href="?page=%s&action=%s&problem=%s">Delete</a>',$_REQUEST['page'],'delete',$item['id'])
		) ;

		return sprintf('%1$s %2$s', $item['id'], $this->row_actions($actions)) ;
	}

	public function column_default($item, $column_name) {
		switch($column_name) {
			case 'title':
			case 'problemtype':
			case 'timelimit':
			case 'memorylimit':
			case 'created':
			case 'modified':
				return $item[$column_name] ;
		}
	}

}

class Problems_Admin {

	public function __construct() {

	}

	public function getAdminPage() {
		$problems_list = new Problems_List_Table() ;
		?>
		<div class="wrap">
		<h2>OnlineJudge Problems</h2>
		<form method="post">
			<input type="hidden" name="page" value="<?php echo $_REQUEST['page']; ?>" />
			<?php $problems_list->search_box('Search','search_id'); ?>
		</form>
		<?php
		$problems_list->prepare_items() ;
		$problems_list->display() ;
		?>
		</div>
		<?php
	}

}
?>
