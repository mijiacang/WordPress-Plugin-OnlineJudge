<?php

global $wp_query ;

$problem_id = $wp_query->query_vars['problem'] ;

add_filter('wpseo_title',function($title) use($problem_id){ return "Problem $problem_id - ".get_bloginfo('name'); }) ;

?>

<?php get_header(); ?>


<script type="text/javascript" src="/wp-content/plugins/onlinejudge/public/js/pdf.js"></script>
<script type="text/javascript" src="/wp-content/plugins/onlinejudge/public/js/compatibility.js"></script>
<!-- <script type="text/javascript" src="/wp-content/themes/buddyboss-child/js/viewer.js"></script> -->
<script type="text/javascript" src="/wp-content/plugins/onlinejudge/public/js/Chart.js"></script>
<script type="text/javascript">
    //PDFJS.disableWorker = true;
        PDFJS.workerSrc = '/wp-content/plugins/onlinejudge/public/js/pdf.worker.js';
</script>

<script type="text/javascript" src="/wp-content/plugins/onlinejudge/public/js/problem.js"></script>

<header class="entry-header">
        <h1 class="entry-title"><?php echo $problem_id ; ?> - <span id="oj_problem_title"></span>
                <a href="/code/<?php echo $problem_id ; ?>" class="button">Code it!</a>
                <a href="/placeholder" class="button">Discuss this problem</a>
        </h1>
</header>

<div id="problemWrapper">
        <div id="leftMenu">
                Problem type: <span id="oj_problem_problemtype"></span><br/>
                Time limit: <span id="oj_problem_timelimit"></span> ms.<br/>
                Problemsetter: <span id="oj_problem_problemsetter"></span><br/>
                <canvas id="langChart" width="250" height="250"></canvas>
        </div>
        <div id="pdfContainer" class = "pdf-content"></div>
</div>

<script type="text/javascript">
	var $problem_id = <?php echo $problem_id ; ?> ;
       // var $pdfsrc = '{@description._src}' ;
</script>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
