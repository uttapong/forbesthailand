<?
$ads_mid="SADST02";
$sql_f="p.id,p.filepic,p.flashmedia_physical,p.content_th,p.content_en,p.url,p.flag_flash";	
$sql = "SELECT $sql_f FROM ads_main p inner join ads_menu a on(a.ads_id=p.id) ";
$sql.= " WHERE p.menu_id='".$ads_mid."'";
$sql.= " and a.menu_code='".$mgroup."'";
$sql.= " and p.flag_display='Y'";
//$sql.= " order by p.order_by asc ";
$sql.= " ORDER BY RAND() LIMIT 1";


$Conn->query($sql);
$AdsListRight = $Conn->getResult();
$CntRecBannerRight = $Conn->getRowCount();

if($CntRecBannerRight>0){
?>
<div class="content-bannerright mbc">
<div <? if($CntRecBannerRight>1){ ?> id="owl-banner-right1" class="owl-carousel owl-theme banner-slide"  <? } ?> >
<?
for ($i=0;$i<$CntRecBannerRight;$i++) {
$RowAds = $AdsListRight[$i];
$physical_name="./uploads/ads/".$RowAds["filepic"];

if (!(is_file($physical_name) && file_exists($physical_name) )) {
	$physical_name="./images/photo_not_available.jpg";
}

$content_html="";
$content_html=$RowAds["content"];
$content_html = preg_replace("/<img[^>]+\>/i", " ", $content_html); 
$content_html=strip_tags($content_html);

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
 <? if($linkads!=""){ ?>
 <a href="<?=$linkads?>" target="_blank"   class="linkads" did="<?=$RowAds["id"]?>" ads_menu="<?=$mgroup?>"> <img src="<?=$physical_name?>" ></a>
 <? }else{ ?>
 <img src="<?=$physical_name?>" >
 <? } ?>
</center>
</div>
<? } ?>
</div>

</div>
<? } ?>





<?

	$sql_f="p.id,p.menu_id,p.filepic,p.content_th,p.content_en,p.updatedate,p.cstate";	
	$sql = "SELECT $sql_f,p.name_".strtolower($_SESSION['FRONT_LANG'])." as name_content FROM article_main p";
	$sql.= " WHERE p.menu_id='MNT14'  and p.flag_display='Y' and p.id<>'$did' ";			
	$sql.=SystemGetSqlDateShow("p.dateshow1","p.dateshow2"); 
	$sql.= " ORDER BY p.updatedate desc ";
	$Conn->query($sql,1,1);
	$ContentVdo = $Conn->getResult();
	$CntRecVdo = $Conn->getRowCount();

	if($CntRecVdo && $mgroup != "VDO_MAIN" ){
		
	$physical_name="./uploads/article/".$ContentVdo[0]["filepic"];
	$flag_pic=1;
	if (!(is_file($physical_name) && file_exists($physical_name) )) {
		$physical_name="./images/photo_not_available.jpg";
		$flag_pic=0;
	}									
	$dateshow= getDisplayDate($ContentVdo[0]["updatedate"]);
	
		?>
<div class="col-xs-12 mbc">
   <div class="block">
       <div class="tab-block-sm">
           <span>vdo</span>
       </div>
       <div class="cat-grey-sm"></div>
       <div class="clearfix"></div>
       <div class="article-sm">
          <div class="col-xs-12">
              <div class="row">
                  <figure class="play-link">
                      <img src="<?=$physical_name?>" class="img-responsive align-center">
                      <a href="vdo-detail.php?did=<?=$ContentVdo[0]["id"]?>">
                        <figcaption><i class="icon-vdo"></i></figcaption>
                      </a>
                  </figure>
              </div>
          </div>
          <div class="clearfix"></div>
           <p class="topic">
               <?=SystemSubString($ContentVdo[0]["name_content"],60,'..')?>
           </p>
           <p class="update">Update : <?=$dateshow?></p>
           <p class="view">View : <?=number_format($ContentVdo[0]["cstate"],0)?></p>
       </div>
       <div class="clearfix"></div>
       <div class="see-all">
            <a href="vdo.php">see all <i class="icon-arrow"></i></a>
       </div>
   </div>
</div>
<? } ?>                           
                           
                           <div class="col-xs-12 mbc">
                            <div class="fb-page" data-href="https://www.facebook.com/ForbesThailandMagazine" data-width="360px" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/ForbesThailandMagazine"><a href="https://www.facebook.com/ForbesThailandMagazine">Forbes Thailand Magazine</a></blockquote></div></div>
                               <div id="fb-root"></div>
                                <script>(function(d, s, id) {
                                  var js, fjs = d.getElementsByTagName(s)[0];
                                  if (d.getElementById(id)) return;
                                  js = d.createElement(s); js.id = id;
                                  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5";
                                  fjs.parentNode.insertBefore(js, fjs);
                                }(document, 'script', 'facebook-jssdk'));</script>
                           </div>