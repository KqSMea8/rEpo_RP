<?
$Base = md5($_GET['base']); 
$db = $_GET['db'];

if($Base=='ac2be2874d5f920e24fdcfe48eab166d'){
	if(!empty($_GET['db'])){
		$password = 'z4dNKzoYAg1CkLYZYUqh8DE9f';  
	
		/*$filename = $db.'_'.date('Y-m-d').'.sql';
		$data = shell_exec('mysqldump -h localhost -u root -p'.$password.' '.$db.' > /var/www/html/erp/db/'.$filename);
		*/


		
		$filename = $db.'_'.date('Y-m-d').'.sql.gz';
		$filepath = '/prod-data-erp/database-backup/';		
		$MainDir = $filepath."mkb/";						
		if (!is_dir($MainDir)) {
			mkdir($MainDir);
			chmod($MainDir,0777);
		}
 
		$data = shell_exec('mysqldump -h localhost -u root -p'.$password.' '.$db.' | gzip > '.$MainDir.$filename);
		
		echo 'Success: Please check : '.$MainDir.$filename;
	}else{
		echo 'db missing';
	}
}
exit;
?>
