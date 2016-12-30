<?php

global $wpdb ;
global $user_ID ;

$conditions = array() ;
$count = 0 ;

$conditions[] = "id >= ".$wp_query->query_vars['page'] ;

if(isset($wp_query->query_vars['problemid']) && $wp_query->query_vars['problemid'] > 0) {
	$conditions[] = " AND problem=".$wp_query->query_vars['problemid'] ;
}

if(isset($wp_query->query_vars['userid']) && $wp_query->query_vars['userid'] != 0) {
	if($wp_query->query_vars['userid'] == "C") $wp_query->query_vars['userid'] = $user_ID ;
	$conditions[] = " AND user=".$wp_query->query_vars['userid'] ;
}

if(isset($wp_query->query_vars['listlength']) && $wp_query->query_vars['listlength'] != 0) {
	$count = $wp_query->query_vars['listlength'] ;
}

$querystr = 'SELECT id,user,problem,language,created FROM '.$wpdb->prefix.'oj_submissions WHERE ' ;
foreach($conditions as $cond) $querystr .= $cond ;
$querystr .= " ORDER BY id" ;
if($count<0) {
	$querystr .= " DESC" ;
	$count *= -1 ;
}
if($count != null) $querystr .= " LIMIT $count" ;

echo json_encode($wpdb->get_results($querystr),JSON_NUMERIC_CHECK) ;
?>
