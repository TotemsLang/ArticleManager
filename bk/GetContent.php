<?php
		$getClass = $_GET['class'];
		$getValue = $_GET['value'];
		$retvalue = "1";
		
		
		$link = mysql_connect('localhost','root','root');
		if(!$link){
			die('Fail to connect database'.mysql_error());
		}

		mysql_select_db('article',$link) or die('Unable to use database bookdb: '.mysql_error());
		mysql_query("set names 'utf8'");
		
		$sqlfind =  "select * from book where ".$getClass." = '".$getValue."'";
		
		$result = mysql_query($sqlfind);
		while ( $row = mysql_fetch_row($result)) 
		{
			echo "<div>";
			foreach ($row as $key => $value) 
			{
				switch($key)
				{
					case 0:
						echo "<p>".$value."</p>";
						break;
					case 1:
						echo "<p>".$value."</p>";
						break;
					case 3:
						echo "<p>".$value."</p>";
						break;
					case 5:
						echo "<p>".htmlspecialchars($value,ENT_COMPAT,UTF-8)."</p>";
						#echo "Content[".$count."]=\"".str_replace("\r\n", "\\n\\\n", htmlspecialchars($value,ENT_COMPAT,UTF-8))."\";";
						break;
					case 6:
						echo "<p>".$value."</p>";
						break;
					default:
						break;
				}
				
				# code...
			}
			echo "</div>";
			# code...
		}
		mysql_close($link);
?>