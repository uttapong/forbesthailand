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
<? 	if ($ModuleAction == "getMoreContent") {?>
<?
	$page=$_REQUEST["page"];
	$mid=$_REQUEST["mid"];
	$cid=$_REQUEST["cid"];
	  $txt_search=$_REQUEST["s"]; 

	if($page<1) $page=1;
	$page++;
	$pagesize=9;	
	$start_rec = (($page-1)*$pagesize)+1;
		
	$sql ="SELECT p.*,p.name_".strtolower($_SESSION['FRONT_LANG'])." as name_content,p.cstate as statshow FROM article_main p";
	$sql.=" ";
	$sql.=" WHERE  p.flag_display='Y' and p.cstate>0 ";
	
	$sql.=" and (p.name_th  like '%".$txt_search."%' ";
	$sql." or p.name_en  like '%".$txt_search."%' "; 			 
	$sql.=")";
	
	$sql.=SystemGetSqlDateShow("p.dateshow1","p.dateshow2")."  order by p.updatedate desc ";	
	$sql_c=$sql;
	$sql.= " LIMIT ".$start_rec.",".$pagesize;
	
	
    $Conn->query($sql);
	$ContentList = $Conn->getResult();
	$CntRec = $Conn->getRowCount();
	
	$sql_c = "select count(*) as CNT from (".$sql_c.") tb";
  	$Conn->query($sql_c);
	$ContentCount = $Conn->getResult();
	$TotalRec=$ContentCount[0]["CNT"];
	
	
	$_content="";
	
	for ($i=0;$i<$CntRec;$i++) {					
	$Row = $ContentList[$i];	
	 
	$physical_name="./uploads/article/".$Row["filepic"];
	$flag_pic=1;
	if (!(is_file($physical_name) && file_exists($physical_name) )) {
		$physical_name="./images/photo_not_available.jpg";
		$flag_pic=0;
	}
	$dateshow= getDisplayDate($Row["updatedate"]);	
	$topic=SystemSubString($Row["name_content"],60,'');
	
	$_title_module=$_source_title[$Row["menu_id"]];
	$_color_module=$_source_color[$Row["menu_id"]];
	$_url_module=$_source_url[$Row["menu_id"]];	
	$_url_seeall=$_source_seeall[$Row["menu_id"]];	
	
 	$_content.=' <div class="col-xs-12 col-sm-4 mbc list-load">
                        <div class="block">
                              <div class="tab-block-sm">
                                  <span>'.$_title_module.'</span>
                              </div>
                              <div class="'.$_color_module.'"></div>
                              <div class="clearfix"></div>
                              <div class="article-sm"> ';
							  
							  if($Row["menu_id"]=="MNT14"){ 
				 			$_content.=' <div class="col-xs-12">
                                          <div class="row">
                                              <figure class="play-link">
                                                  <img src="'.$physical_name.'" class="img-responsive align-center">
                                                  <a href="'.$_url_module.'?did='.$Row["id"].'">
                                                    <figcaption><i class="icon-vdo"></i></figcaption>
                                                  </a>
                                              </figure>
                                          </div>
                                      </div>
                                      <div class="clearfix"></div> ';
							  }else{
                         	$_content.='           <a class="a_pic"  href="'.$_url_module.'?did='.$Row["id"].'"><img src="'.$physical_name.'" class="img-responsive align-center"></a> ';
							  }
                          	$_content.='          <p class="topic">
                                     '.$topic.'
                                      </p>
                                      <p class="update">Update : '.$dateshow.'</p>
                                      <p class="view">View : '.number_format($Row["cstate"],0).'</p>
                              </div>
                              <div class="clearfix"></div>
                              <div class="see-all">
                                  <a href="'.$_url_seeall.'">see all <i class="icon-arrow"></i></a>
                              </div>
                          </div>
                      </div>';
	
  } 
  
	
	$returnArray[error] = "true";
	$returnArray[html] = $_content;
	$returnArray[page] = $page;
	if(($page*$pagesize)<$TotalRec){
		$returnArray[end] = false;
	}else{
		$returnArray[end] = true;
	}
	echo json_encode($returnArray);
	exit;
  
  ?>


<? } ?>