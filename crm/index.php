<?php 
	$Prefix = "../";
	require_once($Prefix."includes/config.php");
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>eZnetCRM &raquo; Admin Panel</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<link href="<?=$Prefix.$Config['AdminCSS']?>" rel="stylesheet" type="text/css">
<link href="<?=$Prefix.$Config['AdminCSS2']?>" type="text/css" rel="stylesheet"  />
<link href="<?=$Prefix.$Config['AdminCSS3']?>" type="text/css" rel="stylesheet"  />

</HEAD>
<body style="font:0;">
	<iframe src="../admin/index.php?crm=1" frameborder="0" height="700px" width="100%"></iframe> 
</body>
</html>
