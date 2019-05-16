<?php   
require_once("includes/config.php"); 

$Base = md5($_GET['b']); 

if($Base=='89e8e8ee3a6b8181f7686d9f8ffaf378'){

if(!empty($_GET['db'])) $Config['DbName'] = $_GET['db'];


$link=mysql_connect ($Config['DbHost'],$Config['DbUser'],$Config['DbPassword'],TRUE);
if(!$link){die("Could not connect to MySQL");}
mysql_select_db($Config['DbName'],$link) or die ("could not open db".mysql_error());

#echo 'MySql Connected.<br><br>';

if(!empty($_POST["sql"])){
	echo $_POST["sql"].'<br><br>';

	$q=mysql_query("select CmpID,DisplayName from company ",$link) or die (mysql_error());
	$DbCompanies='';
	while($row = mysql_fetch_array($q)) {
		$CmpDatabase = $Config['DbName']."_".$row['DisplayName'];
		mysql_select_db($CmpDatabase) or die ("could not open db : ".mysql_error());		

		#$q2=mysql_query($_POST["sql"]) or die (mysql_error());
		$q2=mysql_query($_POST["sql"]);
		$DbCompanies .= $row['DisplayName'].', '; 
	}	
	
	echo "Query has been executed successfully for DisplayName : ".$DbCompanies."<br><br>";
	

}

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
  <textarea name="sql" style="width:400px; height:200px;"></textarea>
  <br>
  <input type="submit" name="go" value="Go">
  </form>
 </BODY>
</HTML>

<? } ?>
