<?php
/**************************************************/
$ThisPageName = 'themes.php'; $EditPage = 1;
/**************************************************/

include_once("includes/header.php");

require_once("classes/theme.class.php");

(!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
if (class_exists(theme)) {
	$themeObj=new theme();
} else {
	echo "Class Not Found Error !! CMS Class Not Found !";
	exit;
}
$ThemeId = isset($_REQUEST['edit'])?$_REQUEST['edit']:"";
if ($ThemeId && !empty($ThemeId)) {$ModuleTitle = "Edit Menu";}else{$ModuleTitle = "Add Menu";}
$ModuleName = 'Theme ';
$ListTitle  = 'Themes';
$ListUrl    = "themes.php?curP=".$_GET['curP'];


if (!empty($ThemeId))
{
	$arryTheme = $themeObj->getThemeById($ThemeId);
}






$SubHeading = 'Theme';
if (is_object($themeObj)) {

	if ($_POST) {
		$postArray=$_POST;
		if (!empty($ThemeId)) {
			$_SESSION['mess_Page'] = $ModuleName.UPDATED;
			$themeObj->updateTheme($postArray);
		}else{
			$_SESSION['mess_Page'] = $ModuleName.ADDED;
			$themeObj->addTheme($postArray);
			header("location:".$ListUrl);
		}

		if($_FILES['thumb_image']['name']!=''){
			$Compdir=$Prefix."template/".$_SESSION['CmpID']."/";
			$MainDir = $Prefix."template/".$_SESSION['CmpID']."/".$ThemeId."/";
			$CSSMainDir = $Prefix."template/".$_SESSION['CmpID']."/".$ThemeId."/css/";
			$CSSfile=$CSSMainDir.'style.css';
			if (!is_dir($Compdir)) {
				mkdir($Compdir);
				chmod($Compdir,0777);
			}
			if (!is_dir($MainDir)) {
				mkdir($MainDir);
				chmod($MainDir,0777);
			}
			if (!is_dir($CSSMainDir)) {
				mkdir($CSSMainDir);
				chmod($CSSMainDir,0777);
			}
			if (!file_exists($CSSfile)) {
				$fh = fopen($CSSfile, 'wb');
          		fwrite($fh, '');
				fclose($fh);
				chmod($CSSfile, 0777);
			}
			$ImageExtension = GetExtension($_FILES['thumb_image']['name']);

			$imageName = $_FILES['thumb_image']['name'];

			$ImageDestination = $MainDir.$imageName;

			if(!empty($_POST['OldImage']) && file_exists($_POST['OldImage'])){
				$OldImageSize = filesize($_POST['thumb_image'])/1024; //KB
				unlink($_POST['OldImage']);
			}
			if(@move_uploaded_file($_FILES['thumb_image']['tmp_name'], $ImageDestination)){
				$themeObj->UpdateThumbImage($imageName,$ThemeId);
					
			}
		}
	}








}



require_once("includes/footer.php");


?>
