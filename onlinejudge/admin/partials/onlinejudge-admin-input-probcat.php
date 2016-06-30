<?php
class OnlineJudge_AdminInputProbcat {

	private $tmp_cats ;
	private $problemid ;

	public function __construct($problemid) {

		$this->tmp_cats = array() ;
		$this->problemid = $problemid ;

	}

	public function getProbcat() {

		global $wpdb ;

		$cat_array = array() ;
		$cat_array = $wpdb->get_results("SELECT id,name,parent FROM ".$wpdb->prefix."oj_categories WHERE id!=0 ORDER BY id ASC",ARRAY_A) ;
		$probcat_array = array() ;
		$probcat_array = $wpdb->get_results("SELECT category FROM ".$wpdb->prefix."oj_probcat WHERE problem=".$this->problemid,ARRAY_A) ;

		$this->sortCats($cat_array) ;

		$returnstr = '<select data-placeholder="Select a category..." class="chosen-select" multiple name="probcat[]">' ;
		foreach($this->tmp_cats as $cat) {
			$selected = '' ;
			foreach($probcat_array as $probcat) {
				if($probcat['category'] == $cat['id']) {
					$selected = 'selected' ;
				}
			}
			$returnstr .= '<option value="'.$cat['id'].'" '.$selected.' style="padding-left:'.($cat['level']*15).'px;">'.$cat['name'].'</option>' ;
		}
		$returnstr .= '</select>' ;
		$returnstr .= '<script type="text/javascript">jQuery(".chosen-select").chosen()</script>' ;
		return $returnstr;
	}

	function sortCats($cats,$level=0,$parent=0) {
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
