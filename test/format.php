<?
echo $Date = date("Y-m-d");
echo '<br><br>';
echo date("F j, Y", strtotime($Date));
echo '<br><br>';
echo date("F jS, Y", strtotime($Date));
echo '<br><br>';
echo date("jS F, Y", strtotime($Date));
echo '<br><br>';
echo date("j M, Y", strtotime($Date));
echo '<br><br>';
echo date("Y/m/d", strtotime($Date));
echo '<br><br>';
echo date("d/m/Y", strtotime($Date));
echo '<br><br>';
echo date("m/d/Y", strtotime($Date));
echo '<br><br>';
?>