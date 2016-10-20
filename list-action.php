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
	$source_navi=getCategoryNavi($cid);
	$cate_lel1=$source_navi['cate_lel1'];
	$cate_lel2=$source_navi['cate_lel2'];

	if($page<1) $page=1;
	$page++;
	$pagesize=9;	
	if($_REQUEST["t"]=="COVER"){
		$start_rec = (($page-1)*$pagesize);
		$did=$_REQUEST["did"];
	}else{
		$start_rec = (($page-1)*$pagesize)+1;
	}
	
		
	$sql = "SELECT p.*,p.name_".strtolower($_SESSION['FRONT_LANG'])." as name_content FROM article_main p";

	
	if($_REQUEST["t"]=="COVER"){
		$sql.= " WHERE p.cover_id='".$did."'  and p.flag_display='Y' and  p.flag_approved='Y' ";		
	}else{
		$sql.= " WHERE p.menu_id='".$mid."'  and p.flag_display='Y' and  p.flag_approved='Y' ";		
	}
		
	if($cate_lel1>0){
		$sql.= "  and p.cate1_id='$cate_lel1' ";		
	}
	if($cate_lel2>0){
		$sql.= "  and p.cate2_id='$cate_lel2' ";		
	}
	
	$sql.=SystemGetSqlDateShow("p.dateshow1","p.dateshow2"); 
	$sql.= " ORDER BY p.approveddate desc ";
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
	
 	$_content.=' <div class="col-xs-12 col-sm-4 mbc list-load">
                        <div class="block">
                              <div class="tab-block-sm">
                                  <span>'.$_title_module.'</span>
                              </div>
                              <div class="'.$_color_module.'"></div>
                              <div class="clearfix"></div>
                              <div class="article-sm"> ';
							  
							  if($mid=="MNT14"){ 
				 			$_content.=' <div class="col-xs-12">
                                          <div class="row vdopic">
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
                                  <a href="'.$_url_module.'?did='.$Row["id"].'">'._Detail_More_.' <i class="icon-arrow"></i></a>
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