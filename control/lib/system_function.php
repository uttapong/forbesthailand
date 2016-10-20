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
	$sql .= " OR (".$f1." = '0000-00-00' AND ".$f2." = '0000-00-00'))";
	
	return $sql;
}


	function SystemCheckInputToDB($value)
	{
	// Stripslashes
	if (get_magic_quotes_gpc())
	  {
	  $value = stripslashes($value);
	  }
	// Quote if not a number
	if (!is_numeric($value))
	  {
		 $value= str_replace('&quot;','"',$value);
	  $value = "'" . mysql_real_escape_string($value) . "'";
	  }
	  
	  	
	  
		return $value;
	}

function SystemGetLangIcon($Lang){
	if($Lang=='EN'){
		$icon='flag-th.gif';	
	}else{
		$icon='flag-en.gif';	
	}
	return $icon;
}

function SystemGetPermContent($createby){
	if($_SESSION['UserGroupCode'] =="ADMIN" || $createby==$_SESSION['UserID'] ){
		return 1;
	}else{
		return 0;
	}
}


function SystemCheckFileImage($FileType){
	 $FileType=strtolower($FileType);
	if($FileType=='jpg' || $FileType=='jpeg' || $FileType=='png' || $FileType=='gif'  || $FileType=='bmp'){
		$c=1;
	}else{
		$c=0;
	}
	return $c;
}

function SystemGetTitleModule($MenuCode){
	$Conn = $GLOBALS['Conn'];
	$sql = "SELECT m.name,m.description FROM sysmenu m";
	$sql.= " WHERE  m.lang_code='".$_SESSION['LANG']."'";
	$sql.= " and m.menu_id='".$MenuCode."' ";
	
	$Conn->query($sql);
	$ContentList = $Conn->getResult();
	
	return $ContentList[0]["name"]." <span>".$ContentList[0]["description"]."</span> ";
	
}

function SystemGetNavigatorModule($MenuCode){
	$Conn = $GLOBALS['Conn'];
	$sql = "SELECT m.name,m.description FROM sysmenu m";
	$sql.= " WHERE  m.lang_code='".$_SESSION['LANG']."'";
	$sql.= " and m.menu_id='".$MenuCode."' ";
	
	$Conn->query($sql);
	$ContentList = $Conn->getResult();
	
	return '<li class="active">'.$ContentList[0]["name"].'</li>';
	
}

function SysGetTitleSort($my_field,$field,$sort){	
	$myClass="sorting";
	if ($my_field==$field){	
		$myClass.="_".$sort;
		if ($sort=="asc"){
			$sort="desc";
			
		}else{
			$sort="asc";
		}
	}else{
		$sort="asc";
	}
	$str=' class="'.$myClass.'" ';
	$str.='onclick="sysSort('."'".$my_field."',"."'".$sort."'".')" ';
	
	return $str;
}


function SystemCheckLogin(){
	
	

	if(!isset($_SESSION['UserID']) || $_SESSION['UserID']=='' || $_SESSION["SysSess_ID"]=='' || !isset($_SESSION['SysSess_ID']) ) {
	
		$count1=0;
		$count2=0;
		$count3=0;
		
		$str=str_replace("/authen/index.php", "",$_SERVER['PHP_SELF'], $count1);
		$str=str_replace("/authen/authentication.php", "",$_SERVER['PHP_SELF'], $count2);
		//$str=str_replace("/systemAuthentication/Authentication-prompt.php", "",$_SERVER['PHP_SELF'], $count3);

		$count=$count1+$count2+$count3;
		
		
		if($count>0){
			return true;
		}else{
			return false;
		}	
	}else{	
	
	
		if(	$_SESSION["SysSess_ID"] == session_id()){
			return true;
		}else{
			return false;
		}
		
		
	}


}


