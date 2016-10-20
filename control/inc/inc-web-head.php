<header class="navbar navbar-inverse navbar-fixed-top" style=";">
<div class="navbar-inner  ">
<div class="container-fluid">
<ul class="nav pull-right visible-phone visible-tablet">
<li class="divider-vertical remove-margin"></li>
<li>
<a href="javascript:void(0)" data-toggle="collapse" data-target=".nav-collapse">
<i class="icon-white icon-reorder"></i>

</a>
</li>
</ul>
<a href="../dashboard/index.php" class="brand"><img src="../img/logo.png" alt="logo" style="height:35px; margin-top:5px; margin-left:5px;" ></a>
<div class="area_menu_top" style="position:relative; float:left; margin-top:7px; margin-left:20px;">
                <ul class="dropdown">
                
                <?
				
		$sql = "SELECT m.*,mo.filepath FROM sysmenu m";
		$sql.=" left join sysmodule mo on(mo.module_code=m.module_code) ";
		$sql.=" left join sysusergroupaccess pm on(pm.menuid=m.menu_id and pm.usergroupcode='".$_SESSION['UserGroupCode']."')";
		$sql.= " WHERE 1=1 ";
		$sql.= " and m.type='web' and m.lang_code='".$_SESSION['LANG']."' ";
		$sql.= " and m.menu_group='top' ";
		$sql.= " and (pm.controlaccess='VIEW' or pm.controlaccess='MANAGE') ";
		$sql.= " ORDER BY m.order_by ASC";
			
		
		$sql = " ( select s.menu_id as menu_id
			,s.name as name
			,s.parent_id as parent_id
			,s.level as level
			,s.module_code as module_code
			,'' as filepath
			,s.order_by as order_by
			from sysmenu s ";
		$sql.=" inner join ( select sb.parent_id  from sysmenu sb ";
		$sql.="	inner join sysusergroupaccess g on(g.menuid=sb.menu_id AND g.usergroupcode='".$_SESSION['UserGroupCode']."' AND (g.controlaccess='VIEW' or g.controlaccess='MANAGE') ) ) ss on(ss.parent_id=s.menu_id) ";
		$sql.=" where s.module_code ='group' and   s.status = 'Enable'";
		$sql.= " and s.type='web' and s.lang_code='".$_SESSION['LANG']."' ";
		$sql.= " and s.menu_group='top' ";
		$sql.=" group by menu_id ) " ;
		$sql.=" union ";
		$sql.= " ( select s.menu_id as menu_id
			,s.name as name
			,s.parent_id as parent_id
			,s.level as level
			,s.module_code as module_code
			,mo.filepath as filepath
			,s.order_by as order_by
			from sysmenu s inner join sysusergroupaccess g on(g.menuid=s.menu_id AND g.usergroupcode='".$_SESSION['UserGroupCode']."' AND (g.controlaccess='VIEW' or g.controlaccess='MANAGE') ) ";
		$sql.=" inner join sysmodule mo on(mo.module_code=s.module_code) ";	
		$sql.=" where s.module_code <>'group' and  s.status = 'Enable'   ";
		$sql.= " and s.type='web' and s.lang_code='".$_SESSION['LANG']."' ";
		$sql.= " and s.menu_group='top' ";
		$sql.= "  ) ";
		$sql.= " order by order_by   ";
			
		
			
			
			
			$Conn->query($sql);
			$ContentList = $Conn->getResult();
			$CntRecInPage = $Conn->getRowCount();
			$TotalRec= $Conn->var_totalRow;
			
			
			$_menuList_lv1="";
			$_menuList_lv2="";
			$_menuList_lv3="";
			
			for ($i=0;$i<$CntRecInPage;$i++) {
				
				$Row = $ContentList[$i];
				
				if($Row["level"]=="1"){
					$_menuList_lv1[$Row["menu_id"]]["name"]=$Row["name"];
					$_menuList_lv1[$Row["menu_id"]]["path"]=SystemGetMenuFilePath($Row);
					$_menuList_lv1[$Row["menu_id"]]["module_code"]=$Row["module_code"];
				}else if($Row["level"]=="2"){
					$_menuList_lv2[$Row["parent_id"]][$Row["menu_id"]]["name"]=$Row["name"];	
					$_menuList_lv2[$Row["parent_id"]][$Row["menu_id"]]["path"]=SystemGetMenuFilePath($Row);	
					
				}else if($Row["level"]=="3"){
					$_menuList_lv3[$Row["parent_id"]][$Row["menu_id"]]["name"]=$Row["name"];	
					$_menuList_lv3[$Row["parent_id"]][$Row["menu_id"]]["path"]=SystemGetMenuFilePath($Row);	
				}
			}
			
	
		?>
        
     <?
	 
	function my_loadStoreTreeCat($ParentID){
	global $Conn;	
	$sql = "SELECT * FROM store_category";
	$sql.= " WHERE parent_id='$ParentID'";
	$sql.= " ORDER BY order_by ASC";
	
	
	$Conn->query($sql);
	$ContentList = $Conn->getResult();
	$CntRecInPage = $Conn->getRowCount();
	$TotalRec= $Conn->var_totalRow;
	
	for ($i=0;$i<$CntRecInPage;$i++) {
			
		$Row = $ContentList[$i];
		$sql1 = "SELECT count(*) as CNT FROM store_category ";
		$sql1.=" WHERE parent_id ='".$Row["cate_id"]."' ";
		
		$sql1.=" ORDER BY order_by ASC";
		$Conn->query($sql1);
		$ContentList1 = $Conn->getResult();
		$RecordCount1= $ContentList1[0]["CNT"];
		
			?>
			<li >
            	 <a href="../store/index.php?<?=SystemEncryptURL("SysMenuID=S101")?>">  <?=$Row["name"]?></a>
                			<?
			if($RecordCount1>0){
			?>
			<ul ><?=my_loadStoreTreeCat($Row["cate_id"]); ?></ul></li>
			<?
			}
	
		}
	}
