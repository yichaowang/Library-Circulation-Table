<html>
	<head>	
		<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
	</head>
		<body>
			<form action="circulation.php" method="post">
				<table width="67%"  border="0" align="center">
					<tr>
					  <td width="18%" align="center">ѡ��ʱ��</td>
					  <td width="25%"><input id="year" name="year" type="text" size="8" maxlength="4" />
						�� </td>
					 <!-- <td width="27%">            
						<select name="month">
						  <option value="01" selected="selected">һ��</option>
						  <option value="02" >����</option>
						  <option value="03" >����</option>
						  <option value="04" >����</option>
						  <option value="05" >����</option>
						  <option value="06" >����</option>
						  <option value="07" >����</option>
						  <option value="08" >����</option>
						  <option value="09" >����</option>
						  <option value="10" >ʮ��</option>
						  <option value="11" >ʮһ��</option>
						  <option value="12" >ʮ����</option>
						</select>
						</td>   -->
						<td width="10%"><input name="type" type="hidden" value="1" />
							<input type="hidden" name="stat" value="1" /></td>
						<td><input type="submit" name="circulation" value="�ύ"></td>
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
						��ͨ��ͳ�� �� ����
					</tr>
<?php 
	$sql_jieyue = "select * from webroot.libraries where month like '".$year_display."'"
?>
					<br>
					<tr>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;��ͨ��ͳ�� �� ����
					</tr>
					<br>
					<tr>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;��ͨ��ͳ�� �� ����
					</tr>
<?php
	}
?>
					<tr>
						<td><a href = "index.php">����Ա��½</a></td>
					</tr>
				</table>
			</form>
		</body>
</html>
