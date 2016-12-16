<?php
add_filter('wpseo_title',function($title) use($problem_id){ return "Code Problem $problem_id - ".get_bloginfo('name'); }) ;
?>

<?php get_header(); ?>
<header class="entry-header">
        <h1 class="entry-title">
                <span id="problemid">0</span> - <span id="problemtitle">TITLE</span>
                <a href="#lsRet" id="save_draft" class="button">Save draft</a>
                <a href="/placeholder" class="button">Test code</a>
                <a href="/placeholder" class="button">Submit</a>
        </h1>
</header>

<script type="text/javascript">
var $ojid = <?php echo $wp_query->query_vars['code'] ; ?> ;
</script>
<script type="text/javascript" src="/wp-content/plugins/onlinejudge/public/js/ace/ace.js"></script>
<script type="text/javascript" src="/wp-content/plugins/onlinejudge/public/js/code.js"></script>

<div id="code_wrapper">
        <div id="left_menu">
                <div id="draft" class="submission">
                        <div class="backtitle saved">DRAFT</div>
                        <div class="info">
                                DRAFT CODE<br/>
                                <span id="last_saved">0000-00-00 00:00:00</span><br/>
                                Language: <span id="language">C++</span>
                        </div>
                        <div class="loadcode">
                                <i class="fa fa-arrow-right fa-2x" title="Load this code in the editor"></i>
                        </div>
                </div>
                <div id="submissions"></div>
        </div>
        <div id="code_editor_wrapper">
                <div id="code_editor"></div>
        </div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
