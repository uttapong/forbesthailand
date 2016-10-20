<? require("../lib/system_core.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

<link rel="stylesheet" href="../../dist/css/bootstrap.min.css" />
<link rel="stylesheet" href="../../assets/css/layout.css" />
<link rel="stylesheet" href="../../assets/css/main.css" />
<style>
body{ background-color:#fff; }
</style>

</head>

<body>
<div id="content_html">

	        		<div id="wrapper">
		        			        		
		        		<div class="inner">
<?
	$sql = "select *  from webpage where menu_id = '$SysMenuID'";
	
	$Conn->query($sql);
	$Content = $Conn->getResult();
	$Row=$Content[0];	
	echo $Row["content"];
	
?>
	<div class="clearfix"></div>
		        		</div>
		        		<!--inner-->
		        	
		        	</div>
		        	<!--wrapper-->
</div>
</body>
</html>