<?php 
	ob_start();
	session_start();
	$pref='/var/www/html/erp/';
	$db=$_SESSION['CmpDatabase'];
	$post_data = array();

     $post_data[] = urlencode('CmpID') . '=' . urlencode($_SESSION['CmpID']);
     $post_data[] = urlencode('AdminID') . '=' . urlencode($_SESSION['AdminID']);
     $post_data[] = urlencode('AdminType') . '=' . urlencode($_SESSION['AdminType']);   
     $post_data[] = urlencode('TodayDate') . '=' . urlencode($_SESSION['TodayDate']);    
     $post_data[] = urlencode('CmpDatabase') . '=' . urlencode($_SESSION['CmpDatabase']);
     $post_data[] = urlencode('SyncButton') . '=' . urlencode('1');
         
     $post_data = implode('&', $post_data);///opt/lampp/htdocs/
     //pr($post_data,1);    
   // echo  $cmd="/usr/bin/php ".$pref."admin/importInvoice.php  '".$post_data."'"; 
 //   die;
///echo   $cmd= 'php '.$pref."admin/importInvoice.php  '".$post_data."'"; die;


$cmd= 'php '.$pref."admin/importPayment.php  '".$post_data."'"; 

 $_SESSION['importPaymentProcess']=$command =exec($cmd.' > /dev/null & echo $!;', $output, $return);
//$_SESSION['importPaymentProcess']=$command = exec("( $cmd  > /dev/null &);" . "echo $$;",$output);  


 $cmd= 'php '.$pref."admin/importCustomer.php  '".$post_data."'"; 
 $_SESSION['importCustomerProcess']=$command =exec($cmd.' > /dev/null & echo $!;', $output, $return);
//$cmd="/usr/bin/php ".$pref."admin/importCustomer.php  '".$post_data."'"; 
//$_SESSION['importCustomerProcess']=$command = exec("( $cmd  > /dev/null &);" . "echo $$;",$output);    

 $cmd= 'php '.$pref."admin/importProduct.php  '".$post_data."'"; 
 $_SESSION['importProductProcess']=$command =exec($cmd.' > /dev/null & echo $!;', $output, $return);
 
//$cmd="/usr/bin/php ".$pref."admin/importProduct.php  '".$post_data."'"; 
//$_SESSION['importProductProcess']=$command = exec("( $cmd  > /dev/null &);" . "echo $$;",$output);    

 
 $cmd= 'php '.$pref."admin/importInvoice.php  '".$post_data."'"; 
 $_SESSION['importInvoiceProcess']=$command =exec($cmd.' > /dev/null & echo $!;', $output, $return);
 
 
//$cmd="/usr/bin/php ".$pref."admin/importInvoice.php  '".$post_data."'"; 
//$_SESSION['importInvoiceProcess']=$command = exec("( $cmd  > /dev/null &);" . "echo $$;",$output);

$cmd= 'php '.$pref."admin/importUpdatefee.php  '".$post_data."'"; 
$command =exec($cmd.' > /dev/null & echo $!;', $output, $return);
 

				$_SESSION['mess_phone']='Importing hostbill data in proccess';
	 			header("Location:".'finance/hostbillCustomer.php');
				exit;		
	 			die();

?>
