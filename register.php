<?php
    if($_GET['action']=='reg')
	{
        $username = $_POST['username'];
        $password = $_POST['password'];

		$link = mysql_connect('localhost','root','root');
        if(!$link){
            die('Fail to connect database'.mysql_error());
        }

        mysql_select_db('article',$link) or die('Unable to use database bookdb: '.mysql_error());
        mysql_query("set names 'utf8'");
        
        $sqlfind =  "select Password from user where Username = '".$username."'";
        $result = mysql_query($sqlfind);
        if($row = mysql_fetch_row($result))
        {
            die("User exsits!");
        }
        
        $query = "insert into `user` (`Username`,`Password`) values('".$username."','".md5($password)."')";
        $result = mysql_query($query) or die("Error in query: $query. ".mysql_error());  
        
        $query = "insert into `class` (`Name`,`Type`,`User`) values('".$username."','0','".$username."')";
        $result = mysql_query($query) or die("Error in query: $query. ".mysql_error());
        
        $lastid = mysql_insert_id();
        $query =  "update class set User='".$username."', Next='".$lastid."' where `ID` = '".$lastid."'";
        $result = mysql_query($query) or die("Error in query: $query. ".mysql_error());
        
        $query =  "update user set Class='".$lastid."' where Username = '".$username."'";
        $result = mysql_query($query) or die("Error in query: $query. ".mysql_error());
        
        header("Content-Type: text/html;charset=utf-8");
        echo "注册成功!3秒后跳转到登陆页面";
        header("Refresh:3;url=login.php");
        die();
	}
	
?>
<html>
    <head>
        <meta charset="utf-8">
        <script src="scripts/md5.js"></script>
        <script src="scripts/reg.js"></script>
        <link href="css/reg.css" rel="stylesheet" type="text/css"/>
    </head>
    
    <body>
        <form id="reg" action="register.php?action=reg" method="post" >
            <div id="login" class="reg">
                <p>
                    <label for="username">用户名称：</label>
                    <input type="text" name="username" id="username">
                </p>
                <p>
                    <label for="pw1">用户密码：</label>
                    <input type="password" name="password" id="pw1">
                </p>
                <p>
                    <label for="pw2">确认密码：</label>
                    <input type="password" name="password_sure" id="pw2">
                </p>

                    <button type="button" onclick="javascript:reg();" class="login-button">Login</button>
            </div>
            
        </form>
    
    </body>


</html>