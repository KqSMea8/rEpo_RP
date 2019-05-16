<?php
$validate=array(	'price' =>array(
				'value'=>$_POST['price'],
				'rule' =>array('requried','number'),
				'message'=>'Please Select Price!'),
			'country' =>array(
				'value'=>$_POST['country'],
				'rule' =>array('requried'),
				'message'=>'Please Select Event Date!'),			
			'state' =>array(
				'value'=>$state,
				'rule' =>array('requried'),
				'message'=>'Please Enter State!')								
				
			);
 global $objVali;
			$aa=array();
		$errormessages=$objVali->NewValidate($validate);
?>
