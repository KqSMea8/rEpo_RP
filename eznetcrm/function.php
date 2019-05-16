<?php 
require_once("settings.php"); 
function showBanner(){
$data =array();
 $sql = "SELECT * FROM banner WHERE Status = 'Yes'  ORDER BY id DESC ";
 $res = mysql_query($sql);
while($result=mysql_fetch_array($res)){
 $data[]=$result;
}
return $data;
}
function homePageContent($slug){
 $sql = "SELECT * FROM pages WHERE UrlCustom = '$slug' ";
 $res = mysql_query($sql);
 $result=mysql_fetch_array($res);
 return  $result;
}
function getHeaderMenu($slug=''){
	
$menuDta=array();
 $sql="SELECT pages.Name,pages.id,pages.UrlCustom,pages.Title FROM menu INNER JOIN pages ON menu.page_id = pages.id WHERE menu.slug= '$slug'";
 $res = mysql_query($sql);
while($result=mysql_fetch_array($res)){
 $menuDta[]=$result;
}
return $menuDta;

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
$sql="SELECT id,feature FROM package_feature WHERE Status = 'Yes' ORDER BY id ASC ";
 $res = mysql_query($sql);
while($result=mysql_fetch_array($res)){
 $dataspf[]=$result;
}
return $dataspf;
}


function getPack($where=''){
$datasp =array();
$sql="SELECT * FROM packages WHERE Status = 'Yes' $where ORDER BY id ASC ";
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


?>