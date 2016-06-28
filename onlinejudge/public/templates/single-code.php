<?php get_header(); ?>
<header class="entry-header">
        <h1 class="entry-title">
                {@problem.ojid} - {@problem.title}
                <a href="#lsRet" id="save_draft" class="button">Save draft</a>
                <a href="/placeholder" class="button">Test code</a>
                <a href="/placeholder" class="button">Submit</a>
        </h1>
</header>

<script type="text/javascript">
        var $ojid = {@problem.ojid} ;
</script>

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
