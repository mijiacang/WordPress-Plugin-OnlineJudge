<?php

global $user_ID ;
global $wpdb ;
$problem = $wp_query->query_vars['page'] ;

file_put_contents('/tmp/postdata.txt', var_export($_REQUEST, true));
file_put_contents('/tmp/headers.txt', getallheaders());

$results = array() ;

if(isset($_POST['draftcode'])) {
	$wpdb->query($wpdb->prepare(
		"
			INSERT INTO ".$wpdb->prefix."oj_codedrafts
			(user,problem,code,language,created,modified)
			VALUES (%d,%d,%s,1,UTC_TIMESTAMP(),UTC_TIMESTAMP())
			ON DUPLICATE KEY UPDATE
			code = %s, language = 1, modified = UTC_TIMESTAMP()
		",
		$user_ID,
		$problem,
		$_POST['draftcode'],
		$_POST['draftcode']
	)) ;
}

$results['problemdata'] = $wpdb->get_results('SELECT id,title FROM '.$wpdb->prefix.
				'oj_problems WHERE id='.$problem)[0] ;
$results['draft'] = $wpdb->get_results('SELECT language,code,created,modified FROM '.$wpdb->prefix.
				'oj_codedrafts WHERE user='.$user_ID.' AND problem='.$problem)[0] ;

echo json_encode($results) ;

?>
