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
    <link href='https://fonts.googleapis.com/css?family=Kanit:200,500' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="js/modernizr.js"></script>
    <script src="js/jquery/jquery.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    
  </head>
  <body>
      <!-- START HEADER -->
   <?	include('./inc-menu.php');	?>
        <!-- END HEADER -->
        <div class="clearfix"></div>
        <!-- START CONTENT -->
   <article>   
       <?php include("inc-banner-head.php"); ?>
       <section class="content">
           <div class="container">
               <div class="row">
                               <div class="block">
                                   <div class="page-topic">
                                       <span>PRIVACY STATEMENT</span>
                                   </div>
                                       <div class="txt-contact">
                                       
									<?
                                    $sql = "select content_".strtolower($_SESSION['FRONT_LANG'])." as content_html  from webpage where menu_id = 'SFT01'";
                                    
                                    $Conn->query($sql);
                                    $Content = $Conn->getResult();
                                    $Row=$Content[0];	
                                    echo $Row["content_html"];
                                    ?>
                                    
                                         
                                       </div>
                               </div>             
               </div>
           </div>
       </section>
        <section class="ads">
           <div class="container-fluid">
            <div class="row">
                <img src="images/main/ads_bot.png" class="img-responsive align-center">
            </div>
           </div>
       </section>
   </article>
   <div class="clearfix"></div>
        <!-- END  CONTENT -->
   <? include('./inc-footer.php');?>
  </body>
</html>