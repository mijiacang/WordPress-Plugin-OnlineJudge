<?php

class OnlineJudge_AdminAddEdit {

	private $ojtitle ;

	public function __construct($ojtitle) {
		$this->ojtitle = $ojtitle ;
	}

	public function getAddEdit() {
		?>
		<div class="wrap">
		<h1><?php echo $this->ojtitle ;?><a href="?page=<?php echo $_REQUEST['page'];?>&action=add" class="page-title-action">Add New</a></h1>
		</div>
		<?php
	}
}

?>
