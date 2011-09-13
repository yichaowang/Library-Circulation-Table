<?php
	session_start();
?>
		<html>
			<head>
		<?php 
			session_start();
			$username = $_POST['username'];
			$pw = $_POST['pw'];

			$link = mysql_connect("localhost", "yiwen", "19891011")
				or die("Could not connect: " . mysql_error());
				
			$sql = "select id from webroot.user where username='".$username."' and pw='".$pw."'";

			$result = mysql_query($sql);
			$row = mysql_fetch_row($result);
			
			//print_r($row);exit;

			if(empty($row)){
				$url = "index.php";
				///$_SESSION["user"]="";
				?>
				<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
				<meta http-equiv="refresh" content="1;url=<?php echo $url; ?>">
				</head>
				<body>
				登录失败！
				<a href = "index.php">返回</a>
				<?php
			}
			else{	

				$_SESSION["user"] = $username;
				echo "<script language=\"javascript\">";
				echo "location.href=\"upload.php\"";
				echo "</script>";
				
			}

			mysql_close($link);

		?>
				</body>
			</html>
