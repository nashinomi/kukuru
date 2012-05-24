<?php
/********************************
    シングル(illust)テンプレート
    添付ファイルからキャプションの情報や
    説明を表示する.
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
			/*
				get_the_content()の文字列編集
			*/
			$content=get_the_content();
			preg_match_all('/(wp-image-\d+)/',$content,$match);
			//print_r($match);
			$str='post_parent=0';
			// 要素が無い時は画像の読み込み処理しをない
			if(!empty($match[0][0])){
				$str='include='.mb_ereg_replace('[^0-9]','',$match[0][0]);
				for($i=1; $i<count($match[0]);++$i){
					$str=$str.','.mb_ereg_replace('[^0-9]','',$match[0][$i]);
				}
			}
			//echo 'クエリ＝$str='.$str;
			$post_imgs=get_posts($str.'&post_type=attachment');
			//リンクの貼られた[画像]を消す。
			$contentstr= mb_ereg_replace('<a href="http:\/\/[一-龠ぁ-んa-zA-Z0-9\.\/\%\"\ \=\-\?\_]+><img (.*)</a>','',$content);
			//改行文字の代入
			$contentstr=preg_replace("/\n/","<br />",$contentstr);
			//本文
			echo $contentstr;
			/*
				画像並び替え編成
			*/
			$nomber=$post->post_author;	//	記事投稿したユーザーのナンバー
			//--$nomber;					//	adminユーザー分を引く
			$users= get_users(array('role'=>'Editor'));
            $car_key=0;
            // カレントキーを検索
            foreach ($users as $key => $value){
                if($nomber==$value->ID){
                    $car_key=$key;
                }
                $max=$key+1;
            }
            $sortarray=array();
			$users_attachment=array();
			/*
            echo 'Carrent='.$car_key.'MAX='.$max.'<br />';
			print_r($users);
			echo '<br /><br /><br />';
			echo 'post_imgs=';
			print_r($post_imgs);
			echo '<br /><br /><br />';
			echo 'car_kery='.$car_key.'</br>';
			echo '<br /><br /><br />';
			echo '000numbar='.$nomber.'</br>';
			*/
			
			$attachments = get_children(array('numberposts' =>-1,'post_parent' => get_the_ID(), 'post_type' => 'any', 'post_mime_type' => 'image'));
			$car_odai_key=array();
			// 御題別ユーザー並び替え
			// プラス一は回転させるためー。・・
			for($i=0; $i<$max; ++$i){
			    $j=0;
				// このループは御題画像の配列番号を得ている
				foreach($post_imgs as $value):
                    if($value->post_author==$nomber){
				    	$sortarray[$i][$j]=$value;
				    	//echo 'count$i ='.$i;echo '<br />';
						$strarray= explode(',', $value->post_excerpt);
						//御題検索
						if(array_search('御題',$strarray)!==FALSE){
							$car_odai_key[$i]=$j;
						}	
						++$j;
				    }
				endforeach;
				
				// 応急処置
				if($nomber==4){
				    //echo '切り替え='.$i.'</br>';
					$car_key=0;
				}else{
					++$car_key;
				}
				//echo 'car_kery='.$car_key.'</br>';
				$nomber=$users[$car_key]->ID;
				//echo 'nonmber='.$nomber.'</br>';
				// 応急処置↓users配列の値へのアクセス忘れた
				//echo 'user[2]='.$users[2]->post_author.'<br>';
				
			}
            $value_link=0;
            /*
            print_r($users);
            echo '<br /><br /><br />1';
			print_r($sortarray[0]);
            echo '<br /><br /><br />2';
            print_r($sortarray[1]);
            echo '<br /><br /><br />3';
            print_r($sortarray[2]);
            echo 'count' .count($sortarray).'<br /><br /><br />';
			echo '<br /><br /><br />max='.$max;
			print_r($car_odai_key);
            */
           ?>
           
           <?php
           	for($i=0;$i<$max; ++$i){
				// 投稿者名を表示する
				
				//	御題のついた物を一番上に持ってくる
				if(!empty($car_odai_key)&&!empty($sortarray[$i][$car_odai_key[$i]])){
					// 改行文字を消されないために編集
                    $content = preg_replace("/\n/","<br />",$sortarray[$i][$car_odai_key[$i]]->post_content);
					$value_link=get_permalink($sortarray[$i][$car_odai_key[$i]]->ID);
					?>
					<div class="illust_box">
						<div class="illust_image">
							<a href="<?php echo $value_link; ?>">
							<?php echo wp_get_attachment_image($sortarray[$i][$car_odai_key[$i]]->ID, 'medium'); ?>
							</a>
						</div>
						<div class="illust_content">
							<img class="odaiimg" src="http://kukuruart.com/wp-content/themes/kukuruart/img/odai.png" alt="odai" />
							<h3 class="illust_name">
								<a href="<?php echo $value_link; ?>"><?php echo $sortarray[$i][$car_odai_key[$i]]->post_title ?></a>
							</h3>
							<?php
								if(empty($content)){
									echo '<p>この画像には説明がありません。</p>';  
								}else{
									echo "<p>$content</p>";
								}
							?>
							<span class="view_star">
								<?php the_ratings('div',$sortarray[$i][$car_odai_key[$i]]->ID,true); ?>
							</span>
						</div>
					</div>
                <?php
				}
                for($j=0; $j<count($sortarray[$i]); ++$j){
					//	既に御題絵として表示しているものは表示させない
					//	多分やってたのは上で表示した御題のついた絵は表示しない処理
					if($car_odai_key[$i]!==$j){
						// 改行文字を消されないために編集
						$content = preg_replace("/\n/","<br />",$sortarray[$i][$j]->post_content);
						// キャプション
						$strarray= explode(',', $sortarray[$i][$j]->post_excerpt);
						//print_r($strarray);
						$odai_key = array_search('御題',$strarray);
						$Unfin_key= array_search('未完成',$strarray);
						
						if($Unfin_key!==FALSE){$value_link=$sortarray[$i][$j]->guid.'" rel="lightbox['.$post->ID.']"';}
						else{$value_link=get_permalink($sortarray[$i][$j]->ID);}
						?>
						<div class="illust_box">
							<div class="illust_image">
								<a href="<?php echo $value_link; ?>">
								<?php echo wp_get_attachment_image($sortarray[$i][$j]->ID, 'medium'); ?>
								</a>
							</div>
							<div class="illust_content">
								<?php if($odai_key!==FALSE){echo '<img class="odaiimg" src="';bloginfo('template_directory'); echo'/img/odai.png" alt="odai" />';} ?>
								<?php if($Unfin_key!==FALSE){echo '<img class="odaiimg" src="';bloginfo('template_directory'); echo'/img/mikan.png" alt="mikan" />';}?> 
								<h3 class="illust_name">
									<a href="<?php echo $value_link; ?>"><?php echo $sortarray[$i][$j]->post_title ?></a>
								</h3>
								<?php
									if(empty($content)){
										echo '<p>この画像には説明がありません。</p>';  
									}else{
										echo "<p>$content</p>";
									}
								// 未完成だった時は表示しない
								if($Unfin_key===FALSE):
								?>
								<span class="view_star">
									<?php the_ratings('div',$sortarray[$i][$j]->ID,true); ?>
								</span>
								<?php endif; ?>
							</div>
						</div>
                    <?php
					}	// endif
                }	// endfor j
            }	//	endfor i
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
endif;
?>