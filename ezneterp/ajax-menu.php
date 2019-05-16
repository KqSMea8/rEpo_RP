<?php 
session_start();
require_once("includes/settings.php");
require_once('includes/function.php');
$sql="SELECT pages.Priority,pages.Name,pages.id,pages.UrlCustom,pages.Title FROM menu INNER JOIN pages ON menu.page_id = pages.id WHERE menu.slug= 'header' ORDER BY pages.Priority";
 $res = mysql_query($sql);
while($result=mysql_fetch_array($res)){
 $menuDta[]=$result;
}
echo json_encode($menuDta);
?>


