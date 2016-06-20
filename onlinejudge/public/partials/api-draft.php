<?php

global $user_ID ;
$problem = $wp_query->query_vars['page'] ;

echo "You asked for draft of problem $problem by user $user_ID" ;

?>
