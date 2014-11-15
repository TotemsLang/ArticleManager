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
    <script src="md5.js"></script>
	<script>
		function login(){
            var passwd = document.getElementById('pw').value;
            document.getElementById('pw').value = hex_md5(passwd);
			document.getElementById('log_post').submit();
		}
	</script>
	<style type="text/css">div.wrapper{width:940px;margin:0 auto;padding:0 30px 36px;position:relative;}div#header{background:#f5f5f5;height:72px;border-bottom:1px solid #eee;margin:0;}div#header h4{float:left;position:absolute;top:24px;left:145px;border-left:1px solid #ddd;padding-left:14px;}div#header h4 small{font-size:14px;font-weight:normal;}div#header h4 a,div#header h4 a:visited{font-weight:normal;}div.page-header{padding:0 0 8px;margin:18px 0;border-bottom:1px solid #ddd;}div.page-header h1{padding:0;margin:0;font-size:24px;line-height:27px;letter-spacing:0;}.awesome,.awesome:visited{background:#222 url(alert-overlay.png) repeat-x;display:inline-block;padding:5px 10px 6px;color:#fff;text-decoration:none;-moz-border-radius:5px;-webkit-border-radius:5px;-moz-box-shadow:0 1px 3px rgba(0,0,0,0.5);-webkit-box-shadow:0 1px 3px rgba(0,0,0,0.5);text-shadow:0 -1px 1px rgba(0,0,0,0.25);border-bottom:1px solid rgba(0,0,0,0.25);position:relative;cursor:pointer;}.awesome:hover{background-color:#111;color:#fff;}.awesome:active{top:1px;}.small.awesome,.small.awesome:visited{font-size:11px;padding:;}.awesome,.awesome:visited,.medium.awesome,.medium.awesome:visited{font-size:13px;font-weight:bold;line-height:1;text-shadow:0 -1px 1px rgba(0,0,0,0.25);}.large.awesome,.large.awesome:visited{font-size:14px;padding:8px 14px 9px;}.green.awesome,.green.awesome:visited{background-color:#91bd09;}.green.awesome:hover{background-color:#749a02;}.blue.awesome,.blue.awesome:visited{background-color:#2daebf;}.blue.awesome:hover{background-color:#007d9a;}.red.awesome,.red.awesome:visited{background-color:#e33100;}.red.awesome:hover{background-color:#872300;}.magenta.awesome,.magenta.awesome:visited{background-color:#a9014b;}.magenta.awesome:hover{background-color:#630030;}.orange.awesome,.orange.awesome:visited{background-color:#ff5c00;}.orange.awesome:hover{background-color:#d45500;}.yellow.awesome,.yellow.awesome:visited{background-color:#ffb515;}.yellow.awesome:hover{background-color:#fc9200;}</style>
		<style type="text/css">
			body {
				background-color:#D0D0D0;
			}
			
			#log{
				margin-left:30%;
			}
			#reg{
				margin-left:10%;	
			}
			
			h1 {
				margin-top:10%;
				text-align:center;
				color:white;
				font-family:黑体;
				text-shadow:0 0 5px #000000;

			}
	
			table{
				margin-left:20%;
				color:white;
				font-family:黑体;
				font-size:25px;
				text-shadow:0 0 5px #000000;
			}
			#login{
				background-image:url('BG.png');
				opacity:0.9;
				width:40%;
				height:50%;
				position:absolute;
				top:25%;
				left:30%;
				box-shadow:0 0 20px #000000;
				border-radius:10px;
			}
		</style>
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
						<td><input id="pw" name="password" type="password"></td>
					</tr>
				</table>
			</form>
			<a id="log" class="large awesome" onclick="javascript:login();">登录</a>
			<a id="reg" class="large awesome" href="register.php" >注册</a>
		</div>
	</body>
</html>
