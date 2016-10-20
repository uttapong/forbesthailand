<?	
function SystemGetAccessKey($client){
		$params = array('UserID'=>'admin','UserPassword'=>'password');
		$objectResult = $client->__soapCall("GetAccessKey", array($params)); 
		$objectResult=$objectResult->GetAccessKeyResult;
		$objectResult=json_decode($objectResult, true);	
	
		if($objectResult["STATUS"]=="Success"){
			$_SESSION['ACCESS_KEY']=$objectResult["ACCESSKEY"];
			return 1;
		}else{
			$_SESSION['ACCESS_KEY']="";
			return 0;
		}
	
}
function SystemGetSqlDateShow($f1,$f2){
	$sql="";
	$sql .= " and ((DATE(".$f1.") <=DATE('".date("Y-m-d")."')";
	$sql .= " AND DATE(".$f2.") >=DATE('".date("Y-m-d")."')) ";
	$sql .= " OR (DATE(".$f1.") = DATE('0000-00-00') AND DATE(".$f2.") = DATE('0000-00-00') ) )";
	
	return $sql;
}


function SystemCheckInput($value)
{
	// Stripslashes
	if (get_magic_quotes_gpc())
	  {
	  $value = stripslashes($value);
	  }
	// Quote if not a number
	if (!is_numeric($value))
	  {
	  $value = "'" . mysql_real_escape_string($value) . "'";
	  }
	return $value;
}


function getDisplayDate($date_db) { 
	
	$Sys_MonthName = $GLOBALS['Sys_MonthName'];
	
	if($_SESSION['FRONT_LANG']=="TH"){
		$date=date("d",strtotime($date_db));	
		$date.=" ".$Sys_MonthName[date("m",strtotime($date_db))+0];	
		$date.=" ".(date("Y",strtotime($date_db))+543);	
	}else{
		$date=date("d F Y",strtotime($date_db));	
	}
	return $date;
}
	
	
function getEmotionList($m_key) { 
$emo.='<a class="btn-emo"  _t="laugh" href="javascript:void(0)"><img src="../img/emotion/laugh.jpg" title="หัวเราะ" ></a>';
$emo.='<a class="btn-emo"  _t="like" href="javascript:void(0)"><img src="../img/emotion/like.jpg"  title="ชอบ"></a>';
$emo.='<a class="btn-emo"  _t="love" href="javascript:void(0)"><img src="../img/emotion/love.jpg"  title="รัก"></a>';
$emo.='<a class="btn-emo"  _t="sad" href="javascript:void(0)"><img src="../img/emotion/sad.jpg"  title="เศร้า"></a>';
$emo.='<a class="btn-emo"  _t="smile" href="javascript:void(0)"><img src="../img/emotion/smile.jpg"   title="ยิ้มกว้าง"></a>';
return $emo;
}

function getTxtChat($txt){
	
	$txt=str_replace(':laugh:','<img src="../img/emotion/b/laugh.jpg"  title="หัวเราะ">',$txt);
	$txt=str_replace(':like:','<img src="../img/emotion/b/like.jpg"  title="ชอบ">',$txt);
	$txt=str_replace(':love:','<img src="../img/emotion/b/love.jpg"  title="รัก">',$txt);
	$txt=str_replace(':sad:','<img src="../img/emotion/b/sad.jpg"  title="เศร้า">',$txt);
	$txt=str_replace(':smile:','<img src="../img/emotion/b/smile.jpg"  title="ยิ้มกว้าง">',$txt);
	
	$txt=nl2br($txt);
	return $txt;
}


function getCountFacebook($url_share) { 
$fb_link= "http://graph.facebook.com/?id=".$url_share;
$response = file_get_contents($fb_link);
$fb_array = json_decode($response, true);
if($fb_array['shares']<1){
	$fb_array['shares']=0;
}
return $fb_array['shares'];
}

function getCountTweet($url_share){
$fb_tw= "http://cdn.api.twitter.com/1/urls/count.json?url=".$url_share;
$response = file_get_contents($fb_tw);
$tw_array = json_decode($response, true);
return $tw_array['count'];
}

function getCountPlus1($url_share) {
$html =  file_get_contents( "https://plusone.google.com/_/+1/fastbutton?url=".urlencode($url_share));
$doc = new DOMDocument();   $doc->loadHTML($html);
$counter=$doc->getElementById('aggregateCount');
return  $counter->nodeValue;
}

function SystemGETIP() {
	/*
    $ipaddress = '';
    if ($_SERVER['HTTP_CLIENT_IP'])
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if($_SERVER['HTTP_X_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if($_SERVER['HTTP_X_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if($_SERVER['HTTP_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if($_SERVER['HTTP_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if($_SERVER['REMOTE_ADDR'])
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
	*/
	 $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
	
	
}


function getFullPathContent($content) {	
	$content=str_replace('src="/uploads/userfiles/','src="'._SYSTEM_HOST_NAME_.'/uploads/userfiles/',$content);
	return $content;
}

function updateStateArticle($did,$link) {
	
	$Conn = $GLOBALS['Conn'];	
	

	
	
	$sql = "select article_id  from  article_log where  article_id='".$did."' and  link='".$link."' and  ipaddress='".SystemGETIP()."' and DATE(createdate)=CURDATE()";
	$Conn->query($sql);
	$Content = $Conn->getResult();
	$RowHead=$Content[0];
	
	if($RowHead["article_id"] < 1){
		$sql = "update  article_main set  cstate = cstate + 1 ";
		$sql.=" where id = '".$did."'";
		$Conn->execute($sql);
		
		$key=date("Y-m-01");
		$sql = "SELECT num FROM article_statmonth ";
		$sql .= " WHERE article_id='".$did."'";
		$sql .= " AND datemonth='".$key."'";
		$Conn->query($sql);
		$ContentList = $Conn->getResult();
		$num= $ContentList[0]["num"];
		
		if ($num>0){ $num=$num+1; }else{ $num=1; }	
		
		if($num>1){			
			$update='';
			$update[]="num = '".$num."'";
			$sql="UPDATE article_statmonth SET ".implode(", ",$update)." WHERE article_id = '".$did."' ";
			$sql .= " AND datemonth='".$key."'";
			$Conn->execute($sql);	
		}else{
			$insert='';
			$insert["article_id"] 	= "'".$did."'";
			$insert["datemonth"] 	= "'".$key."'";
			$insert["num"] 	= "'".$num."'";
			$sql="INSERT INTO article_statmonth (".implode(",",array_keys($insert)).") VALUES (".implode(",",array_values($insert)).")";
			$Conn->execute($sql);	
		}
		
		$insert="";
		$insert["article_id"] 			= "'".$did."'";
		$insert["link"] 				= "'".$link."'";
		$insert["createdate"] 			= "sysdate()";
		$insert["ipaddress"] 			= "'".SystemGETIP()."'";
		$sql = "insert into article_log(".implode(",",array_keys($insert)).") values (".implode(",",array_values($insert)).")";
		$Conn->execute($sql);
		
	}
	
	
	
}


