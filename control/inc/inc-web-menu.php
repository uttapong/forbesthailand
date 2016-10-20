<div class="nav-collapse collapse" style="margin-left:0px;  ">
<aside id="page-sidebar" >
<div class="mini-profile" style=" background-color:#e9e9e9!important">

<?
	
$physical_picuser="../../uploads/users/".$_SESSION['FIEEPIC'];

if (!(is_file($physical_picuser) && file_exists($physical_picuser) )) {
$physical_picuser="../img/photo_not_available.jpg";
}


?>
<div style="float:left; display:inline-block; ">
 <img data-src="../js/holder.js/80x80" src="<?=$physical_picuser?>"   class="img-polaroid">
 </div>
<div style="clear:both;"></div>
<div style="width:100%; font-weight:bold; float:left; display:inline-block; margin-top:5px">
<?=$_SESSION['UserFname']?> <?=$_SESSION['UserLname']?> (<?=$_SESSION['LANG']?>)<br />
<span style="font-weight:normal;"><?=$_SESSION['UserGroupName']?> </span>
</div>
<div style="clear:both;"></div>
</div>

<nav id="primary-nav">
<ul>

<?
	
	$sql = "SELECT m.level,m.parent_id FROM sysmenu m";
	$sql.= " WHERE m.lang_code='".$_SESSION['LANG']."' and m.menu_id='".$SysMenuID."' ";
	$sql.= " ORDER BY m.order_by ASC";
	

	
	$Conn->query($sql);
	$ContentList = $Conn->getResult();
	$_max_lv= $ContentList[0]["level"];
	$_menuActive[$_max_lv]=$SysMenuID;
	
	if($_max_lv==2){
		$_menuActive[1]= $ContentList[0]["parent_id"];
	}else{
		
	}
	
	$sql = "SELECT m.*,mo.filepath,mo.param FROM sysmenu m";
	$sql.=" left join sysmodule mo on(mo.module_code=m.module_code) ";
	$sql.= " WHERE  m.lang_code='".$_SESSION['LANG']."'";
	$sql.= " and m.type='system' ";
	$sql.= " ORDER BY m.order_by ASC";
	
	
	
	$sql = " ( select s.menu_id as menu_id
		,s.name as name
		,s.parent_id as parent_id
		,s.level as level
		,s.module_code as module_code
		,'' as filepath
		,'' as param
		,s.order_by as order_by
		from sysmenu s ";
	$sql.=" inner join ( select sb.parent_id  from sysmenu sb ";
	$sql.="	inner join sysusergroupaccess g on(g.menuid=sb.menu_id AND g.usergroupcode='".$_SESSION['UserGroupCode']."' AND (g.controlaccess='VIEW' or g.controlaccess='MANAGE') ) ) ss on(ss.parent_id=s.menu_id) ";
	$sql.=" where s.module_code ='group' and   s.status = 'Enable'";
	$sql.= " and s.type='system' and s.lang_code='".$_SESSION['LANG']."' ";
	$sql.= " and s.menu_group='top' ";
	$sql.=" group by menu_id ) " ;
	$sql.=" union ";
	$sql.= " ( select s.menu_id as menu_id
		,s.name as name
		,s.parent_id as parent_id
		,s.level as level
		,s.module_code as module_code
		,mo.filepath as filepath
		,mo.param as param
		,s.order_by as order_by
		from sysmenu s inner join sysusergroupaccess g on(g.menuid=s.menu_id AND g.usergroupcode='".$_SESSION['UserGroupCode']."' AND (g.controlaccess='VIEW' or g.controlaccess='MANAGE') ) ";
	$sql.=" inner join sysmodule mo on(mo.module_code=s.module_code) ";	
	$sql.=" where s.module_code <>'group' and  s.status = 'Enable'   ";
	$sql.= " and s.type='system' and s.lang_code='".$_SESSION['LANG']."' ";
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
	

if(is_array($_menuList_lv1)){
foreach($_menuList_lv1 as $key1 => $val1){
	
	$_active_lv1="";
	if($_menuActive[1]==$key1) $_active_lv1='active l1';
	
	$_lv2="";	
	$_lv2=$_menuList_lv2[$key1];
	$_menu_link="";
	if(is_array($_lv2)){
		$_menu_link=' class="menu-link" ';
	
	}
	
	echo '<li class="'.$_active_lv1.'" ><a  href="'.$val1["path"].'" '.$_menu_link.' ><i class="icon-minus"></i>'.$val1["name"].'</a>';	
	
	if(is_array($_lv2)){
		echo "<ul>";
		foreach($_lv2 as $key2 => $val2){	
			$_lv3="";
			$_lv3=$_menuList_lv3[$key2];	
		
			echo '<li><a ';
			$_active_lv2='';
			if($_menuActive[2]==$key2) $_active_lv2='active';
			
			if(is_array($_lv3)){
				echo 'href="'.$val2["path"].'" class="submenu-link '.$_active_lv2.'"';	 
			}else{
				echo ' href="'.$val2["path"].'" class="'.$_active_lv2.'" ';
			}
			echo '>'.$val2["name"].'</a>';
			if(is_array($_lv3)){
				echo '<ul style="display:none" >';
				foreach($_lv3 as $key3 => $val3){	
					echo '<li><a href="#">  '.$val3["name"]."</a></li>";
				}
				echo "</ul>"; 
			}
			echo '</li>'; 
		}
		echo '</ul>'; 
	}// LV2	
	echo "</li>"; 	
}
}

?>
<!-- <li class="active"> -->

<!--
<li style="background-color:#404040; color:#fff; padding:8px;"> Administrator</li>
-->



</ul>

</nav>


</aside>

</div>