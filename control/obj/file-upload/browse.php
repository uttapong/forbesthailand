<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Browse test</title>

<script type="text/javascript">
function select_image() {
var CKEditorFuncNum = <?php echo $_GET['CKEditorFuncNum']; ?>;
window.parent.opener.CKEDITOR.tools.callFunction( CKEditorFuncNum, 'http://www.extremetech.com/wp-content/uploads/2012/12/Audi-A1.jpg', '' );
self.close();
}
</script>

</head>
<body>

<a href="javascript:select_image();">Insert this image</a>

</body>
</html>