function updateStateCover($did,$link) {
	
	$Conn = $GLOBALS['Conn'];
	

	$sql = "select cover_id  from  cover_log where  cover_id='".$did."' and  link='".$link."' and  ipaddress='".SystemGETIP()."' and DATE(createdate)=CURDATE()";
	$Conn->query($sql);
	$Content = $Conn->getResult();
	$RowHead=$Content[0];
	
	if($RowHead["cover_id"] < 1){
		$sql = "update  cover_main set  cstate = cstate + 1 ";
		$sql.=" where id = '".$did."'";
		$Conn->execute($sql);
		
		$insert="";
		$insert["cover_id"] 			= "'".$did."'";
		$insert["link"] 				= "'".$link."'";
		$insert["createdate"] 			= "sysdate()";
		$insert["ipaddress"] 			= "'".SystemGETIP()."'";
		$sql = "insert into cover_log(".implode(",",array_keys($insert)).") values (".implode(",",array_values($insert)).")";
		$Conn->execute($sql);
		
	}
	
}



function SystemCheckLogin($client){
	if(!isset($_SESSION['ACCESS_KEY']) || $_SESSION['ACCESS_KEY']=='' ) {
		return SystemGetAccessKey($client);
	}else{	
		//return 1;
		return SystemGetAccessKey($client);
	}
}
		
	function SystemWebAcess($IP) {
	
		$Conn = $GLOBALS['Conn'];
	
		$insert[_SYSTEM_TABLE_WEBACESSLOG_."_DATE"] = 'curdate()';
		$insert[_SYSTEM_TABLE_WEBACESSLOG_."_IP"] = "'".$IP."'";
		
		$sql = "insert into "._SYSTEM_TABLE_WEBACESSLOG_." (".implode(",",array_keys($insert)).") values (".implode(",",array_values($insert))." ) ";
		
		$Conn->execute($sql);
		
		$sql = "select count(*) CNT from "._SYSTEM_TABLE_WEBACESS_." where "._SYSTEM_TABLE_WEBACESS_."_DATE = curdate() ";
		$Conn->query($sql);
		
	
		
		$Result = $Conn->getResult();
		$Result = $Result[0]['CNT']; 
		
		if ($Result == 0) {

			$insert = NULL;
			$insert[_SYSTEM_TABLE_WEBACESS_."_DATE"] = 'curdate()';
			$insert[_SYSTEM_TABLE_WEBACESS_."_UIP"] = '1';
			$insert[_SYSTEM_TABLE_WEBACESS_."_PAGEVIEWS"] = '1';
			
			$sql = "insert into "._SYSTEM_TABLE_WEBACESS_."(".implode(",",array_keys($insert)).") values (".implode(",",array_values($insert)).")";
			$Conn->execute($sql);

			
		} else {
			
		
		
			$subQuery = "select count(*) CNT from "._SYSTEM_TABLE_WEBACESSLOG_;
			$subQuery.= " where "._SYSTEM_TABLE_WEBACESSLOG_."_DATE = curdate() ";
			
			$sql = "update "._SYSTEM_TABLE_WEBACESS_." set "._SYSTEM_TABLE_WEBACESS_."_UIP = (".$subQuery.") , ";
			$sql.= _SYSTEM_TABLE_WEBACESS_."_PAGEVIEWS = "._SYSTEM_TABLE_WEBACESS_."_PAGEVIEWS + 1 ";
			$sql.=" where "._SYSTEM_TABLE_WEBACESS_."_DATE = curdate() ";
			
			$Conn->execute($sql);

		}
	
	}
	
	
	###   UTILITY   ###########################################################################
	
	function SystemSubString($STR,$P_LEN,$TEXT_OVERFLOW = "",$P_ENCODE = "UTF-8") {
		$NEW_STR = iconv_substr($STR,0,$P_LEN,$P_ENCODE);
		
		if (strlen($STR) > $P_LEN)  $NEW_STR .= $TEXT_OVERFLOW;
		
		return $NEW_STR;
	}
	
	function SystemGetFullURL() {
		
		$s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == 'on') ? 's' : '';
		$protocol = substr(strtolower($_SERVER["SERVER_PROTOCOL"]), 0, strpos(strtolower($_SERVER["SERVER_PROTOCOL"]), '/')) . $s;
		//$port = ($_SERVER["SERVER_PORT"] == '80' ? '' : (':'.$_SERVER["SERVER_PORT"]);
		return $protocol . '://' . $_SERVER['SERVER_NAME'] . $port . $_SERVER['REQUEST_URI'];

	}
	
	function SystemGetTextToFileTest($str) {
		$fp = fopen('../UploadFile/TestScript/data.txt', 'w');
		fwrite($fp, $str);
		fclose($fp);	
	}
	
	

