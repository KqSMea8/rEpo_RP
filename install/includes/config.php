<?php
	global $Config;

	$Config['DbHost'] 	= 'localhost';
	$Config['DbUser'] 	= 'root';
	$Config['DbPassword']	= 'root';
	$Config['DbName']    	= 'crm';
	$Config['Url']	     	= 'http://192.168.1.138/erp/';
	$Config['Online']   	= '1';

	/************************/
	/************************/
	$Config['DbMain']  = $Config['DbName'];

	$Config['AdminFolder']	= 'admin';
	$Config['EmpFolder']	= 'employee';
	$Config['Currency'] 	= 'USD';
	$Config['CurrencySymbol'] = '$';
	$Config['NumLocation'] 	= '4';  

	$Config['AdminCSS'] 	= "css/admin.css";
	$Config['AdminCSS2'] 	= "css/admin-style.css";
	$Config['AdminCSS3'] 	= "css/admin-ecom-style.css";
	$Config['PrintCSS'] 	= "css/print.css";

	$Config['EmailTemplateFolder']	= 'includes/html/email/';


	$bgcolor ='#ffffff';
	$table_bg =' width="100%" align="center" cellpadding="3" cellspacing="1" id="list_table" ';

	$view = '<img src="'.$Config['Url'].'admin/images/view.png" border="0"  onMouseover="ddrivetip(\'<center>View</center>\', 40,\'\')"; onMouseout="hideddrivetip()" >';
	$edit = '<img src="'.$Config['Url'].'admin/images/edit.png" border="0"  onMouseover="ddrivetip(\'<center>Edit</center>\', 40,\'\')"; onMouseout="hideddrivetip()" >';
	$delete = '<img src="'.$Config['Url'].'admin/images/delete.png" border="0"  onMouseover="ddrivetip(\'<center>Delete</center>\', 40,\'\')"; onMouseout="hideddrivetip()" >';
	$move = '<img src="'.$Config['Url'].'admin/images/move.png" border="0"  onMouseover="ddrivetip(\'<center>Move</center>\', 40,\'\')"; onMouseout="hideddrivetip()" >';
	$search = '<img src="'.$Config['Url'].'admin/images/search.png" border="0"  onMouseover="ddrivetip(\'<center>Search</center>\', 40,\'\')"; onMouseout="hideddrivetip()" >';
	$download = '<img src="'.$Config['Url'].'admin/images/download.png" border="0"  onMouseover="ddrivetip(\'<center>Download</center>\', 60,\'\')"; onMouseout="hideddrivetip()" >';

	
	$Config['SalesCommission'] = 1;
	/************************/
	/************************/
?>
