<?php
/*****************************************************
	wordpressの管理画面からjsファイルの編集
******************************************************/
//ブラウザにはキャッシュしてほしい
$expires = 3600000;
header('Last-Modified: Fri Jan 01 2010 00:00:00 GMT');
header('Expires: ' . gmdate('D, d M Y H:i:s T', time() + $expires));
header('Cache-Control: private, max-age=' . $expires);
header('Pragma: ');
 
//これ重要
header('Content-Type: text/javascript; charset=UTF-8');
?>
 
/*-----------------------------------------------------
javascriptの処理をここから以下に記入してもらえば大丈夫です
：基本的に投稿ページにしか反映されませんのでご了承ください。
------------------------------------------------------*/
/*
    function test()
    {
        alert("Hello!");
    }
*/