function SystemNotQuote($STR) {
	$str=str_replace("'", "", $STR);	
	return $str;
}

	function SystemReplaceArrayKey($Array,$SearchKey) {
	
		$NewResult = NULL;
	
		$Result = $Array;
		
		if (!empty($Result)) {
		
			$ResultKey = array_keys($Result);
			$ResultValue = array_values($Result);
			
			
			for ($i=0;$i<count($Result);$i++) {
			
				$NewResult[str_replace($SearchKey,"",$ResultKey[$i])] = $ResultValue[$i];
			
			}
			
		}

		return $NewResult;

	}


	function SystemGetUserInfo($UID = "") {
	
		
		if ($UID  != "")	{
			$Conn = $GLOBALS['Conn'];
			
			$sql = " select * ";
			$sql.= " from "._SYSTEM_TABLE_ACCOUNT_;
			$sql.=" left join "._SYSTEM_TABLE_UPLOAD_." on  ("._SYSTEM_TABLE_ACCOUNT_."_PICTURE = "._SYSTEM_TABLE_UPLOAD_."_ID) ";
			$sql.= " where  "._SYSTEM_TABLE_ACCOUNT_."_ID = ".$UID;
			
			$Conn->query($sql);
			
			$Result = $Conn->getResult();
			
			if ($Conn->getRowCount() != 0) 
				$Result = SystemReplaceArrayKey($Result[0],_SYSTEM_TABLE_ACCOUNT_."_","");
	
		}
						
		return $Result;
	
	}
	

	function SystemGetMenuInfo($MenuID = "") {
	
		
		if ($MenuID != "")	{
			$Conn = $GLOBALS['Conn'];
			
			$sql =" SELECT s.*,x."._SYSTEM_TABLE_MENU_."_NAME as PARENTNAME	";
			$sql.= " FROM "._SYSTEM_TABLE_MENU_." s ";
			$sql.=" left outer join "._SYSTEM_TABLE_MENU_." x on x."._SYSTEM_TABLE_MENU_."_ID = s."._SYSTEM_TABLE_MENU_."_PARENTID ";
			$sql.= " where s."._SYSTEM_TABLE_MENU_."_ID = '".$MenuID."'";
			
			$Conn->query($sql);
			
			if ($Conn->getRowCount() != 0) {
				$Result=$Conn->getResult();
				//print_r($Result);
				$Result = SystemReplaceArrayKey($Result[0],_SYSTEM_TABLE_MENU_."_","");
			}
			
	
		}
						
		return $Result;
	
	}

	function SystemCreateFolder($path) {
		$sub_path = explode("/",$path);
		
		$new_path = "";
		
		foreach ( $sub_path as $sub ) {
			$new_path .= $sub."/";
			if (( ($sub != ".") || ($sub != "..") )  && (!is_dir($new_path))) {
				mkdir($new_path,0755);
			}
		}
		return $path;
	}
	
	function SystemGetNewFileName() {
		return date("Ymd-His")."-".rand(0,1000);
	}
	
	function SystemGetFileExtension($FileName) {
		
		$FileExtension = explode(".",$FileName);
		$FileExtension = $FileExtension[count($FileExtension)-1];
		
		return $FileExtension;
	}
	
	function SystemUploadFile($file,$newPath,$BYID) {
	
		$FileExtension = SystemGetFileExtension($file["name"]);
		
		$FileName = SystemGetNewFileName().".".$FileExtension;		

		@chmod($newPath,0755);
		
		while (true) {
			$FilePath = $newPath."/".$FileName;
			if (file_exists($FilePath))
				$FileName =SystemGetNewFileName().".".$FileExtension;
			else 
				break;
		}
		
		move_uploaded_file($file["tmp_name"],$FilePath);	
		
		
	
		return SystemUploadFileToSYSUPLOAD($file["name"],str_replace('../','',$FilePath),$file["size"],$BYID,$FileExtension,$file["type"]);
			
		
	}
	
	function SystemUploadFileToSYSUPLOAD($Name,$Path,$Size,$BYID,$FileExtension,$FileType) {
	
		$Conn = $GLOBALS['Conn'];
		$insert[_SYSTEM_TABLE_UPLOAD_."_NAME"] = "'".$Name."'";
		$insert[_SYSTEM_TABLE_UPLOAD_."_PATH"] = "'".$Path."'";
		$insert[_SYSTEM_TABLE_UPLOAD_."_SIZE"] = $Size;
		$insert[_SYSTEM_TABLE_UPLOAD_."_BYID"] ="'".$BYID."'";
		$insert[_SYSTEM_TABLE_UPLOAD_."_EXT"] = "'".$FileExtension."'";
		$insert[_SYSTEM_TABLE_UPLOAD_."_TYPE"] = "'".$FileType."'";
		$insert[_SYSTEM_TABLE_UPLOAD_."_CREATEDATE"] = "sysdate()";
		
		$sql = "insert into "._SYSTEM_TABLE_UPLOAD_." (".implode(",",array_keys($insert)).") values (".implode(",",array_values($insert)).")";
		
		
		$Conn->execute($sql);

		return $Conn->getInsertID();
	
	}
	
	
	function SystemGetFileUploadInfo($FileID) {
	
		$Conn = $GLOBALS['Conn'];
	
		$sql = "select * from "._SYSTEM_TABLE_UPLOAD_." where "._SYSTEM_TABLE_UPLOAD_."_ID = '".$FileID."'";
	
		$Conn->query($sql);
		
		$Result = $Conn->getResult();
		
		if ($Conn->getRowCount() != 0)
			$Result = SystemReplaceArrayKey($Result[0],_SYSTEM_TABLE_UPLOAD_."_","");
			
		return $Result;
	
	}
	
	function SystemSetFileUploadInfo($FileID,$AttrName,$Val) {
	
		$Conn = $GLOBALS['Conn'];
	
		$sql .= " update "._SYSTEM_TABLE_UPLOAD_." set "._SYSTEM_TABLE_UPLOAD_."_".$AttrName." = '".$Val."'";
		$sql .= " where "._SYSTEM_TABLE_UPLOAD_."_ID = ".$FileID;
	
		$Conn->execute($sql);

	
	}
	
	function SystemRemoveFileUpload($FileID,$Dir = "../") {
	
		$Conn = $GLOBALS['Conn'];
	
		$Info = SystemGetFileUploadInfo($FileID);
		
		$File = $Dir.$Info["PATH"];
		SystemRemoveFile($File);
		
		$sql = "delete from "._SYSTEM_TABLE_UPLOAD_." where "._SYSTEM_TABLE_UPLOAD_."_ID = ".$FileID;
	
		$Conn->execute($sql);
	
	}
	
	function SystemRemoveFile($File) {
		if (file_exists($File))
			unlink($File);
	}

	function SystemFormatBytes($bytes, $precision = 2) { 
		$units = array('B', 'KB', 'MB', 'GB', 'TB'); 
	   
		$bytes = max($bytes, 0); 
		$pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
		$pow = min($pow, count($units) - 1); 
	   
		$bytes /= pow(1024, $pow); 
	   
		return round($bytes, $precision) . ' ' . $units[$pow]; 
	} 
	
	function SystemEncrypt($Str) {
		$Code  =  base64_encode($Str);
		$Code = strrev($Code);
		$Code = base64_encode($Code);
		$Code = str_replace("=","_",$Code);
		
		return $Code;
	}
	
	function SystemDecrypt($Str) {
		$Code = str_replace("_","=",$Code);
		$Code  =  base64_decode($Str);
		$Code = strrev($Code);
		$Code = base64_decode($Code);
		
		return  $Code;
	}

	function SystemEncryptURL($URL) {
	
		$NEW_URL = "P=".SystemEncrypt($URL);
		return $NEW_URL;
	
	}
	
	function SystemDecryptURL($URL) {
	
		$NEW_URL = substr($URL,strpos($URL,"P="));

		if (strpos($NEW_URL,"&"))
			$NEW_URL = substr($NEW_URL,0,strpos($NEW_URL,"&"));
		
		$NEW_URL = str_replace("P=","",$NEW_URL);
		
		$NEW_URL  =  base64_decode($NEW_URL);
		$NEW_URL = strrev($NEW_URL);
		$NEW_URL = base64_decode($NEW_URL);
		
		$VarArray = explode("&",$NEW_URL);
		for ($i=0;$i<count($VarArray);$i++) {
			$Str = $VarArray[$i];
			$Var = explode("=",$Str);
			
		 	$VarKey = $Var[0];
			
			
			global $$VarKey;
			$$VarKey = $Var[1] ;
		
		}
		
		return $NEW_URL;
	
	}
	
	
	#### DATE Function ##########################################
	
	function SystemFirstOfMonth($Date) {					 // Input example 2011-12-01 ("Y-m-d")
		return date("Y-m-d",strtotime(SystemDateFormat($Date,'Y')."-".SystemDateFormat($Date,'m').'-01'));
	}
	
	function SystemLastOfMonth($Date) {				 	// Input example 2011-12-01 ("Y-m-d")
		return date("Y-m-d",strtotime('-1 second',strtotime('+1 month',strtotime(SystemDateFormat($Date,'Y').'-'.SystemDateFormat($Date,'m').'-01'))));
	}


	function SystemDateDiff($startDate, $endDate)   	// Input example 2011-12-01 ("Y-m-d")
	{ 
		return (strtotime($endDate) - strtotime($startDate))/  ( 60 * 60 * 24 );  // 1 day = 60*60*24 
	} 
	
	
	function SystemMonthDiff($startDate, $endDate)   	// Input example 2011-12-01 ("Y-m-d")
	{ 
		$startDate = date_create($startDate);
		$endDate = date_create($endDate);
		$MonthFromYear = (date_format($endDate,"Y") - date_format($startDate,"Y")) * 12 ;
		$MonthDiff =  $MonthFromYear - abs(date_format($endDate,"m") - date_format($startDate,"m"));
		return $MonthDiff+1;
	} 
	
	function SystemDateFormat($date , $key='d/m/Y') {
	
		$Return = NULL;
		
		if (($date != '0000-00-00 00:00:00' ) && ($date != '0000-00-00' ) && !empty($date)) {
			$XDate = date_create($date);
			$Return =date_format($XDate,$key);
		}
		
		return $Return;
		
	}
	
	function SystemUIDatetoSystemDate($date , $format='d/m/Y') {
	
		$Return = NULL;
		
		if (!empty($date))	{
			if ($format == 'd/m/Y') {
				$XDate = explode("/",$date);
				$Return = implode("-",array_reverse($XDate));
			}
		}
			
		return $Return;
		
	}
	
	###   MENU   ###########################################################################
	function SystemIsMenuID($MenuID) {
	
		$Return = false;
	
		$Conn = $GLOBALS['Conn'];
		
		$sql = "select * from "._SYSTEM_TABLE_MENU_." where "._SYSTEM_TABLE_MENU_."_ID = '".$MenuID."'";
		$Conn->query($sql);
		
		if ($Conn->getRowCount() == 0) {
		
			$FixSystemMenuID[] = "SystemHome";
			$FixSystemMenuID[] = "SystemSearch";
			$FixSystemMenuID[] = "SystemUpload";
			$FixSystemMenuID[] = "SystemUser";
			$FixSystemMenuID[] = "SystemUserGroup";
			$FixSystemMenuID[] = "SystemVulgarity";
			$FixSystemMenuID[] = "SystemControlMenu";
			$FixSystemMenuID[] = "SystemRegister";
			$FixSystemMenuID[] = "SystemProfile";
			$FixSystemMenuID[] = "SystemWebAccess";
		
			if (in_array($MenuID,$FixSystemMenuID))
				$Return = true;
		
		} else {
			$Return = true;
		}
		
		return $Return;
	
	}
	
	###   RATING   ###########################################################################
	
	function SystemInsertRatingScore($CONID,$BYID,$SCORE) {
	
		$Conn = $GLOBALS['Conn'];
		
		$insert[_TABLE_CONTENT_RATING_."_CONID"] = $CONID;
		$insert[_TABLE_CONTENT_RATING_."_BYID"] = $BYID;
		$insert[_TABLE_CONTENT_RATING_."_SCORE"] = $SCORE;
		$insert[_TABLE_CONTENT_RATING_."_CREATEDATE"] = 'sysdate()';
		
		$sql = "insert into "._TABLE_CONTENT_RATING_."(".implode(",",array_keys($insert)).") values (".implode(",",array_values($insert))." )";
		$Conn->execute($sql);
	
	}
	
	function SystemGetRatingScore($CONID) {
	
		$Conn = $GLOBALS['Conn'];
		
		
		$sql = "select avg("._TABLE_CONTENT_RATING_."_SCORE) SCORE from "._TABLE_CONTENT_RATING_." where "._TABLE_CONTENT_RATING_."_CONID = ".$CONID;
		$Conn->query($sql);
		
		$Result = $Conn->getResult();

		return ((empty($Result[0]['SCORE']))?0:$Result[0]['SCORE']);
	
	}
	
	function SystemGetRatingCount($CONID) {
	
		$Conn = $GLOBALS['Conn'];
		
		
		$sql = "select count("._TABLE_CONTENT_RATING_."_SCORE) CNT from "._TABLE_CONTENT_RATING_." where "._TABLE_CONTENT_RATING_."_CONID = ".$CONID;
		$Conn->query($sql);
		
		$Result = $Conn->getResult();

		return ((empty($Result[0]['CNT']))?0:$Result[0]['CNT']);
	
	}
	
	
	function SystemGetAccountGiveRatingScore($CONID,$BYID) {
	
		$Conn = $GLOBALS['Conn'];
		
		
		$sql = "select "._TABLE_CONTENT_RATING_."_SCORE SCORE from "._TABLE_CONTENT_RATING_;
		$sql.=" where "._TABLE_CONTENT_RATING_."_CONID = ".$CONID;
		$sql.=" and "._TABLE_CONTENT_RATING_."_BYID = ".$BYID;
		$Conn->query($sql);

		
		$Result = $Conn->getResult();

		return ((empty($Result[0]['SCORE']))?0:$Result[0]['SCORE']);
	
	}
	
	
	### Insert Notification ####################################
	
	function SystemInsertNotification($Set) {
	
		$Conn = $GLOBALS['Conn'];
		
		$insert[_TABLE_NOTIFICATION_."_TOID"] =  $Set['TO_ID'];
		$insert[_TABLE_NOTIFICATION_."_FROMID"] = $Set['FROM_ID'];
		$insert[_TABLE_NOTIFICATION_."_TITLE"] = "'".$Set['TITLE']."'";
		$insert[_TABLE_NOTIFICATION_."_TXT"] = "'".$Set['MSG']."'";
		$insert[_TABLE_NOTIFICATION_."_URL"] = "'".$Set['URL']."'";
		$insert[ _TABLE_NOTIFICATION_."_DATE"] = "sysdate() ";
		
		$sql = "insert into "._TABLE_NOTIFICATION_."(".implode(",",array_keys($insert)).") values (".implode(",",array_values($insert)).") ";
		$Conn->execute($sql);
	
	}
	
	function SystemClearNotification($AccountID) {
	
		$Conn = $GLOBALS['Conn'];
		
		$sql = "delete from "._TABLE_NOTIFICATION_." where "._TABLE_NOTIFICATION_."_TOID = ".$AccountID;
		$Conn->execute($sql);
	
	}
	
	
		function SystemDateFormatDB($date) {
			
			$date=trim($date);
		
		$Return = NULL;
		if ($date != '') {
			$arr_date=explode("/",$date);
			
			$Return=$arr_date[2].'-'.$arr_date[1].'-'.$arr_date[0];
				$Return=str_replace("'", "", $Return);
			//	$Return="'".$Return."'";
		}

		return $Return;
		
	}
	
		function SystemDateFormatDBUPDATE($date) {
		
		$Return = NULL;
		if ($date != '') {
			$arr_date=explode("/",$date);
			
			$Return=$arr_date[2].'-'.$arr_date[1].'-'.$arr_date[0];
				$Return=str_replace("'", "", $Return);
			
		}

		return $Return;
		
	}
	


	function SystemDisplayDateTh($date) {
			
		$source_month_thshort = $GLOBALS['source_month_thshort'];
		
		$Return = NULL;
		
		$ts = strtotime($date);
		
		$Return=date('j',$ts)." ".$source_month_thshort[date('m',$ts)]." ".substr((date('Y',$ts)+543),2,2);

		return $Return;
		
	}
	
	
	function SystemDisplayDateThLong($date) {
			
		$source_month_thlong = $GLOBALS['source_month_thlong'];
		
		$Return = NULL;
		
		$ts = strtotime($date);
		
		$Return=date('j',$ts)." ".$source_month_thlong[date('m',$ts)]." ".(date('Y',$ts)+543);

		return $Return;
		
	}
	
	
		
	function SystemGetAgentName($AID) {
	
		$Conn = $GLOBALS['Conn'];
		
		
		$sql = "select "._TABLE_AGENT_."_NAME NAME from "._TABLE_AGENT_;
		$sql.=" where "._TABLE_AGENT_."_ID = ".$AID;

		$Conn->query($sql);
		$Result = $Conn->getResult();

		return ((empty($Result[0]['NAME']))?"":$Result[0]['NAME']);
	
	}
	
		
		
