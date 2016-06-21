<?php get_header(); ?>

<header class="entry-header">
	<h1 class="entry-title">Problems</h1>
</header>

<div id="oj_categories">
<?php

/* function print_cat($parent) {
	global $wpdb ;

	echo '<ul>' ;

	$cats = array() ;
	$cats = $wpdb->get_results('SELECT id,name,permalink FROM '.$wpdb->prefix.'oj_categories WHERE parent = '.$parent.' ORDER BY listorder',ARRAY_A) ;

	foreach($cats as $cat) {
		echo '<li value="'.$cat['id'].'"><a href="#" data-permalink="'.$cat['permalink'].'">'.$cat['name'].'</a>' ;
		print_cat($cat['id']) ;
		echo '</li>' ;
	}

	echo '</ul>' ;
}

print_cat(0) ; */
?>
</div>
<div id="oj_problems">
    
</div>
<script type="text/javascript" src="/wp-content/plugins/onlinejudge/public/js/problems.js"></script>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
