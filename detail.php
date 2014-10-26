<html>
	<head>
		<title></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="style.css" rel="stylesheet" type="text/css"/>
		<?php
					$link = mysql_connect('localhost','root','root');
					if(!$link){
						die('Fail to connect database'.mysql_error());
					}

					mysql_select_db('article',$link) or die('Unable to use database bookdb: '.mysql_error());
					mysql_query("set names 'utf8'");
					$sqlfind =  "select * from book where Name = '".$_POST['Name']."'";
					
					$result = mysql_query($sqlfind);
					$row = mysql_fetch_row($result)
		?>
	</head>
	
	<body id="detail">
		<div id = "content">
		<h1><?php echo $row[0]; ?></h1>
		<h3><?php echo $row[1]; ?></h3>
		<p>
		<?php
			echo str_replace("\r\n", "<br />", htmlspecialchars($row[5],ENT_COMPAT,UTF-8));
		?>
		</p>
		</div>
	</body>
</html>
