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

    if($_GET["method"] == 0)
    {
        $sqlfind = "select * from book where `Name` = '".$_GET["value"]."'";
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
    else if($_GET["method"] == 1)
    {
        $sqlfind = "select * from book where `CTime` = '".$_GET["value"]."'";
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
    else if($_GET["method"] == 2)
    {
        $article_list = explode(",",$_GET["value"]);
        $count = count($article_list);

        for($i = 1; $i < $count; $i++)
        {
            echo "<div>";
            $sqlfind = "select * from book where `Index` = '".$article_list[$i]."'";
            $result = mysql_query($sqlfind);
            while ( $row = mysql_fetch_row($result)) 
            {
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
            }
            echo "</div>";
        }
        die();
    }
    else
    {
        $sqlfind = "select * from book";
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