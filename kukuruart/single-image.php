<?php
/********************************
	シングル(gallery)テンプレート
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
		    //the_content("more");
			//echo 'コンテンツ表示<br />';
			//
			// 直で画像を表示させる？↓
			?>
            <div id="mainimage">
			<?php
			echo '<a href="'.wp_get_attachment_url($post->ID).'" rel="lightbox['.$post->ID.']">';
			echo wp_get_attachment_image($post->ID, 'large');
			echo '</a>';
			?>
            </div>
            <?php
			// コンテンツの文章部分だけを取り出す
			$content = preg_replace("/\n/","<br />",get_the_content());
			// 説明の中に文字があるか調べる
			if($content){
				echo '<h3>説明</h3>';
				echo '<p>'.$content.'</p>';
			}else{
				echo '<p>この画像に説明文はありません</p>';
			}
			//	表示
			
			//print_r($content_test);
			//echo '<!-- '.$content_test.' -->';
			/*
			SRCに指定する値だけを取り出す処理↓
			$image=wp_get_attachment_image_src($post->ID, 'large');
			<img src="<?php echo $image[0];  ?>" alt="*" />
			print_r($image_test);
			*/
		?>
       	<div class="ratings_pos">
			<?php if(function_exists('the_ratings')) { the_ratings(); } ?>
        </div>
		<p class="postinfo">
			<?php echo get_the_date('Y年Fd日 l'); the_time(); ?>
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