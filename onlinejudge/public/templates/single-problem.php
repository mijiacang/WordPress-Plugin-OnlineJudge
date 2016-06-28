<?php

global $wp_query ;
global $wpdb ;

$problem_id = $wp_query->query_vars['problem'] ;

?>

<?php get_header(); ?>


<script type="text/javascript" src="/wp-content/themes/buddyboss-child/js/pdf.js"></script>
<script type="text/javascript" src="/wp-content/themes/buddyboss-child/js/compatibility.js"></script>
<!-- <script type="text/javascript" src="/wp-content/themes/buddyboss-child/js/viewer.js"></script> -->
<script type="text/javascript" src="/wp-content/themes/buddyboss-child/js/Chart.js"></script>
<script type="text/javascript">
    //PDFJS.disableWorker = true;
        PDFJS.workerSrc = '/wp-content/themes/buddyboss-child/js/pdf.worker.js';
</script>
<link rel='stylesheet' id='problem-css'  href='/wp-content/themes/buddyboss-child/css/problem.css' type='text/css' media='all' />

<?php
// $params = array('where' => 'ojid = '.pods_var(1,'url')) ;

?>

<script type="text/javascript" src="/wp-content/themes/buddyboss-child/js/problem.js"></script>

<header class="entry-header">
        <h1 class="entry-title"><?php echo $problem_id ; ?> - {@title}
                <a href="/code/<?php echo $problem_id ; ?>" class="button">Code it!</a>
                <a href="/placeholder" class="button">Discuss this problem</a>
        </h1>
</header>

<div id="problemWrapper">
        <div id="leftMenu">
                Problem type: {@problem_type.name}<br/>
                Time limit: {@time_limit} ms.<br/>
                Problemsetter: {@problemsetter}<br/>
                <canvas id="langChart" width="250" height="250"></canvas>
                <div id="langLegend"></div>
        </div>
        <div id="pdfContainer" class = "pdf-content"></div>
</div>

<script type="text/javascript">
        var $pdfsrc = '{@description._src}' ;
</script>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
