// JavaScript Document
<!--
/*
<!--
<script type="text/javascript">
	var j=jQuery.noConflict();

	j(function(){
		function test(){
			alert("1");
			var data = "文字出てこい！";
			alert("2");
			var textarea = j("#comment");
			alert("3");
			textarea.text(data);
			alert("4")
			//alert(document.container.main.comments.respond.commentform.comment.value);
		}
	});
	
	function test2(){
		//var test=document.getElementById("testtest");
		alert('start');
		var test= j("testest");	
		alert(test.innerHTML);
		alert('end');
	}
	
	function test3(){
		alert("start");
		var data = "文字出てこい！";
		var textarea = j("#comment");
		textarea.text(data);
		alert("end");
	}
</script>
-->	
*/
<!-- 
// 競合を避ける処理？
var j=jQuery.noConflict();

function temple(){
	var data = 
	"技術点:\n立体感:\n構成力:\nインパクト:\nチャレンジ:\n合計値:\n";
	var textarea = j("#comment");
	textarea.text(data);
}

// tab

var tab = {
	init: function(){
		var tabs = this.setup.tabs;
		var pages = this.setup.pages;
		 
		for(i=0; i<pages.length; i++) {
			if(i !== 0) pages[i].style.display = 'none';
			tabs[i].onclick = function(){ tab.showpage(this); return false; };
		}
	},
		 
	showpage: function(obj){
		var tabs = this.setup.tabs;
		var pages = this.setup.pages;
		var num;
		 
		for(num=0; num<tabs.length; num++) {
			if(tabs[num] === obj) break;
		}
		 
		for(var i=0; i<pages.length; i++) {
			if(i == num) {
				pages[num].style.display = 'block';
				tabs[num].className = 'present';
				j('#sortbox').jScrollPane();
			}
			else{
				pages[i].style.display = 'none';
				tabs[i].className = null;
			}
		}
	}
}

-->