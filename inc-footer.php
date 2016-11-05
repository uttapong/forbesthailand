<footer id="footer">
<section class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-4 fpr mb">
                    <p class="f-topic text-uppercase">Contact</p>
                    <p class="fsub-topic">MAILING ADDRESS</p>
                    <p class="f-txt">Forbes Thailand<br>
                    Post International Media Co., Ltd.<br>
                    6th Floor, Bangkok Post Building, 136 <br>
                    Sunthornkosa Road, Klong Toey, <br>
                    Bangkok 10110<br><br>
                    </p>
                    <p class="f-txt text-uppercase"><br><a href="privacy.php">Privacy Statement >></a></p>
                    <p class="f-txt text-uppercase"><br><a href="map.php">See map >></a></p>
                </div>
                <div class="col-xs-12 col-sm-4 fpr mb text-uppercase">
                    <p class="fsub-topic">WEB EDITOR</p>
                    <p class="f-txt">E-mail : <br><font class="">kampanath_k@postintermedia.com</font></p>
                    <p class="fsub-topic"><br>EDITORIAL DEPARTMENT</p>
                    <p class="f-txt">Tel. 0-2616-4666 ext. 4734 <br>E-mail : forbesthailand@postintermedia.com</p>
                    <p class="fsub-topic"><br>ADVERTISING DEPARTMENT</p>
                    <p class="f-txt">Tel. 0-2616-4720 <br>E-mail : auntika_s@postintermedia.com</p>
                    <!--
                    <p class="fsub-topic"><br>MARKETING AND PROMOTION DEPARTMENT</p>
                    <p class="f-txt">Tel. 0-2616-4760 <br>E-mail : varainvis_m@postintermedia.com</p>
                    -->
                    <p class="fsub-topic"><br>SUBSCRIPTION DEPARTMENT</p>
                    <p class="f-txt">Tel. 02 616 4666 Ext. 4655 <br>E-mail : nuntaree_k@postintermedia.com</p>
                </div>
                <div class="col-xs-12 col-sm-4 text-uppercase">
                    <p class="fsubs-topic"><a href="content.php">Current issue </a><a href="privacy.html"> / E-Magazine </a></p>
                    <p class="img-subscribe">
                    
					<?
					$sql_f="p.id,p.filepic,p.url";	
                    $sql = "SELECT $sql_f FROM ads_main p ";
                    $sql.= " WHERE p.menu_id='SADST05'";
                    $sql.= " and p.flag_display='Y'";
                    $sql.= " order by p.order_by asc ";
                    
                    $Conn->query($sql,1,2);
                    $AdsList = $Conn->getResult();
                  	$CntRecAds = $Conn->getRowCount();
                    if($CntRecAds>0){
						for ($i=0;$i<$CntRecAds;$i++) { 
						$RowAds = $AdsList[$i];
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
                    <a href="<?=$linkads?>" target="_blank"><img src="<?=$physical_name?>" class="img-responsive align-center"></a>
                      <? } ?>   
                    <? } ?>              
                    
                    </p>
                    <p class="btn-subscribe"><a id="btn-subscribe"  data-fancybox-type="ajax" href="./index-action.php?ModuleAction=showShbscribe" class="fancybox" target="_blank">Subscription</a></p>
                 
                    <script>
					  	$(document).ready(function(){			
							$("#btn-subscribe").fancybox({
								 padding: 0,
								openEffect	: 'none',
								closeEffect	: 'none',
								closeBtn : true,
							});
						});
				  </script>
                    
                    
                    <p class="fsubs-topic"><br>Social Media</p>
                    <p>
                        <a href="https://www.facebook.com/ForbesThailandMagazine/" target="_blank"><i class="icon-fb"></i></a>
                        <a href="https://twitter.com/Forbes_TH" target="_blank"><i class="icon-twit"></i></a>
                        <a href="https://plus.google.com/117157998451916073434" target="_blank"><i class="icon-g"></i></a>
                        <a href="https://www.instagram.com/forbesthailand/" target="_blank"><i class="icon-ig"></i></a>
                        <a href="https://www.youtube.com/user/ForbesThai" target="_blank"><i class="icon-you"></i></a>
                        <a href="./rss/feed.php" target="_blank"><i class="icon-rss"></i></a></p>
                        
                        <!-- https://css-tricks.com/snippets/php/rss-generator/ -->
                </div>
            </div>
        </div>
    </section>
    <section class="footer-bottom">
       <div class="container">
           <div class="row">
               <div class="col-xs-12">
                    <span>2015 Forbesthailand.com All right Reserved</span>
               </div>
           </div>
        </div>
    </section>
