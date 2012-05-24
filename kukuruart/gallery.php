<?php 
/********************************
		ギャラリーページ	
*******************************

<div id="gallery_nav">
	<ul id="gallery_nav">
    	<li>a</li>
        <li><a href="<?php echo get_permalink().'odai-gallery'; ?>">
                <img src="<?php bloginfo('template_directory'); echo'/img/odai.png' ?>" />
            </a>
        </li>
        <li>c</li>
        <li>d</li>
    </ul>
<!-- end gallery_nav -->
</div>
<div class="clear"></div>
*/ ?>
<!-- gallery_List -->
<div id="new_gallery_box">
	<?php 
	//　画像を表示する処理
	//$args = array( 'numberposts'=>7, 'offset'=>3, 'post_type'=> 'attachment', 'author'=>$user->ID);
	//$posts= get_posts('nopaging=1&offset=0&post_type=attachment');
	
	$onlyID=0;
	$count_max=7;
	$only= $_GET['user'];
	switch($only){
		case 'na'		: $onlyID=2; break;
		case 'nana'		: $onlyID=3; break;
		case 'test'		: $onlyID=4; break;
		default				: break;
	}
	$users= get_users(array('role' =>'Editor'));
	foreach($users as $user):
	if($onlyID==0 || $user->ID==$onlyID){
	?>
        <div class="new_gallery_authorbox">            
            <p class="authorName"><a href="<?php echo get_home_url().'/gallery?user='.$user->user_nicename; ?>"><?php echo $user->display_name; ?></a></p>
            
            <span class="rounded-img" style="background: url(<?php echo ps_get_user_profile_image_src($user->ID, big); ?>) no-repeat center center; width: 70px; height: 70px;">
            <span class="authorImage"><?php ps_user_profile_image( $user->ID, 'big' ); ?></span>
            </span>
           
<div class="authorImages">
      <?php
            $posts= query_posts('posts_per_page=-1&offset=0&post_type=attachment&post_status=inherit&author='.$user->ID);
            if(empty($posts)){
                echo '<p class="notimage">投稿がありません</p>';	
            }else{
                foreach($posts as $post):
                // キャプションに写真と入力されていた場合のみ表示
                if($post->post_excerpt){
                    $strarray= explode(',', $post->post_excerpt);
                    // 写真以外のキャプションはとっぱらう
                    if(in_array('写真', $strarray)){
                        ++$count;
        ?>
              <div class="new_thumbnail_Image">
                            <a href= "<?php echo get_permalink(); ?>">
                            <p><?php echo get_the_date(Fd日); ?></p>
                            <?php
                                $thumbnails= wp_get_attachment_image_src($post->ID, 'thumbnail');
                            ?>
                            <?php //echo $post->post_excerpt; ?>
                            <span class="rounded-img" style="background: url(<?php print($thumbnails[0]); ?>) no-repeat center center; width: <?php echo $thumbnails[1]; ?> height: <?php echo $thumbnails[2];?>; <?php if(strpos($post->post_excerpt,'未完成')){ echo'border-color:yellow;'; } ?>";>
                            <img src="<?php echo $thumbnails[0]; ?>" style="opacity: 0;" alt="*" width=<?php echo $thumbnails[1]; ?>; height=<?php echo $thumbnails[2];?>;" />
                            </span>
                            </a>
                        </div>
        <?php	
                    }
                }
                // これだと最新7件しか取れないどうしよう..
                if($count>= 7){
                    if($onlyID==0){
                        break;
                    }else{
                        $count=0;
                        echo '<br />';
                    }
                }
                endforeach;
                
                if($count==0){
                    echo '<p class="notimage">投稿がありません</p>';
                }
                $count=0;
            }
        ?>
            <!-- end authorImages-->
            </div>
        <!-- end new_gallery_authorbox -->
        </div>
	<?php
	}
	endforeach; 
	?>
</div>