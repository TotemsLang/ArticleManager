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
    //$post_data = substr($GLOBALS['HTTP_RAW_POST_DATA'],strpos($GLOBALS['HTTP_RAW_POST_DATA'],"=") + 1);
    //$up_content = substr($post_data,strpos($post_data,"=") + 1);
    //$up_index = substr($post_data,0,strpos($post_data,"&"));

    $up_content = $GLOBALS['HTTP_RAW_POST_DATA'];
    $up_index = $_GET['index'];
    $up_author = $_GET['author'];
    $up_title = $_GET['title'];
    $is_new = $_GET['isnew'];
    
    if(!($up_content | $up_author | $up_title))
        echo "(部分内容为空)";

    if($is_new == '0')
    {
        $sqlfind =  "update book set Content='".str_replace("'","''",$up_content)."', Name='".$up_title."', Author='".$up_author."' where `Index` = '".$up_index."'";
    }
    else if($is_new == '1')
    {
        $sqlfind =  "insert into book (`Name`,`Author`,`Class`,`CTime`,`ATime`,`Content`) values('".$up_title."','".$up_author."','".$_COOKIE["username"]."','".date('Ymd',time())."','".date('Ymd',time())."','".str_replace("'","''",$up_content)."')";
    }
    else
    {
        echo "操作无效！";
    }
    
    
    if (!($result = mysql_query($sqlfind)))
        die(mysql_error());
    echo "修改成功！";
?>