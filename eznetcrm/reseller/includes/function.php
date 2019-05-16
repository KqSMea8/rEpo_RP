<?php 
require_once("includes/settings.php"); 
function showBanner(){
$data =array();
 $sql = "SELECT * FROM banner WHERE Status = 'Yes'  ORDER BY id DESC ";
 $res = mysql_query($sql);
while($result=mysql_fetch_array($res)){
 $data[]=$result;
}
return $data;
}


	
	function ValidateCrmSession(){
		global $Config;	
		if($_SESSION['CrmRsID']  == '') {
			$RedirectLoginUrl = 'user.php';
			echo '<script>location.href="'.$RedirectLoginUrl.'";</script>';
			exit;
		}
	}

	function IsCrmSession(){	
		global $Config;	
		if($_SESSION['CrmRsID']  != '') {
			$RedirectLoginUrl = 'dashboard.php';
			echo '<script>location.href="'.$RedirectLoginUrl.'";</script>';
			exit;
		}
	}

	
function homePageContent($slug){
 $sql = "SELECT * FROM pages WHERE UrlCustom = '$slug' ";
 $res = mysql_query($sql);
 $result=mysql_fetch_array($res);
 return  $result;
}
function getHeaderMenu($slug=''){
	
$menuDta=array();
 $sql="SELECT pages.Priority,pages.Name,pages.id,pages.UrlCustom,pages.Title FROM menu INNER JOIN pages ON menu.page_id = pages.id WHERE menu.slug= '$slug' ORDER BY pages.Priority";
 $res = mysql_query($sql);
while($result=mysql_fetch_array($res)){
 $menuDta[]=$result;
}
return $menuDta;

}

function getFooterMenu($slugF=''){
	
$footerMenu=array();
 $sql="SELECT pages.Priority,pages.Name,pages.id,pages.UrlCustom,pages.Title FROM menu INNER JOIN pages ON menu.page_id = pages.id WHERE menu.slug= '$slugF' ORDER BY pages.Priority";
 $res = mysql_query($sql);
while($result=mysql_fetch_array($res)){
 $footerMenu[]=$result;
}
return $footerMenu;
}


function useerSubcription($email){
	$sql="INSERT INTO subcription (email) VALUES ('$email')";
	mysql_query($sql);

}
function getSocialLinks(){
$datasl =array();
$sql="SELECT * FROM social_link WHERE Status = 'Yes' ORDER BY Priority ASC ";
 $res = mysql_query($sql);
while($result=mysql_fetch_array($res)){
 $datasl[]=$result;
}
return $datasl;
}

function getPackFeature(){
$dataspf =array();
$sql="SELECT id,ModuleID,feature FROM package_feature WHERE Status = 'Yes' ORDER BY id ASC ";
 $res = mysql_query($sql);
while($result=mysql_fetch_array($res)){
 $dataspf[]=$result;
}
return $dataspf;
}


function getPack($where=''){
$datasp =array();
$sql="SELECT * FROM packages WHERE Status = 'Yes' $where ORDER BY id ASC LIMIT 0,3";
 $res = mysql_query($sql);
while($result=mysql_fetch_array($res)){
 $datasp[]=$result;
}
return $datasp;
}


function getPackType($where=''){
$dataspt =array();


$sql="SELECT * FROM package_type WHERE Status = 'Yes' $where ORDER BY id ASC ";
 $res = mysql_query($sql);
while($result=mysql_fetch_array($res)){
 $dataspt[]=$result;
}
return $dataspt;
}

function getPackAndPriceById(){
$datasp =array();
 $sql="SELECT * FROM packages WHERE Status = 'Yes' AND package_type='4' ORDER BY id ASC ";
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

?>