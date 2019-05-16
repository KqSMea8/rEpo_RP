<?
/*
shell_exec('mysqldump -h '.$Config['DbHost'].' -u '.$Username.' -p'.$Password.' erpdefault | mysql -h '.$Config['DbHost'].' -u '.$Username.' -p'.$Password.' '.$db_name);
*/

//$cmd="/usr/bin/php /var/www/html/erp/mail.php"; 

$cmd="/usr/bin/php /var/www/html/erp/admin/pdfCommon.php 21898 SalesInvoice Invoice 1 ".$_SESSION['CmpDatabase']; 


/*
$post_data = array();

$post_data[] = urlencode('o') . '=' . urlencode('10204');
$post_data[] = urlencode('ModuleDepName') . '=' . urlencode('SalesInvoice');
$post_data[] = urlencode('module') . '=' . urlencode('Invoice');
$post_data[] = urlencode('attachfile') . '=' . urlencode('1');
$post_data = implode('&', $post_data);
     
$cmd="/usr/bin/php /var/www/html/erp/admin/pdfCommonhtml.php  '".$post_data."'"; 
*/

$command = exec("( $cmd  > /dev/null &);" . "echo $$;",$output);  

print_r($output);

print_r($argv);
?>
