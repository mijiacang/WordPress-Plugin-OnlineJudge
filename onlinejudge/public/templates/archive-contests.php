<?php
add_filter('wpseo_title',function($title){ return "Contests - ".get_bloginfo('name'); }) ;
?>

<?php get_header(); ?>

<header class="entry-header">
	<h1 class="entry-title">Contests</h1>
</header>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
