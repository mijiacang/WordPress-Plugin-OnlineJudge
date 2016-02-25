<?php

if( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class OnlineJudge_List_Table extends WP_List_Table {

	private $ojcolumns ;
	private $ojfields ;
	private $ojtable ;
	private $ojitem ;
	private $ojorder ;

	public function __construct($columns,$fields,$table,$item,$order) {

		parent::__construct() ;

		global $wpdb ;

		$this->ojcolumns = $columns ;
		$this->ojfields = $fields ;
		$this->ojtable = $wpdb->prefix.$table ;
		$this->ojitem = $item ;
		$this->ojorder = $order ;
	}

	public function get_columns() {
		return $this->ojcolumns ;
	}

	public function prepare_items() {

		global $wpdb ;

		$columns = $this->get_columns() ;
		$hidden = array() ;
		$sortable = array() ;
		$this->_column_headers = array($columns,$hidden,$sortable) ;
		$this->items = $wpdb->get_results("SELECT " . $this->ojfields . " FROM " . $this->ojtable . ($this->ojorder != '' ? " ORDER BY ".$this->ojorder : ''),ARRAY_A) ;
	}

	public function column_default($item, $column_name) {
		if($column_name == array_keys($this->ojcolumns)[0]) {
			$actions = array(
				'edit' => sprintf('<a href="?page=%s&action=%s&' . $this->ojitem .'=%s" title="Edit this item">Edit</a>',$_REQUEST['page'],'edit',$item['id']),
				'inline hide-if-no-js' => sprintf('<a href="#" title="Edit this item inline">Quick Edit</a>'),
				'delete' => sprintf('<a href="?page=%s&action=%s&' . $this->ojitem .'=%s" title="Delete this item">Delete</a>',$_REQUEST['page'],'delete',$item['id'])
			) ;
			return sprintf('%1$s %2$s', $item[$column_name], $this->row_actions($actions)) ;
		} else {
			return $item[$column_name] ;
		}
	}

}

class OnlineJudge_AdminPage {

	private $ojtitle ;
	private $ojcolumns ;
	private $ojfields ;
	private $ojtable ;
	private $ojitem ;
	private $ojorder ;

	public function __construct($title,$columns,$table,$item,$order = '') {
		$this->ojtitle = $title ;
		$this->ojcolumns = $columns ;
		$this->ojtable = $table ;
		$this->ojitem = $item ;
		$this->ojorder = $order ;

		foreach(array_keys($this->ojcolumns) as $key) {
			$this->ojfields .= $key."," ;
		}

		$this->ojfields = substr($this->ojfields,0,-1) ;
	}

	public function getAdminPage() {
		$list = new OnlineJudge_List_Table($this->ojcolumns,$this->ojfields,$this->ojtable,$this->ojitem,$this->ojorder) ;
		$list->prepare_items();
		?>
		<div class="wrap">
		<h1><?php echo $this->ojtitle ;?><a href="?page=<?php echo $_REQUEST['page'];?>&action=add" class="page-title-action">Add New</a></h1>
		<form method="post">
			<input type="hidden" name="page" value="<?php echo $_REQUEST['page']; ?>" />
			<?php
			$list->search_box('Search','search_id');
			$list->display();
			?>
		</form>
		</div>
		<?php
	}

}
?>