<?php
add_filter('wpseo_title',function($title){ return "Problems - ".get_bloginfo('name'); }) ;
?>

<?php get_header(); ?>

<header class="entry-header"><h1 class="entry-title">Problems</h1></header>
<div id="oj_categories"></div>
<div id="oj_problems"></div>
<script type="text/javascript" src="/wp-content/plugins/onlinejudge/public/js/problems.js"></script>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
