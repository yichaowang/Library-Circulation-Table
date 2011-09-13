<?php
	session_start();
	if(!isset($_SESSION["user"]) || $_SESSION["user"] == ""){
		$_SESSION["user"] = "";
		header("Location:logout.php");
	}else{
?>
		<html>
			<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
			<form action="uploadpost.php" method="post" enctype="multipart/form-data" onsubmit="return ChkFields()">

				  <table width="67%"  border="0" align="center">
					<tr>
						<td width="18%" align="center">选择时间</td>
						<td width="25%"><input id="year" name="year" type="text" size="8" maxlength="4" />
							年 </td>
							<td width="27%">            
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
							</td>
							<td width="10%"><input name="type" type="hidden" value="1" />
							<input type="hidden" name="stat" value="1" /></td> 
							
					</tr>
					<tr>
						<td width="15%" align="center"><input type="file" name="filename"></td>
						<td width="17%"><input type="submit" value="上传" OnClick="return CheckForTestFile();"></td>
						<td width="17%"><input type="button" value="退出" OnClick="javascript:location.href='logout.php'"></td>
				  </table>
			</form>
		</html>

			<script language="javascript">

				function ChkFields(){
					if(document.getElementById("year").value==""){
						window.alert("请输入年份");
						return false;
					}
				}
				function Trim(input){
					var lre = /^\s*/; 
					var rre = /\s*$/; 
					input = input.replace(lre, ""); 
					input = input.replace(rre, ""); 
					return input; 
				}
				function CheckForTestFile() {
					var file = document.getElementById('filename');
					var fileName=file.value;        
					//Checking for file browsed or not 
					if (Trim(fileName) =='' ){
						alert("请选择上传文件!");
						file.focus();
						return false;
					}      
				}    
			</script>
<?php 
	}	
?>