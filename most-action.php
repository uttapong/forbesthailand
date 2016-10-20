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
	$start_rec = (($page-1)*$pagesize)+1;
		

	
	$sql = "SELECT p.*,p.name_".strtolower($_SESSION['FRONT_LANG'])." as name_content FROM article_main p";
	$sql.= " WHERE p.menu_id<>'MNT01'  and p.flag_display='Y' ";
	$sql.= SystemGetSqlDateShow("p.dateshow1","p.dateshow2")."  order by p.cstate desc ";
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
	$topic=SystemSubString($Row["name_content"],48,'');
	
	$_title_module="MOST POPULAR";
	$_color_module="cat-greenlight-sm";
	$_url_module=$_source_url[$Row["menu_id"]];	
	
 	$_content.=' <div class="col-xs-12 col-sm-4 mbc list-load">
                        <div class="block">
                              <div class="tab-block-sm">
                                  <span>'.$_title_module.'</span>
                              </div>
                              <div class="'.$_color_module.'"></div>
                              <div class="clearfix"></div>
                              <div class="article-sm"> ';
                         	$_content.='  <a class="a_pic"  href="'.$_url_module.'?did='.$Row["id"].'"><img src="'.$physical_name.'" class="img-responsive align-center"></a> ';
							$_content.='    	<div class="most">
                                    <span>'.($i+$start_rec+1).'</span>                
                                	</div>
                                    <div class="most-topic">
                                    <p class="topic"> 
                               		 '.$topic.'
                                    </p>
                                    </div>';
							
                          	$_content.='  <p class="update">Update : '.$dateshow.'</p>
                                      <p class="view">View : '.number_format($Row["cstate"],0).'</p>
                              </div>
                              <div class="clearfix"></div>
                              <div class="see-all">
                                  <a href="'.$_url_module.'?did='.$Row["id"].'">see all <i class="icon-arrow"></i></a>
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