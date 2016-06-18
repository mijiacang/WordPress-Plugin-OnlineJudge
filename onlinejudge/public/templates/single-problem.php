<?php

global $wp_query ;
$problem_id = $wp_query->query_vars['problem'] ;

?>

<?php get_header(); ?>
Hi there, you want problem <?php echo $problem_id ; ?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
