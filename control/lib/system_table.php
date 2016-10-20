<?
	// System
	define("_SYSTEM_TABLE_ACCOUNT_","SYSACC");
	define("_SYSTEM_TABLE_ACCOUNT_GROUP_","SYSACC_GROUP");
	define("_SYSTEM_TABLE_ACCOUNT_IN_GROUP_","SYSACC_IN_GROUP");
	
	
	define("_SYSTEM_TABLE_MENU_","sysmenu");
	
	
	
	define("_SYSTEM_TABLE_UPLOAD_","SYSUPLOAD");
	define("_SYSTEM_TABLE_WEBACESS_","SYSWEBACCESS");
	define("_SYSTEM_TABLE_WEBACESSLOG_","SYSWEBACCESSLOG");
	define("_SYSTEM_TABLE_PROVINCE_","SYSPROVINCE");

	// Module Content
	define("_TABLE_CONTENT_","CONTENT");
	define("_TABLE_CONTENT_FILE_","CONTENT_FILE");
	define("_TABLE_CONTENT_PHOTO_","CONTENT_PHOTO");
	define("_TABLE_CONTENT_HTML_PHOTO_","CONTENT_HTML_PHOTO");
	define("_TABLE_CONTENT_LINK_","CONTENT_LINK");
	define("_TABLE_CONTENT_ACCESS_","CONTENT_ACCESS");
	define("_TABLE_CONTENT_DISCUSS_","CONTENT_DISCUSS");
	define("_TABLE_CONTENT_RATING_","CONTENT_RATING");
	
	// Module Task
	define("_TABLE_TASK_","TASK");
	define("_TABLE_TASK_OWNER_","TASK_OWNER");
	define("_TABLE_TASK_EVENT_","TASK_EVENT");
	define("_TABLE_TASK_EVENT_FILE_","TASK_EVENT_FILE");
	define("_TABLE_TASK_ASSIGN_","TASK_ASSIGN");
	define("_TABLE_TASK_HTML_PHOTO_","TASK_HTML_PHOTO");
	
	
	// Module Customer
	define("_TABLE_CUS_TYPE_","CUSTOMER_TYPE");	
	define("_TABLE_CUS_TYPEPERMIT_","CUSTOMER_TYPEPERMIT");
	
	define("_TABLE_LICENCE_RUNNO_","LICENCE_RUNNO");
	
	
	
	
	define("_TABLE_CUS_","CUSTOMER_MAIN");
	define("_TABLE_AGENT_","AGENT_MAIN");
	define("_TABLE_LICENCE_","LICENCE_MAIN");
	
	define("_TABLE_CONTRACT_","CONTRACT_MAIN");
	define("_TABLE_LICENCE_NO_","LICENCE_NO");
	
	define("_TABLE_INVOICE_","INVOICE_MAIN");

	// Object Table
	define("_TABLE_WHITEBOARD_","WHITEBOARD");
	define("_TABLE_NOTIFICATION_","NOTIFICATION");
	
	
	$source_month[1]=31;
	$source_month[3]=93;
	$source_month[6]=186;
	$source_month[12]=372;
	
	$source_month_thshort['01']='ม.ค.';
	$source_month_thshort['02']='ก.พ.';
	$source_month_thshort['03']='มี.ค.';
	$source_month_thshort['04']='เม.ย.';
	$source_month_thshort['05']='พ.ค.';
	$source_month_thshort['06']='มิ.ย.';
	$source_month_thshort['07']='ก.ค.';
	$source_month_thshort['08']='ส.ค.';
	$source_month_thshort['09']='ก.ย.';
	$source_month_thshort['10']='ต.ค.';
	$source_month_thshort['11']='พ.ย.';
	$source_month_thshort['12']='ธ.ค.';
	
	$source_month_thlong['01']='มกราคม';
	$source_month_thlong['02']='กุมภาพันธ์';
	$source_month_thlong['03']='มีนาคม';
	$source_month_thlong['04']='เมษายน';
	$source_month_thlong['05']='พฤษภาคม';
	$source_month_thlong['06']='มิถุนายน';
	$source_month_thlong['07']='กรกฎาคม';
	$source_month_thlong['08']='สิงหาคม';
	$source_month_thlong['09']='กันยายน';
	$source_month_thlong['10']='ตุลาคม';
	$source_month_thlong['11']='พฤศจิกายน';
	$source_month_thlong['12']='ธันวาคม';
	
	//GOLF
	
	
	$source_status['Y']	=_Enable_;
	$source_status['N']	=_Disable_;
	
	
	$source_approve['Y']	=_Approve_;
	$source_approve['N']	=_Unapprove_;
	
	//publish
	$source_permiss['Y']	= "ใช่ / Yes";
	$source_permiss['N']	= "ไม่ / No";
	
	
	$source_flash_banner['Y']	= "ใช่ / Yes";
	$source_flash_banner['N']	= "ไม่ / No";
	
	
	$ItemPerPageSource[10]="10 "._Per_page_;
	$ItemPerPageSource[20]="20 "._Per_page_;
	$ItemPerPageSource[30]="30 "._Per_page_;
	
	$sourceAdsMenu['HOME_MAIN']				="HOME MENU";
	$sourceAdsMenu['COVER_MAIN']			="COVER MENU";
	$sourceAdsMenu['RICH_MAIN']				="LIST'S RICH";
	$sourceAdsMenu['NEWS_MAIN']				="NEWS ";
	$sourceAdsMenu['PEOPLE_MAIN']			="PEOPLE";
	$sourceAdsMenu['ENTREPRENEUR_MAIN']		="ENTREPRENEURS";
	$sourceAdsMenu['ASIANBIZ_MAIN']			="ASIAN BIZ ";
	$sourceAdsMenu['WORLD_MAIN']			="WORLD ";
	$sourceAdsMenu['FORBES_LIFE_MAIN']		="FORBES LIFE ";
	$sourceAdsMenu['TECHNOLOGY_MAIN']		="TECHNOLOGY ";
	$sourceAdsMenu['COMMENTARIE_MAIN']		="COMMENTARIES ";
	$sourceAdsMenu['LEADERBOARD_MAIN']		="LEADERBOARD ";
	$sourceAdsMenu['FORBES_EVENT_MAIN']		="FORBES EVENT & CONFERENCE ";
	$sourceAdsMenu['FORBES_THAI_MAIN']		="SPECIAL ISSUE ";
	$sourceAdsMenu['VDO_MAIN']				="VDOs ";
	$sourceAdsMenu['PR_NEWS_MAIN']			="PR NEWS ";
	$sourceAdsMenu['TOPLIST_MAIN']			="TOP LIST ";
	$sourceAdsMenu['MOST_POPULAR_MAIN']			="MOST POPULAR ";	
	
	
	
//	$sourceCateMenu['TOPLIST_MAIN']			="TOP LIST ";
//	$sourceCateMenu['MOST_POPULAR_MAIN']			="MOST POPULAR ";	
	
	
	$sourceCateMenu["MNT03"]="NEWS";
	$sourceCateMenu["MNT04"]="PEOPLE";
	$sourceCateMenu["MNT05"]="ENTREPRENEURS";
	$sourceCateMenu["MNT06"]="ASIAN BIZ";
	$sourceCateMenu["MNT07"]="WORLD";
	$sourceCateMenu["MNT08"]="FORBES LIFE";
	$sourceCateMenu["MNT09"]="TECHNOLOGY";
	$sourceCateMenu["MNT10"]="COMMENTARIES";
	$sourceCateMenu["MNT11"]="LEADERBOARD";
	$sourceCateMenu["MNT12"]="FORBES EVENT & CONFERENCE";
	$sourceCateMenu["MNT13"]="SPECIAL ISSUE";
	//$sourceCateMenu["MNT14"]="VDOs";
	$sourceCateMenu["MNT15"]="PR NEWS";
	$sourceCateMenu["MNT16"]="TOP LIST";
	
	
?>