?>
        
        
        
        <?
if(is_array($_menuList_lv1)){
foreach($_menuList_lv1 as $key1 => $val1){
	echo '<li><a href="'.$val1["path"].'"  >'.$val1["name"].'</a>';
	
	 $chk_storecate= strpos("C".$val1["module_code"],"store-menucate");
	
	if($chk_storecate){
		$store_cate_id=str_replace("store-menucate-","",$val1["module_code"]);
		echo '<ul >';
		my_loadStoreTreeCat($store_cate_id);
		echo '</ul>';
	}
	
	$_lv2="";	
	$_lv2=$_menuList_lv2[$key1];
	if(is_array($_lv2)){
		echo "<ul>";
		foreach($_lv2 as $key2 => $val2){
			
			$_lv3="";
			$_lv3=$_menuList_lv3[$key2];
			echo '<li><a  href="'.$val2["path"].'" >'.$val2["name"].'</a>';
			
			
			if(is_array($_lv3)){
				echo '<ul >';
				foreach($_lv3 as $key3 => $val3){		
					echo '<li><a  href="'.$val3["path"].'" >  '.$val3["name"]."</a></li>";
				}
				echo "</ul>"; 
			}
			
			echo '</li>'; 
		}
		echo '</ul>'; 
	}// LV2
	
	echo "</li>"; 
	
}
}// if array LV1

?>
             	
        
        </ul>
        </div>



<div id="loading" class="hide pull-left"><i class="icon-certificate icon-spin"></i></div>

<!--

<ul id="widgets" class="nav pull-right">
<li class="divider-vertical remove-margin"></li>
<li id="messages-widget" class="dropdown dropdown-left-responsive">
<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
<i class="icon-envelope"></i>
<span class="badge badge-success">1</span>
</a>
<ul class="dropdown-menu widget pull-right">
<li class="widget-heading"><i class="icon-comment pull-right"></i>Latest Messages</li>
<li class="new-on">
<div class="media">
<a class="pull-left" href="javascript:void(0)">
<img src="index_files/image_light_64x64.png" alt="fakeimg">
</a>
<div class="media-body">
<h6 class="media-heading"><a href="javascript:void(0)">George</a><span class="label label-success">2 min ago</span></h6>
<div class="media">Thanks for your help! The tutorial really helped me a lot!</div>
</div>
</div>
</li>
<li class="divider"></li>
<li>
<div class="media">
<a class="pull-left" href="javascript:void(0)">
<img src="index_files/image_light_64x64.png" alt="fakeimg">
</a>
<div class="media-body">
<h6 class="media-heading"><a href="javascript:void(0)">Julia</a><span class="label">1 day ago</span></h6>
<div class="media">We should better consider our social media marketing strategy!</div>
</div>
</div>
</li>
<li class="divider"></li>
<li class="text-center"><a href="#">View All Messages</a></li>
</ul>
</li>
<li class="divider-vertical remove-margin"></li>

</ul>


-->

<div class="pull-right" style="padding:12px 50px;">
<div class="mini-profile-options">

<!--
<a href="javascript:sysChangelang('TH');" class="badge <? if($_SESSION['LANG']=="TH"){?>badge-warning<? } ?>" data-toggle="tooltip" data-placement="right" title="" >
<img src="../img/lang/flag-th.gif"  style="width:20px!important; height:13px!important" />
</a>
<a href="javascript:sysChangelang('EN');" class="badge <? if($_SESSION['LANG']=="EN"){?>badge-warning<? } ?>" data-toggle="tooltip" data-placement="right" title="" >
<img src="../img/lang/flag-en.gif"  style="width:20px!important; height:13px!important" />
</a>
-->

<a href="../authen/logout.php" class="badge badge-important" data-toggle="tooltip" data-placement="right" title="" data-original-title="Log out">
<i class="icon-off"></i>
</a>
</div>
</div>

</div>



</div>
</header>