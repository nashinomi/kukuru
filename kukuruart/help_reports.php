<?php
/********************************
	ヘルプ一覧テンプレート
********************************/
// カテゴリー別
if(is_category()): ?>
    <p class="pagetitle">
        <?php single_cat_title(); ?>
    </p>
<?php endif;
// 月別
if(is_month()): ?>
    <p class="pagetitle">
        <?php single_month_title(); ?>
    </p>
<?php endif; ?>
<?php query_posts('category_name=ヘルプ&posts_per_page=5'); ?>
<?php if(have_posts()): while(have_posts()): the_post(); ?>
    <div class="postTitle">
        <?php /* 
            ps_user_profile_imageのプラグイン画像サイズが指定されたサイズより小さい場合表示されなくなる
         */ ?>
        <span class="trick_rounded-img post_authorimage" style="background: url(<?php echo ps_get_user_profile_image_src(get_the_author_meta( 'ID' ), 'standard'); ?>) no-repeat center center; width: 60px; height: 60px;></span>
            <span class="trick_thumbnail_Image">
                <?php ps_user_profile_image( get_the_author_meta( 'ID' ), 'standard' ); ?>
            </span>
        <h2>
        	<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h2>
    </div>

    <!-- メイン記事部分 -->
    <div class="post">
        <?php
            //画像のサムネイル表示
            //echo 'サムネイル表示<br />';
            the_excerpt();
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
<?php endwhile; endif; ?>

<!-- 新しい記事古い記事 -->
<p class="pagelink">
    <span class="oldpage">
        <?php next_posts_link('&laquo; 古い記事'); ?>
    </span>
    <span class="newpage">
       <?php previous_posts_link('新しい記事 &raquo;'); ?>
    </span>
</p>