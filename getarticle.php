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
    
    if($_GET["method"] == 0)//根据名字查询
    {
        $sqlfind = "select * from book where `Name` = '".$_GET["value"]."' and `Class` = '".$username."'";
        $result = mysql_query($sqlfind);
        while ( $row = mysql_fetch_row($result)) 
        {
            echo "<div>";
            foreach ($row as $key => $value) 
            {
                switch($key)
                {
                    case 2:
                    case 4:
                        break;
                    default:
                        echo "<div>".$value."</div>";
                        break;
                }
            }
            echo "</div>";
        }
        mysql_close($link);
        die();
    }
    else if($_GET["method"] == 1)//根据创建时间查询
    {
        $sqlfind = "select * from book where `CTime` = '".$_GET["value"]."' and `Class` = '".$username."'";
        $result = mysql_query($sqlfind);
        
        while ( $row = mysql_fetch_row($result)) 
        {
            echo "<div>";
            foreach ($row as $key => $value) 
            {
                switch($key)
                {
                    case 2:
                    case 4:
                        break;
                    default:
                        echo "<div>".$value."</div>";
                        break;
                }
            }
            echo "</div>";
        }
        mysql_close($link);
        die();
    }
    else if($_GET["method"] == 2)//根据类型查询
    {
        $class_id = $_GET["value"];
        $sqlfind =  "select `Article` from class where `ID` = '".$class_id."'";
        $result = mysql_query($sqlfind);
        if(!($row = mysql_fetch_row($result)))
        {
            mysql_close($link);
            echo $root_select[$i]."：分类获取失败！请联系管理员";
            die(mysql_error());
        }
        $article_list = explode(",",$row[0]);
        $count = count($article_list);
        $flag = 1;
        for($i = 0; $i < $count; $i++)
        {
            $sqlfind = "select * from book where `Index` = '".$article_list[$i]."'";
            $result = mysql_query($sqlfind);
            while ( $row = mysql_fetch_row($result)) 
            {
                echo "<div>";
                foreach ($row as $key => $value) 
                {
                    switch($key)
                    {
                        case 2:
                        case 4:
                            break;
                        default:
                            echo "<div>".$value."</div>";
                            break;
                    }
                }
                echo "</div>";
            }
        }
        die();
    }
    else//全部文章查询
    {
        $sqlfind = "select * from book where `Class` = '".$_COOKIE['username']."'";
        $result = mysql_query($sqlfind);
        while ( $row = mysql_fetch_row($result)) 
        {
            echo "<div>";
            foreach ($row as $key => $value) 
            {
                switch($key)
                {
                    case 2:
                    case 4:
                        break;
                    default:
                        echo "<div>".$value."</div>";
                        break;
                }
            }
            echo "</div>";
        }  
        mysql_close($link);
        die();
    }
?>