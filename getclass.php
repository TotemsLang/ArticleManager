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

    $sqlfind =  "select * from class where `ID` = '".$_GET['index']."'";
    $result = mysql_query($sqlfind);
    if(!($row = mysql_fetch_row($result)))
    {
        mysql_close($link);
        echo "分类获取失败！请联系管理员";
        die(mysql_error());
    }
    $root_select = explode(",",$row[3]);
    $root_select_count = count($root_select);

    for($i = 0; $i < $root_select_count; $i++)
    {
        $sqlfind =  "select * from class where `ID` = '".$root_select[$i]."'";
        $result = mysql_query($sqlfind);
        if(!($row = mysql_fetch_row($result)))
        {
            mysql_close($link);
            echo $root_select[$i]."分类获取失败！请联系管理员";
            die(mysql_error());
        }
        echo "<option value=\"".$row[0]."\">".$row[1]."</option>";
    }

    mysql_close($link);

?>