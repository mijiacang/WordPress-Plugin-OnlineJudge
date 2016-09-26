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

	function save_success() {
	?>
		<div class="notice notice-success is-dismissible">
			<p>Saved successfully</p>
		</div>
	<?php
	}

	public function getAddEdit() {

		global $wpdb ;

		$field_array = array() ;

		if($_REQUEST['save'] == 'yes') {
			if($this->action=='add') {
				$auto_id = false ;
				$field_string = '' ;
				$value_string = '' ;
				$this->action='edit' ;

				foreach($this->params['fields'] as $field) {
					if($field['type'] == 'auto') {
						$auto_id = true ;
					} elseif($field['dbname'] == null) {
						// NULL FIELD
					} else {
						$field_string .= $field['dbname']."," ;
						$value_string .= "'".$_REQUEST[$field['dbname']]."'," ;
					}
				}

				$query_string = "INSERT INTO ".$this->table." (".substr($field_string,0,-1).") VALUES (".substr($value_string,0,-1).")" ;

				$wpdb->query($wpdb->prepare($query_string)) ;
				if($auto_id == true) {
					$this->item = $wpdb->insert_id ;
				}
			} elseif($this->action=='edit') {
				$edit_string = '' ;

				foreach($this->params['fields'] as $field) {
					if($field['dbname'] != 'id' && $field['dbname'] != null) {
						$edit_string .= $field['dbname']."='".$_REQUEST[$field['dbname']]."'," ;
					}
				}

				$query_string = "UPDATE ".$this->table." SET ".substr($edit_string,0,-1)." WHERE id=".$_REQUEST['id'] ;

				$this->item = $_REQUEST['id'] ;
				
				$wpdb->query($wpdb->prepare($query_string)) ;
			}
		}

		if($this->action=='edit') {
			$field_string = '' ;
			foreach($this->params['fields'] as $field) {
				if($field['dbname']!=null) {
					$field_string .= $field['dbname']."," ;
				}
			}
			$field_string = substr($field_string,0,-1) ;

			$field_array = $wpdb->get_results("SELECT $field_string FROM ".$this->table." WHERE id = ".$this->item,ARRAY_A) ;
			$field_array = $field_array[0] ;
		}

		?>

		<div class="wrap">
		<h1><?php echo $this->ojtitle ;?><a href="?page=<?php echo $_REQUEST['page'];?>&action=add" class="page-title-action">Add New</a></h1>

		<?php if($_REQUEST['save'] == 'yes') {
			$this->save_success() ;
		} ?>

		<form method="post" action="admin.php?page=<?php echo $_REQUEST['page']; ?>&action=<?php echo $_REQUEST['action']; ?>&item=<?php echo $_REQUEST['item']; ?>">
		<input type="hidden" name="save" value="yes"/>
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

		global $wpdb ;

		switch($field['type']) {
			case 'input':
				return '<input name="' . $field['dbname'] . '"'.($this->action=='edit'?' value="'.$value.'"':'').' />' ;
			case 'datetime':
				return '<input name="' . $field['dbname'] . '"'.($this->action=='edit'?' value="'.$value.'"':'').' class="datefield" />' ;
			case 'problemtype':
				require_once('onlinejudge-admin-input-problemtype.php') ;
				$probtype = new OnlineJudge_AdminInputProblemtype() ;
				return $probtype->getProblemtype();
			case 'categories':
				require_once('onlinejudge-admin-input-categories.php') ;
				$cats = new OnlineJudge_AdminInputCategories() ;
				return $cats->getCategories();
			case 'probcat':
				require_once('onlinejudge-admin-input-probcat.php') ;
				$probcat = new OnlineJudge_AdminInputProbcat($this->item) ;
				return $probcat->getProbcat();
			case 'auto':
				if($this->action=='edit') {
					return $value.'<input type="hidden" name="id" value="'.$value.'"/>' ;
				}
				return 'This field is filled automatically' ;
			case 'media':
				require_once('onlinejudge-admin-input-media.php') ;
				$media = new OnlineJudge_AdminInputMedia() ;
				return $media->getMedia() ;
			default:
				return 'Not implemented' ;
		}
	}
}

?>
