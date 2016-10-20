<section class="ads">
<?
$ads_mid="SADST01";
$sql_f="p.id,p.filepic,p.flashmedia_physical,p.content_th,p.content_en,p.url,p.flag_flash";	
$sql = "SELECT $sql_f FROM ads_main p inner join ads_menu a on(a.ads_id=p.id) ";
$sql.= " WHERE p.menu_id='".$ads_mid."'";
$sql.= " and a.menu_code='".$mgroup."'";
$sql.= " and p.flag_display='Y'";
$sql.=SystemGetSqlDateShow("p.dateshow1","p.dateshow2"); 	
//$sql.= " order by p.order_by asc ";
$sql.= " ORDER BY RAND() LIMIT 1";



$Conn->query($sql);
$AdsListHead = $Conn->getResult();
$CntRecBannerHead = $Conn->getRowCount();

if($CntRecBannerHead>0){
?>
<style>
#owl-banner-header{
	display:none;
}
</style>
<div <? if($CntRecBannerHead>1){ ?> id="owl-banner-header" class="owl-carousel owl-theme banner-slide"  <? } ?> >
<?
for ($i=0;$i<$CntRecBannerHead;$i++) {
$RowAds = $AdsListHead[$i];
$physical_ads_name="./uploads/ads/".$RowAds["filepic"];
if (!(is_file($physical_ads_name) && file_exists($physical_ads_name) )) {
	$physical_ads_name="./images/photo_not_available.jpg";
}

$physical_adsflash_name="./uploads/ads/".$RowAds["flashmedia_physical"];
$content_html="";
$content_html=$RowAds["content_".strtolower($_SESSION['FRONT_LANG'])];
$content_html = preg_replace("/<img[^>]+\>/i", " ", $content_html); 
$content_html=strip_tags($content_html);

//echo $RowAds["flag_flash"];

if(trim($RowAds["url"])!=""){
	$linkads=trim($RowAds["url"]);
}else if(trim($content_html)!=""){		
	$linkads="intro-detail.php?did=".$RowAds["id"];;
}else{
	$linkads="";
}
?>
 <div class="item" >
<center>
 <? if($RowAds["flag_flash"]=="Y"){ ?>
 
 <div id="flashContent" onmousedown="clickBanner('<?=$RowAds["id"];?>','<?=$linkads?>')" style="height:90px;">
        <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="728"  height="100%"  id="Banner<?php echo $RowAds["id"];?>" align="middle" >
		<param name="movie" value="<?=$physical_adsflash_name?>?clickTAG=<?php echo $linkads;?>" />
		<param name="quality" value="high" />
		<param name="bgcolor" value="transparent" />
        <param name="wmode" value="transparent">
		<param name="play" value="true" />
		<param name="loop" value="true" />
		<param name="wmode" value="window" />
		<param name="scale" value="showall" />
		<param name="menu" value="true" />
		<param name="devicefont" value="false" />
		<param name="salign" value="" />
		<param name="allowScriptAccess" value="sameDomain" />
		<!--[if !IE]>--> 
		<object type="application/x-shockwave-flash" data="<?=$physical_adsflash_name?>?clickTAG=<?php echo $linkads;?>" width="728" height="100%" id="<?php echo $RowAds["id"];?>" >
		<param name="movie" value="<?=$physical_adsflash_name?>?clickTAG=<?php echo $linkads;?>" />
		<param name="quality" value="high" />
        <param name="bgcolor" value="#000000" />
        <param name="wmode" value="transparent">
		<param name="play" value="true" />
		<param name="loop" value="true" />
		<param name="wmode" value="window" />
		<param name="scale" value="showall" />
		<param name="menu" value="true" />
		<param name="devicefont" value="false" />
		<param name="salign" value="" />
		<param name="allowScriptAccess" value="sameDomain" />
		<!--<![endif]-->
         <? if($linkads!=""){ ?>
		 <a href="<?=$linkads?>" target="_blank"  class="linkads" did="<?=$RowAds["id"]?>" ads_menu="<?=$mgroup?>"> <img src="<?=$physical_ads_name?>" ></a>
        <? } ?>
		<!--[if !IE]>-->
		</object>
		<!--<![endif]-->
		</object>
        </div>
 <? }else{ ?>
 
  <? if($linkads!=""){ ?>
 <a href="<?=$linkads?>"  target="_blank" class="linkads" did="<?=$RowAds["id"]?>" ads_menu="<?=$mgroup?>"> <img src="<?=$physical_ads_name?>" ></a>
 <? }else{ ?>
 <img src="<?=$physical_ads_name?>" >
 <? } ?>
 
 <? } ?>
 
 
</center>
</div>
<? } ?>
</div>
<? } ?>



</section>