function SystemGetSqlSelect($table,$f_id,$f_name,$link,$order="NULL",$cri="NULL"){
	
	if(is_array($f_name)){
			$field= implode(",",$f_name);				
	}else{
		$field=$f_name;
	}
	
	$Conn = $GLOBALS['Conn'];
	$html = '';
	$sql = "SELECT $f_id , $field FROM $table";
	if ($cri != 'NULL' && $cri != '' ) { $sql .= " WHERE $cri"; }
	if ($order != 'NULL' && $order != '' ) { 
		$sql .= " ORDER BY $order "; 
	
	}else if(is_array($f_name)){
		$sql .= " ORDER BY $f_id "; 
	}else{
		$sql .= " ORDER BY $f_name "; 
	}
	
		$Conn->query($sql);
		$ContentList = $Conn->getResult();
		$TotalC = $Conn->getRowCount();

	 	for ($i=0;$i<=($TotalC-1);$i++)	{	
		
		$Row = $ContentList[$i];
		$html .= "<option value=\"".$Row[$f_id]."\"";
		if (trim($Row[$f_id]) == trim($link)) { $html .= " selected"; }
		
		
		if(is_array($f_name)){
			$html .= " >";
			foreach($f_name as $val){
				$html.=" ".$Row[$val];
			}
			$html.="</option> ";
		}else{
			$html .= " >".$Row[$field]."</option> ";
		}
		
	}	
	
	

	return $html;
}



