<?php
    header("Content-Type: text/html;charset=utf-8");

    if($_COOKIE["isLogin"] != '1')
    {
        echo "未登录!2秒后跳转到登陆页面";
        header("Refresh:2;url=login.php");
        die();
    }

    $username = $_COOKIE["username"];
    $link = mysql_connect('localhost','root','root');
    if(!$link){
        die('Fail to connect database'.mysql_error());
    }

    mysql_select_db('article',$link) or die('Unable to use database bookdb: '.mysql_error());
    mysql_query("set names 'utf8'");

    $method = $_GET['method'];
    $index = $_GET['index'];

    if($method == 'del_node')
    {
        $sqlfind =  "select * from class where `ID` = '".$index."'";
        $result = mysql_query($sqlfind);
        $row = mysql_fetch_row($result);
        $next_class = explode(",",$row[3]);
        $child_article = explode(",",$row[4]);
        //$next_article = $row[4];
        $length = count($next_class);
        
        $sqlfind =  "select * from class where `ID` = '".$next_class[1]."'";
        $result = mysql_query($sqlfind);
        $row = mysql_fetch_row($result);
        if(!$row)
            die("ERROR");
        $ajax_back = $row[1].",".$next_class[1];

        for($i = 2; $i < $length; $i++)
        {
            $sqlfind =  "select * from class where `ID` = '".$next_class[$i]."'";
            $result = mysql_query($sqlfind);
            $row = mysql_fetch_row($result);
            $ajax_back = $ajax_back."|".$row[1].",".$next_class[$i];
        }
        
        $ajax_back = $ajax_back."&";
        
        $sqlfind = "select Name from book where `Index` = ".$child_article[0];
        $result = mysql_query($sqlfind);
        $row = mysql_fetch_row($result);
        if(!$row)
            die("ERROR");
        $ajax_back = $ajax_back.$row[0].",".$child_article[0];
        $length = count($child_article);
        
        for($i = 1; $i < $length; $i++)
        {
            $sqlfind =  "select Name from book where `Index` = ".$child_article[$i];
            $result = mysql_query($sqlfind);
            $row = mysql_fetch_row($result);
            if($row[0] == "")
                continue;
            $ajax_back = $ajax_back."|".$row[0].",".$child_article[$i];
        }
        
        
        die($ajax_back);
    }

    
    

?>