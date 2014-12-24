<?php
	if(!$_COOKIE["isLogin"])
			die("请先登录！");

	$link = mysql_connect('localhost','root','root');
	mysql_select_db('article',$link) or die('Unable to use database bookdb: '.mysql_error());
	mysql_query("set names 'utf8'");
	
	$query = "DELETE FROM book WHERE `Index` = '".$_GET['index']."'";
	mysql_query($query) or die(mysql_error());
	mysql_close($link);
	echo "操作成功！";
	header("Location:index.php");

?>