function SystemArraySelect($source,$link,$order="NULL"){
	$html = '';
	if (is_array($source)){
		foreach($source as $key=>$value) {
			$html .= "<option value=\"$key\"";
			if ($key == $link) { $html .= " selected"; }
			$html .= ">$value</option>";
		}
	}
	
	return $html;
}


function SystemAutoNumber($typemod,$key,$qtyno=4,$type="GET") {
	
	$Conn = $GLOBALS['Conn'];
	
	
	$sql = "SELECT maxno as MAXNO FROM sysautonumber ";
	$sql .= " WHERE typemod='".$typemod."'";
	$sql .= " AND syskey='".$key."'";
	
	
	$Conn->query($sql);
	$ContentList = $Conn->getResult();
	
	
	$maxno= $ContentList[0]["MAXNO"];

	$auto_number=$key;
		
	if ($maxno>0){
		$maxno=$maxno+1;
	}else{
		$maxno=1;
	}
		
	if($qtyno>0){
		$auto_number=$auto_number.sprintf("%0".$qtyno."s",$maxno); 
	}else{
		$auto_number=$auto_number;
	}
	
	
	if ($type=="GET"){
		return $auto_number;
	}else if($type=="ADD"){
		
		if($maxno>1){			
			$update='';
			$update[]="maxno = '".$maxno."'";
			
			$sql="UPDATE sysautonumber SET ".implode(", ",$update)." WHERE typemod = '".$typemod."' ";
			$sql .= " AND syskey='".$key."'";
			$Conn->execute($sql);	
		}else{
			$insert='';
			$insert["typemod"] 	= "'".$typemod."'";
			$insert["syskey"] 	= "'".$key."'";
			$insert["maxno"] 	= "'".$maxno."'";
			
			$sql="INSERT INTO sysautonumber (".implode(",",array_keys($insert)).") VALUES (".implode(",",array_values($insert)).")";
			$Conn->execute($sql);	
		}
		

	}
	
}

function SystemGetMaxOrder($table,$condition="NULL"){
	$Conn = $GLOBALS['Conn'];
	$sql = "SELECT max(order_by) as MAXNO FROM $table ";
	if ($condition != 'NULL' && $condition != '' ) { $sql .= " WHERE $condition"; }
	
	$Conn->query($sql);
	$ContentList = $Conn->getResult();
	$maxno= $ContentList[0]["MAXNO"];
	
	return $maxno;
}

function SystemGetMenuIDLevel1($menuid_lvl2){
	$Conn = $GLOBALS['Conn'];
	$sql = "SELECT p.parent_id FROM  sysmenu p";
	$sql.=" where p.menu_id='".$menuid_lvl2."' and p.lang_code='".$_SESSION['FRONT_LANG']."'";

	$Conn->query($sql);
	$ContentList = $Conn->getResult();
	$Row=$ContentList[0];
	
	return $Row["parent_id"];
}


function SystemGetPathMenuFristLevel1($parent_id){
	$Conn = $GLOBALS['Conn'];
	
	$sql = "SELECT p.menu_id,m.filepath_front FROM  sysmenu p";
	$sql.= " inner join sysmodule m on(m.module_code=p.module_code) ";
	$sql .= " WHERE p.parent_id='".$parent_id."'";
	$sql .= " and p.lang_code='".$_SESSION['FRONT_LANG']."'";
	$sql.=" order by p.order_by limit 0,1";
	
	
	$Conn->query($sql);
	$ContentList = $Conn->getResult();
	$Row=$ContentList[0];
	
	
	$url= $Row["filepath_front"]."?".SystemFrontURL("mid=".$Row["menu_id"]);
	
	return $url;
}

function SystemGetMenuFilePath($Row){
				
	$url="";	
	$chk_storecate= strpos("C".$Row["module_code"],"store-menucate");	
	
	if($Row["module_code"]=="home"){
			$url="../home/index.php";
	}else if($Row["module_code"]=="group"){	
		if($Row["level"]=="1"){
			$url=SystemGetPathMenuFristLevel1($Row["menu_id"]);
		}else{
			$url="javascript:void(0)";
		}
	}else if($Row["module_code"]=="link"){	
			$url= $Row["url"];
	}else{	
		if($chk_storecate){			
			$store_cate_id=str_replace("store-menucate-","",$Row["module_code"]);
			$url="../store/index.php?".SystemFrontURL("mid=".$Row["menu_id"]."&c=".$store_cate_id);
		}else{
			$url=$Row["filepath"]."?".SystemFrontURL("mid=".$Row["menu_id"]);
		}	
			
	}

	return $url;
}

function SystemPriceDB($price) {
	$price=str_replace(",","",$price);
	
	 $pos = strpos($price,"(");
								
	if($pos>-1){
		
		$price=str_replace("(","",$price);
		$price=str_replace(")","",$price);
		
		$price="-".$price;
	}
				
						   
						   
	
	return $price;
}



