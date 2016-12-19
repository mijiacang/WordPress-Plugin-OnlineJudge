<?php
global $wp_query ;

switch($wp_query->query_vars['api']) {
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
	case 'categories':
		require(dirname(__FILE__).'/../partials/api-categories.php') ;
		break ;
	default:
		require(dirname(__FILE__).'/../partials/api-front.php') ;
		break ;
}

?>
