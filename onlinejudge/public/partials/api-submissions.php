<?php

if(count($api_query) == 1) {
	api_submission($wp_query->query_vars['page']) ;
} elseif(count($api_query) == 2) {
	switch($api_query[1]) {
		case 'problem':
			api_submission_problem($wp_query->query_vars['page']) ;
			break ;
		case 'user':
			api_submission_user($wp_query->query_vars['page']) ;
			break ;
		case 'last':
			api_submission_last($wp_query->query_vars['page']) ;
			break ;
	}
} elseif(count($api_query) == 3) {
	if(is_numeric($api_query[1])) {
		switch($api_query[2]) {
			case 'code':
				api_submission_code($api_query[1]) ;
				break ;
		}
	}
}

function api_submission($submission) {
	echo "You asked for submission $submission" ;
}

function api_submission_problem($problem) {
	echo "You asked for submissions related to problem $problem" ;
}

function api_submission_last($last) {
	echo "You asked for the last $last submissions" ;
}

function api_submission_user($user) {
	echo "You asked for submissions related to user $user" ;
}

function api_submission_code($submission) {
	echo "You asked for the code of submission $submission" ;
}

?>
