<?php
class OnlineJudge_AdminInputCategories {

	private $tmp_cats ;

	public function __construct() {

		$this->tmp_cats = array() ;

	}

	public function getCategories() {

		global $wpdb ;

		$cat_array = array() ;
		$cat_array = $wpdb->get_results("SELECT id,name,parent FROM ".$wpdb->prefix."oj_categories ORDER BY id ASC",ARRAY_A) ;

		$this->sortCats($cat_array) ;

		$returnstr = '<select data-placeholder="Select a parent category..." class="chosen-select" name="parent">' ;
		foreach($this->tmp_cats as $cat) {
			$returnstr .= '<option value="'.$cat['id'].'"'.($value==$cat['id']?' selected':'').' style="padding-left:'.($cat['level']*15).'px !important;">'.$cat['name'].'</option>' ;
		}
		$returnstr .= '</select>' ;
		$returnstr .= '<script type="text/javascript">jQuery(".chosen-select").chosen()</script>' ;
		return $returnstr;
	}

	function sortCats($cats,$level=0,$parent=null) {
		foreach($cats as $cat) {
			if($cat['parent']==$parent) {
				$cat['level'] = $level ;
				array_push($this->tmp_cats,$cat) ;
				$this->sortCats($cats,$level+1,$cat['id']) ;
			}
		}
	}
}
?>
