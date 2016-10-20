<?php
	require("../lib/system_core.php");
	
	

	header("Content-Type: text/html; charset=UTF-8");
	//set_time_limit(10);
		function sett($str){
		return $str;
	}
	
	function set_text($str){
		if($str!=""){
			return "\r".$str;
		}else{
			return "";
		}		
	}
	
	function dateExcel($myDate){
		if(empty($myDate) || $myDate=='0000-00-00 00:00:00' || $myDate=='0000-00-00'){
			return "";
		}else{
			return date("d/m/Y", strtotime($myDate));
		}
	}
	

	$fname_export="banner_statistics_export.xls";	
	
	require_once "../lib/ExcelWriter/class.writeexcel_workbook.inc.php";
	require_once "../lib/ExcelWriter/class.writeexcel_worksheet.inc.php";
		
	

	$fname = tempnam("/tmp", $fname_export);
	$workbook = &new writeexcel_workbook($fname);
	$worksheet =& $workbook->addworksheet();
	
	# Set the column width for columns 1, 2, 3 and 4
	$worksheet->set_column(1, 50, 15);
	$worksheet->set_row(3, 25);
	$worksheet->set_row(4, 25);
	
	# Create a format for the column headings
	$header =& $workbook->addformat();
	$header->set_bold();
	$header->set_top(1);
	$header->set_bottom(1);
	$header->set_left(1);
	$header->set_right(1);
	$header->set_align('center');
		$header->set_align('vcenter');
	
	# Create a border format
	$cell_merge =& $workbook->addformat();
	$cell_merge->set_bold();
	$cell_merge->set_align('center');
	$cell_merge->set_align('vcenter');
	$cell_merge->set_merge(); # This is the key feature
	$cell_merge->set_top(1);
	$cell_merge->set_bottom(1);
	$cell_merge->set_left(1);
	$cell_merge->set_right(1);
	
	$cell_style1 =& $workbook->addformat();
	$cell_style1->set_align('left');
	$cell_style1->set_top(1);
	$cell_style1->set_bottom(1);
	$cell_style1->set_left(1);
	$cell_style1->set_right(1);
	$cell_style1->set_align('vcenter');
	
	# Create a border format
	$header1 =& $workbook->addformat();
	$header1->set_bold();
	$header1->set_align('center');
	$header1->set_align('bcenter');
	$header1->set_top(1);
	$header1->set_left(1);
	$header1->set_right(1);
	
	
	# Create a border format
	$header2 =& $workbook->addformat();
	$header2->set_left(1);
	$header2->set_right(1);
	$header2->set_bottom(1);
	
	
		# Create a border format
	$headerRpt =& $workbook->addformat();
	$headerRpt->set_bold();
	
	
	
	#===================================
	# Set Column Size
	
	$worksheet->set_column('A:A', 30);
	/*$worksheet->set_column('B:C', 15);
	$worksheet->set_column('C:D', 15);
	$worksheet->set_column('D:E', 30);
	$worksheet->set_column('E:F', 30);
	$worksheet->set_column('F:G', 30);
	$worksheet->set_column('G:H', 10);
	$worksheet->set_column('I:J', 10);
	$worksheet->set_column('J:K', 10);	
	$worksheet->set_column('L:M', 50);	
	$worksheet->set_column('M:N', 10);
	*/
	#===================================
	
	
	
	$row_no=1;	
	$worksheet->write($row_no,0, iconv('UTF-8','TIS-620',"Banner Statistics"),  $headerRpt);	
	$row_no++;
	//$worksheet->write($row_no, 4, iconv('UTF-8','TIS-620',"ระหว่างวันที่ ".$TxtHeadDate),  $headerRpt);	
	$row_no++;
	
	# Write out the data

	
	$ic=0;$worksheet->write($row_no, $ic,iconv('UTF-8','TIS-620',"Menu ads"),$header); 
	$ic++;$worksheet->write($row_no, $ic,iconv('UTF-8','TIS-620',"Date Time"),$header); 
	$ic++;$worksheet->write($row_no, $ic,iconv('UTF-8','TIS-620',"IP"),$header); 
	
	//$ModuleDataID
	
	$sql = "SELECT p.* FROM ads_state p";
	$sql.=" where p.ads_id='".$ModuleDataID."'";
	$sql.= " ORDER BY p.createdate desc";
	
	$Conn->query($sql);
	$ContentList = $Conn->getResult();
	$CntRecInPage = $Conn->getRowCount();
	
	if($CntRecInPage >0) { 
	
			for ($i=0;$i<$CntRecInPage;$i++) {
				$Row = $ContentList[$i];
				$row_no=$row_no+1;
				$ic=0;$worksheet->write($row_no, $ic,iconv('UTF-8','TIS-620',$sourceAdsMenu[$Row["ads_menu"]]),$cell_style1);
				$ic++;$worksheet->write($row_no, $ic,iconv('UTF-8','TIS-620'," ".$Row["createdate"]),$cell_style1);	
				$ic++;$worksheet->write($row_no, $ic,iconv('UTF-8','TIS-620'," ".$Row["ipaddress"]),$cell_style1);		
				
			}
	
	}
	

$workbook->close();

header("Content-Type: application/x-msexcel; name=\"$fname_export\"");
header("Content-Disposition: inline; filename=\"$fname_export\"");
$fh=fopen($fname, "rb");
fpassthru($fh);
unlink($fname);

?>
