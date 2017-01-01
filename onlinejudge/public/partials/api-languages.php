<?php

global $wpdb ;

$language = $wp_query->query_vars['page'] ;

$result = array() ;
$result = $wpdb->get_results('SELECT id,shortname FROM '.$wpdb->prefix.'oj_languages '.
				($language>0?'WHERE id='.$language.' ':'').'ORDER BY id',ARRAY_A) ;

echo json_encode(($language>0?$result[0]:$result),JSON_NUMERIC_CHECK) ;

?>
