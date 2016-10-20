<?php
require("./../lib/system_core.php");
header("Content-Type: application/xml; charset=utf-8");   // ส่งค่าเป็น xml   
//strtolower($_SESSION['FRONT_LANG'])
$rss_html.= '<?xml version="1.0" encoding="windows-874"?>';  
$rss_html.= '<rss version="2.0">';  
$rss_html.=  '<channel>';  
$rss_html.=    '<title>FORBES THAILAND</title>'; // หัวข้อ rss  กขค
$rss_html.=    '<link>'._SYSTEM_HOST_NAME_.'</link>'; // เว็บไซต์  
$rss_html.=    '<description>แรงบันดาลใจของผู้ใฝ่ความสำเร็จ</description>'; // คำอธิบาย rss  
$rss_html.=    '<language>th-TH</language>'; 
$rss_html.=    '<pubDate>'.date("r").'</pubDate>'; // วันที่ปัจจุบัน  
$rss_html.=    '<lastBuildDate>'.date("r").'</lastBuildDate>'; // วันที่ปัจจุบัน  
$rss_html.=    '<copyright>Copyright yourwebsite.com</copyright>'; // copyright  
$rss_html.=    '<image>'; 
$rss_html.=    '<title>FORBES THAILAND LOGO</title>';  // หัวข้อสำหรับรูปภาพโลโก้  
$rss_html.=    '<url>'._SYSTEM_HOST_NAME_.'/images/main/logo.png</url>'; //  url โลโก้  
$rss_html.=    '<link>'._SYSTEM_HOST_NAME_.'</link>'; // ลิ้งจากโลโก้  
$rss_html.=    '</image>';  


	
	$sql = "SELECT p.*,p.name_".strtolower($_SESSION['FRONT_LANG'])." as name_content  FROM (SELECT * FROM article_main WHERE menu_id<>'MNT01' and menu_id<>'MNT02'  and flag_display='Y' ".SystemGetSqlDateShow("dateshow1","dateshow2")." ORDER BY updatedate DESC) p GROUP BY p.menu_id order by p.updatedate desc ";
	$Conn->query($sql,$page,$pagesize);
	$ContentList = $Conn->getResult();
	$CntRecContentList = $Conn->getRowCount();
	$TotalContentRec= $Conn->getTotalRow();			   
				   
for ($i=0;$i<$CntRecContentList;$i++) {
		$Row = $ContentList[$i];	
		$physical_name="./uploads/article/".$Row["filepic"];
		$flag_pic=1;
		if (!(is_file($physical_name) && file_exists($physical_name) )) {
			$physical_name="./images/photo_not_available.jpg";
			$flag_pic=0;
		}									
		$dateshow= getDisplayDate($Row["updatedate"]);	
		$topic=$Row["name_content"];
		
		
		$_title_module=$_source_title[$Row["menu_id"]];
		$_color_module=$_source_color[$Row["menu_id"]];
		$_url_module=_SYSTEM_HOST_NAME_."/".strtolower($_SESSION['FRONT_LANG'])."/".$_source_url[$Row["menu_id"]]."?did=".$Row["id"];	
		$_url_seeall=$_source_seeall[$Row["menu_id"]];	
		
		$content_html=$Row["content_".strtolower($_SESSION['FRONT_LANG'])];
		$content_html = preg_replace("/<img[^>]+\>/i", " ", $content_html); 
		$content_html=strip_tags($content_html);
		$content_html = SystemSubString($content_html,200,'');
			

$rss_html.=    '<item>';  
$rss_html.=    '<title>'.$topic.'</title>'; // หัวข้อบทความ   
$rss_html.=    '<link>'.$_url_module.'</link>'; // ลิ้งบทความ  
$rss_html.=    '<description><![CDATA[';  
$rss_html.= $content_html; // รายละเอียดบทความอย่างย่อ  
$rss_html.=    ']]></description>';  
$rss_html.=    '<pubDate>'.date('r',strtotime($Row["updatedate"])).'</pubDate>'; // วันที่ของบทความ  
$rss_html.=    '</item>';  
} // ปิด loop  

$rss_html.=    '</channel>';  
$rss_html.=    '</rss>';  
echo $rss_html;