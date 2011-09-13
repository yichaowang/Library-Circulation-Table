<?php
	session_start();
	if(!isset($_SESSION["user"])){
		$_SESSION["user"]="";
		header("Location:logout.php");
	}

	else{
?>
		<html>
		<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
		<?php 
			//$date = $year.$month;
			//$date = date("Y", time());
			$date = $_SESSION['date'];
			//print_r($_SESSION['date']);
		?>
			<div id="content">
				<div class="feature">
					<h2 align="left"><td>上传结果：</td>
					<?php 

					$link = mysql_connect("localhost", "root", "")
						or die("Could not connect: " . mysql_error());
						mysql_query('SET NAMES UTF8');

					$sql_day = "select * from webroot.libraries where month like '".$date."'";
					$result_day = mysql_query($sql_day, $link);
					$row_day = mysql_fetch_array($result_day, MYSQL_NUM);
					echo $row_day[3];
					?>
					流通量统计 - 
					<?php
						$sql_tag = "select tag from webroot.libraries where month like '".$date."'";
						$result_tag = mysql_query($sql_tag);
						$row_tag = mysql_fetch_row($result_tag);
						//print_r ($row_tag);exit;
						if($row_tag[0] == 0)
							echo "借阅";
						else if($row_tag[0] == 1)
							echo "续借";
						else echo "还书";
					?>
					</h2>
				</div>
			<center>
			<table width="50%"  border="0" cellspacing="1">
			<tr bgcolor="#EBEBEB"><th>日期</th><th>分馆</th><th><?php
						if($row_tag[0] == 0)
							echo "借阅";
						else if($row_tag[0] == 1)
							echo "续借";
						else echo "还书";
					?>量</th></tr>

		<?php


			$sql = "select * from webroot.libraries where month like '".$date."%'";


			$result = mysql_query($sql, $link);
			$total = 0;
			while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
				//文件格式转换4-3
				$row[1] = iconv('utf-8', 'gbk', $row[1]);	
				$total = $total + $row[2];
		?>
			
			<tr bgcolor="#F9FFF9"><th><?php echo $row[3]; ?></th><th><?php echo $row[1]; ?></th><th><?php echo $row[2]; ?></th></tr>

		<?php
			
			}

			?>
			
			<tr bgcolor="#FFEEDD"><th><?php echo $row_day[3]; ?></th><th>合计</th><th><?php echo $total; ?></th></tr>
			<tr align="right"><td colspan="2"><input type="button" value="继续上传文件" OnClick="javascript:location.href='upload.php'"></td><td><input type="button" value="退出" OnClick="javascript:location.href='logout.php'"></td></tr>
			</table>
			</center>
		</html>
<?php
	}				
?>