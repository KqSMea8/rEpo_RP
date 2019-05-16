<?php 
	ob_start();
	session_start();

//$command = exec("(/usr/bin/php /var/www/html/erp/admin/finance/importPayment.php > /dev/null &);" . "echo $$;",$output); 
    
    
    

//$command =  '/usr/bin/php /var/www/html/erp/admin/importPayment.php' . ' > /dev/null 2>&1 & echo $!; ';
//$pid = exec($command, $output);
//var_dump($pid);
$pref='/var/www/html/erp/';
	$db=$_SESSION['CmpDatabase'];
	$post_data = array();



     $post_data[] = urlencode('CmpID') . '=' . urlencode($_SESSION['CmpID']);
     $post_data[] = urlencode('AdminID') . '=' . urlencode($_SESSION['AdminID']);
     $post_data[] = urlencode('AdminType') . '=' . urlencode($_SESSION['AdminType']);   
     $post_data[] = urlencode('TodayDate') . '=' . urlencode($_SESSION['TodayDate']);    
     $post_data[] = urlencode('CmpDatabase') . '=' . urlencode($_SESSION['CmpDatabase']);
     $post_data[] = urlencode('SyncButton') . '=' . urlencode('1');
     /*foreach ($_POST as $k => $v)
        {
            $post_data[] = urlencode($k) . '=' . urlencode($v);
        }*/
     $post_data = implode('&', $post_data);///opt/lampp/htdocs/
     //pr($post_data,1);
    /* $pid = exec('php /var/www/html/erp/cron/AmazonProductUpdate.php 
"'.$post_data.'" > /dev/null & echo $!;', $output, $return);*/
     //echo $cmd="/usr/bin/php ".$pref."admin/importInvoice.php  '".$post_data."'";  die;

$cmd="/usr/bin/php ".$pref."admin/importPayment.php  '".$post_data."'"; 
$command = exec("( $cmd  > /dev/null &);" . "echo $$;",$output);  


$cmd="/usr/bin/php ".$pref."admin/importCustomer.php  '".$post_data."'"; 
$command = exec("( $cmd  > /dev/null &);" . "echo $$;",$output);    

$cmd="/usr/bin/php ".$pref."admin/importProduct.php  '".$post_data."'"; 
$command = exec("( $cmd  > /dev/null &);" . "echo $$;",$output);    

$cmd="/usr/bin/php ".$pref."admin/importInvoice.php  '".$post_data."'"; 
$command = exec("( $cmd  > /dev/null &);" . "echo $$;",$output);   

				$_SESSION['mess_phone']='Hostbill data import is in process.';
	 			header("Location:".'finance/hostbillCustomer.php');
				exit;		
	 			die();

//print_r($output);
// $PID = shell_exec("nohup nice -n 0 $cmd 2> /dev/null & echo $!");
// echo $PID;
//exec(sprintf("%s > %s 2>&1 & echo $! >> %s", $cmd, $outputfile, $pidfile));
//print_r($outputfile);
//echo '<br>';
//print_r($pidfile);
    
   // print_R($output);
  //exec($command, $out);

?>
