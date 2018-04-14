<?php 
$docroot=$_SERVER['DOCUMENT_ROOT'];
//header
require($docroot."/../etc/header.php");
//由于现在没有其他的吧，直接跳转到default吧
Header("Location:/bar.php?bar_id=bar-default");
?>

<!--footer-->
<?php require($docroot."/../etc/footer.php");