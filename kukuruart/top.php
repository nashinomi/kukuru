<?php 
/********************************
	トップページテンプレート
********************************/
?>

<!-- コンテンツ -->
<div id="Topcontent">
    <div id="TopFeed">
        <img class="newimg" src="<?php bloginfo('template_url'); ?>/img/newimg.png" alt="new" />
        <h2 class="newposts">新着記事</h2>
        <?php $posts = get_posts('numberposts=7&order=desc');
        foreach($posts as $post): ?>
            <div class="feed">
                <div class="yu-za">
                    <?php ps_user_profile_image($post->post_author, 'thumbnail' ); ?>
                </div>
                <div class="feed_title">
                    記事「<a href="<?php the_permalink(); ?>" id="post-<?php the_ID(); ?>"><?php the_title(); ?></a>」
                    が作成されました。
                </div>
                <div class="day_category">
	                <span class="month"><?php echo date("Y年m月d日", strtotime($post->post_date)); ?></span>
                    <span class="category">カテゴリー： <?php the_category(' , '); ?></span>
                </div>           
            </div>
            <?php //print_r($post); ?>
        <?php endforeach; ?>
    <!-- end_TopFeed -->
    </div>
<!--End content -->
</div>

<!-- サイドバー  -->
<div id="sidebar">
<ul>
    <?php dynamic_sidebar(); ?>
</ul>
<!-- end_sidebar -->
</div>