<?php
add_filter('wpseo_title',function($title){ return "Submissions - ".get_bloginfo('name'); }) ;
?>

<?php get_header(); ?>

<header class="entry-header">
<h1 class="entry-title">Submissions</h1>
</header>

<table id="submissions">
<thead id="submissions_header">
<th>ID</th><th>Problem</th><th>User</th><th>Verdict</th><th>Language</th><th>Runtime</th><th>Submission time</th>
</thead>
<tbody id="submissions_body">
</tbody>
</table>

<script type="text/javascript" src="/wp-content/plugins/onlinejudge/public/js/submissions.js"></script>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
