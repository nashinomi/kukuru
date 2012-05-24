<?php
/********************************
	記事一覧テンプレート
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
<?php if(is_author()): ?>
    <p class="pagetitle">
        <?php the_author_meta(display_name,$author); ?>
    </p>
<?php endif; ?>
<div id="left_box">
    <!-- カテゴリー別 -->
    <ul id="tab">
        <li class="present"><a href="#tab_cat">カテゴリー別</a></li>
        <li><a href="#tab_month">月別</a></li>
        <li><a href="#tab_users">ユーザー別</a></li>
    </ul>
    <div id="sortbox">
        <!-- カテゴリー別 -->
        <div id="tab_cat">
            <ul>
        <?php
            $cat_all = get_terms( "category", "fields=all&get=all" );
            foreach($cat_all as $value):
         ?>
            <li><a href="<?php echo get_category_link($value->term_id); ?>">
                    <?php echo $value->name.'('.$value->count.')'; ?>
                </a>
           </li>
        <?php endforeach; ?>
            </ul>
        </div>
        <!-- 月別 -->
        <div id="tab_month">
            <ul><?php wp_get_archives('type=monthly&show_post_count=1'); ?></ul>
        </div>
        <div id="tab_users">
            <ul>
            <?php 
                //print_r($users);
                $users= get_users();
                foreach($users as $value):
                /*the_author_meta*/
                    echo '<li><a href="'.get_home_url().'/author/'.$value->user_nicename.' ">'.$value->display_name.'('.get_usernumposts($value->ID).')'.'</a></li>';
                endforeach;
            ?>
            </ul>
        </div>
    </div>
</div>
<div id="right_box">
    <!-- 新着記事 -->
    <p>新着コメント</p>
    <div id="new_comments">
    <?php 
    /*	
        Get Recent Commentsは使い勝手はいいけど
        postデータしかとってこないので保留
    
    if (function_exists('get_recent_comments')) { ?>
       <li>
       <ul><?php get_recent_comments(); ?></ul>
       </li>
    <?php } 
	*/?>
        <?php get_recently_commented(); ?>
    </div>
    <?php //query_posts('author='.$onlyID); ?>
    
</div>
	<?php if(have_posts()): while(have_posts()): the_post();?>
    <div class="postTitle">
        <?php 
        /* 
            ps_user_profile_imageのプラグイン画像サイズが指定されたサイズより小さい場合表示されなくなる
         */ ?>
        <a href="<?php echo get_home_url() ?>/author/<?php the_author(); ?>">
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

<script type="text/javascript">
// <![CDATA[
    tab.setup = {
        tabs: document.getElementById('tab').getElementsByTagName('li'),
         
        pages: [
            document.getElementById('tab_cat'),
            document.getElementById('tab_month'),
            document.getElementById('tab_users')
        ]
    } //オブジェクトをセット
    tab.init(); //起動！
// ]]>
</script>