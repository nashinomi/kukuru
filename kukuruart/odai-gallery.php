<?php 
/********************************
        御題別ギャラリーページ  
********************************/

/*!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	手動依存プログラム、変更必要...。 
!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/

$odai_ranks=array();
$odai_value=array("ID"=>0,"post_user"=>0,"odai_title"=>'',"star_ave"=>0);
$odai_key=0;
$block_key=0;
// 全体の平均値を各ユーザー毎に算出する
$ave_total=array();
$ave_total_count=array();
// データ取り出し
$users= get_users(array('role' =>'Editor'));
$odai_posts= query_posts('showposts=-1&category_name=御題');

// 御題記事の御題絵をすべて取り出す
foreach($odai_posts as $cap_post):
	$odai_children = get_children(array('numberposts' =>-1,'post_parent' => $cap_post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image'));
	//print_r($cap_post);
	// タイトルを取得
	$odai_ranks[$odai_key]['id']=$cap_post->ID;
	
	// 投稿画像の要素を調べる
	foreach($odai_children as $value_cildren):
		$strarray= explode(',', $value_cildren->post_excerpt);
		// 御題キャプションがあるかの判定
		if(in_array('御題', $strarray)){
			$odai_value['ID']= $value_cildren->ID;
			$odai_value['post_user']= $value_cildren->post_author;
			$odai_value['odai_title']= $value_cildren->post_title;
			$odai_value['star_ave']= get_post_meta( $value_cildren->ID, 'ratings_average', true );
			$odai_ranks[$odai_key][$block_key]=$odai_value;
			//	空だった時の代入処理
			if(empty($ave_total[$odai_value['post_user']])){
				$ave_total[$odai_value['post_user']]=$odai_value['star_ave'];
				$ave_total_count[$odai_value['post_user']]=1;
			}else if($odai_value['star_ave']!=0){
				$ave_total[$odai_value['post_user']]+=$odai_value['star_ave'];
				$ave_total_count[$odai_value['post_user']]++;
				//$ave_total[$odai_value['post_user']]=($ave_total[$odai_value['post_user']]+$odai_value['star_ave'])/2;
			}else{
				//御題が存在していても評価されていなければカウントしない
			}
			
			$block_key++;
		}
	endforeach;
	// 御題名で一つ配列が増えているのでその分を引く
	$max=count($odai_ranks[$odai_key])-1;
	
	// 星の高順にユーザー並び変え
	for($i=0;$i<$max; ++$i){
		for($j=$max;$j>$i;--$j){
			if($odai_ranks[$odai_key][$i]['star_ave']*100 < $odai_ranks[$odai_key][$j]['star_ave']*100){
				$t=$odai_ranks[$odai_key][$j];
				$odai_ranks[$odai_key][$j]=$odai_ranks[$odai_key][$j-1];
				$odai_ranks[$odai_key][$j-1]=$t;
			}
		}
	}
	// 次の御題記事へ
	$odai_key++;
	$block_key=0;
endforeach;
$i=0;
//print_r($ave_total);
//print_r($ave_total_count);

// キーと値の取り出し
foreach($ave_total as $key=>$value):
	$users_rank[$i]->keys= $key;
	$users_rank[$i]->ave= $value;
	$users_rank[$i]->ave=round($users_rank[$i]->ave/ $ave_total_count[$key],2);
	$i++;
endforeach;

// 最大ユーザー数保持
$max=$i;


// バブルソート
for($i=0;$i<$max; ++$i){
	for($j=$max;$j>$i;--$j){
		if($users_rank[$i]->ave*100 < $users_rank[$j]->ave*100){
			$t=$users_rank[$j];
			$users_rank[$j]=$users_rank[$j-1];
			$users_rank[$j-1]=$t;
		}
	}
}

?>
<!-- odai_gallery_List -->
<div id="odai_rank_gallery">
	<h2>御題ランキング</h2>
	<ul id="odai_rank">
    	<?php for($i=0; $i<$max; ++$i): $value= $users_rank[$i];?>
        	<li>
            	<span class="trick_rounded-img" style="background: url(<?php echo ps_get_user_profile_image_src($value->keys, 'thumbnail' ); ?>) no-repeat center center; width: 50px; height: 50px;
				<?php 
				switch($i){
					case 0: echo 'border-color:#0F6;'; 		break;
					case 1: echo 'border-color:yellow;'; 	break;
					case 2: echo 'border-color:red";'; 		break;
					default: break;
				}?>">
                <span class="trick_thumbnail_Image"><?php ps_user_profile_image($value->keys, 'thumbnail' ); ?></span>
                </span>
                <?php $strarray= explode('.', $value->ave); ?>	
                
                <p><img src="<?php bloginfo('template_directory'); ?>/img/on_star.gif" alt="star" /><strong 
				<?php 
				switch($i){
					case 0: echo 'style="color:#0F6";';		break;
					case 1: echo 'style="color:yellow";'; 	break;
					case 2: echo 'style="color:red";'; 		break;
					default: break;
				}?>>
				<?php echo $strarray[0]; ?></strong><?php if($strarray[1]) echo '.'.$strarray[1]; ?></p>
            </li>
        <?php endfor; ?>
    </ul>
<?php
	// 御題別表示
	for($i=0; $i<count($odai_ranks); ++$i){
?>
    <table class="odaibox">
        <tr>
            <th colspan="3"><a href="<?php echo get_permalink($odai_ranks[$i]['id']);?>">
                <?php echo get_the_title($odai_ranks[$i]['id']);?></a>
            	<img src="<?php bloginfo('template_directory'); ?>/img/on_star.gif" alt="star" />
                <?php
					$odai_ave_total=$odai_ranks[$i][0]['star_ave'];
					// タイトル枠はカウントから消す-1
					$count_ave=count($odai_ranks[$i])-1;
					for($a=1; $a<$count_ave; ++$a){ 
						$odai_ave_total+=$odai_ranks[$i][$a]['star_ave'];
					}
					if($odai_ave_total==0&&$count_ave==0){
						echo 0;
					}else{
						echo round($odai_ave_total/$count_ave,2);
					}
				 ?>
				
            </th>
        </tr>
        <tr>
        <?php
            // -1は追加した御題タイトル分のマイナス
            for($j=0; $j< $max; ++$j){
				//	空だった場合の判定
				if(!$odai_ranks[$i][$j]['ID']){
					echo '<td></td>';
				}else{
					$imgs=wp_get_attachment_image_src($odai_ranks[$i][$j]['ID'], 'medium');
					?>
				<td>
					<a href="<?php echo get_permalink($odai_ranks[$i][$j]['ID']); ?>">
					<img src="<?php echo $imgs[0]; ?>" title="<?php echo $odai_ranks[$i][$j]['odai_title']; ?>" alt="<?php echo $odai_ranks[$i][$j]['odai_title']; ?>" width="<?php echo $imgs[1]; ?>" height="<?php echo $imgs[2]; ?>" />
					</a><br />
                    <?php echo $odai_ranks[$i][$j]['odai_title']; ?>
                    <img src="<?php bloginfo('template_directory'); ?>/img/on_star.gif" alt="star" />
                    <?php echo $odai_ranks[$i][$j]['star_ave']; ?>
				</td>
            
            <?php
				}
            }
        ?>
        </tr>
    </table>
        <?php
	}
    ?>
</div>