<?
if($_SERVER['HTTP_X_REQUESTED_WITH']=="XMLHttpRequest"){
	require("./lib/system_core.php");
}
if($_REQUEST['ModuleAction']!=""){
	$ModuleAction = $_REQUEST['ModuleAction'];
	$SysMenuID=$_POST["SysMenuID"];
	$ModuleDataID = $_REQUEST['ModuleDataID'];
}
?>
<? 	if ($ModuleAction == "showContent") {
$_SESSION['FLAG_SID']=session_id();
$_SESSION['FLAG_ADS']="NO";
$did=$_REQUEST["did"];

$sql = "select *,name_".strtolower($_SESSION['FRONT_LANG'])." as name_content  from  ads_main where  id='".$did."' ";
$Conn->query($sql);
$Content = $Conn->getResult();
$RowHead=$Content[0];

$physical_name="./uploads/ads/".$RowHead["filepic"];		
if (!(is_file($physical_name) && file_exists($physical_name) )) {
	$physical_name="./images/photo_not_available.jpg";
}									
$topic=SystemSubString($RowHead["name_content"],130,'..');


$content_html="";
$content_html=$RowHead["content"];
$content_html = preg_replace("/<img[^>]+\>/i", " ", $content_html); 
$content_html=strip_tags($content_html);

if(trim($RowHead["url"])!=""){
	$linkads=trim($RowHead["url"]);
}else if(trim($content_html)!=""){		
	$linkads="intro-detail.php?did=".$RowHead["id"];;
}else{
	$linkads="";
}

?>
<div class="dialog-box" >
<div class="content">
 <? if($linkads!=""){ ?>
 <a  href="<?=$linkads?>" class="linkads" did="<?=$RowAds["id"]?>" ads_menu="<?=$mgroup?>"> <img src="<?=$physical_name?>" width="" style="width:800px;"  /> </a>
  <? }else{ ?>
 <img src="<?=$physical_name?>" >
 <? } ?>
</div>
<div class="head">
 <? if($linkads!=""){ ?>
<a  href="<?=$linkads?>" class="linkads" did="<?=$RowAds["id"]?>" ads_menu="<?=$mgroup?>">
 <? if($topic!=""){ ?>
<p class="topic"><?=$topic?></p>
<? } ?>
</a>
  <? }else{ ?>
  <? if($topic!=""){ ?>
  <p class="topic"><?=$topic?></p>
  <? } ?>
  <? } ?>
</div>
<div style="float:right; margin-top:-30px;  position: relative;">
<? if(trim($RowHead["filemedia_physical"])!=""){ ?>
<a href="./uploads/fileall/<?=$RowHead["filemedia_physical"]?>" target="_blank"><img src="assets/img/icon-pdf.png" width="43" height="55" /></a>
<? } ?>
</div>
</div>
<script>
 var date = new Date();
 var minutes = 30;
 date.setTime(date.getTime() + (minutes * 60 * 1000));
 $.cookie("FLAG_ADS", "NO", { expires: date, path: '/'});
 //$.cookie("FLAG_ADS", "NO", { expires: date, path: '/' ,domain: "digitgood.com"  });


$(document).ready(function(){					   
	$('.linkads').click(function(){		
		var Vars="ModuleAction=saveState&did=<?=$did?>";
		Vars+="&ads_menu=";		
		Vars+="&link=<?="http://$_SERVER[HTTP_HOST]"?>";		
		$.ajax({
		url : "./index-action.php",
		data : Vars,
		type : "post",
		dataType: 'json',
		cache : false ,
		success : function(resp){
				
			}
		});	
	});
});
</script>



<?
$link="http://$_SERVER[HTTP_HOST]";

$sql = "select ads_id  from  ads_state where  ads_id='".$did."' and type='V' and  link='".$link."' and  ipaddress='".SystemGETIP()."' and DATE(createdate)=CURDATE()";
$Conn->query($sql);
$Content = $Conn->getResult();
$RowHead=$Content[0];
if($RowHead["ads_id"]>0){
	exit;
}

if($did>0){

	$sql = "update  ads_main set  cread = cread + 1 ";
	$sql.=" where id = '".$did."'";
	$Conn->execute($sql);
	
	$insert="";
	$insert["ads_id"] 			= "'".$did."'";
	$insert["type"] 			= "'V'";
	$insert["link"] 			= "'".$link."'";
	$insert["createdate"] 			= "sysdate()";
	$insert["ipaddress"] 			= "'".SystemGETIP()."'";
	$sql = "insert into ads_state(".implode(",",array_keys($insert)).") values (".implode(",",array_values($insert)).")";
	$Conn->execute($sql);
	
	
}
?>

<? 	}else if ($ModuleAction == "showShbscribe") { ?>


<?

$sql = "SELECT p.* FROM ads_main p ";
$sql.= " WHERE p.menu_id='SFT04'";
$sql.= " and p.flag_display='Y'";
$sql.= " order by p.order_by asc ";


$Conn->query($sql);
$AdsList = $Conn->getResult();
$CntRecAds = $Conn->getRowCount();
$CntRecSlideM = $CntRecAds;


if($CntRecAds>0){
$RowAds = $AdsList[0];
$physical_name="./uploads/ads/".$RowAds["filepic"];

if (!(is_file($physical_name) && file_exists($physical_name) )) {
	$physical_name="./images/photo_not_available.jpg";
}

if(trim($RowAds["url"])!=""){
	$linkads=trim($RowAds["url"]);
}else if(trim($content_html)!=""){		
	$linkads="intro-detail.php?did=".$RowAds["id"];;
}else{
	$linkads="";
}

?>
<div class="dialog-box-sub" >
 <a id="btn-subscribe-iframe"  class="fancybox" data-fancybox-type="iframe"  href="<?=$linkads?>"><img src="<?=$physical_name?>" width="100%" style="width:100%;"  /> </a>
</div>

 <script>
					  	$(document).ready(function(){			
							$("#btn-subscribe-iframe").fancybox({
								 padding: 0,
								openEffect	: 'none',
								closeEffect	: 'none',
								closeBtn : true,
							});
						});
				  </script>

 <? } ?>



<? 	}else if ($ModuleAction == "clearPopUP") {?>
<?
$_SESSION['FLAG_ADS']="";

?>
<? 	}else if ($ModuleAction == "InsertData") {?>

<?

$sql = "select *  from  newsletter_main where  email='".trim($_REQUEST['input_email'])."' ";

$Conn->query($sql);
$Content = $Conn->getResult();
$RowHead=$Content[0];

if($RowHead["id"]>0){
	$returnArray[error] = "true";
	$returnArray[txt] = "EMAIL ALREADY EXISTS.";
	echo json_encode($returnArray);
	exit;
}


$insert="";
$insert["email"] 			= "'".trim($_REQUEST['input_email'])."'";
$insert["createdate"] 			= "sysdate()";
$sql = "insert into newsletter_main(".implode(",",array_keys($insert)).") values (".implode(",",array_values($insert)).")";
$Conn->execute($sql);

$returnArray[error] = "false";
echo json_encode($returnArray);
exit;
?>	
<? 	}else if ($ModuleAction == "saveState") {?>
<?
$did=$_REQUEST["did"];
$link=$_REQUEST["link"];


$sql = "select ads_id  from  ads_state where  ads_id='".$did."' and type='C' and  link='".$link."' and  ipaddress='".SystemGETIP()."' and DATE(createdate)=CURDATE()";
$Conn->query($sql);
$Content = $Conn->getResult();
$RowHead=$Content[0];
if($RowHead["ads_id"]>0){
	exit;
}


$sql = "update  ads_main set  cstate = cstate + 1 ";
$sql.=" where id = '".$did."'";
$Conn->execute($sql);

$insert="";
$insert["ads_id"] 			= "'".$did."'";
$insert["type"] 			= "'C'";
$insert["link"] 			= "'".$link."'";
$insert["createdate"] 			= "sysdate()";
$insert["ipaddress"] 			= "'".SystemGETIP()."'";
$sql = "insert into ads_state(".implode(",",array_keys($insert)).") values (".implode(",",array_values($insert)).")";
$Conn->execute($sql);

$returnArray[error] = "false";
echo json_encode($returnArray);
exit;
?>
<? 	}else if ($ModuleAction == "saveStateView") {?>
<?
$did=$_REQUEST["did"];
$link=$_REQUEST["link"];

$sql = "select ads_id  from  ads_state where  ads_id='".$did."' and type='V' and  link='".$link."' and  ipaddress='".SystemGETIP()."' and DATE(createdate)=CURDATE()";
$Conn->query($sql);
$Content = $Conn->getResult();
$RowHead=$Content[0];
if($RowHead["ads_id"]>0){
	exit;
}

if($did>0){

	$sql = "update  ads_main set  cread = cread + 1 ";
	$sql.=" where id = '".$did."'";
	$Conn->execute($sql);
	
	$insert="";
	$insert["ads_id"] 			= "'".$did."'";
	$insert["type"] 			= "'V'";
	$insert["link"] 			= "'".$link."'";
	$insert["createdate"] 			= "sysdate()";
	$insert["ipaddress"] 			= "'".SystemGETIP()."'";
	$sql = "insert into ads_state(".implode(",",array_keys($insert)).") values (".implode(",",array_values($insert)).")";
	$Conn->execute($sql);
	
	$returnArray[error] = "false";
	echo json_encode($returnArray);
	exit;
}
?>

<? 	} ?>