function SystemSetCleanPath($path) { 
    $result = array();
    $pathA = explode('/', $path);
    if (!$pathA[0]) $result[] = '';

    foreach ($pathA AS $key => $dir) {
        if ($dir == '..') {
            if (end($result) == '..') { 
                $result[] = '..';
            } elseif (!array_pop($result)) {
                $result[] = '..';
            }
        } elseif (($dir && $dir != '.') || $dir=='0') {  
            $result[] = $dir;
        }
    }
    if (!end($pathA)) $result[] = '';
    return implode('/', $result);
}
function SystemSetReadyPath($Path=""){ 
	$Path=SystemSetCleanPath($Path);
	if(!is_dir($Path) && !empty($Path)){
		$dir=explode("/" , $Path);
		foreach($dir as $value){
			$dir2.= $value;  
			if(!is_dir($dir2) && strlen($value) > 0) { 
				@mkdir($dir2,0777);
				chmod($dir2, 0777);
			} 
			$dir2.="/";
		}
	}
	return $Path;
}

function SystemGetOneData($table,$f_value,$cri="NULL"){
	$Conn = $GLOBALS['Conn'];
	$html = '';
	$sql = "SELECT $f_value FROM $table";
	if ($cri != 'NULL' && $cri != '' ) { $sql .= " WHERE $cri "; }else{ $sql .= " "; }
	
	//echo $sql;
	
	$Conn->query($sql);
	$ContentList = $Conn->getResult();
	
	$Conn->query($sql);
	$Row = $Conn->getResult();
	
	
	return $Row[0][$f_value];
}




function SystemGetMoreData($table,$f_value,$cri="NULL"){

	$Conn = $GLOBALS['Conn'];

	$field='';	
	if (is_array($f_value)){
		foreach ($f_value as $value){
			$field[] = $value;
		}		
	}
	
	$sql = "select ".implode(",",$field);		
	$sql .= " FROM $table";
	if ($cri != 'NULL' && $cri != '' ) { $sql .= " WHERE $cri "; }else{ $sql .= " WHERE 1<0 "; } 
	
	
	$Conn->query($sql);
	$Row = $Conn->getResult();

	return $Row[0];
}


function getCategoryNavi($cid){
	if($cid>0){
		$arrCate1=SystemGetMoreData("article_category",array('name_'.strtolower($_SESSION['FRONT_LANG']),'level','parent_id'),"cate_id='$cid'");
		
		$text_navi="";
		
		if($arrCate1['level']==1){	
			$cate_lel1=$cid;
			$cate_name1=$arrCate1['name_'.strtolower($_SESSION['FRONT_LANG'])];
			$text_navi.='/ '.$cate_name1;
		}else if($arrCate1['level']==2){
			$cate_lel1=$arrCate1['parent_id'];	
			$cate_lel2=$cid;	
			$cate_name2=$arrCate1['name_'.strtolower($_SESSION['FRONT_LANG'])];
			
			$arrCate1Name=SystemGetMoreData("article_category",array('name_'.strtolower($_SESSION['FRONT_LANG'])),"cate_id='$cate_lel1'");
			$cate_name1=$arrCate1Name['name_'.strtolower($_SESSION['FRONT_LANG'])];
			$text_navi.='/ '.$cate_name1.' / '.$cate_name2;
		}
	}
	
	$data['navi']=$text_navi;
	$data['cate_lel1']=$cate_lel1;
	$data['cate_lel2']=$cate_lel2;
	
	return $data;
}

function SystemNumToWordsThai($num){ 
	$num=str_replace(",","",$num);
	$num_decimal=explode(".",$num);
	
	$returnNumWord="";
	$returnNumWord.= SystemNumToWordsThai2($num_decimal[0],"B");
	
	
	$returnNumWord.= SystemNumToWordsThai2($num_decimal[1],"S");
	
	return $returnNumWord;
}

function SystemNumToWordsThai2($num,$type){   

    $returnNumWord;   
    $lenNumber=strlen($num);   
    $lenNumber2=$lenNumber-1;   
    $kaGroup=array("","เธชเธดเธ","เธฃเนเธญเธข","เธเธฑเธ","เธซเธกเธทเนเธ","เนเธชเธ","เธฅเนเธฒเธ","เธชเธดเธ","เธฃเนเธญเธข","เธเธฑเธ","เธซเธกเธทเนเธ","เนเธชเธ","เธฅเนเธฒเธ");   
    $kaDigit=array("","เธซเธเธถเนเธ","เธชเธญเธ","เธชเธฒเธก","เธชเธตเน","เธซเนเธฒ","เธซเธ","เน€เธเนเธ”","เนเธเธ”","เน€เธเนเธฒ");   
	$kaDigitDecimal=array("เธจเธนเธเธขเน","เธซเธเธถเนเธ","เธชเธญเธ","เธชเธฒเธก","เธชเธตเน","เธซเนเธฒ","เธซเธ","เน€เธเนเธ”","เนเธเธ”","เน€เธเนเธฒ");   
    $ii=0;   
    for($i=$lenNumber2;$i>=0;$i--){   
        $kaNumWord[$i]=substr($num,$ii,1);   
        $ii++;   
    }   
    $ii=0;   
    for($i=$lenNumber2;$i>=0;$i--){   
        if(($kaNumWord[$i]==2 && $i==1) || ($kaNumWord[$i]==2 && $i==7)){   
            $kaDigit[$kaNumWord[$i]]="เธขเธตเน";   
        }else{   
            if($kaNumWord[$i]==2){   
                $kaDigit[$kaNumWord[$i]]="เธชเธญเธ";        
            }   
            if(($kaNumWord[$i]==1 && $i<=2 && $i==0) || ($kaNumWord[$i]==1 && $lenNumber>6 && $i==6)){   
                if($kaNumWord[$i+1]==0){   
                    $kaDigit[$kaNumWord[$i]]="เธซเธเธถเนเธ";      
                }else{   
                    $kaDigit[$kaNumWord[$i]]="เน€เธญเนเธ”";       
                }   
            }elseif(($kaNumWord[$i]==1 && $i<=2 && $i==1) || ($kaNumWord[$i]==1 && $lenNumber>6 && $i==7)){   
                $kaDigit[$kaNumWord[$i]]="";   
            }else{   
                if($kaNumWord[$i]==1){   
                    $kaDigit[$kaNumWord[$i]]="เธซเธเธถเนเธ";   
                }   
            }   
        }   
        if($kaNumWord[$i]==0){   
			if($i!=6){
	            $kaGroup[$i]="";   
			}
        }   
        $kaNumWord[$i]=substr($num,$ii,1);   
        $ii++;   
        $returnNumWord.=$kaDigit[$kaNumWord[$i]].$kaGroup[$i];   
    }  
	
		if($type=="B"){
			 $returnNumWord.="เธเธฒเธ—";
		}else{
			if($num!="00"){
				$returnNumWord.="เธชเธ•เธฒเธเธเน";
			}
			 
		}
		
    return $returnNumWord;   
}   


