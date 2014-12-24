<?php
    header("Content-Type: text/html;charset=utf-8");
    if($_COOKIE["isLogin"] != '1')
    {
        echo "未登录!2秒后跳转到登陆页面";
        header("Refresh:2;url=login.php");
        die();
    }

	$link = mysql_connect('localhost','root','root');
	mysql_select_db('article',$link) or die('Unable to use database article: '.mysql_error());
	mysql_query("set names 'utf8'");
	$query = "DELETE FROM book WHERE `Index` = '".$_GET['index']."'";
	mysql_query($query) or die(mysql_error());
	mysql_close($link);
	echo "删除成功！";
?>