<?php
	session_start();
	if(!isset($_SESSION["user"])){
		$_SESSION["user"]="";
		header("Location:logout.php");
	}
	else{
		//��ȡ�ϴ��ļ���Ϣ
		$filename = $_FILES['filename'];
		if($_FILES['filename']['tmp_name']){
			$contents = file_get_contents($_FILES['filename']['tmp_name']);
		}

		//��ȡѡ������
		$year = $_POST['year'];
		$month = $_POST['month'];
		$day = $year.$month;
		
		$_SESSION['date']=$day;

		$link = mysql_connect("localhost", "root", "")
			or die("Could not connect: " . mysql_error());
			mysql_query('SET NAMES UTF8');

		//�ж���ͨ����
		if(strstr($contents, '�ֹ�������ͳ��')){
			$tag = '1';
		}
		else if(strstr($contents, '�ֹݽ�����ͳ��')){
			$tag = '0';
		}
		else if(strstr($contents, '�ֹݻ�����ͳ��')){
			$tag = '2';
		}
		//�ж����ġ�Ӣ�Ľ���
		if(strstr($contents,'TOTAL')){
			$exp = '0';
		}
		else if(strstr($contents,'�ܼ�')){
			$exp = '1';
		}
		//print_r ($exp);exit;

		//$day = date("Ym", strtotime("last month"));
		
		$sql_judge = "select id from webroot.libraries where month like '".$day."' and tag like '".$tag."'";
		$result_judge = mysql_query($sql_judge);
		$row_judge = mysql_fetch_row($result_judge);

		if(!empty($row_judge[0])){
			echo '<script type="text/javascript" charset="utf-8"> var overwriteUser = confirm("�����ļ����ϴ����Ƿ񸲸ǣ�");					
			// if user click cancel, then redirect to upload.php
			if (overwriteUser == false) window.location="upload.php";
			// if use click confirm then nothing happens. Going back to php and continue.
			</script>';

			//ɾ������ԭ����Ϣ
			$sql_del = "delete from webroot.libraries where month like '".$day."' and tag like '".$tag."'";
			print_r("$sql_del");
			$result_del = mysql_query($sql_del);
			$row_del = mysql_fetch_row($result_del);

			//���²����ĵ��е���Ϣ
				//��TOTAL �� �ܼ� �����ĵ�
			if($exp == '0'){
				$temp_update = explode("TOTAL", $contents);
			}
			else if($exp == '1'){
				$temp_update = explode("�ܼ�", $contents);
			}

			$eachcontent_update = explode("\n", $temp_update[1]);
			foreach($eachcontent_update as $key_update => $val_update){
				$tcontents_update = explode("\t", $val_update);
				
				if(isset($tcontents_update[1])){
					//�ļ���ʽת��4-1
					$tcontents_update[0] = iconv('gbk', 'utf-8', $tcontents_update[0]);
					$sql_update = "insert into webroot.libraries(`item`, `total`, `month`, `tag`) values('".$tcontents_update[0]."', ".$tcontents_update[1].", ".$day.", ".$tag.")";
					$result_update = mysql_query($sql_update);

					if(!empty($result_update)){
						echo "<script language=\"javascript\">";
						echo "location.href=\"check.php\"";
						echo "</script>";
					}
					else{
						echo "�ϴ�ʧ�ܣ�";?>
						<input type="button" value="�����ϴ��ļ�" OnClick="javascript:location.href='upload.php'">
<?php					}	
				}
			}
		}
		else{
			//��TOTAL �� �ܼ� �����ĵ�
			if($exp == '0'){
				$temp_insert = explode("TOTAL", $contents);
			}
			else if($exp == '1'){
				$temp_insert = explode("�ܼ�", $contents);
			}
			//print_r ($temp_insert);exit;
			$eachcontent_insert = explode("\n", $temp_insert[1]);
			foreach($eachcontent_insert as $key_insert => $val_insert){
				$tcontents_insert = explode("\t", $val_insert);
			//print_r ($eachcontent_insert);exit;	//���ĵ��°벿����ȡÿ����Ϣ
				if(isset($tcontents_insert[1])){
					//�ļ���ʽת��4-2
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
				echo "�ϴ�ʧ�ܣ�"; ?>
				<input type="button" value="�����ϴ��ļ�" OnClick="javascript:location.href='upload.php'">

	<?php
			}
		}
	}