function SystemGetPermission($groupcode,$menuid,$controlaccess){
	$Conn = $GLOBALS['Conn'];
	
	$sql = "select count(*) CNT from mst_usergroupaccess ";
	$sql .= " where usergroupcode='".$groupcode."'";
	$sql .= " and menuid='".$menuid."'";
	$sql .= " and controlaccess='".$controlaccess."'";
	
	
	$Conn->query($sql);
	$Row = $Conn->getResult();
	
	$c= $Row[0]["CNT"];
	
	
	return $c;
}



function SystemGetSQLSearch($tSearch,$f_value){

	$Conn = $GLOBALS['Conn'];
	$sql="";
	
	$tSearch=trim($tSearch);
	
	
	if (trim($tSearch)!=""){
		$sql =" AND (";
		//$sql.=" AND (  p.templateno like '%".$tSearch."%' ";
		//$sql.=" OR p.description  like '%".$tSearch."%' ";
	
		//$field='';	
		if (is_array($f_value)){
			$i=0;
			foreach ($f_value as $value){
				if($i>0){	$sql.=" OR "; }
				$sql.= $value." like '%".$tSearch."%'";
				$i++;
			}		
		}
		$sql.=")";
	}
	
	return $sql;

}

function number_format_2($val){
	
		$tmp = $val;
		
		$tmp_arr=explode(".",$val);
		$tmp1=substr($tmp_arr[1],2,3);
		
		$tmp_price_2=substr($tmp_arr[1],0,2);
		$tmp_price_3="";
		
		for ($i=2;$i>-1;$i--){
			if(substr($tmp1,$i,1)=="0"){
				$tmp_price_3 = substr($tmp1,0,$i);	
			}else{
				if($i==2) $tmp_price_3=$tmp1;
				break;	
			}	
		}
		
		
	
		$price =$tmp_arr[0].".".$tmp_price_2.$tmp_price_3 ;
	
	
		return $price;
}

function SystemGetReturnURL($other_url=""){
	$SysMenuID = $GLOBALS['SysMenuID'];
	$Page = $GLOBALS['Page'];
	
	$Url=SystemEncryptURL("SysMenuID=$SysMenuID&Page=$Page");
	return $Url;
}


function SystemSizeFilter( $bytes ){
	$label = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB' );
	for( $i = 0; $bytes >= 1024 && $i < ( count( $label ) -1 ); $bytes /= 1024, $i++ );
	return( round( $bytes, 2 ) . " " . $label[$i] );
}


function sysGetImgSrc($html,$t="ALL"){
	preg_match_all('/<img[^>]+>/i',$html, $rawimagearray,PREG_SET_ORDER); 
	$imagearray = array();
	for ($i = 0; $i < count($rawimagearray); $i++) {
		array_push($imagearray, $rawimagearray[$i][0]);
	}
	$imageinfo = array();
	foreach($imagearray as $img_tag) {
		preg_match_all('/(src|width|height)=("[^"]*")/i',$img_tag, $imageinfo[]);
	}
	$data_src="";
	
	if($t=="ALL"){
		foreach($imageinfo as $val){
			$data_src[]= $val[2][0];
		}
	}else{
		$data_src= $imageinfo[0][2][0];
		
	}

	return $data_src;
}



function SystemFrontURL($URL) {	
	$NEW_URL = $URL;
	return $NEW_URL;
}

function SystemGoUrlPaging($source,$type="all") {
	$url="";
	foreach($source as $key=>$val){
		$url.="&".$key."=".$val;
	}
	return $url;
}

function SystemResizeImgAuto($origWidth,$origHeight,$width,$height){
	if ($origHeight < $origWidth){
		 $resizeWidth  = $width;
		 $resizeHeight= floor(($origHeight/$origWidth)*$width);
	}elseif ($origHeight > $origWidth){
		$resizeWidth = floor(($origWidth/$origHeight)*$height);
		$resizeHeight= $height;
	}else{	
		if ($height < $width) {
			$resizeWidth = $width;
			$resizeHeight= floor(($origHeight/$origWidth)*$width);
		} else if ($height > $width) {
			$resizeWidth = floor(($origWidth/$origHeight)*$height);
			$resizeHeight= $height;
		} else {
			$resizeWidth= $width;
			$resizeHeight= $height;
		}	
	}
	return array($resizeWidth, $resizeHeight);
	
}



function SystemSendEmail($arrEmailForm,$arrEmailTo,$arrEmailCc,$arrEmailBcc,$strEmailSubject,$strEmailBody,$file="") {
	
	$mail             = new PHPMailer(); // defaults to using php "mail()"
	//$mail -> charSet = "UTF-8";
	$mail->CharSet = "UTF-8";
//	$body             = file_get_contents('contents.html');
//	$body             = eregi_replace("[\]",'',$body);
	
	$body = $strEmailBody;
	//$mail->SetFrom('support@jigsawoffice.com', 'Jigsaw');

	#Form
	foreach($arrEmailForm as $val){
			$mail->SetFrom($val["email"], $val["name"]);
	}
	
	#To
	//$address = "kemtongwit@hotmail.com";
	foreach($arrEmailTo as $val){
			$mail->AddAddress($val["email"], $val["name"]);
			//$mail->AddAddress($strToEmail, $strToName);
	}
	#Cc
	if(is_array($arrEmailCc)){
		foreach($arrEmailCc as $val){
				$mail->AddCC($val["email"], $val["name"]);
		}
	}

	#Bcc
	if(is_array($arrEmailBcc)){
		foreach($arrEmailBcc as $val){
				$mail->AddBCC($val["email"], $val["name"]);
		}
	}
	
	$mail->Subject    = $strEmailSubject;
	$mail->MsgHTML($body);
	
	if(trim($file)!=""){	
		$mail->AddAttachment($file);  
	}
	
	$mail->IsHTML(true);
	
	if(!$mail->Send()) {
	  return "Mailer Error: " . $mail->ErrorInfo;
	} else {
	  return "Message sent!";
	}
	
}


