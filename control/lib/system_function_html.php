<?
function promptHeadHtml(){
?>
<a href="javascript:MyGlassBox.close();" class="MyGlassBoxClose"></a>
<table  width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="headleft">&nbsp;</td>
    <td class="headcenter">&nbsp; </td>
    <td class="headright">&nbsp;</td>
  </tr>
</table>
<?
}
?>

<?
function promptFooterHtml(){
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="footleft">&nbsp;</td>
    <td class="footcenter">&nbsp;</td>
    <td class="footright">&nbsp;</td>
  </tr>
</table>
<?
}
?>


<?
function promptPleaseWait(){
?>
<div class="MyGlassBox" >
	<? promptHeadHtml(); ?>
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
    <td class="bodyleft">&nbsp;</td>
    <td valign="top" >
        <div class="MyGlassBoxHeader">Please Wait ...</div>
        <div class="MyGlassBoxContent"> Please Wait ...</div>
    <div class="MyGlassBoxFooter"></div>
    
    </td>
    <td  class="bodyright">&nbsp;</td>
    </tr>
    </table>
    <? promptFooterHtml(); ?>
</div>
<?
}
?>

