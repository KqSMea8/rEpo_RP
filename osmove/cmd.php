<?
// https://eznetcrm.com/erp/osmove/cmd.php?pk=93e42d4acf46&cmp=31

$Base = md5($_GET['pk']);
if(!empty($Base) && $Base=='2e5bda28ac98653b0c5ec52b9906845a'){ 
 
	 $cmd="/usr/bin/php /var/www/html/erp/osmove/os_move.php ".$_GET['pk']." ".$_GET['cmp'];
						 
	$command = exec("( $cmd  > /dev/null &);" . "echo $$;",$output);
	echo '<br>success';
}else{
	echo 'error';
}
?>
