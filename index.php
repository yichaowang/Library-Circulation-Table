<?php
	session_start();
	$SESSION["user"]="";
	//header("Content-type:application/vnd.ms-excel");
	//header("Content-Disposition:attachment;filename=test_data.xls");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
	<script type="text/javascript" src="j/vender/jquery-1.6.2.min.js"></script>
	<script>
		function validateYear(){
			var year = document.getElementById('year').value;
						
			if (!year) {
				window.alert('���������!');
				return false;
			}
			if (!(/^[0-9]+$/.test(year))) {
				window.alert('��ݱ���������!');
				return false;
			}
			if (year.length != 4) {
				window.alert('��ݱ�����4λ!');
				return false;
			}
			
			var date = new Date();
			var max = date.getFullYear();
			var min = 1925;

			var n = new Number(year);
			if ((n.valueOf() > max) || (n.valueOf() < min)) {
				window.alert('������ȷ��ʱ��!');
				return false;
			}
			return true;	
		}       
	</script>
	
	<table align="center" width="35%">
            <td><p><font size="6">�ֹ���ͨ����ͳ��</font></p></td>
    </table>

</head>
<body>
	<a name="circulation_top"></a>
	<div style="margin:20px">
		<div style="float:left; width=400px">
			<form action="index0.php" method="get" onsubmit="return validateYear();"> 
				������� <input id="year" name="year" type="text" size="8" maxlength="4"/> �� 
				<input type="hidden" name="stat" value="1" />
				<input type="submit" style="width:50px; margin-left:20px" value="��ѯ" />
			</form>
		</div> 
		
			<?php 
		if (!isset($_GET["year"])){
			$display_yr = date("Y");
		} 
		else{
			$display_yr = $_GET["year"];
		}
				
		$link = mysql_connect("localhost", "lib", "123456")
				or die("Could not connect: " . mysql_error());  
				
		mysql_select_db("webroot", $link); 
		mysql_query("SET character_set_results=utf8", $link);
				
		$lib_result= mysql_query("SELECT SQL_NO_CACHE * FROM libraries WHERE CAST(month as SIGNED) >".$display_yr."00 AND CAST(month as SIGNED) < ".($display_yr+1)."00 order by item ASC") ;  
		
		// Mapping data 
		/*
		 *  $lib_dept_output[dept_name] => array(
		 *  	[2-digit month] => array (
		 *   		[total] => value
		 *			[tag]   => 0 (renew), 1 (return), 2 (borrow)
		 *   	)
		 *  )
		 *   
		*/     
		
		$lib_dept_output=array();
		while($row = mysql_fetch_array($lib_result)){
			//print_r("dsafd".$row);
			//�ļ���ʽת��4-4
			$row["item"] = iconv('utf-8', 'gbk', $row["item"]);
			$dept_key = array_key_exists($row['item'], $lib_dept_output);
			if ($dept_key === false){
	  			$lib_dept_output[$row['item']] = array(); //��ÿһ��item�������� 
			}
			$lib_dept_output[$row['item']][substr($row['month'],-2)][$row['tag']] = $row['total'];
	  	} 
	  	
		//print_r($lib_dept_output);
		//print_r($lib_dept_output);
		?>
		<form action="index0.php" method="post" enctype="multipart/form-data">
			<div style="float:right; padding-left:100px; width:200px"> 
				<td width="27%">            
					<select name="fenguan">
						<option value="00" selected="selected">��ѡ��ֹ�</option>
					<?php
						$i = 1;
						foreach ($lib_dept_output as $dept_name => $dept){
					?>
						<option value="<?php echo "0".$i;?>"><?php echo $dept_name?></option>
					<?php 
						$i++;
						}?>	
					</select>
				</td>
				
					<td width="10%"><input name="type" type="hidden" value="1" />
					<input type="hidden" name="stat" value="1" /></td>
					<input type="submit" style="width:50px; margin-left:20px" value="��ѯ" />
			</div>
		</form>
		
		<div style="clear:both;"></div>
	</div>
	
	
	<?php
		$select_fenguan = $_POST['fenguan'];
		print_r($select_fenguan);

		// Rendering
	    //if($select_fenguan == "00"){
	    for ($n=0; $n <= 2;$n++){
			if ($n == 0){
				$i = 0;
			} else if ($n == 1){
				$i = 2;
			} else if ($n == 2){
				$i = 1;
		}
  
  
	   if ($i == 0 ){
		   echo "<b>".$display_yr." ����</b>";
	   } else if ($i == 1){
   		   echo "<a name='circulation_renew'></a>";
		   echo "<b>".$display_yr." ����</b>";
	   } else if ($i == 2){
		   echo "<a name='circulation_return'></a>";
		   echo "<b>".$display_yr." ����</b>";
	   }
		
	?>

	<form>
	<table class="circulation_table" width="100%"  border="0" cellspacing="1" >
		<tr bgcolor="#EBEBEB">
			<th scope="col">�ֹ�</th> 
			<th scope="col">1��</th> 
			<th scope="col">2��</th> 
			<th scope="col">3��</th> 
			<th scope="col">4��</th> 
			<th scope="col">5��</th> 
			<th scope="col">6��</th> 
			<th scope="col">7��</th> 
			<th scope="col">8��</th> 
			<th scope="col">9��</th> 
			<th scope="col">10��</th> 
			<th scope="col">11��</th> 
			<th scope="col">12��</th>
			<th scope="col">�ֹݺϼ�</th> 
		</tr>
		<?php
			foreach ($lib_dept_output as $dept_name => $dept){
		?>  
			<tr>
				<td class="dept-name" style="background-color:#f9fff9;"><?php echo $dept_name?></td>
				<??><?php
				for ($m = 1; $m <= 12; $m++){
					$m2 = str_pad($m, 2, "0", STR_PAD_LEFT); //�·ݡ�02������m��Ϊ��λ����һλ��ʱ����0��
				?>
				<td style="text-align:center;"><?php echo ((array_key_exists($m2, $dept)) && (array_key_exists($i, $dept[$m2]))) ? $dept[$m2][$i] : "0";?></td>
				<?php
				}
				//(array_key_exists($i, $dept[$m2]))) ? $dept[$m2][$i] : "0"
				?>
				<td style="background-color:#FFEEDD;text-align:center" class="dept-total"></td>
			</tr>
		<?php		
			}
		?>
		<tr style="background-color:#FFEEEE">
			<td>��&nbsp&nbsp��</td> 
			<?php for ($m = 1; $m <= 12; $m++){ ?>
		 		<td style="text-align:center;" class="mon-total">1</td> 
			<?php }	?>
			<td style="background-color:#FFDDBB;text-align:center" class="grand-total">2</td>
		</tr>
		<div>
			<a href = "#circulation_top">Top�����飩</a>
			<a href = "#circulation_return">����</a>
			<a href = "#circulation_renew">����</a>
		</div>     
	</table>
	<br>
	</form>
	<?php
		}
	   //}
	?>

	<script type="text/javascript" charset="gbk">
		function deptTotal(){
			$('.dept-total').each(function(){
				var row_total;
				row_total = 0;
				$(this).siblings().not('.dept-name').each(function(){
					row_total += Number($(this).text());
				});
				$(this).text(row_total);
			});
		}  
		
		function monTotal(){
			$('.mon-total').each(function(){
				var mon_total,
				mon_id;
				mon_total = 0;
				mon_id = $(this).index()+1; 
				$(this).closest('table').find('td:nth-child('+mon_id+')').not('.mon-total').each(function(){
					mon_total += Number($(this).text())
				}); 
				$(this).text(mon_total);
			})              
		} 

		function grandTotal(){
			$(".grand-total").each(function(){
				var grand_total;
				grand_total = 0;
				$(this).siblings('.mon-total').each(function(){
					grand_total += Number($(this).text());
				})                                       
				$(this).text(grand_total);
			}) 
		}  
		
		monTotal(); 
		deptTotal();
		grandTotal();
  </script>
</body>
</html>