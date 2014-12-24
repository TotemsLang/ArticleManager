<?php
	if(!$_COOKIE["isLogin"])
			die("请先登录！");
			
	if($_GET['action'] == 'submit')
	{
		$link = mysql_connect('localhost','root','root');
		mysql_select_db('article',$link) or die('Unable to use database bookdb: '.mysql_error());
		mysql_query("set names 'utf8'");
		if($_POST['method'] == '0')
		{
			$query = "insert into `article`.`book` (`Name`,`Author`,`Class`,`CTime`,`ATime`,`Content`,`Index`) values('".$_POST['name']."','".$_POST['author']."','空之境界','".date('Ymd')."','".date('Ymd')."','".$_POST['content']."',NULL)";
			$result = mysql_query($query) or die("Error in query: $query. ".mysql_error());  
		}
		else if($_POST['method'] == '1')
		{
			$query = "UPDATE  `article`.`book` SET  `Name` =  '".$_POST['name']."',`Author` = '".$_POST['author']."',`Content` = '".$_POST['content']."' WHERE  `book`.`Index` =".$_POST['index'];
			$result = mysql_query($query) or die("Error in query: $query. ".mysql_error());  
		}
		else
		{
			die("提交错误！");
		}
		mysql_close($link);
		echo "操作成功！";
		header("Location:index.php");

	}
	else
	{
		if($_GET['action'] == 'new')
		{
			
					
			$index = 'NULL';
			$method = 0;
		}
		else if($_GET['action'] == 'edit')
		{
			$link = mysql_connect('localhost','root','root');
			if(!$link){
				die('Fail to connect database'.mysql_error());
			}

			mysql_select_db('article',$link) or die('Unable to use database bookdb: '.mysql_error());
			mysql_query("set names 'utf8'");
			
			$sqlfind =  "select * from book where `Index` = '".$_GET['index']."'";

			$result = mysql_query($sqlfind) or die(mysql_error());
			while ( $row = mysql_fetch_row($result)) {
				foreach ($row as $key => $value) {
					switch($key)
					{
						case 0:
							$oname = $value;
						case 1:
							$oauthor = $value;
							break;
						case 5:
							$ocontent = $value;
							break;
						default:
							break;
					}
				}
			}
			$index = $_GET['index'];
			$method = 1;
		}
		else
		{
			die("错误操作！");
		}
		
	}

?>



<html>
	<head>
		<style type="text/css">
			#sub{
				display:none;
			}
			#change{
				position:fixed;
				top:10%;
				left:10%;
				width:80%;
				height:80%;
				font-family:楷体;
				border:0;
				box-shadow: 0px 0px 10px #888888;
				background-color:rgba(0,0,0,.8);
				color:#D0D0D0;
								
			}
			
			
			button{
				text-align:center;
				margin-left:40px;
				width:60px;
			}
			
			
			input{
				font-family:Microsoft Yahei;
				box-shadow:0 0 4px #FFFFFF;
				border-radius:4px;
				border:0;
				width:400px;
			}
			
			span{
				font-family:Microsoft Yahei;
			}
			
			#author{
				margin-left:40px;
			}
			
			
			#contain{
				position:fixed;
				top:10%;
				left:10%;
				width:80%;
				height:80%;
				font-family:Microsoft Yahei;
				color:#808080;
			}
			
			textarea {
				margin:10px;
				color:Teal;
				font-size:18px;
				font-family:Microsoft Yahei;
				border-radius:4px;
				box-shadow:0 0 4px #FFFFFF;
				border:0;
				width:1060px;
				height:500px;
			}

		</style>
		<script language="javascript">
			function gogo()
			{
				document.getElementById('sub_name').value = document.getElementById('bookname').value;
				document.getElementById('sub_author').value = document.getElementById('bookauthor').value;
				document.getElementById('sub_content').value = document.getElementById('bookcontent').value;
				document.getElementById('edit_post').submit();
			}
		</script>
	</head>
	<body style="background-color:#C0C0C0;border:0;margin:0">
		<div id="contain">
			<table>
				<tr>
					<td><p id="title">标题：</p></td>
					<td><input id="bookname" value="<?php echo $oname?>"/></td>
					<td><p id="author">作者：</p></td>
					<td><input id="bookauthor" value="<?php echo $oauthor ?>"></td>
					<td><button onclick="javascript:gogo();"><span>提交</span></button></td>
				</tr>
				
			</table>
			<br>
			<textarea id="bookcontent"><?php echo $ocontent?></textarea>
		</div>
		<div id="sub">
			<form id="edit_post" action="edit.php?action=submit" method="post">
				<input id="sub_name" name="name"/>
				<input id="sub_author" name="author"/>
				<input id="sub_content" name="content"/>
				<input name="method" value="<?php echo $method ?>"/>
				<input name="index" value="<?php echo $index?>"/>
			</form>
		</div>
	</body>
</html>