function SystemPaging($source) {
	
	//ItemPerPage
	$ItemPerPageSource = $GLOBALS['ItemPerPageSource'];
	
	$Mode			= $source["Mode"];
	$Page			= $source["Page"];
	$PageSize		= $source["PageSize"];
	$TotalRec		= $source["TotalRec"];
	$CntRecInPage	= $source["CntRecInPage"];
	$Type			= $source["Type"];
	$MenuID			= $source["MenuID"];
	$Sort			= $source["Sort"];
	$Order			= $source["Order"];
	 $CateID			= $source["CateID"];
	
	
	$Page = ($Page*1==0) ? 1 : $Page;
	$PageTotal=ceil($TotalRec/$PageSize);	
	$perPageSource= $ItemPerPageSource[$Mode];
	
	$LastPage=$Page-1;
	$NextPage=$Page+1;

	if($Page>=$PageTotal){	
		$_onNextPage="#";
	}else{
		$_onNextPage=_SYSTEM_HOST_NAME_."/store/index.php?mid=$MenuID&c=$CateID&mode=$Mode&per=$PageSize&p=$NextPage&sort=$Sort&order=$Order";
	}
	
	if($Page<2){
		$_onLastPage="#";
	}else{
		$_onLastPage=_SYSTEM_HOST_NAME_."/store/index.php?mid=$MenuID&c=$CateID&mode=$Mode&per=$PageSize&p=$LastPage&sort=$Sort&order=$Order";
	}
	
	
	if($Type=="HEAD"){
		$paging_style="paging_header";
	}else{
		$paging_style="paging_footer";
	}
	
	
	?>
    
<style>
.paging_header{
	border-bottom:1px solid #eeeeee; padding-bottom:4px; margin-bottom:10px;
}
.paging_footer{
	border-top:1px solid #eeeeee; padding-top:10px; margin-bottom:10px;
}
</style>

<div class="row-fluid <?=$paging_style?>">
<div class="sort-by" >
<label  >เน€เธฃเธตเธขเธเธ•เธฒเธก :</label>
<div class="control" >
<select  class="select-box-style"  onchange="sysGoUrl(this.value)"  >
<option <? if($Order=="position" && $Sort=="asc"){?> selected="selected" <? } ?> value="<?=_SYSTEM_HOST_NAME_?>/store/index.php?<?="mid=$MenuID&c=$CateID&mode=$Mode&per=$PageSize&sort=asc&order=position"?>" >  เธฅเธณเธ”เธฑเธ </option>
<option <? if($Order=="name" && $Sort=="asc"){?> selected="selected" <? } ?> value="<?=_SYSTEM_HOST_NAME_?>/store/index.php?<?="mid=$MenuID&c=$CateID&mode=$Mode&per=$PageSize&sort=asc&order=name"?>">   เธเธทเนเธญ A-Z </option>
<option <? if($Order=="name" && $Sort=="desc"){?> selected="selected" <? } ?> value="<?=_SYSTEM_HOST_NAME_?>/store/index.php?<?="mid=$MenuID&c=$CateID&mode=$Mode&per=$PageSize&sort=desc&order=name"?>">  เธเธทเนเธญ Z-A   </option>
<option <? if($Order=="popsells" && $Sort=="desc"){?> selected="selected" <? } ?> value="<?=_SYSTEM_HOST_NAME_?>/store/index.php?<?="mid=$MenuID&c=$CateID&mode=$Mode&per=$PageSize&sort=desc&order=popsells"?>">  เธชเธดเธเธเนเธฒเธเธฒเธขเธ”เธต  </option>
</select>
</div>
</div>

<div class="view-mode" >
<label  >เธกเธธเธกเธกเธญเธ : </label>
<div class="control">
<ul>
<li  <? if($Mode=="grid"){?>class="active"<? } ?> ><a href="<?=_SYSTEM_HOST_NAME_?>/store/index.php?<?="mid=$MenuID&c=$CateID&mode=grid&sort=$Sort&order=$Order"?>"><img src="../img/icon/grid.png" width="16" height="16"> </a></li>
<li <? if($Mode=="list"){?>class="active"<? } ?>><a href="<?=_SYSTEM_HOST_NAME_?>/store/index.php?<?="mid=$MenuID&c=$CateID&mode=list&sort=$Sort&order=$Order"?>"><img src="../img/icon/list.png" width="16" height="16"> </a></li>
</ul>
</div>
</div>  

<div class="view-perpage" style="width:200px;" >
<label  >เนเธชเธ”เธ : </label>
<div class="control">
<select class="select-box-style" onchange="sysGoUrl(this.value)" >
<? foreach($perPageSource as $key=>$val){ ?>
<option value="<?=_SYSTEM_HOST_NAME_?>/store/index.php?<?="mid=$MenuID&c=$CateID&mode=$Mode&per=$key&sort=$Sort&order=$Order"?>" <? if($key==$PageSize){?> selected="selected" <? } ?> ><?=$val?></option>
<? } ?> 	
</select>
</div>
</div>

<div class="pages pagination">
    <label>Page:</label>
    <div class="control">
    <ul>
    <li class="prev  <? if($_onLastPage=="#"){?>disabled <? } ?> "><a href="<?=$_onLastPage?>"><i class="icon-chevron-left"></i> </a></li>
    
    <? for($i=1;$i<=$PageTotal;$i++){ ?> 
    <li <? if($i==$Page){?>class="active"<? } ?> ><a href="<?=_SYSTEM_HOST_NAME_?>/store/index.php?mid=<?="$MenuID&c=$CateID&mode=$Mode&per=$PageSize&p=$i&sort=$Sort&order=$Order"?>" ><?=$i?></a></li>
    <? } ?>
    <li class="next <? if($_onNextPage=="#"){?>disabled <? } ?>   "><a href="<?=$_onNextPage?>"> <i class="icon-chevron-right"></i></a></li>
    </ul>
    </div>
</div>

</div>


<?
}

?>
<?

#################
function SystemPagingBlog($source) {
	
	//ItemPerPage
	$ItemPerPageSource = $GLOBALS['ItemPerPageSource'];
	
	$Mode			= $source["Mode"];
	$Page			= $source["Page"];
	$PageSize		= $source["PageSize"];
	$TotalRec		= $source["TotalRec"];
	$CntRecInPage	= $source["CntRecInPage"];
	$Type			= $source["Type"];
	$MenuID			= $source["MenuID"];
	$Sort			= $source["Sort"];
	$Order			= $source["Order"];
	 $CateID			= $source["CateID"];
	
	
	$Page = ($Page*1==0) ? 1 : $Page;
	$PageTotal=ceil($TotalRec/$PageSize);	
	$perPageSource= $ItemPerPageSource[$Mode];
	
	$LastPage=$Page-1;
	$NextPage=$Page+1;

	if($Page>=$PageTotal){	
		$_onNextPage="#";
	}else{
		$_onNextPage=_SYSTEM_HOST_NAME_."/article/index.php?mid=$MenuID&c=$CateID&mode=$Mode&per=$PageSize&p=$NextPage&sort=$Sort&order=$Order";
	}
	
	if($Page<2){
		$_onLastPage="#";
	}else{
		$_onLastPage=_SYSTEM_HOST_NAME_."/article/index.php?mid=$MenuID&c=$CateID&mode=$Mode&per=$PageSize&p=$LastPage&sort=$Sort&order=$Order";
	}
	
	
	?>


<div class="row-fluid">

<div class="pages pagination">
    <label>Page:</label>
    <div class="control">
    <ul>
    <li class="prev  <? if($_onLastPage=="#"){?>disabled <? } ?> "><a href="<?=$_onLastPage?>"><i class="icon-chevron-left"></i> </a></li>
    
    <? for($i=1;$i<=$PageTotal;$i++){ ?> 
    <li <? if($i==$Page){?>class="active"<? } ?> ><a href="<?=_SYSTEM_HOST_NAME_?>/article/index.php?mid=<?="$MenuID&c=$CateID&mode=$Mode&per=$PageSize&p=$i&sort=$Sort&order=$Order"?>" ><?=$i?></a></li>
    <? } ?>
    <li class="next <? if($_onNextPage=="#"){?>disabled <? } ?>   "><a href="<?=$_onNextPage?>"> <i class="icon-chevron-right"></i></a></li>
    </ul>
    </div>
</div>

</div>


<?
}

?>