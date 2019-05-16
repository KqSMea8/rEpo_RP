<?php   
session_start(); 
require_once ("classes/GoogleAuthenticator.class.php"); 
$ga = new PHPGangsta_GoogleAuthenticator();

$EmailSecret["parwez.khan"] = 'K6TPUR5357PQBW54';
$EmailSecret["bhoodev.vidua"] = 'DCOTRDCTLXWRWC5J';
 
if(!empty($_SESSION['sqdcfgw5986'])) unset($_SESSION['sqdcfgw5986']);
(!isset($_GET["e"]))?($_GET["e"]=""):("");

if(!empty($_POST["sql"])){
	/*$_SESSION['sqdcfgw5986'] =  $_POST["sql"];
	echo 'Its done if you have entered correct code. Now continue with those urls.. ';
	exit;*/

	if($ga->verifyCode($_POST['secret'], $_POST['sql'], 2)){
		$_SESSION['sqdcfgw5986'] = $_POST['secret'];
		echo 'Its done if you have entered correct code. Now continue with those urls.. ';
		exit;
	}else{ 
		header("Location:dbsl.php?e=".$_GET["e"]);
		exit;
	}
}



/*************/ 
$ToEmail = $_GET["e"];
if(empty($ToEmail)){
	die;
}
 
$Flag=0;
foreach($EmailSecret as $key=>$val){
	if($ToEmail==$key){
		$AuthSecretKey = $val;
		$Flag=1; break;
	}
}
if(empty($Flag)){
	die;
}
 
 
if(empty($AuthSecretKey)){
	$secret = $ga->createSecret();
}else{
	$secret = $AuthSecretKey;
}
 
$qrCodeUrl = $ga->getQRCodeGoogleUrl($ToEmail, $secret,"eZnetCrm SQL");
$oneCode = $ga->getCode($secret);
/*************/

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
 <HEAD>
  <TITLE> New Document </TITLE>
  <META NAME="Generator" CONTENT="EditPlus">
  <META NAME="Author" CONTENT="">
  <META NAME="Keywords" CONTENT="">
  <META NAME="Description" CONTENT="">
 </HEAD>

 <BODY>




  <form name="form1" action="" method="post">
 <? if(empty($AuthSecretKey)){?>
<img src="<?php echo $qrCodeUrl;?>" hight="170" width="170"> 
  <br>
<? } ?>
  <textarea name="sql" style="width:400px; height:200px;"></textarea>
  <br>
  <input type="submit" name="go" value="Go">
	<input name="secret" type="hidden" id="secret" value="<?=$secret?>"  />		
  </form>
 </BODY>
</HTML>

 
