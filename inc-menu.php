<?
 	$sql = "SELECT p.cate_id FROM article_category p";
	//$sql.=" inner join article_main c on(c.cate1_id=p.cate_id) ";
	$sql.= " WHERE 1=1 ";
	$sql.=" and p.level='1' ";
//	$sql.= " group by p.cate_id";
	$sql.= " ORDER BY p.order_by asc";	
/*
	$Conn->query($sql);
	$MRList = $Conn->getResult();
	$CntRecMR = $Conn->getRowCount();
  	if($CntRecMR>0){
		for ($i=0;$i<$CntRecMR;$i++) {					
		
		$RowMR = $MRList[$i];
	
		$sel_sql='p.cate_id,p.name';
		$sql = "SELECT  ".$sel_sql."  FROM article_category p";
		$sql.=" inner join article_main c on(c.cate2_id=p.cate_id) ";
		$sql.=" WHERE  p.status='Enable' and p.level='2'  AND  p.parent_id='".$RowMR['cate_id']."' ";
		$sql.= " group by p.cate_id";
		$sql.= " ORDER BY p.order_by asc";	
	
		$Conn->query($sql);
		$MRList2 = $Conn->getResult();
		$CntRecMR2 = $Conn->getRowCount();
		$MenuReviewM[$RowMR['cate_id']]["c"]=$CntRecMR2;
		$MenuReviewM[$RowMR['cate_id']]["cid"]=$MRList2[0]["cate_id"];
		}	
	}

*/
$sql = "SELECT p.menu_id,p.cate_id,p.name_th,p.name_en FROM article_category p";
$sql.= " WHERE 1=1 ";
$sql.=" and p.level='1' ";
$sql.= " ORDER BY p.order_by asc";
$Conn->query($sql);
$List = $Conn->getResult();
$CntRec = $Conn->getRowCount();
for ($i=0;$i<$CntRec;$i++) {		
	$Row = $List[$i];
	$MenuCateMain[$Row['menu_id']][$Row['cate_id']]["name"]=$Row["name_".strtolower($_SESSION['FRONT_LANG'])];
}
function getCategoryMain($mid){
	$MenuCateMain = $GLOBALS['MenuCateMain'];
	return $MenuCateMain[$mid];
}
function getCategory($mid){
	$Conn = $GLOBALS['Conn'];
	$sql = "SELECT p.* FROM article_category p";
	$sql.= " WHERE p.menu_id='".$mid."'";
	$sql.=" and p.level='1' ";
	$sql.= " ORDER BY p.order_by asc";	
	$Conn->query($sql);
	$List = $Conn->getResult();
	$CntRec = $Conn->getRowCount();
	for ($i=0;$i<$CntRec;$i++) {		
		$Row = $List[$i];
		$MenuCate[$Row['cate_id']]["name"]=$Row["name_".strtolower($_SESSION['FRONT_LANG'])];
	}
	if($CntRec){
		return $MenuCate;
	}else{
		return 0;	
	}
}
function getCategoryCover($mid){
	$Conn = $GLOBALS['Conn'];
	$sql = "SELECT p.* FROM cover_category p";
	$sql.= " WHERE 1=1 ";
	$sql.=" and p.level='1' ";
	$sql.= " ORDER BY p.order_by asc";
	
	$Conn->query($sql);
	$List = $Conn->getResult();
	$CntRec = $Conn->getRowCount();
	for ($i=0;$i<$CntRec;$i++) {		
		$Row = $List[$i];
		$MenuCate[$Row['cate_id']]["name"]=$Row["name_".strtolower($_SESSION['FRONT_LANG'])];
	}
	if($CntRec){
		return $MenuCate;
	}else{
		return 0;	
	}
}
?>
<header id="header">
    <section id="header-top">
           <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-sm-3 hide-xs">
                <!--
                <div id="select-lng">
                    <div class="select-lng-box1 text-uppercase" data-toggle="dropdown">select language</div>
                    <div class="select-lng-box2 text-center"><i class="icon-right"></i> </div>
                    <div id="dropdown-lng">
                        <a href="../th/"><i class="icon-flag-th"></i> THAI</a><br>
                        <a href="../en/"><i class="icon-flag-en"></i> ENGLISH</a>
                    </div>
                </div>
                <script> 
                $(document).ready(function(){
                    $("#dropdown-lng").hide();
                    $("#select-lng").click(function(){
                        $("#dropdown-lng").toggle("medium");
                    });
                });
                </script>
                -->
            </div>
            <div class="col-xs-12 col-sm-6">
                <a href="./"><img src="images/main/logo.png" class="img-responsive align-center logo"></a>
            </div>
            <div class="col-xs-12 col-sm-3 hide-xs">
                <div class="form-search">
                    <form  method="get" id="frmsearch"  action="search.php" >
                        <input type="text" name="s" id="s" class="input-search" required placeholder="SEARCH">
                        <button type="submit" class="custom-search"><i class="icon-search"></i></button>
                    </form>
                  
                </div>
            </div>
        </div>
       </div> 
    </section>
    <section id="nav-menu">
        <div class="container-fluid">
            <div class="row">
                <nav class="main-menu hide-xs">
                    <ul>
                    <li class="red  <? if($mgroup=="COVER_MAIN"){ ?> red-active <? } ?> "><p><a href="cover.php">Cover</a>
                        </p> 
                    <? 
							$catelist_cover= getCategoryCover(""); 
							if( $catelist_cover){
							?>
                            <ul>
                            	<? foreach($catelist_cover as $key=>$val){ ?>
                                <li><a href="cover.php?cid=<?=$key?>"><?=$val["name"]?></a> </li>
                                <? } ?>    
                            </ul>
                            <? } ?>                        
                        </li>
                        </li>
                        <!--
                        <li class="orange <? if($mgroup=="RICH_MAIN"){ ?> orange-active <? } ?> "><p><a href="list-rich.php?cid=1" >List’s Rich</a></p>
                            <? 
							$catelist_rich= getCategoryMain("MNT01"); 
							if( $catelist_rich){
							?>
                            <ul>
                            	<? foreach($catelist_rich as $key=>$val){ ?>
                                <li><a href="list-rich.php?cid=<?=$key?>"><?=$val["name"]?></a> </li>
                                <? } ?>    
                            </ul>
                            <? } ?>
                        </li>
                        -->
                        <li class="yellow <? if($mgroup=="NEWS_MAIN"){ ?> yellow-active <? } ?>"><p><a href="news.php">News</a></p> 
                        <? 
							$catelist_news= getCategoryMain("MNT03"); 
							if( $catelist_news){
							?>
                            <ul>
                            	<? foreach($catelist_news as $key=>$val){ ?>
                                <li><a href="news.php?cid=<?=$key?>"><?=$val["name"]?></a> </li>
                                <? } ?>    
                            </ul>
                            <? } ?>
                            
                        </li>
                        <li class="greeno <? if($mgroup=="PEOPLE_MAIN"){ ?> greeno-active <? } ?>"><p><a href="people.php">People</a></p>
                             <? 
							$catelist_people= getCategoryMain("MNT04"); 
							if($catelist_people){
							?>
                            <ul>
                            	<? foreach($catelist_people as $key=>$val){ ?>
                                <li><a href="people.php?cid=<?=$key?>"><?=$val["name"]?></a>
                                <?
								$sql = "SELECT  p.name_".strtolower($_SESSION['FRONT_LANG'])." as name_cate2,p.cate_id FROM article_category p";
								$sql.=" WHERE  p.status='Enable' and p.level='2'  AND  p.parent_id='".$key."' ";
								$sql.= " ORDER BY p.order_by asc";	
								$Conn->query($sql);
								$CateList2 = $Conn->getResult();
								$CntRec2 = $Conn->getRowCount();
								if($CntRec2){
									?>
                                  <ul>
                                    <?
								for ($i=0;$i<$CntRec2;$i++) {			
									$RowCate2 = $CateList2[$i];
									?>
                                     <li><a href="people.php?cid=<?=$RowCate2["cate_id"]?>"><?=$RowCate2["name_cate2"]?></a> </li>
                                    <?
								}
								?>
                                </ul>
                                <?
								}
								?>
                                 </li>
                                <? } ?>    
                            </ul>
                            <? } ?>
                            
                            
                        </li>
                        <li class="green <? if($mgroup=="ENTREPRENEUR_MAIN"){ ?> green-active <? } ?>"><p><a href="entrepreneurs.php">Entrepreneurs</a></p>
                             
                               <? 
							$catelist_entre= getCategoryMain("MNT05"); 
							if( $catelist_entre){
							?>
                            <ul>
                            	<? foreach($catelist_entre as $key=>$val){ ?>
                                <li><a href="entrepreneurs.php?cid=<?=$key?>"><?=$val["name"]?></a> </li>
                                <? } ?>    
                            </ul>
                            <? } ?>
                        </li>
                        <li class="sky <? if($mgroup=="ASIANBIZ_MAIN"){ ?> sky-active <? } ?> "><p><a href="asian-biz.php">ASEAN Biz</a></p>                             
                        </li>
                        <li class="blue <? if($mgroup=="WORLD_MAIN"){ ?> blue-active <? } ?> last"><p><a href="world.php">World</a></p>
                                <? 
							$catelist_world= getCategoryMain("MNT07"); 
							if( $catelist_world){
							?>
                            <ul>
                            	<? foreach($catelist_world as $key=>$val){ ?>
                                <li><a href="world.php?cid=<?=$key?>"><?=$val["name"]?></a> </li>
                                <? } ?>    
                            </ul>
                            <? } ?>
                        </li>
                    </ul>
                    <ul class="rows8">
                        <li class="purple <? if($mgroup=="FORBES_LIFE_MAIN"){ ?> purple-active <? } ?> "><p><a href="forbes-life.php">Forbes Life</a></p>                             
                        </li>
                        </li>
                        <li class="violet  <? if($mgroup=="TECHNOLOGY_MAIN"){ ?> violet-active <? } ?>"><p><a href="technology.php">Technology</a></p>     
                             <? 
							$catelist_tech= getCategoryMain("MNT09"); 
							if( $catelist_tech){
							?>
                            <ul>
                            	<? foreach($catelist_tech as $key=>$val){ ?>
                                <li><a href="technology.php?cid=<?=$key?>"><?=$val["name"]?></a> </li>
                                <? } ?>    
                            </ul>
                            <? } ?>
                        </li>
                        <li class="pink <? if($mgroup=="COMMENTARIE_MAIN"){ ?> pink-active <? } ?>"><p><a href="commentaries.php">Commentaries</a></p>  
                           <? 
							$catelist_comm= getCategoryMain("MNT10"); 
							if( $catelist_comm){
							?>
                            <ul>
                            	<? foreach($catelist_comm as $key=>$val){ ?>
                                <li><a href="commentaries.php?cid=<?=$key?>"><?=$val["name"]?></a> </li>
                                <? } ?>    
                            </ul>
                            <? } ?>
                        </li>
                        <li class="greenl <? if($mgroup=="LEADERBOARD_MAIN"){ ?> greenl-active <? } ?>"><p><a href="leaderboard.php">Leaderboard</a></p> 
                            <? 
							$catelist_leader= getCategoryMain("MNT11"); 
							if( $catelist_leader){
							?>
                            <ul>
                            	<? foreach($catelist_leader as $key=>$val){ ?>
                                <li><a href="leaderboard.php?cid=<?=$key?>"><?=$val["name"]?></a> </li>
                                <? } ?>    
                            </ul>
                            <? } ?>
                        </li>
                        <li class="brown <? if($mgroup=="FORBES_EVENT_MAIN"){ ?> brown-active <? } ?>"><p><a href="forbes-event.php">Forbes Event & Conference</a></p>    
                              <? 
							$catelist_event= getCategoryMain("MNT12"); 
							if( $catelist_event){
							?>
                            <ul>
                            	<? foreach($catelist_event as $key=>$val){ ?>
                                <li><a href="forbes-event.php?cid=<?=$key?>"><?=$val["name"]?></a> </li>
                                <? } ?>    
                            </ul>
                            <? } ?>
                        </li>
                        <?
						$catelist_lifethai= getCategoryMain("MNT13");
						$first_cate = key($catelist_lifethai);
						?>
                        <li class="white <? if($mgroup=="FORBES_THAI_MAIN"){ ?> white-active <? } ?>"><p><a href="special_issue_category.php?cid=<?=$first_cate?>">SPECIAL ISSUE</a></p>
                        
                         <? 
							
							if( $catelist_lifethai){
							?>
                            <ul>
                            	<? foreach($catelist_lifethai as $key=>$val){ ?>
                                <li><a href="special_issue_category.php?cid=<?=$key?>"><?=$val["name"]?></a> </li>
                                <? } ?>    
                            </ul>
                            <? } ?>  
                        </li>
                        <li class="grey <? if($mgroup=="VDO_MAIN"){ ?> grey-active <? } ?>"><p><a href="vdo.php">VDO</a></p>
                            <? 
							$catelist_vdo= getCategoryMain("MNT14"); 
							if( $catelist_vdo){
							?>
                            <ul>
                            	<? foreach($catelist_vdo as $key=>$val){ ?>
                                <li><a href="vdo.php?cid=<?=$key?>"><?=$val["name"]?></a> </li>
                                <? } ?>    
                            </ul>
                            <? } ?>
                        </li>
                        <li class="black <? if($mgroup=="PR_NEWS_MAIN"){ ?> black-active <? } ?> last"><p><a href="pr.php">PR NEWS</a></p>
                            <? 
							$catelist_pr= getCategoryMain("MNT15"); 
							if( $catelist_pr){
							?>
                            <ul>
                            	<? foreach($catelist_pr as $key=>$val){ ?>
                                <li><a href="pr.php?cid=<?=$key?>"><?=$val["name"]?></a> </li>
                                <? } ?>    
                            </ul>
                            <? } ?>
                        </li>
                    </ul>
                </nav>
                 <nav class="menu-mobile hide-sm">
                    <div class="toggle">Menu</div>
                    <div class="dropdown-mobile">
                 
						<ul class="nav navbar-nav">
                        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">COVER</a>
                        <ul class="dropdown-menu">       
                 			<?
                			if( $catelist_cover){
							?>
                            <? foreach($catelist_cover as $key=>$val){ ?>
                                <li><a href="cover.php?cid=<?=$key?>"><?=$val["name"]?></a> </li>
                                <? } ?>   
                            <? } ?>            
                        </ul>
                        </li> 
                        <!--
                      	<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">List’s Rich</a>
                        <ul class="dropdown-menu">       
                 			<?
                			if( $catelist_rich){
							?>
                            <? foreach($catelist_rich as $key=>$val){ ?>
                                <li><a href="list-rich.php?cid=<?=$key?>"><?=$val["name"]?></a> </li>
                                <? } ?>   
                            <? } ?>            
                        </ul>
                        </li>
                        -->
                       	<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">News</a>
                        <ul class="dropdown-menu">       
                 			<?
                			if( $catelist_news){
							?>
                            <? foreach($catelist_news as $key=>$val){ ?>
                                <li><a href="news.php?cid=<?=$key?>"><?=$val["name"]?></a> </li>
                                <? } ?>   
                            <? } ?>            
                        </ul>
                        </li>
                      
                        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">People</a>
                        <ul class="dropdown-menu">
                          <? 
							if($catelist_people){
							?>
                          	<? foreach($catelist_people as $key=>$val){ ?> 
                              <?
								$sql = "SELECT  p.name_".strtolower($_SESSION['FRONT_LANG'])." as name_cate2,p.cate_id FROM article_category p";
								$sql.=" WHERE  p.status='Enable' and p.level='2'  AND  p.parent_id='".$key."' ";
								$sql.= " ORDER BY p.order_by asc";	
								$Conn->query($sql);
								$CateList2 = $Conn->getResult();
								$CntRec2 = $Conn->getRowCount();
								?>
                                 <li <? if($CntRec2){?> class="dropdown dropdown-submenu" <? } ?> ><a href="<? if($CntRec2){?>#<? }else{ ?> people.php?cid=<?=$key?> <? } ?>" <? if($CntRec2){?>   class="dropdown-toggle" data-toggle="dropdown"<? } ?>><?=$val["name"]?> <? if($CntRec2){?> <b class="caret"></b> <? } ?> </a>
                                <?
								if($CntRec2){
								?>
                            <ul class="dropdown-menu">
                                <?
								for ($i=0;$i<$CntRec2;$i++) {			
									$RowCate2 = $CateList2[$i];
									?>
                                     <li><a href="people.php?cid=<?=$RowCate2["cate_id"]?>"><?=$RowCate2["name_cate2"]?></a> </li>
                                    <?
								}
								?>
                              </ul> 
                                <? } ?>
                                </li>
                             <? } ?>    
                            <? } ?>
                        </ul>
                        </li>
                        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Entrepreneurs</a>
                        <ul class="dropdown-menu">       
                 			<?
                			if( $catelist_entre){
							?>
                            <? foreach($catelist_entre as $key=>$val){ ?>
                                <li><a href="entrepreneurs.php?cid=<?=$key?>"><?=$val["name"]?></a> </li>
                                <? } ?>   
                            <? } ?>            
                        </ul>
                        </li>
                        <li><a href="asian-biz.php" >ASEAN Biz</a> </li>
                    	<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">World</a>
                        <ul class="dropdown-menu">       
                 			<?
                			if( $catelist_world){
							?>
                            <? foreach($catelist_world as $key=>$val){ ?>
                                <li><a href="world.php?cid=<?=$key?>"><?=$val["name"]?></a> </li>
                                <? } ?>   
                            <? } ?>            
                        </ul>
                        </li>
                        <li><a href="forbes-life.php" >Forbes Life</a> </li>
                      <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Technology</a>
                        <ul class="dropdown-menu">       
                 			<?
                			if( $catelist_tech){
							?>
                            <? foreach($catelist_tech as $key=>$val){ ?>
                                <li><a href="technology.php?cid=<?=$key?>"><?=$val["name"]?></a> </li>
                                <? } ?>   
                            <? } ?>            
                        </ul>
                        </li>
                        
                         <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Commentaries</a>
                        <ul class="dropdown-menu">       
                 			<?
                			if( $catelist_comm){
							?>
                            <? foreach($catelist_comm as $key=>$val){ ?>
                                <li><a href="commentaries.php?cid=<?=$key?>"><?=$val["name"]?></a> </li>
                                <? } ?>   
                            <? } ?>            
                        </ul>
                        </li>
                   		<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Leaderboard</a>
                        <ul class="dropdown-menu">       
                 			<?
                			if( $catelist_leader){
							?>
                            <? foreach($catelist_leader as $key=>$val){ ?>
                                <li><a href="leaderboard.php?cid=<?=$key?>"><?=$val["name"]?></a> </li>
                                <? } ?>   
                            <? } ?>            
                        </ul>
                        </li>
   						<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Forbes Event & Conference</a>
                        <ul class="dropdown-menu">       
                 			<?
                			if( $catelist_event){
							?>
                            <? foreach($catelist_event as $key=>$val){ ?>
                                <li><a href="forbes-event.php?cid=<?=$key?>"><?=$val["name"]?></a> </li>
                                <? } ?>   
                            <? } ?>            
                        </ul>
                        </li>   
                     <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">SPECIAL ISSUE</a>
                        <ul class="dropdown-menu">       
                 			<?
                			if( $catelist_lifethai){
							?>
                            <? foreach($catelist_lifethai as $key=>$val){ ?>
                                <li><a href="special_issue_category.php?cid=<?=$key?>"><?=$val["name"]?></a> </li>
                                <? } ?>   
                            <? } ?>            
                        </ul>
                        </li> 
                         <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">VDO</a>
                        <ul class="dropdown-menu">       
                 			<?
                			if( $catelist_vdo){
							?>
                            <? foreach($catelist_vdo as $key=>$val){ ?>
                                <li><a href="vdo.php?cid=<?=$key?>"><?=$val["name"]?></a> </li>
                                <? } ?>   
                            <? } ?>            
                        </ul>
                        </li> 
                          <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">PR NEWS</a>
                        <ul class="dropdown-menu">       
                 			<?
                			if( $catelist_pr){
							?>
                            <? foreach($catelist_pr as $key=>$val){ ?>
                                <li><a href="pr.php?cid=<?=$key?>"><?=$val["name"]?></a> </li>
                                <? } ?>   
                            <? } ?>            
                        </ul>
                        </li> 
                      
                        
              		</ul>    
                    </div>
                    <script type="text/javascript">
		                   $(".dropdown-mobile").hide();
		                  $('.toggle').click(function() {
		                   $(this).toggleClass('on');
		                   $('.dropdown-mobile').slideToggle(250);
		                  });  
						  $('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
    // Avoid following the href location when clicking
    event.preventDefault(); 
    // Avoid having the menu to close when clicking
    event.stopPropagation(); 
    // If a menu is already open we close it
    //$('ul.dropdown-menu [data-toggle=dropdown]').parent().removeClass('open');
    // opening the one you clicked on
	//alert($(this).parent().hasClass('open'));
	if($(this).parent().hasClass('open')==false){	
		 $(this).parent().addClass('open');
	}else{
		 $(this).parent().removeClass('open');
	}
    var menu = $(this).parent().find("ul");
    var menupos = menu.offset();
	
  
    if ((menupos.left + menu.width()) + 30 > $(window).width()) {
        var newpos = - menu.width(); 
    } else {
		
        var newpos = $(this).parent().width();
    }
    menu.css({ left:newpos });

});
						  
						  
		          </script>
                </nav>      
            </div>
        </div>
    </section>
    </header>