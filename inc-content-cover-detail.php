<? include('./inc-vdo-cover.php');	?> 
   <p class="topic">
  <?=$RowHead["name_content"]?>
   </p>
    <?=getFullPathContent($RowHead["content_html"])?>
   <div class="clearfix"></div><br>
   <div class="img-writer">
   <?
  		$physical_user="./uploads/users/".$RowHead["filepic_user"];
	
		if (!(is_file($physical_user) && file_exists($physical_user) )) {
			$physical_user="./images/photo_not_available.jpg";
		
		}		
	?>
     <img src="<?=$physical_user?>" class="img-responsive">
   </div>
   <div class="txt-writer">
      <span class="name"><?=$RowHead["firstname"]?>  <?=$RowHead["lastname"]?></span><br>
      <span class="position"><?=$RowHead["usergroupname"]?></span>    
   </div>
    <div class="clearfix"></div><br>
    <p class="update">Update : <?=$dateshow?></p>
    <p class="view">View : <?=number_format($RowHead["cstate"],0)?></p><br>
    
<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-57021aaab4d01ff0"></script>


    <div class="box-click">
      <div class="share">
       <div class="addthis_sharing_toolbox"></div>
      </div>
      
      
      <div class="like">
      
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5&appId=509623369080549";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
	
    <div class="fb-like" data-href="<?=$url_share?>" data-layout="standard" data-action="like" data-show-faces="false" data-share="false"></div>

      </div>
    </div>
