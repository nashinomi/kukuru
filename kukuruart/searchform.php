<?php /*
    <input type="text" class="searchtext" name="s" id="s" value="Search..." onblur="if (value == '')  {value = 'Search...';}" onfocus="if (value == 'Search...') value = '';"  />
*/?>

<form method="get" action="<?php bloginfo ('url'); ?>/">
	<!-- searchtextが空白だった時はsubmitしても検索を開始しない様にする予定 -->
    <input type="text" id="s" name="s" class="searchtext" value="" />
    <!--<input type="submit" value="検索" /> -->
    <input type="image" class="searchbutton"  src="<?php bloginfo ('template_directory'); echo '/img/search.jpg' ?>" alt="検索">
</form>