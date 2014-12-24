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
    $param1 = $_GET['param1'];
    $param2 = $_GET['param2'];
    $param3 = $_GET['param3'];

    if($method == 'change_name')
    {
        $sqlfind =  "update class set Name='".$param2."' where `ID` = '".$param1."'";
        mysql_query($sqlfind) or die(mysql_error());
        die();
    }

    if($method == 'add_article')
    {
        $sqlfind =  "select * from class where `ID` = '".$param1."'";
        $result = mysql_query($sqlfind);
        $row = mysql_fetch_row($result);
        if($row[4])
            $new_article = $row[4].",".$param2;
        else
        {
            $new_article = $param2;
        }
        $sqlfind =  "update class set Article='".$new_article."' where `ID` = '".$param1."'";
        mysql_query($sqlfind) or die(mysql_error());
        die();
    }
    
    if($method == 'add_class')
    {
        $sqlfind =  "select * from class where `ID` = '".$param1."'";
        $result = mysql_query($sqlfind);
        $row = mysql_fetch_row($result);
        if($row[2] == '3')
        {
            die("不能将子类插入到三级分类 ！");
        }
        
        $new_type = $row[2] + 1;
        $old_next = $row[3];
        
        $query = "insert into `class` (`Name`,`Type`,`User`) values('".$param2."','".$new_type."','".$username."')";
        $result = mysql_query($query) or die("Error in query: $query. ".mysql_error());
        
        $lastid = mysql_insert_id();
        $query =  "update class set User='".$username."', Next='".$lastid."' where `ID` = '".$lastid."'";
        $result = mysql_query($query) or die("Error in query: $query. ".mysql_error());
        
        $new_next = $old_next.",".$lastid;
        $query =  "update class set Next='".$new_next."' where `ID` = '".$param1."'";
        $result = mysql_query($query) or die("Error in query: $query. ".mysql_error());

        die();
    }

    if($method == "del_node")
    {
        $sqlfind =  "select * from class where `ID` = '".$param1."'";
        $result = mysql_query($sqlfind);
        $row = mysql_fetch_row($result);
        $books = explode(",",$row[4]);
        $nodes = explode(",",$row[3]);
        
        if($param3 == "book")
        {
            for($i=0;$i<count($books);$i++)
            {
                if($books[$i] == $param2)
                {
                    array_splice($books,$i,1);
                    break;
                }
            }
            $newbooks = join(",",$books);
            $query =  "update class set Article='".$newbooks."' where `ID` = '".$param1."'";
            $result = mysql_query($query) or die("Error in query: $query. ".mysql_error());
            die();
        }
        else if($param3 == "node")
        {

            for($i=0;$i<count($nodes);$i++)
            {
                if($nodes[$i] == $param2)
                {
                    array_splice($nodes,$i,1);
                    break;
                }
            }
           
            $newnodes = join(",",$nodes);
            $query =  "update class set Next='".$newnodes."' where `ID` = '".$param1."'";
            $result = mysql_query($query) or die("Error in query: $query. ".mysql_error());
            $query =  "delete from class where `ID` = '".$param2."'";
            $result = mysql_query($query) or die("Error in query: $query. ".mysql_error());
            die();
        }
            
        die("ERROR");
        
    }



?>