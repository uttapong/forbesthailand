<? 
require("./lib/system_core.php"); 
$article_id= $_REQUEST["article_id"];
$sql = "select p.* from article_main p ";
$sql.= "where  p.id='".$article_id."' ";
$Conn->query($sql);
$Content = $Conn->getResult();
$RowHead=$Content[0];
$link= $_source_url[$RowHead["menu_id"]];	

$link.="?did=".$article_id;

 header( "location: $link" );
 exit(0);
?>
