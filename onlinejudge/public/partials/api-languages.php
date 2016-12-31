<?php

global $wpdb ;

$result = array() ;
$result = $wpdb->get_results('SELECT id,shortname FROM '.$wpdb->prefix.'oj_languages ORDER BY id') ;

echo json_encode($result,JSON_NUMERIC_CHECK) ;

?>
