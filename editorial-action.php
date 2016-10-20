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
	
	
	$sql = "SELECT u.userid,u.firstname_".strtolower($_SESSION['FRONT_LANG'])." as firstname_txt,u.lastname_".strtolower($_SESSION['FRONT_LANG'])." as lastname_txt,u.filepic as filepic_user,u.position_".strtolower($_SESSION['FRONT_LANG'])." as usergroupname   FROM sysuser u";
	$sql.=" left join sysusergroup ug on(ug.usergroupcode=u.usergroupcode) ";
	$sql.= " WHERE 1=1 ";		
	$sql.= " ORDER BY u.order_by asc ";
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
	 
	$physical_name="./uploads/users/".$Row["filepic_user"];
	$flag_pic=1;
	if (!(is_file($physical_name) && file_exists($physical_name) )) {
		$physical_name="./images/photo_not_available.jpg";
		$flag_pic=0;
	}
	$dateshow= getDisplayDate($Row["updatedate"]);	
	$topic=SystemSubString($Row["name_content"],48,'');
	
	$_title_module="EDITORIAL & CONTRIBUTOR";
	$_color_module="cat-greendark-sm";
	$_url_module="editorial-detail.php";
	
 	$_content.=' <div class="col-xs-12 col-sm-4 mbc list-load">
                        <div class="block">
                              <div class="tab-block-sm">
                                  <span>'.$_title_module.'</span>
                              </div>
                              <div class="'.$_color_module.'"></div>
                              <div class="clearfix"></div>
                              <div class="article-sm"> ';
                         	$_content.='  <a class="a_pic"  href="'.$_url_module.'?did='.$Row["userid"].'"><img src="'.$physical_name.'" class="img-responsive align-center"></a> ';
							$_content.='<p class="topic">'.$Row["firstname_txt"]." ".$Row["lastname_txt"].'</p>
                                    <p class="position">'.$Row["usergroupname"].'</p>';
                          	$_content.=' 
                              </div>
                              <div class="clearfix"></div>
                              <div class="see-all">
                                  <a href="'.$_url_module.'?did='.$Row["userid"].'">'._Detail_More_.' <i class="icon-arrow"></i></a>
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