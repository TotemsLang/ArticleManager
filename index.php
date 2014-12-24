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
    $root_class_ID = $row[1];
    $head_img = $row[4];
    
        echo $sqlfind;
    $sqlfind =  "select * from class where `ID` = '".$root_class_ID."'";
    echo $sqlfind;
    $result = mysql_query($sqlfind);
    if(!($row = mysql_fetch_row($result)))
    {
        mysql_close($link);
        echo "分类获取失败！请联系管理员";
        die(mysql_error());
    }
    $root_select = explode(",",$row[3]);
    $root_select_count = count($root_select);

?>
<html>
	<head>
		<title>article manager</title>
		<meta charset="utf-8" />
		<script src="scripts/script.js"></script>
        <script src="scripts/widgEditor.js"></script>
        <style type="text/css" media="all">
            @import "css/widgEditor.css";
            @import "css/style.css";
        </style>
	</head>
	
	<!--<body onload="javascript:get_article(-1,-1);">-->
    <body>
		<div id="left" >
            <img id="head" src="images/head-img/<?php echo $head_img ?>" >
            <h1 id="username" onclick="javascript:profile();"><?php echo $username ?></h1>
            <hr />
            <p><a href="#" onclick="javascript:edit(-1,1)">新建文章</a></p>
            <p><a href="#" onclick="javascript:get_article(-1,-1)">全部文章</a></p>
            <hr /> 
            <div id="class">
                <section class="container">
                    <div>
                        <p>一级分类</p>
                        <div class="dropdown">
                            <select id="class0" onchange="javascript:select(this);" class="dropdown-select">
                                <option value="-1">请选择一项</option>
                                <?php
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
                                ?>
                            </select>
                        </div>
                    </div>
                    <div>   
                        <p>二级分类</p>
                        <div class="dropdown">
                            <select id="class1" onchange="javascript:select(this);" class="dropdown-select">
                                <option value="-1">请选择一项</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <p>三级分类</p>
                        <div class="dropdown">
                            <select id="class2" onchange="javascript:select(this);" class="dropdown-select">
                                <option value="-1">请选择一项</option>
                            </select>
                        </div>
                    </div>
                </section>
            </div>
            <hr />
            <p><a href="login.php">注销</a></p>
		</div>
		
		<div id="right" >
            <div id="content"> 
                
            </div>
		</div>
        <iframe id="guide" src="guide.html"  scrolling="no">
        </iframe>
        <div id="shadow">
        </div>
        <div id="edit">
            <textarea id="editor" class="widgEditor"></textarea>
        </div>
	</body>
</html>