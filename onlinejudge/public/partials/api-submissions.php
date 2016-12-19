<?php

echo "You asked for submissions, starting with ".$wp_query->query_vars['page'] ;

if(isset($wp_query->query_vars['problemid']) && $wp_query->query_vars['problemid'] > 0) {
	echo ", for problem ".$wp_query->query_vars['problemid'] ;
} else {
	echo ", for all problems" ;
}

if(isset($wp_query->query_vars['userid']) && $wp_query->query_vars['userid'] > 0) {
	echo ", for user ".$wp_query->query_vars['userid'] ;
} else {
	echo ", for all users" ;
}

if(isset($wp_query->query_vars['listlength']) && $wp_query->query_vars['listlength'] > 0) {
	echo ", with a length of ".$wp_query->query_vars['listlength'] ;
} else {
	echo ", with full length" ;
}

?>
