<?
require("../lib/system_core.php");
$Sys_Title=_SYSTEM_TITLE_;
$Sys_MainFile[]=array(type=>'javascript',path=>'index.js');
if ($ModuleAction=="") $ModuleAction="Datalist";

?>
<? require("../inc/inc-mainfile.php");?>
<body >
<div id="page-container">
<? require("../inc/inc-web-head.php");?>
<div id="inner-container"  >
<? require("../inc/inc-web-menu.php");?>
<div style="min-height: 726px;" id="page-content"  >
<? require("../inc/inc-web-navigator.php");?>

<? if ($ModuleAction == "AddForm" || $ModuleAction == "EditForm") {}else{ ?>




<!--
<script>
    $(function() {
        var baseURL = 'http://yourdomain.com/ajax/';
        //load content for first tab and initialize
        $('#home').load(baseURL+'home', function() {
            $('#myTabs').tab(); //initialize tabs
        });    
        $('#myTabs').bind('show', function(e) {    
           var pattern=/#.+/gi //use regex to get anchor(==selector)
           var contentID = e.target.toString().match(pattern)[0]; //get anchor         
           //load content for selected tab
            $(contentID).load(baseURL+contentID.replace('#',''), function(){
                $('#myTabs').tab(); //reinitialize tabs
            });
        });
    });
</script>
-->
<div id="datalist-content">

<?
include('index-action.php');
?>
</div>
<? } ?>

</div><!-- page-content -->
<? require("../inc/inc-web-footer.php");?>
</div><!-- inner-container -->
</div>
</body></html>