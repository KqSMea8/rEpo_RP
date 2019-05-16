<?php

//mysql_query('CREATE DATABASE erp_test01');
exec('mysqldump -h localhost -u root -pPyJtCk7TFo  erp_test | mysql -h localhost -u root -pPyJtCk7TFo erp_test01',$output, $return_var);
if ($return_var === 0) {
 echo  "success";
}else{
  echo  "fail";
}
?>