<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<?php
        /*定数宣言*/
        define("MY_NOTPAGE", 0);
        define("MY_TOP", 1);
        define("MY_REPORTS", 2);
        define("MY_GALLERY", 3);
		define("MY_SINGLE", 4);
		define("MY_SINGLE_ATACCHMENT", 5);
		define("MY_SITEHELP", 6);
        define("MY_SINGLE_ILLUST", 7);
        define("MY_GALLERY_ODAI", 8);
		define("MY_SITEPROJECT", 9);
        // 分岐スイッチグローバル変数
        $pageSwitch=0;
    ?>
    <!-- ヘッダー -->
    <head>
        <?php get_header(); ?>
            <!-- スタイル読み込み -->
            <link rel="stylesheet" href="<?php bloginfo ('stylesheet_url'); ?>" type="text/css" />
            <?php 
                $cat_name='0';
				// トップページ
				if((is_page('Home'))){
					$pageSwitch= MY_TOP; ?>
                    <link rel="stylesheet" href="<?php bloginfo ('template_directory'); echo '/css/top.css'; ?>" type="text/css" />
                    <link rel="stylesheet" href="<?php bloginfo ('template_directory'); echo '/css/sidebar.css'; ?>" type="text/css" />
                <?php
				// 記事一覧ページ系
				}else if(is_home()||is_archive()||is_month()||is_author()){
					$pageSwitch= MY_REPORTS; ?>
                    <link rel="stylesheet" href="<?php bloginfo ('template_directory'); echo '/css/post.css' ?>" type="text/css" />
                    <link rel="stylesheet" href="<?php bloginfo ('template_directory'); echo '/css/reports.css' ?>" type="text/css" />
                    <link rel="stylesheet" href="<?php bloginfo ('template_directory'); echo '/jquery/jquery.jscrollpane.css' ?>" type="text/css" />
                    <script src=<?php bloginfo ('template_directory'); ?>/jquery/jquery.mousewheel.js></script>
                    <script src=<?php bloginfo ('template_directory'); ?>/jquery/jquery.jscrollpane.js></script>
                    <script type="text/javascript">
						j(function()
						{
							j('#sortbox').jScrollPane();
							j('#new_comments').jScrollPane();
						});
						
					</script>
				<?php
				//	サイトヘルプ
				}else if(is_page('sitehelp')){
					$pageSwitch= MY_SITEHELP; ?>
                    <link rel="stylesheet" href="<?php bloginfo ('template_directory'); echo '/css/post.css' ?>" type="text/css" />
                <?php
				}else if(is_page('project')){
					$pageSwitch= MY_SITEPROJECT; ?>
                    <link rel="stylesheet" href="<?php bloginfo ('template_directory'); echo '/css/post.css' ?>" type="text/css" />
                <?php
				// ギャラリ-	
				}else if(is_page('gallery')){
					$pageSwitch= MY_GALLERY; ?>
                    <link rel="stylesheet" href="<?php bloginfo ('template_directory'); echo '/css/gallery.css' ?>" type="text/css" />
				<?php
				// 御題ギャラリー
				}else if(is_page('odai-gallery')){
                    $pageSwitch= MY_GALLERY_ODAI; ?>
                    <link rel="stylesheet" href="<?php bloginfo ('template_directory'); echo '/css/gallery.css' ?>" type="text/css" />
                <?php
                // 投稿ページ
				}else if(is_single()&& !is_attachment()){
				    $pageSwitch= MY_SINGLE;
				    // 投稿フォーマットがギャラリーの時
				    if(has_post_format('gallery'))$pageSwitch= MY_SINGLE_ILLUST;
				?>
                    <link rel="stylesheet" href="<?php bloginfo ('template_directory'); echo '/css/post.css' ?>" type="text/css" />
                    <link rel="stylesheet" href="<?php bloginfo ('template_directory'); echo '/test.css' ?>" type="text/css" />
                    <script type="text/javascript" src=<?php bloginfo ('template_directory'); ?>/jstest.php></script>
                <?php
				// 個別ギャラリー
				}else if(is_attachment()){
					$pageSwitch= MY_SINGLE_ATTACHMENT; ?>
                	<link rel="stylesheet" href="<?php bloginfo ('template_directory'); echo '/css/post.css' ?>" type="text/css" />
				<?php
                // ページが見つからない		
				}else{
					$pageSwitch= MY_NOTPAGE;
                    
				}
			?>	
    </head>
    <body>
        <!-- ヘッダー -->
        <div id="header">
        	<div id="sitetitle">
            	<h1><a href="<?php echo home_url(); ?>"><?php echo bloginfo('name'); ?></a></h1>
            	<p id="desc"><?php bloginfo('description') ?></p>
            </div>
       		<div id="search"><?php get_search_form(); ?></div>
           
			<!-- これ以外にクリアできない・・ -->
            <div class="clear"></div>
            <?php
                if($pageSwitch==MY_TOP) :
                    get_template_part('head_image'); 
                endif;
            ?>
        <!-- End header -->	
        </div>
        
        <!-- ナビゲーションバー -->
        <div id="nav">
            <?php wp_nav_menu(array('theme_location' => 'navigation')); ?>
        <!-- end nav -->	
        </div>
        <!-- コンテナー -->
        <div id="container">	
            <!-- 上下２段組下段 -->
            <div id="main">
                <?php
                    if($pageSwitch==MY_TOP){
                        get_template_part('top');
                    // 記事一覧ページ系列
                    }else if($pageSwitch==MY_REPORTS){
                        get_template_part('reports');
                    // シングルページ			
                    }else if($pageSwitch==MY_SINGLE){
                        get_template_part('single_post');
					}else if($pageSwitch==MY_SINGLE_ATTACHMENT){
						get_template_part('single','image');
                    // 絵の投稿ページ
                    }else if($pageSwitch==MY_SINGLE_ILLUST){
                        get_template_part('single','illust');
                    // ギャラリー					
                    }else if($pageSwitch==MY_GALLERY){
                        get_template_part('gallery');
                    // 御題ギャラリー
                    }else if($pageSwitch==MY_GALLERY_ODAI){
                        get_template_part('odai-gallery');
                    // サイトヘルプ
					}else if($pageSwitch==MY_SITEHELP){
						get_template_part('help_reports');
					// 有言実行宣言まとめ個別ページ
					}else if($pageSwitch==MY_SITEPROJECT){
						get_template_part('project_reports');
					}else{
						echo '<h2>このページは存在しません。</h2>';
					}             
                ?>                 
            <!-- end_main -->
            </div>
            
            <!-- フッター -->
            <div id="footer">
                <?php get_footer(); ?>
            <!-- end_footer -->
            </div>
        <!-- end_continer -->
        </div>
    </body>
</html>