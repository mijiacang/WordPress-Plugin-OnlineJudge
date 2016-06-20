<?php
global $wp_query ;

$api_uri = $wp_query->query_vars['api'] ;
$api_query = explode("/",$api_uri) ;

switch($api_query[0]) {
	case 'contests':
		require(dirname(__FILE__).'/../partials/api-contests.php') ;
		break ;
	case 'problems':
		require(dirname(__FILE__).'/../partials/api-problems.php') ;
		break ;
	case 'problem':
		require(dirname(__FILE__).'/../partials/api-problem.php') ;
		break ;
	case 'submissions':
		require(dirname(__FILE__).'/../partials/api-submissions.php') ;
		break ;
	case 'draft':
		require(dirname(__FILE__).'/../partials/api-draft.php') ;
		break ;
	default:
		require(dirname(__FILE__).'/../partials/api-front.php') ;
		break ;
}

?>
