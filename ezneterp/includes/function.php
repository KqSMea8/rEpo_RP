<?php 
require_once("includes/settings.php"); 
//require_once("settings.php"); 
function showBanner(){
$data =array();
 $sql = "SELECT * FROM erp_banner WHERE Status = 'Yes'  ORDER BY id DESC ";
 $res = mysql_query($sql);
while($result=mysql_fetch_array($res)){
 $data[]=$result;
}
return $data;
}


	function ValidateCrmSession(){	
		global $Config;	
		if($_SESSION['CrmAdminID']  == '') {
			$RedirectLoginUrl = 'index.php?slug=user';
			echo '<script>location.href="'.$RedirectLoginUrl.'";</script>';
			exit;
		}
	}

	function IsCrmSession(){	
		global $Config;	
		if($_SESSION['CrmAdminID']  != '') {
			$RedirectLoginUrl = 'index.php?slug=dashboard';
			echo '<script>location.href="'.$RedirectLoginUrl.'";</script>';
			exit;
		}
	}
	
function homePageContent($slug){
 $sql = "SELECT * FROM erp_pages WHERE UrlCustom = '$slug' ";
 $res = mysql_query($sql);
 $result=mysql_fetch_array($res);
 return  $result;
}
function getHeaderMenu($slug=''){
	
$menuDta=array();
 $sql="SELECT erp_pages.Priority,erp_pages.Name,erp_pages.id,erp_pages.UrlCustom,erp_pages.Title FROM erp_menu INNER JOIN erp_pages ON erp_menu.page_id = erp_pages.id WHERE erp_menu.slug= '$slug' ORDER BY erp_pages.Priority";
 $res = mysql_query($sql);
while($result=mysql_fetch_array($res)){
 $menuDta[]=$result;
}
return $menuDta;

}

function getFooterMenu($slugF=''){
	
$footerMenu=array();
 $sql="SELECT erp_pages.Priority,erp_pages.Name,erp_pages.id,erp_pages.UrlCustom,erp_pages.Title FROM erp_menu INNER JOIN erp_pages ON erp_menu.page_id = erp_pages.id WHERE erp_menu.slug= '$slugF' ORDER BY erp_pages.Priority";
 $res = mysql_query($sql);
while($result=mysql_fetch_array($res)){
 $footerMenu[]=$result;
}
return $footerMenu;
}


function useerSubcription($email){
	$sql="INSERT ignore INTO subcription (email) VALUES ('$email')";
	mysql_query($sql);

}
function getSocialLinks(){
$datasl =array();
$sql="SELECT * FROM erp_social_link WHERE Status = 'Yes' ORDER BY Priority ASC ";
 $res = mysql_query($sql);
while($result=mysql_fetch_array($res)){
 $datasl[]=$result;
}
return $datasl;
}

function getPackFeature(){
$dataspf =array();
$sql="SELECT id,ModuleID,feature FROM erp_pack_feature WHERE Status = 'Yes' ORDER BY id ASC ";
//$sql="SELECT id,ModuleID,feature FROM package_feature WHERE Status = 'Yes' ORDER BY id ASC ";
 $res = mysql_query($sql);
while($result=mysql_fetch_array($res)){
 $dataspf[]=$result;
}
return $dataspf;
}


function getPack($where=''){
$datasp =array();
$sql="SELECT * FROM erp_packages WHERE Status = 'Yes' $where ORDER BY id ASC LIMIT 0,3";
 $res = mysql_query($sql);
while($result=mysql_fetch_array($res)){
 $datasp[]=$result;
}
return $datasp;
}


function getPackType($where=''){
$dataspt =array();


$sql="SELECT * FROM erp_package_type WHERE Status = 'Yes' $where ORDER BY id ASC ";
 $res = mysql_query($sql);
while($result=mysql_fetch_array($res)){
 $dataspt[]=$result;
}
return $dataspt;
}

function getPackAndPriceById(){
$datasp =array();
 $sql="SELECT * FROM erp_packages WHERE Status = 'Yes' AND package_type='4' ORDER BY id ASC ";
 $res = mysql_query($sql);
while($result=mysql_fetch_array($res)){
 $datasp[]=$result;
}
return $datasp;
}
function userLogin($email,$password){
	$error='Please Enter Valid User Name And Password';
     $sql="SELECT * FROM company WHERE Email='".$email."' AND Password='".$password."'";
	$res=mysql_query($sql);
	$num_rows = mysql_num_rows($res);
	if($num_rows>0){
	  while ($row = mysql_fetch_array($res)) {
			return $row;
	}
		
	}else{
		return 0;
	}

}


function getDepartNameById($id){
  $sql="SELECT feature FROM erp_pack_feature WHERE id = '".$id."'";
 $res = mysql_query($sql);
  $row = mysql_fetch_row($res);
  return $row[0];
}

//******************************

//*******************************/
?>
