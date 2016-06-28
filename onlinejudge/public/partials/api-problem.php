<?php

$problem = $wp_query->query_vars['page'] ;

global $wpdb ;

$result = array() ;
$result = $wpdb->get_results('SELECT id as ojid,title,problemtype,timelimit,memorylimit from '.$wpdb->prefix.'oj_problems WHERE id = '.$problem,ARRAY_A) ;
echo json_encode($result) ;

?>
