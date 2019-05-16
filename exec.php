<?php
// outputs the username that owns the running php/httpd process
// (on a system with the "whoami" executable in the path)

echo exec('whoami');
$res =  shell_exec('/usr/bin/php /var/www/html/erp/admin/pdfCommon.php 29563 Sales Quote 37 erp_DemoVstacks 212');
//$command = exec("( /usr/bin/php /var/www/html/erp/admin/pdfCommon.php 29599 SalesInvoice Invoice 37 erp_DemoVstacks 196  > /dev/null &);" . "echo $$;",$output);
echo $res;
/*var_dump($res);
print_r($output);*/
//var_dump($output);
//var_dump($return);


/*try{
	$result = shell_exec(sprintf("ps %d", $res));
	if( count(preg_split("/\n/", $result)) > 2){
	    echo 'Done';
	}
}catch(Exception $e){ echo 'Message: ' .$e->getMessage();}*/

?>
 <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type=text/javascript>
$(function() {
	getCurrentStatus();
});

function getCurrentStatus(){  
  var sendParam='';
  sendParam = 'BackgroundExec=Item&pid='+<?=$res?>+'&totalCount=50&randomval='+Math.random();
$.ajax({
    type: "POST",
    async:false,
    url: 'admin/inventory/ajax.php',
    data: sendParam,
    success: function (responseText) { 
		var data = jQuery.parseJSON(responseText);
		console.log(data);
     		if(parseInt(data.per)<=100 && data.status=='1'){ 
			setTimeout(function(){getCurrentStatus();}, 6000);
		}
     		
    }
	});
}
</script>-->
