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
						<td width="18%" align="center">ѡ��ʱ��</td>
						<td width="25%"><input id="year" name="year" type="text" size="8" maxlength="4" />
							�� </td>
							<td width="27%">            
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
							</td>
							<td width="10%"><input name="type" type="hidden" value="1" />
							<input type="hidden" name="stat" value="1" /></td> 
							
					</tr>
					<tr>
						<td width="15%" align="center"><input type="file" name="filename"></td>
						<td width="17%"><input type="submit" value="�ϴ�" OnClick="return CheckForTestFile();"></td>
						<td width="17%"><input type="button" value="�˳�" OnClick="javascript:location.href='logout.php'"></td>
				  </table>
			</form>
		</html>

			<script language="javascript">

				function ChkFields(){
					if(document.getElementById("year").value==""){
						window.alert("���������");
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
						alert("��ѡ���ϴ��ļ�!");
						file.focus();
						return false;
					}      
				}    
			</script>
<?php 
	}	
?>