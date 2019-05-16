<?php
session_start();

$SessionTimeoutBefore=$session_life='';
/****************/ 
if(!empty($_SESSION['SessionTimeout'])){ 	
	$SessionTimeoutBefore = $_SESSION['SessionTimeout'] - 120;
}
/****************/  
if(!empty($_SESSION['start'])){
	$session_life = time() - $_SESSION['start'];
}
if($session_life > $SessionTimeoutBefore){
    echo "EXPIRED";die;
}else{
    echo "NOTEXPIRED";die;
}

?>
