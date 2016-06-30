<?php
class OnlineJudge_AdminInputProblemtype {

	public function __construct() {

	}

	public function getProblemtype() {

		global $wpdb ;

		$probtype_array = array() ;
		$probtype_array = $wpdb->get_results("SELECT id,name FROM ".$wpdb->prefix."oj_problemtypes ORDER BY id ASC",ARRAY_A) ;
                                
		$returnstr = '<select name="problemtype">' ;
		foreach($probtype_array as $problemtype) {
			$returnstr .= '<option value="'.$problemtype['id'].'"'.($value==$problemtype['id']?' selected':'').'>'.$problemtype['name'].'</option>' ;
		}
		$returnstr .= '</select>' ;
		return $returnstr;
	}
}
?>
