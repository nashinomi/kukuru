<?php 
		/*
			現在コメント自動了承された状態。
			一般公開しないようにする。
			参照URL:			http://www.konnect-kollect.info/wordpress%E9%9D%9E%E5%85%AC%E9%96%8B%E3%82%B5%E3%82%A4%E3%83%88%E3%81%AE%E3%82%B3%E3%83%A1%E3%83%B3%E3%83%88%E8%87%AA%E5%8B%95%E6%89%BF%E8%AA%8D%E8%A8%AD%E5%AE%9A.html
			
			wp_include/comment.phpの
			//	if ( ! isset($comment_approved) )
			ここのコメントアウトを消せばもとに戻る
			
		*/
 ?>

<div id="comments" name="comments">
	<?php if(have_comments()): ?>
	<h3>コメント</h3>
	<ul>
		<?php wp_list_comments('callback=mydesign'); ?>
	</ul>
	<?php endif; ?>
	<?php comment_form(); ?>
</div>

<?php
/*
 * トラックバックの必要性が無いのでコメントアウト
 * 
 * 	<p id="comfeed">
		<?php post_comments_feed_link(); ?>
	</p>
    <!--
    <form>
    	<input type="button" value="テンプレート表示" onclick="test()">
    </form>
    -->
   
	<!-- トラックバック部分 -->
	<?php if(pings_open()): ?>
		<p id="trurl">
			<strong>トラックバックURL:</strong>
			<?php trackback_url(); ?>
		</p>
	<?php endif; ?>
 */ 
 ?>


