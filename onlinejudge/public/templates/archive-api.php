<?php
global $wp_query ;
$api_uri = $wp_query->query_vars['api'] ;

$api_query = explode("/",$api_uri) ;

switch($api_query[0]) {
	default:
		require(dirname(__FILE__).'/../partials/api-front.php') ;
		break ;
}

?>