function SystemGETIP() {
	
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
	
	
	### Clean Temp file ####################################
	
	function SystemClearTempUpload() {
	
		$Conn = $GLOBALS['Conn'];
		
		$sql = " SELECT "._SYSTEM_TABLE_UPLOAD_."_ID ";
		$sql.= " FROM "._SYSTEM_TABLE_UPLOAD_;
		$sql.= " where sysupload_id not in ( select "._TABLE_CONTENT_PHOTO_."_UPLOADID from "._TABLE_CONTENT_PHOTO_.") and ";
		$sql.= " 		sysupload_id not in ( select "._TABLE_CONTENT_HTML_PHOTO_."_UPLOADID from "._TABLE_CONTENT_HTML_PHOTO_.") and ";
		
		$sql.= " 			sysupload_id not in ( select "._TABLE_CONTENT_FILE_."_UPLOADID from "._TABLE_CONTENT_FILE_.") and ";
		
		$sql.= " 			sysupload_id not in ( select "._TABLE_CONTENT_."_THUMBNAIL from "._TABLE_CONTENT_." where "._TABLE_CONTENT_."_THUMBNAIL is not null) and ";
		$sql.= " 			sysupload_id not in ( select "._TABLE_CONTENT_."_THUMBNAIL2 from "._TABLE_CONTENT_." where "._TABLE_CONTENT_."_THUMBNAIL2 is not null) and ";
		$sql.= " 			sysupload_id not in ( select "._TABLE_CONTENT_."_THUMBNAIL3 from "._TABLE_CONTENT_." where "._TABLE_CONTENT_."_THUMBNAIL3 is not null) and ";
		$sql.= " 			sysupload_id not in ( select "._TABLE_CONTENT_."_THUMBNAIL4 from "._TABLE_CONTENT_." where "._TABLE_CONTENT_."_THUMBNAIL4 is not null) and ";			  
		$sql.= " 			sysupload_id not in ( select "._SYSTEM_TABLE_ACCOUNT_."_PICTURE from "._SYSTEM_TABLE_ACCOUNT_." where "._SYSTEM_TABLE_ACCOUNT_."_PICTURE is not null) and ";	
		$sql.= " 		"._SYSTEM_TABLE_UPLOAD_."_CREATEDATE <= date_add(sysdate(),INTERVAL -1 DAY) and ";
		
		$sql.= " 			sysupload_id not in ( select "._TABLE_TASK_EVENT_FILE_."_UPLOADID from "._TABLE_TASK_EVENT_FILE_.") and ";
		$sql.= " 			sysupload_id not in ( select "._TABLE_TASK_HTML_PHOTO_."_UPLOADID from "._TABLE_TASK_HTML_PHOTO_.") ";
		
		
		$Conn->query($sql);
		$Result = $Conn->getResult();

		for ($i=0;$i<count($Result);$i++) {
			$File = $Result[$i];
			SystemRemoveFileUpload($File[_SYSTEM_TABLE_UPLOAD_."_ID"]);
		}
		
		$sql2 = "delete from "._SYSTEM_TABLE_UPLOAD_;
		$sql2.= " where "._SYSTEM_TABLE_UPLOAD_."_ID IN (".$sql.")";
		$Conn->execute($sql);
		
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
	
	
	
	function getLicenceNo($Conn,$LicID,$type='br') {
		
		
		$sql = "select "._TABLE_LICENCE_NO_."_START,"._TABLE_LICENCE_NO_."_END from "._TABLE_LICENCE_NO_;
		$sql.=" where "._TABLE_LICENCE_NO_."_MAINID='".$LicID."'";
		
	
		$Conn->query($sql);
		$Result = $Conn->getResult();

		for ($i=0;$i<count($Result);$i++) {
			
		
				if (($type=="limit" && $i<1) || ($type!="limit")){
			
					if ($i>0){
							if ($type=="br"){
								$v_str.='<BR>';
							}else if($type=="comma"){
								$v_str.=' , ';
							}
					}
		
					$v_str.=$Result[$i][_TABLE_LICENCE_NO_."_START"];
					
					if (trim($Result[$i][_TABLE_LICENCE_NO_."_END"])>0){
						$v_str.=' - '.$Result[$i][_TABLE_LICENCE_NO_."_END"];
					}
					
		
				}// End IF Limit
		}// End For
		
		if ($type=="limit" ){
	
			if ($i>1){
			 $v_str.= ',...';	
			}
		}
		
		return $v_str;
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


function SystemGetMenuFilePath($Row){
				
	$url="";
	
	if($Row["module_code"]=="home"){
			$url="../home/index.php";
	}else if($Row["module_code"]=="group"){
		$url="javascript:void(0)";
	}else{
		
			$_param="";
			if(trim($Row["param"])!=""){
				$_param="&".$Row["param"];
			}
		
			$url=$Row["filepath"]."?".SystemEncryptURL("SysMenuID=".$Row["menu_id"].$_param);
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
    $kaGroup=array("","สิบ","ร้อย","พัน","หมื่น","แสน","ล้าน","สิบ","ร้อย","พัน","หมื่น","แสน","ล้าน");   
    $kaDigit=array("","หนึ่ง","สอง","สาม","สี่","ห้า","หก","เจ็ด","แปด","เก้า");   
	$kaDigitDecimal=array("ศูนย์","หนึ่ง","สอง","สาม","สี่","ห้า","หก","เจ็ด","แปด","เก้า");   
    $ii=0;   
    for($i=$lenNumber2;$i>=0;$i--){   
        $kaNumWord[$i]=substr($num,$ii,1);   
        $ii++;   
    }   
    $ii=0;   
    for($i=$lenNumber2;$i>=0;$i--){   
        if(($kaNumWord[$i]==2 && $i==1) || ($kaNumWord[$i]==2 && $i==7)){   
            $kaDigit[$kaNumWord[$i]]="ยี่";   
        }else{   
            if($kaNumWord[$i]==2){   
                $kaDigit[$kaNumWord[$i]]="สอง";        
            }   
            if(($kaNumWord[$i]==1 && $i<=2 && $i==0) || ($kaNumWord[$i]==1 && $lenNumber>6 && $i==6)){   
                if($kaNumWord[$i+1]==0){   
                    $kaDigit[$kaNumWord[$i]]="หนึ่ง";      
                }else{   
                    $kaDigit[$kaNumWord[$i]]="เอ็ด";       
                }   
            }elseif(($kaNumWord[$i]==1 && $i<=2 && $i==1) || ($kaNumWord[$i]==1 && $lenNumber>6 && $i==7)){   
                $kaDigit[$kaNumWord[$i]]="";   
            }else{   
                if($kaNumWord[$i]==1){   
                    $kaDigit[$kaNumWord[$i]]="หนึ่ง";   
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
			 $returnNumWord.="บาท";
		}else{
			if($num!="00"){
				$returnNumWord.="สตางค์";
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

function SystemGetPermissionText($menuid){
	$Conn = $GLOBALS['Conn'];
	
	$sql = "select controlaccess  from sysusergroupaccess ";
	$sql .= " where usergroupcode='".$_SESSION['UserGroupCode']."'";
	$sql .= " and menuid='".$menuid."'";

	
	$Conn->query($sql);
	$Row = $Conn->getResult();
	$access= trim($Row[0]["controlaccess"]);
	
	if($access==""){
		$access="HIDE";
	}
	
	return $access;
}


function SystemGetModuleOption($menuid){
	
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




function SystemPaging($source) {
	
	//ItemPerPage
	$ItemPerPageSource = $GLOBALS['ItemPerPageSource'];
	
	
	$Page			= $source["Page"];
	$PageSize		= $source["PageSize"];
	$TotalRec		= $source["TotalRec"];
	$CntRecInPage	= $source["CntRecInPage"];
	$Type			= $source["Type"];
	/*
	$RecNow = (($Page-1)*$PageSize)+1;
	$MaxPage = ceil($TotalRec/$PageSize);
	*/
	
	$Page = ($Page*1==0) ? 1 : $Page;
	$PageTotal=ceil($TotalRec/$PageSize);	
	/*
	$s_page=(($Page-1)*$PageSize)+1;
	$e_page=($s_page+$PageSize)-1;
	
	if ($e_page>$DataTotal) $e_page=$DataTotal;
	*/
	
	$LastPage=$Page-1;
	$NextPage=$Page+1;
	
	
	if($Page>=$PageTotal){	
		$_onNextPage="void(0)";
	}else{
		$_onNextPage="sysListPage('$NextPage')";	
	}
	
	if($Page<2){
		$_onLastPage="void(0)";
	}else{
		$_onLastPage="sysListPage('$LastPage')";	
	}
	
	
	?>
    


<? if($Type=="HEAD"){ ?>

<? } ?>



<div class="row-fluid" >
<div class="span4">
<div class="dataTables_info">
<strong><?=$TotalRec?> <?=_Items_?></strong>
</div>
</div>
<div class="span8">
<div class="dataTables_paginate paging_bootstrap pagination">
<ul>
<li class="prev  <? if($_onLastPage=="void(0)"){?>disabled <? } ?> "><a href="javascript:<?=$_onLastPage?>;"><i class="icon-chevron-left"></i> </a></li>
<li class="disabled" ><a style="background-color:#fff;" href="javascript:void(0)"><?=_Pages_?> : <?=$Page?>/<?=$PageTotal?></a></li>
<li class="next <? if($_onNextPage=="void(0)"){?>disabled <? } ?> "><a  href="javascript:<?=$_onNextPage?>;"> <i class="icon-chevron-right"></i></a></li>
</ul>
</div>
 
<select style="width:115px;float:right; margin-right:20px;" class="input-small"  onchange="sysListPerPage(this.value);">
<option><?=_Items_?>/<?=_Page_?></option>
 <?=SystemArraySelect($ItemPerPageSource,$PageSize);?>     		          
</select>

<div class="input-append" style="float:right; margin-right:10px;">
<input type="text" id="GoToPage"  class="input-mini" >
<button class="btn" onclick="sysListGOPage();"><i class="icon-chevron-right"></i></button>
</div>


</div>
</div>


<?	
}
?>