<?php

class OnlineJudge_AdminAddEdit {

	private $ojtitle ;
	private $fields ;
	private $table ;
	private $action ;
	private $item ;
	private $params ;

	public function __construct($params) {

		$this->params = $params ;

		$this->ojtitle = ($params['action']=='add'?"Add ":"Edit ").$params['title_single'] ;
		$this->fields = $params['fields'] ;
		$this->table = $wpdb->prefix.$params['table'] ;
		$this->action = $params['action'] ;
		$this->item = $params['item'] ;
	}

	public function getAddEdit() {
		?>
		<div class="wrap">
		<h1><?php echo $this->ojtitle ;?><a href="?page=<?php echo $_REQUEST['page'];?>&action=add" class="page-title-action">Add New</a></h1>

		<form method="post" action="">
		<table class="form-table">
		<tbody>

		<?php foreach($this->params['fields'] as $field) { ?>
		<tr>
		<th scope="row"><?php echo $field['name'] ; ?></th>
		<td><?php echo $this->getInputSnippet($field) ; ?></td>
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

	private function getInputSnippet($field) {
		switch($field['type']) {
			case 'input':
				return '<input name="' . $field['name'] . '"/>' ;
			default:
				return 'Not implemented' ;
		}
	}
}

?>
