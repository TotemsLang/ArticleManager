<?php
    header("Content-Type: text/html;charset=utf-8");
	function clearCookies()
	{
		setcookie('username','',time()-3600);
		setcookie('isLogin','',time()-3600);
	}

	if($_GET['action']=='login')
	{
		clearCookies();

		$link = mysql_connect('localhost','root','root');
        if(!$link){
            die('Fail to connect database'.mysql_error());
        }

        mysql_select_db('article',$link) or die('Unable to use database bookdb: '.mysql_error());
        mysql_query("set names 'utf8'");
        
        $sqlfind =  "select Password from user where Username = '".$_POST['username']."'";
        $result = mysql_query($sqlfind);
        $row = mysql_fetch_row($result);
        mysql_close($link);
        
        
		if($_POST['password'] == $row[0])
		{
			setcookie('username',$_POST['username'],time()+60*60*24*7);
			setcookie('isLogin','1',time()+60*60*24*7);
			header("Location:index.php");
		}
		else{
			die("用户名或密码错误!");
		}
	}
	else
	{
		clearCookies();
	}

?>

<html>
	<head>
	<meta charset="utf-8">
    <script src="scripts/md5.js"></script>
	<script>
		function to_login(){
            var passwd = document.getElementById('password').value;
            document.getElementById('pw').value = hex_md5(passwd);
			document.getElementById('log_post').submit();
		}
	</script>
	<link href="css/login.css" rel="stylesheet" type="text/css"/>
		<title>用户登录</title>
	</head>
	<body>
		<div id="login">
            <form id="log_post" method="post" action="login.php?action=login" class="login">
                <p>
                  <label for="login">Username：</label>
                  <input type="text" name="username" id="login">
                </p>

                <p>
                  <label for="password">Password：</label>
                  <input type="password" name="passwd" id="password">
                </p>

                <p class="login-submit">
                  <button type="button" onclick="javascript:to_login();" class="login-button">Login</button>
                </p>
                
                <input id="pw" name="password" type="password" hidden="true">
                

                <p class="forgot-password"><a href="register.php">Click here to register</a></p>
            </form>
            
		</div>
	</body>
</html>
