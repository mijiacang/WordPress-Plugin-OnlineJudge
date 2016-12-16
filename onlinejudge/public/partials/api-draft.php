<?php

global $user_ID ;
global $wpdb ;
$problem = $wp_query->query_vars['page'] ;

file_put_contents('/tmp/postdata.txt', var_export($_REQUEST, true));
file_put_contents('/tmp/headers.txt', getallheaders());

$results = array() ;

if(isset($_POST['code'])) {
	$query_str = 'INSERT INTO '.$wpdb->prefix.'oj_codedrafts (user,problem,language,created,modified) '.
			'VALUES ('.$user_ID.','.$problem.',1,NOW(),NOW()) ON DUPLICATE KEY UPDATE '.
			'code = '.mysqli_real_escape_string($_POST['code']).', language = 1, modified = NOW()' ;
	$results['query'] = $query_str ;
	$wpdb->get_results($query_str) ;
}

$results['problemdata'] = $wpdb->get_results('SELECT id,title FROM '.$wpdb->prefix.
				'oj_problems WHERE id='.$problem)[0] ;
$results['draft'] = $wpdb->get_results('SELECT language,code,created,modified FROM '.$wpdb->prefix.
				'oj_codedrafts WHERE user='.$user_ID.' AND problem='.$problem)[0] ;

echo json_encode($results) ;

?>
