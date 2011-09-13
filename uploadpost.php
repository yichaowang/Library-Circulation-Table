<?php
	session_start();
	if(!isset($_SESSION["user"])){
		$_SESSION["user"]="";
		header("Location:logout.php");
	}
	else{
		//获取上传文件信息
		$filename = $_FILES['filename'];
		if($_FILES['filename']['tmp_name']){
			$contents = file_get_contents($_FILES['filename']['tmp_name']);
		}

		//获取选择年月
		$year = $_POST['year'];
		$month = $_POST['month'];
		$day = $year.$month;
		
		$_SESSION['date']=$day;

		$link = mysql_connect("localhost", "root", "")
			or die("Could not connect: " . mysql_error());
			mysql_query('SET NAMES UTF8');

		//判定流通类型
		if(strstr($contents, '分馆续借量统计')){
			$tag = '1';
		}
		else if(strstr($contents, '分馆借书量统计')){
			$tag = '0';
		}
		else if(strstr($contents, '分馆还书量统计')){
			$tag = '2';
		}
		//判断中文、英文界面
		if(strstr($contents,'TOTAL')){
			$exp = '0';
		}
		else if(strstr($contents,'总计')){
			$exp = '1';
		}
		//print_r ($exp);exit;

		//$day = date("Ym", strtotime("last month"));
		
		$sql_judge = "select id from webroot.libraries where month like '".$day."' and tag like '".$tag."'";
		$result_judge = mysql_query($sql_judge);
		$row_judge = mysql_fetch_row($result_judge);

		if(!empty($row_judge[0])){
			echo '<script type="text/javascript" charset="utf-8"> var overwriteUser = confirm("本月文件已上传，是否覆盖？");					
			// if user click cancel, then redirect to upload.php
			if (overwriteUser == false) window.location="upload.php";
			// if use click confirm then nothing happens. Going back to php and continue.
			</script>';

			//删除表中原有信息
			$sql_del = "delete from webroot.libraries where month like '".$day."' and tag like '".$tag."'";
			print_r("$sql_del");
			$result_del = mysql_query($sql_del);
			$row_del = mysql_fetch_row($result_del);

			//重新插入文档中的信息
				//以TOTAL 或 总计 区分文档
			if($exp == '0'){
				$temp_update = explode("TOTAL", $contents);
			}
			else if($exp == '1'){
				$temp_update = explode("总计", $contents);
			}

			$eachcontent_update = explode("\n", $temp_update[1]);
			foreach($eachcontent_update as $key_update => $val_update){
				$tcontents_update = explode("\t", $val_update);
				
				if(isset($tcontents_update[1])){
					//文件格式转换4-1
					$tcontents_update[0] = iconv('gbk', 'utf-8', $tcontents_update[0]);
					$sql_update = "insert into webroot.libraries(`item`, `total`, `month`, `tag`) values('".$tcontents_update[0]."', ".$tcontents_update[1].", ".$day.", ".$tag.")";
					$result_update = mysql_query($sql_update);

					if(!empty($result_update)){
						echo "<script language=\"javascript\">";
						echo "location.href=\"check.php\"";
						echo "</script>";
					}
					else{
						echo "上传失败！";?>
						<input type="button" value="重新上传文件" OnClick="javascript:location.href='upload.php'">
<?php					}	
				}
			}
		}
		else{
			//以TOTAL 或 总计 区分文档
			if($exp == '0'){
				$temp_insert = explode("TOTAL", $contents);
			}
			else if($exp == '1'){
				$temp_insert = explode("总计", $contents);
			}
			//print_r ($temp_insert);exit;
			$eachcontent_insert = explode("\n", $temp_insert[1]);
			foreach($eachcontent_insert as $key_insert => $val_insert){
				$tcontents_insert = explode("\t", $val_insert);
			//print_r ($eachcontent_insert);exit;	//将文档下半部分提取每行信息
				if(isset($tcontents_insert[1])){
					//文件格式转换4-2
					$tcontents_insert[0] = iconv('gbk', 'utf-8', $tcontents_insert[0]);
					$sql_insert = "insert into webroot.libraries(`item`, `total`, `month`, `tag`) values('".$tcontents_insert[0]."', ".$tcontents_insert[1].", ".$day.", ".$tag.")";
					$result_insert = mysql_query($sql_insert);
				}		
			}
			
			if(!empty($result_insert)){
				echo "<script language=\"javascript\">";
				echo "location.href=\"check.php\"";
				echo "</script>";
			}
			else {
				echo "上传失败！"; ?>
				<input type="button" value="重新上传文件" OnClick="javascript:location.href='upload.php'">

	<?php
			}
		}
	}