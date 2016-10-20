<?                             
 if($RowHead["flag_media"]=="UPLOADFILE"){
?>
     <script src="./johndyer-mediaelement/mediaelement-and-player.min.js"></script>
	<link rel="stylesheet" href="./johndyer-mediaelement/mediaelementplayer.min.css" />
  <div class="align-center">  
  <?

$physical_name="./uploads/cover/".$RowHead["filepiccontent"];
	$flag_pic=1;
if (!(is_file($physical_name) && file_exists($physical_name) )) {
	$physical_name="./images/photo_not_available.jpg";
	$flag_pic=0;
}				
?>
<video class="vdoplay align-center" width="666" height="400" style="width: 100%; height: 100%;"  poster="<?=$physical_name?>" src="<?="./uploads/media/".$RowHead["filemedia_physical"]?>" type="video/mp4" 
id="player1" controls="controls" autoplay="false" preload="none"></video>
<script>

$('audio,video').mediaelementplayer({
mode: 'shim',
success: function(player, node) {
$('#' + node.id + '-mode').html('mode: ' + player.pluginType);
}
});

</script>
</div>
<? }else if($RowHead["flag_media"]=="EMBED"){ ?>
<div class="vdo_content align-center" >
<?php
    $url = $RowHead["embed_code"];
    preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $url, $matches);
    $id = $matches[1];
  
?>
<iframe id="ytplayer" type="text/html" 
    src="https://www.youtube.com/embed/<?php echo $id ?>?rel=0&showinfo=0&color=white&iv_load_policy=3"
    frameborder="0" allowfullscreen></iframe> 
</div>

<? }else if($RowHead["flag_media"]=="UPLOADPIC"){ ?>

<?
	$physical_name="./uploads/cover/".$RowHead["filepiccontent"];
	$flag_pic=1;
	if (!(is_file($physical_name) && file_exists($physical_name) )) {
		$physical_name="./images/photo_not_available.jpg";
		$flag_pic=0;
	}
	if($flag_pic){
		if ($type_cover=="INSIDE"){ 
?>
 <a href="cover-detail.php?did=<?=$RowHead["id"]?>">
    <img src="<?=$physical_name?>" class="img-responsive align-center img-effect">
    </a>
    <? }else{ ?>
     <img src="<?=$physical_name?>" class="img-responsive align-center img-effect">
    
    <? } ?>
<? } ?>
<? } ?>