<?php
	//投稿フォーマット
	add_theme_support('post-formats',array('gallery','status'));
	
	//ウィジェト
	register_sidebar();
	
	// the_excerptの抜粋文字数制限？
	function new_excerpt_length($length) {	
		return 20;	
	}
	add_filter('excerpt_length', 'new_excerpt_length');
	function new_excerpt_more($post) {
		return '<a href="'. get_permalink($post->ID) . '">' . '続きを読む...' . '</a>';	
	}	
	add_filter('excerpt_more', 'new_excerpt_more');

	
	
	// 受信したコメント
	function mydesign($comment, $args, $depth){
		$GLOBALS['comment']=$comment; 
		
		$users = get_users();
?>
        <li id="comment-<?php echo comment_id(); ?>" class="compost">
             <?php
			 	
                // ユーザーIDを引っ張る
                foreach ($users as $user){
					//echo $user->display_name.'<br />';
					//echo get_comment_author();
                    if($user->display_name == get_comment_author()){
                        break;
                    }
                }
				?>
                <span class="trick_rounded-img icon_image" style="background: url(<?php echo ps_get_user_profile_image_src($user->ID, 'standard'); ?>) no-repeat center center; width: 50px; height: 50px;></span>
				<span class="trick_thumbnail_Image">
					<?php ps_user_profile_image( $user->ID, 'thumbnail' ); ?>
				</span>
                <?php
            ?>
            <div class="commentarea">
            	<?php 
            		//改行表示
            		$commentstr='<p>'.get_comment_text().'</p>';
					$commentstr=preg_replace("/\n/","<br />",$commentstr);
					echo $commentstr;
            		//comment_text();
            	?>
            
            </div>
            
            <p class="cominfo">
                <?php comment_date(); ?>
                <?php comment_time(); ?>
                |
                <?php comment_author_link(); ?>
                <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'reply_text' => '返信', 'before' => ' | ', 'after' => '') ) ); ?>
            </p> 
        </li>

<?php
	}
	/* 投稿記事の写真データのurlを配列で返す */
	function get_the_post_image_src($postid,$size,$order=0,$max=null) {
		$attachments = get_children(array('post_parent' => $postid, 'post_type' => 'attachment', 'post_mime_type' => 'image'));
		
		

		/* empty()を追加してworningを消してる */
		if ( is_array($attachments) && !empty($attachments) ){
			print_r($attachments);
			foreach ($attachments as $key => $row) {
				echo '$row->menu_order='.$row->menu_order."<br />";
				$mo[$key]  = $row->menu_order;
				echo '$row->ID='.$row->ID."<br />";
				$aid[$key] = $row->ID;
			}
			
			array_multisort($mo, SORT_ASC,$aid,SORT_DESC,$attachments);
			
			$max = empty($max)? $order+1 :$max;
			for($i=$order;$i<$max;$i++){
				echo '$attachments[$i]->ID='.$attachments[$i]->ID."<br />";
				return wp_get_attachment_image_src( $attachments[$i]->ID, $size );
			}
		}
	}
	// 画像
	set_post_thumbnail_size( $width, $height, $crop_flag ); 
	
	// カスタムメニュー
	register_nav_menus(array('navigation' => 'ナビゲーションバー'));
	
	// カスタムヘッダー
	add_custom_image_header('','admin_header_style');
	function admin_header_style(){
		/*ブラウザのWindowサイズに関係なく指定された大きさで表示する*/
		?>
		<style type="text/css">
			#headimg{ width: 760px!important }
		</style>
		<?php
	}
	
	/* 文字重なり表示をしない */
	define('NO_HEADER_TEXT', true);
	/* ヘッダー画像の指定 */
	define('HEADER_IMAGE', '%s/default_header.jpg');
	define('HEADER_IMAGE_WIDTH', 886);
	define('HEADER_IMAGE_HEIGHT', 259);
	
	// カスタム背景
	add_custom_background();
	
	// 投稿ページでのキャプション自動挿入をOffにする
	define('CAPTIONS_OFF', true);
	add_filter('disable_captions', create_function('','return true;'));
?>