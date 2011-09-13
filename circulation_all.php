<?php

	include ('checkdate.php');
	
	$type = $_REQUEST['type'];		//类型：借阅、续借、归还
	$stat = $_REQUEST['stat'];		//月报、年报
	$year = $_REQUEST['year'];
	$month = $_REQUEST['month'];
	
	$cur_row = 0;
	
	if (empty ($type)) $type = 1;
	if (empty ($stat)) $stat = 1;
	if (empty ($year)) $year = '0000';
	if (empty ($month))
		$month = strftime ('%m') - 1;
	if ($month == 0) {
		$month = 12;
	}
	if (strlen ($month) == 1)
		$month = '0' . $month;

	if ($stat == 2)
		$month = '01';

	include ('db-utf8.php');
	
	
	if ($stat == 1)
		$condition = $db->qstr("${year}${month}%");
	else
		$condition = $db->qstr("${year}%");
		
	$sql = "select * from circulation where type = $type and [日期] like $condition order by [日期]";
	
	$rs = $db->Execute ($sql);
	
	if ($rs === false) {
		print $db->ErrorMsg();
		die ("can't execute sql: " . $sql);
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/lib.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" -->
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>北京大学图书馆社会学系分馆 - 流通信息 - 全校流通</title>
<!-- InstanceEndEditable -->
<link rel="stylesheet" href="2col_leftNav.css" type="text/css" />
<link rel="shortcut icon" type="image/ico" href="favicon.ico" />
<!--[if lt IE 7.]>
<script defer type="text/javascript" src="pngfix.js"></script>
<![endif]-->
</head>
<body>
<div id="masthead">
  <div id="sitehead"><img src="images/site_title.gif" alt="" /><h1 id="siteName">北京大学图书馆社会学分馆</h1></div>
  <div id="globalNav"> <a href="index.php">分馆简介</a> |<a href="#"></a> <a href="newbooks.php">新书通报</a> |<a href="#"></a> <a href="recommend.php">读者推荐</a> |<a href="#"></a> <a href="thesis.php">学位论文</a> |<a href="#"></a> <a href="reference.php">教学参考</a> |<a href="#"></a> <a href="archievement.php">科研成果</a> |<a href="#"></a> <a href="quotation.php">引文文献</a> |<a href="#"></a> <a href="allbook.php">馆藏书目</a> |<a href="#"></a> <a href="resource.php">电子资源</a> |<a href="#"></a> <a href="http://162.105.138.200/uhtbin/cgisirsi/0/0/0/49" target="_blank">书目检索</a> |<a href="#"></a> <a href="circulation.php">流通信息</a> </div>
</div>
<!-- end masthead -->
<!-- InstanceBeginEditable name="EditRegionMain" -->
<div id="content">
  <div class="feature">
    <h2 align="left">
      <?php
		if ($stat == 1) {
			if ($year == '0000' || $month > 12)
				echo '请选择日期，然后开始';
			else
				switch ($type) {
					case 0: echo '请选择日期，然后开始';
					case 1:	echo "${year}年${month}月流通量统计 - 借阅"; break;
					case 3: echo "${year}年${month}月流通量统计 - 续借"; break;
					case 2: echo "${year}年${month}月流通量统计 - 归还"; break;
				}
		} else {
			if ($year == '0000')
				echo '请选择日期，然后开始';
			else
				switch ($type) {
					case 1:	echo "${year}年流通量统计 - 借阅"; break;
					case 3: echo "${year}年流通量统计 - 续借"; break;
					case 2: echo "${year}年流通量统计 - 归还"; break;
				}
		}
	?>
    </h2>
  </div>
  <div class="story">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="application/x-www-form-urlencoded" name="fm_thesis" id="fm_thesis">
      <table width="67%"  border="0" align="center">
        <tr>
          <td width="18%" align="center">选择时间</td>
          <td width="25%"><input name="year" type="text" value="<?php
				if( empty($year) || $year == '0000') {
					if ($month == '12')
						echo strftime ('%Y') - 1;
					else
						echo strftime ('%Y');
				}
				else
					echo $year;
			?>" size="8" maxlength="4" />
            年 </td>
          <td width="27%"><?php if ($stat == 1) { ?>
            <select name="month">
              <option value="01" <?php if($month == '01') echo 'selected="selected"';?>>一月</option>
              <option value="02" <?php if($month == '02') echo 'selected="selected"';?>>二月</option>
              <option value="03" <?php if($month == '03') echo 'selected="selected"';?>>三月</option>
              <option value="04" <?php if($month == '04') echo 'selected="selected"';?>>四月</option>
              <option value="05" <?php if($month == '05') echo 'selected="selected"';?>>五月</option>
              <option value="06" <?php if($month == '06') echo 'selected="selected"';?>>六月</option>
              <option value="07" <?php if($month == '07') echo 'selected="selected"';?>>七月</option>
              <option value="08" <?php if($month == '08') echo 'selected="selected"';?>>八月</option>
              <option value="09" <?php if($month == '09') echo 'selected="selected"';?>>九月</option>
              <option value="10" <?php if($month == '10') echo 'selected="selected"';?>>十月</option>
              <option value="11" <?php if($month == '11') echo 'selected="selected"';?>>十一月</option>
              <option value="12" <?php if($month == '12') echo 'selected="selected"';?>>十二月</option>
            </select>
            <?php } ?></td>
          <td width="10%"><input name="type" type="hidden" value="<?php echo $type; ?>" />
            <input type="hidden" name="stat" value="<?php echo $stat; ?>" /></td>
          <td width="20%"><input type="submit" value="提交" /></td>
        </tr>
      </table>
    </form>
    <table width="100%"  border="0" cellspacing="1">
      <tr bgcolor="#EBEBEB">
        <?php
	if ($rs->EOF) echo '	    <td>&nbsp;</td>';
	
	$fieldcnt = $rs->FieldCount();
	$array_total_cnt = array_fill (0, $fieldcnt - 3, 0);		// 总数统计数组
	$array_month_cnt = array_fill (0, $fieldcnt - 3, 0);		// 年报统计数组

	for ($i = 2; !$rs->EOF && $i < $fieldcnt; $i++ ) {
		$field = $rs->FetchField ($i);
		echo '        <th scope="col">', $field->name, '</th>', "\n";	// 显示表头
	}
	if (!$rs->EOF) echo '        <th scope="col">合计</th>', "\n";
?>
      </tr>
      <?php
	for ($cur_row = 1; !$rs->EOF; $cur_row++, $rs->MoveNext() ) {
		// 年报需要每个月累加统计
		if ($stat == 2) {
			$lastdates = $dates;
			$dates = substr($rs->fields[2], 4, 2);
			if ($dates != $month) {	// 下个月，需要输出数据
				if ($month %2 == 0)
					echo '      <tr bgcolor="#F9F9F9">', "\n";
				else	
					echo "      <tr>\n";

				for ($i = 2; $i < $fieldcnt; $i++ ) {
					if ($i == 2)										// 日期突出显示
						echo '        <td align="center" bgcolor="#F9FFF9">', $year . $lastdates, '</td>', "\n";
					else {
						echo '        <td align="center">', $array_month_cnt[$i - 2], '</td>', "\n";
					}
				}
				echo '        <td align="right" bgcolor="#FFEEDD">', array_sum ($array_month_cnt), '</td>', "\n";
				echo "      </tr>\n";
				$month = $dates;
				$array_month_cnt = array_fill (0, $fieldcnt - 3, 0);		// 年报统计数组
			}
		}

		$array_sub_cnt = array_fill (0, $fieldcnt - 3, 0);			// 每条记录统计
		// 月报
		if ($stat == 1) {
			$color = '';
			if ($cur_row % 2 == 0)
				$color = '#F9F9F9';
			if ( $stat == 1 && is_weekend($rs->fields[2]))
				$color = '#EEEEFF';
			
			if (strlen($color))
				echo '      <tr bgcolor="', $color, '">';					// 周末突出显示
			else	
				echo '      <tr>';
		}
		
		for ($i = 2; $i < $fieldcnt; $i++ ) {
			$value = $rs->fields[$i];
			if (empty ($value)) $value = 0;
			if ($stat == 1)
				if ($i == 2)										// 日期突出显示
					echo '        <td align="center" bgcolor="#F9FFF9">', $value, '</td>', "\n";
				else
					echo '        <td align="center">', $value, '</td>', "\n";
			
			if ($i != 2) {
				$array_sub_cnt[$i - 2] = $value;
				$array_month_cnt[$i - 2] += $value;
				$array_total_cnt[$i - 2] += $value;
			}
		}
		
		if ($stat == 1) {
			echo '        <td align="right" bgcolor="#FFEEDD">', array_sum ($array_sub_cnt), '</td>', "\n";
			echo "      </tr>\n";
		}
	} // end of for
	if ($rs->RecordCount() > 0) {
		if ($stat == 2) {		// 输出最后一次统计的结果
			if ($month %2 == 0)
				echo '      <tr bgcolor="#F9F9F9">', "\n";
			else	
				echo "      <tr>\n";
	
			for ($i = 2; $i < $fieldcnt; $i++ ) {
				if ($i == 2)										// 日期突出显示
					echo '        <td align="center" bgcolor="#F9FFF9">', $year . $dates, '</td>', "\n";
				else {
					echo '        <td align="center">', $array_month_cnt[$i - 2], '</td>', "\n";
				}
			}
			echo '        <td align="right" bgcolor="#FFEEDD">', array_sum ($array_month_cnt), '</td>', "\n";
			echo "      </tr>\n";
		}

		echo '		<tr bgcolor="#EBEBEB">';
		echo '			<td align="center">总计</td>', "\n";
			for ($i = 1; $i < count ($array_total_cnt); $i++)
				echo '			<td align="center" bgcolor="#FFEEEE">', "$array_total_cnt[$i]</td>\n";
		// 最后的总计
		echo '			<td align="right" bgcolor="#FFDDBB">', array_sum ($array_total_cnt), "</td>\n";
		echo "		</tr>\n";
	}
?>
    </table>
    <h3>&nbsp;</h3>
  </div>
</div>
<!--end content -->
<div id="navBar">
  <div id="sectionLinks">
    <h3>流通统计</h3>
    <ul>
      <li><a href="circulation.php?<?php echo "year=$year&amp;month=$month&amp;stat=$stat"; ?>&amp;type=1">本馆流通</a></li>
      <li><a href="circulation_isa.php?<?php echo "year=$year"; ?>">借出与复印</a></li>
      <li><a href="circulation_all.php?<?php echo "year=$year&amp;month=$month&amp;stat=$stat"; ?>&amp;type=1">全校流通</a></li>
      <li>&nbsp;</li>
    </ul>
    <h3>流通类型</h3>
    <ul>
      <li><a href="<?php echo $_SERVER['PHP_SELF'], "?year=$year&amp;month=$month&amp;stat=$stat"; ?>&amp;type=1">借阅统计</a></li>
      <li><a href="<?php echo $_SERVER['PHP_SELF'], "?year=$year&amp;month=$month&amp;stat=$stat"; ?>&amp;type=3">续借统计</a></li>
      <li><a href="<?php echo $_SERVER['PHP_SELF'], "?year=$year&amp;month=$month&amp;stat=$stat"; ?>&amp;type=2">还书统计</a></li>
    </ul>
  </div>
  <div class="relatedLinks">
    <h3>&nbsp;</h3>
    <h3>统计类型</h3>
    <ul>
      <li><a href="<?php echo $_SERVER['PHP_SELF'], "?year=$year&amp;month=$month&amp;type=$type"; ?>&amp;stat=1">月报</a></li>
      <li><a href="<?php echo $_SERVER['PHP_SELF'], "?year=$year&amp;type=$type"; ?>&amp;stat=2">年报</a></li>
    </ul>
    <h3>&nbsp;</h3>
    <h3>使用须知</h3>
    <ul>
      <li> &quot;流通信息&quot;栏目显示的数据报表是根据北京大学图书馆流通部每日运行Sirsi系统报表而统计的。其中有几家分馆不实行读者借还的方式进行服务, 故尚无流通数据显示。另外, 由于各分馆网络编目工作尚未结束，部分图书仍使用手工借阅，因此，这里仅反映各分馆机器借还的情况，不反映全部书刊流通情况。数据仅供各分馆工作参考。 </li>
    </ul>
  </div>
  <div id="advert">
    <div align="center">
      <p><img src="images/43.png" width="128" height="128" alt="" /></p>
    </div>
  </div>
  <div id="headlines">
    <p align="center"><img src="graph.php?text=Powered%20by%20LS" width="120" height="80" alt="Powered by DS" /> </p>
  </div>
</div>
<!-- InstanceEndEditable -->
<div id="siteInfo"><a href="index.php">关于我们</a> | <a href="sitemap.htm">站点地图</a> | <a href="rules.htm">使用规则</a> | <a href="contact.htm">联系我们</a> | &copy; 2006-2009
 北京大学图书馆社会学分馆
</div>
<div id="w3cert">
  <a href="http://jigsaw.w3.org/css-validator/check/referer" target="_blank"><img src="images/valid-css-blue.png" alt="Valid CSS 2.0!" width="88" height="31" border="0" /></a>
  <a href="http://validator.w3.org/check/referer" target="_blank"><img src="images/valid-xhtml10-blue.png" alt="Valid XHTML 1.0!" width="88" height="31" border="0" /></a>
</div>
</body>
<!-- InstanceEnd --></html>
<?php
	$rs->Close();
	$db->Close();
?>
