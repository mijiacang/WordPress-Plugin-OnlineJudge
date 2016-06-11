<?php

class OnlineJudge_AdminAddEdit {

	private $ojtitle ;
	private $fields ;
	private $table ;
	private $action ;
	private $item ;
	private $params ;

	public function __construct($params) {

		global $wpdb ;

		$this->params = $params ;

		$this->ojtitle = ($params['action']=='add'?"Add ":"Edit ").$params['title_single'] ;
		$this->fields = $params['fields'] ;
		$this->table = $wpdb->prefix.$params['table'] ;
		$this->action = $params['action'] ;
		$this->item = $params['item'] ;

		add_action('admin_print_footer_scripts',array(&$this,'add_datepicker'));
	}

	public function add_datepicker() {
	?>
		<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery('.datefield').datepicker({
				dateFormat : 'yy/mm/dd',
				firstDay : 1
			});
		});
		</script>
	<?php
	}

	public function getAddEdit() {

		global $wpdb ;

		$field_array = array() ;

		if($this->action=='edit') {
			$field_string = '' ;
			foreach($this->params['fields'] as $field) {
				$field_string .= $field['dbname']."," ;
			}
			$field_string = substr($field_string,0,-1) ;

			$field_array = $wpdb->get_results("SELECT $field_string FROM ".$this->table." WHERE id = ".$this->item,ARRAY_A) ;
			$field_array = $field_array[0] ;
		}

		?>
		<div class="wrap">
		<h1><?php echo $this->ojtitle ;?><a href="?page=<?php echo $_REQUEST['page'];?>&action=add" class="page-title-action">Add New</a></h1>

		<form method="post" action="">
		<table class="form-table">
		<tbody>

		<?php foreach($this->params['fields'] as $field) { ?>
		<tr>
		<th scope="row"><?php echo $field['name'] ; ?></th>
		<td><?php echo $this->getInputSnippet($field,($this->action=='edit'?$field_array[$field['dbname']]:'')) ; ?></td>
		</tr>
		<?php } ?>

		<tr>
		<th scope="row"></th>
		<td><p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"/></p></td>
		</tr>

		</tbody>
		</form>
		</div>
		<?php
	}

	private function getInputSnippet($field,$value) {
		switch($field['type']) {
			case 'input':
				return '<input name="' . $field['dbname'] . '"'.($this->action=='edit'?' value="'.$value.'"':'').' />' ;
			case 'datetime':
				return '<input name="' . $field['dbname'] . '"'.($this->action=='edit'?' value="'.$value.'"':'').' class="datefield" />' ;
			case 'problemtype':
				return 'Problem Type';
			case 'categories':
				return 'Categories';
			case 'auto':
				if($this->action=='edit') {
					return $value ;
				}
				return 'This field is filled automatically' ;
			default:
				return 'Not implemented' ;
		}
	}
}

?>
