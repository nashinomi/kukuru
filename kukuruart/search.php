<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <!-- ヘッダー -->
    <head>
        <?php get_header(); ?>
        <!-- スタイル読み込み -->
        <link rel="stylesheet" href="<?php bloginfo ('stylesheet_url'); ?>" type="text/css" />
        <link rel="stylesheet" href="<?php bloginfo ('template_directory'); echo '/css/post.css' ?>" type="text/css" />
    </head>
    <body>
        <!-- ヘッダー -->
        <div id="header">
        	<div id="sitetitle">
            	<h1><a href="<?php echo home_url(); ?>"><?php echo bloginfo('name'); ?></a></h1>
            	<p id="desc"><?php bloginfo('description') ?></p>
            </div>
       		<div id="search"><?php get_search_form(); ?></div>
           
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
                global $query_string;
                query_posts($query_string."&post_type=post");
				//query_posts($query_string);
            ?> 
            <h2>検索結果：<?php the_search_query(); ?></h2>
            <?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>    <!-- キーワードに合った記事を表示させる処理 -->
                <div class="postTitle">
                    <a href="/post?user=<?php the_author(); ?>">
                        <span class="trick_rounded-img post_authorimage" style="background: url(<?php echo ps_get_user_profile_image_src(get_the_author_meta( 'ID' ), 'standard'); ?>) no-repeat center center; width: 60px; height: 60px;></span>
                        <span class="trick_thumbnail_Image">
                            <?php ps_user_profile_image( get_the_author_meta( 'ID' ), 'standard' ); ?>
                        </span>
                    </a>
                    <h2>
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>
           		</div>
        
                <!-- メイン記事部分 -->
                <div class="post">
                    <?php
                        //画像のサムネイル表示
                        //echo 'サムネイル表示<br />';
                        the_excerpt("more");
                    ?>
                    <p class="postinfo">
                        <?php echo get_the_date('Y年Fd日 l'); the_time(); ?>
                        |
                        カテゴリー：<?php the_category(' , '); ?>
                        |
                        <a href="<?php comments_link(); ?>">コメント
                        <?php comments_number(' (0) ',' (1) ',' (%) '); ?></a>
                    </p>
                </div>
            	<?php endwhile; ?>
            <?php else: ?>    
                	<!--  キーワードが見つからないときの処理 -->
                    <p>キーワードはみつかりません。</p>
            <?php endif; ?>   
                       
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
