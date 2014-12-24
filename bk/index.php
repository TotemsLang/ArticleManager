<html>
	<head>
		<title>article manager</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="style.css" rel="stylesheet" type="text/css"/>
		<script language="javascript">
			var count = 0;
			var nameindex = new Array();
			var Name = new Array();//0
			var Author = new Array();//1
			var Content = new Array();//5
			var Index = new Array();//6
			var CTime = new Array();//3

		<?php
					
					if(!$_COOKIE["isLogin"])
						die("alert('请先登录');window.location.href='login.php';</script>");
					$link = mysql_connect('localhost','root','root');
					if(!$link){
						die('Fail to connect database'.mysql_error());
					}

					mysql_select_db('article',$link) or die('Unable to use database bookdb: '.mysql_error());
					mysql_query("set names 'utf8'");
					
					$sqlfind =  "select * from book";
					$count = 0;
					$result = mysql_query($sqlfind);
					while ( $row = mysql_fetch_row($result)) {
						foreach ($row as $key => $value) {
							switch($key)
							{
								case 0:
									echo "Name[".$count."]='".$value."';";
									echo "nameindex['".$value."']='".$count."';";
									break;
								case 1:
									echo "Author[".$count."]='".$value."';";
									break;
								case 3:
									echo "CTime[".$count."]='".$value."';";
									break;
								case 5:
									echo "Content[".$count."]=\"".str_replace("\r\n", "\\n\\\n", htmlspecialchars($value,ENT_COMPAT,UTF-8))."\";";
									break;
								case 6:
									echo "Index[".$count."]='".$value."';";
									break;
								default:
									break;
							}
							
							# code...
						}
						$count++;
						# code...
					}
					echo "count = ".$count.";";
					mysql_close($link);
		?>
		

		</script>
		<script language="javascript" src="script.js"></script>
	</head>
	
	<body onload="javascript:init()">
		<div id="left"  >
			<div id="left-info">
				<div id="profile">
							<img id="head" src="head.jpg" >
							<h1 id="user_name">人艰不拆</h1>
							<p id="sub_name">Administrator</p>
							<table id="action">
								<tr><td><p><a href="javascript:updateContent('Class','空之境界');document.getElementById('right-info').scrollTop= 0;">全部文章</a></p></tr></td>
								<tr><td><p><a href="edit.php?action=new">新建文章</a></p></tr></td>
								<tr><td><p><a href="login.php">注销</a></p></tr></td>
							</table>
				</div>
					
					
			</div>
			
		</div>
		
		<div id="right-info" >
		<!--<div id="right-info" style="background-image:url('BG.jpg');width:70%;height:100%;overflow-y:auto" id="main">-->
			<div id="detail">
				<div id="content">
					<!--<button style="BACKGROUND-COLOR:transparent;" onclick="javascript:makecontent(String1,String2,String3);">hehe</button>-->	
				</div>
			</div>
			<div id="full">
			</div>
		</div>
		<iframe id="guide" src="guide.html"  scrolling="no">
		</iframe>
	</body>
</html>