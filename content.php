<? require("./lib/system_core.php"); ?>
<?  
$mgroup="HOME_MAIN";  
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?	include('./inc-meta-main.php');	?>
   
  </head>
  <body >
  <center>
  <?
                                    $sql = "select content_".strtolower($_SESSION['FRONT_LANG'])." as content_html  from webpage where menu_id = 'SFT02'";
                                    
                                    $Conn->query($sql);
                                    $Content = $Conn->getResult();
                                    $Row=$Content[0];	
                                    echo $Row["content_html"];
                                    ?>
   </center>                                 
                                    </body>
</html>