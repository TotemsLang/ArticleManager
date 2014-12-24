<?php
    header("Content-Type: text/html;charset=utf-8");
    if($_COOKIE["isLogin"] != '1')
    {
        echo "未登录!2秒后跳转到登陆页面";
        header("Refresh:2;url=login.php");
        die();
    }
    
    $link = mysql_connect('localhost','root','root');
    if(!$link){
        die('Fail to connect database'.mysql_error());
    }
    mysql_select_db('article',$link) or die('Unable to use database article: '.mysql_error());
    mysql_query("set names 'utf8'");
    
    $username = $_COOKIE["username"];
    $sqlfind =  "select * from user where Username = '".$username."'";
    $result = mysql_query($sqlfind);
    if(!($row = mysql_fetch_row($result)))
    {
        mysql_close($link);
        echo "未识别用户,请重新登陆!2秒后跳转到登陆页面";
        header("Refresh:2;url=login.php");
        die();
    }
    
    if(strcmp(md5($_GET['oldpw']),$row[3]) != 0)
    {
        die("原密码输入错误！");
    }

    if($_GET['headimg'] != "")
    {
        $sqlfind =  "update user set Image='".$_GET['headimg']."' where Username = '".$username."'";
        mysql_query($sqlfind) or die('Unable to modify password: '.mysql_error());
    }
    
    $sqlfind =  "update user set Password='".md5($_GET['newpw'])."' where Username = '".$username."'";
    mysql_query($sqlfind) or die('Unable to modify password: '.mysql_error());
    
    echo "OK";

?>