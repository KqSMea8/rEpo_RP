<?php
$password = 'z4dNKUqh8DE9f';  

$data = shell_exec('mysqldump -h localhost -u root -p'.$password.' erpdefault | mysql -h localhost -u root -p'.$password.' erp_parwez');
print_r($data);
exit;
?>

