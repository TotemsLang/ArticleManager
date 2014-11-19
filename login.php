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
		function login(){
            var passwd = document.getElementById('pwm').value;
            document.getElementById('pw').value = hex_md5(passwd);
			document.getElementById('log_post').submit();
		}
	</script>
	<link href="css/login.css" rel="stylesheet" type="text/css"/>
		<title>用户登录</title>
	</head>
	<body>
		<div id="login">
			<h1>用户登录</h1>
			<form id="log_post" action="login.php?action=login" method="post">
				<table>
					<tr>
						<td><p>用户名：</p></td>
						<td><input name="username"/></td>
					</tr>
					<tr>
						<td><p>密码：</p></td>
						<td><input id="pwm" name="passwd" type="password"></td>
					</tr>
                    <input id="pw" name="password" type="password" hidden="true">
				</table>
			</form>
			<a id="log" class="large awesome" onclick="javascript:login();">登录</a>
			<a id="reg" class="large awesome" href="register.php" >注册</a>
		</div>
	</body>
</html>
