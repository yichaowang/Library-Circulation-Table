<html>
	<head>	
		<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
	</head>
		<body>
			<form action="circulation.php" method="post">
				<table width="67%"  border="0" align="center">
					<tr>
					  <td width="18%" align="center">选择时间</td>
					  <td width="25%"><input id="year" name="year" type="text" size="8" maxlength="4" />
						年 </td>
					 <!-- <td width="27%">            
						<select name="month">
						  <option value="01" selected="selected">一月</option>
						  <option value="02" >二月</option>
						  <option value="03" >三月</option>
						  <option value="04" >四月</option>
						  <option value="05" >五月</option>
						  <option value="06" >六月</option>
						  <option value="07" >七月</option>
						  <option value="08" >八月</option>
						  <option value="09" >九月</option>
						  <option value="10" >十月</option>
						  <option value="11" >十一月</option>
						  <option value="12" >十二月</option>
						</select>
						</td>   -->
						<td width="10%"><input name="type" type="hidden" value="1" />
							<input type="hidden" name="stat" value="1" /></td>
						<td><input type="submit" name="circulation" value="提交"></td>
					</tr>
					<tr>
<?php 
	$day = date("Ym", strtotime("last month"));

	$link = mysql_connect("localhost", "yiwen", "19891011")
        or die("Could not connect: " . mysql_error());
	$sql_day = "select * from webroot.libraries where month like '".$day."'";
	$result_day = mysql_query($sql_day, $link);
	$row_day = mysql_fetch_array($result_day, MYSQL_NUM);
	
	if(isset($_POST['circulation'])){
		$year_display = $_POST['year'];
		
		//$day_display = $year_display.$month_display;
		//print_r($day_display);exit;
		//$month_display = $_POST['month'];
		print_r($year_display);?>
						流通量统计 — 借阅
					</tr>
<?php 
	$sql_jieyue = "select * from webroot.libraries where month like '".$year_display."'"
?>
					<br>
					<tr>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;流通量统计 — 续借
					</tr>
					<br>
					<tr>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;流通量统计 — 还书
					</tr>
<?php
	}
?>
					<tr>
						<td><a href = "index.php">管理员登陆</a></td>
					</tr>
				</table>
			</form>
		</body>
</html>
