<?php
add_filter('wpseo_title',function($title){ return "Problems - ".get_bloginfo('name'); }) ;
$cat_uri = (isset($wp_query->query_vars['problems'])?$wp_query->query_vars['problems']:null) ;
?>

<?php get_header(); ?>

<header class="entry-header"><h1 class="entry-title">Problems</h1></header>
<div id="oj_categories"></div>
<div id="oj_problems"></div>
<?php if($cat_uri) { ?>
<script type="text/javascript">
var $currentcat = '<?php echo $cat_uri ; ?>' ;
</script>
<?php } ?>
<script type="text/javascript" src="/wp-content/plugins/onlinejudge/public/js/problems.js"></script>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
