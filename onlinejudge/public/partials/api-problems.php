<?php

$category = $wp_query->query_vars['page'] ;

global $wpdb ;

$problems = array() ;
$problems = $wpdb->get_results('SELECT problem from '.$wpdb->prefix.'oj_probcat WHERE category = '.$category.' ORDER BY listorder ASC',ARRAY_A) ;

$items = array() ;

foreach($problems as $problem) {
	array_push($items,($wpdb->get_results('SELECT id as ojid,title FROM '.$wpdb->prefix.'oj_problems WHERE id = '.$problem['problem']))[0]) ;
}

echo json_encode($items) ;
?>
