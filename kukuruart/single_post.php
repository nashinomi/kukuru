<?php
/********************************
	シングル(post)テンプレート
********************************/
// 投稿データがあるか調べる
if(have_posts()):
	// あった場合グローバル$postからthe_postでこのpostに指定される？←ココ謎
	the_post();
?>
	<div class="postTitle">
    <span class="trick_rounded-img post_authorimage" style="background: url(<?php echo ps_get_user_profile_image_src(get_the_author_meta( 'ID' ), 'standard'); ?>) no-repeat center center; width: 60px; height: 60px;></span>
            <span class="trick_thumbnail_Image">
                <?php ps_user_profile_image( $post->post_author, 'standard' ); ?>
            </span>
        <h2><?php the_title(); ?></h2>     
	</div>

	<!-- メイン記事部分 -->
	<div class="post">
		<?php
			//echo 'コンテンツ表示<br />';
			the_content();
			// ↓これでも表示は可能だけど画像の横に文字が回り込んだりして改行がされない
			//echo $post->post_content;
		?>
		<p class="postinfo">
			<?php echo get_the_date('Y年Fd日 l'); the_time(); ?>
			|
			カテゴリー：<?php the_category(' , '); ?>
		</p>
	</div>
	
	<p class="pagelink">
		<span class="oldpage">
			<?php previous_post_link(); ?>
		</span>
		<span class="newpage">
			<?php next_post_link(); ?>
		</span>
	</p>
    
	<!-- コメント部分  -->
	<?php comments_template();
// end if hove_posts()	
endif;