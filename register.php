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
        header("Content-Type: text/html;charset=utf-8");
        echo "注册成功!3秒后跳转到登陆页面";
        header("Refresh:3;url=login.php");
        die();
	}
	
?>
<html>
    <head>
        <meta charset="utf-8">
        <script src="md5.js"></script>
        <script src="reg.js"></script>
    </head>
    
    <body>
        <form id="reg" action="register.php?action=reg" method="post" >
            用户名:<input name="username" ><br>
            密码:<input id="pw1" name="password" type="password" ><br>
            确认密码:<input id="pw2" name="password_sure" type="password"><br>
            <input onclick="javascript:reg();" type="button" value="注册"><br>
        </form>
    
    </body>


</html>