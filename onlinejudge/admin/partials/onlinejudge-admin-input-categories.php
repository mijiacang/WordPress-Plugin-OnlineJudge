<?php
class OnlineJudge_AdminInputCategories {

	public function __construct() {

	}

	public function getCategories() {

		global $wpdb ;

		$cat_array = array() ;
		$cat_array = $wpdb->get_results("SELECT id,name FROM ".$wpdb->prefix."oj_categories ORDER BY id ASC",ARRAY_A) ;

		$returnstr = '<select name="parent">' ;
		foreach($cat_array as $cat) {
			$returnstr .= '<option value="'.$cat['id'].'"'.($value==$cat['id']?' selected':'').'>'.$cat['name'].'</option>' ;
		}
		$returnstr .= '</select>' ;
		return $returnstr;
	}

}
?>