</footer>

<script>

 
 function clickBanner(did,linkads){
	var Vars="ModuleAction=saveState&did="+did;
		Vars+="&link=<?="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"?>";	
		$.ajax({
		url : "./index-action.php",
		data : Vars,
		type : "post",
		dataType: 'json',
		cache : false ,
		success : function(resp){
				if(linkads!=""){
					window.open(linkads);
				}
			}
		});	
	 //return true;
 }


$(document).ready(function(){					   
	$('.linkads').click(function(){		
		var Vars="ModuleAction=saveState&did="+$(this).attr('did');
		Vars+="&ads_menu="+$(this).attr('ads_menu');		
		Vars+="&link=<?="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"?>";		
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
<script>
$(document).ready(function() {
function saveStatView(did){
  var Vars="ModuleAction=saveStateView&did="+did;
	Vars+="&ads_menu=<?=$mgroup?>";		
	Vars+="&link=<?="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"?>";		
	$.ajax({
	url : "./index-action.php",
	data : Vars,
	type : "post",
	dataType: 'json',
	cache : false ,
	success : function(resp){			
		}
	});		
}				   
<? 
if($CntRecBannerHead>1){ ?>	
var carousel_head =$("#owl-banner-header").owlCarousel({    
	navigation : true,
	slideSpeed : 300,

	animateOut: 'fadeOut',
	
	paginationSpeed : 400,
	autoplay : true,
	items : 1,  
	autoPlay : 2000,
	loop:true,
}); 
carousel_head.trigger('to.owl.carousel', [<?=rand(1,$CntRecBannerHead)?>,10]);
$('#owl-banner-header').show();
saveStatView($("#owl-banner-header .owl-item.active .item a").attr('did'));
carousel_head.on('change.owl.carousel', function(property) {											 
	var current = (property.page.index)+1;	
	var did=$(property.target).find(".owl-item").eq(current).find("a").attr('did');	
	saveStatView(did);
});
<? }else{ ?>
<? if($AdsListHead[0]["id"]>0){ ?> saveStatView(<?=$AdsListHead[0]["id"]?>); <?  } ?>
<? } ?>
<?
if($CntRecBannerRight>1){ 
?>	
  var carousel_right1 =$("#owl-banner-right1").owlCarousel({    
	navigation : true,
	animateOut: 'fadeOut',
	 slideSpeed : 300,
     paginationSpeed : 400,
	 autoplay : true,
     items : 1,  
	 autoPlay : 2000,
	 loop:true,
  }); 
	carousel_right1.trigger('to.owl.carousel', [<?=rand(1,$CntRecBannerRight)?>,20]);
	saveStatView($("#owl-banner-right1 .owl-item.active .item a").attr('did'));	
	carousel_right1.on('change.owl.carousel', function(property) {											 
	var current = (property.page.index)+1;	
	var did=$(property.target).find(".owl-item").eq(current).find("a").attr('did');	
	saveStatView(did);
});
<? }else{ ?>
<? if($AdsListRight[0]["id"]>0){ ?> saveStatView(<?=$AdsListRight[0]["id"]?>); <?  } ?>
<? } ?>

 <? if($CntRecBannerFooter>1){ ?>	
var carousel_footer =$("#owl-banner-footer").owlCarousel({    
	navigation : true,
	animateOut: 'fadeOut',
	slideSpeed : 300,
	paginationSpeed : 400,
	autoplay : true,
	items : 1,  
	autoPlay : 2000,
	loop:true,
}); 
carousel_footer.trigger('to.owl.carousel', [<?=rand(1,$CntRecBannerFooter)?>,20]);
saveStatView($("#owl-banner-footer .owl-item.active .item a").attr('did'));	
carousel_footer.on('change.owl.carousel', function(property) {											 
	var current = (property.page.index)+1;	
	var did=$(property.target).find(".owl-item").eq(current).find("a").attr('did');	
	saveStatView(did);
});
<? }else{ ?>
<? if($AdsListFooter[0]["id"]>0){ ?> saveStatView(<?=$AdsListFooter[0]["id"]?>); <?  } ?>
<? } ?>
});
</script>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-52059237-1', 'auto');
  ga('send', 'pageview');

</script>
<?
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
//$Conn->disconnect();

//mysqli_close($Conn);
if ($Conn) {
   unset($Conn);
}
?>
