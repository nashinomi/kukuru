<title>
    <?php wp_title(); ?>
    <?php bloginfo('name'); ?>
</title>
<?php
	//if(is_singular())wp_enqueue_script('comment-reply');
?>  
<?php
	/* 要必要？ */
	wp_head();
?>

<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>;charset=<?php bloginfo('charset'); ?>" />
<link rel="alternate" type="application/rss+xml" title="RSS フィード" href="<?php bloginfo('rss2_url'); ?>"/>
<?php 
	wp_deregister_script('jquery');
	wp_enqueue_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js',array(), '1.7.1');
?>
<!-- js読み込み -->
<script src=<?php bloginfo ('template_directory'); ?>/my_functions.js></script>