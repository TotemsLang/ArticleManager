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

    $sqlfind =  "select * from user where Username = '".$username."'";
    $result = mysql_query($sqlfind);
    if(!($row = mysql_fetch_row($result)))
    {
        mysql_close($link);
        echo "未识别用户,请重新登陆!2秒后跳转到登陆页面";
        header("Refresh:2;url=login.php");
        die();
    }
    $Class = explode("|",$row[1]);
    $cClass = count($Class);

    mysql_close($link);
?>
<html>
	<head>
		<title>article manager</title>
		<meta charset="utf-8" />
		<link href="css/style.css" rel="stylesheet" type="text/css"/>
		<script language="javascript" src="scripts/script.js"></script>
	</head>
	
	<body>
		<div id="left" >
            <img id="head" src="images/head-img/head.jpg" >
            <h1 id="username"><?php echo $username ?></h1>
            <p><a href="new.php">新建文章</a></p>
            <div id="class">
        <?php
            $phd = "<p><a onclick=\"javascript:get_article(2,this.children[0].value)\" href=\"#\">";
            $hidhd = "<input value=\"";
            $hided = "\" hidden=\"true\">";
            $ped = "</a></p>";
            
            
            for($i = 0;$i < $cClass;$i++)
            {
                $Classname = explode(",",$Class[$i]);
                echo $phd.$hidhd.$Class[$i].$hided.$Classname[0].$ped;
            }
        ?>
            </div>
            
            <br>
            
            <p><a href="login.php">注销</a></p>
		</div>
		
		<div id="right" >
            <div id="content">
                <h1>
                    测试标题CeShiBiaoTi
                </h1>
                <p>
                    字体测试Font test
                </p>
            </div>
		</div>
        <iframe id="guide" src="guide.html"  scrolling="no">
        </iframe>

	</body>
</html>