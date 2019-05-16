<?php
class plan extends dbClass
{
	//constructor
	function plan()
	{
		$this->dbClass();
	}

	function  getPlans($PlanId='')
	{

		$sql = "select ppp.* from pos_plan_package ppp
		left join pos_plan_package_element pppe on pppe.package_id=ppp.pckg_id
		where ppp.status ='1' ";
		if($PlanId!='')
		$sql .= " and ppp.pckg_id='".addslashes($PlanId)."'";

		$sql .= " group by  ppp.pckg_id";

		return $this->query($sql, 1);

	}

	function  getelements()
	{

		$sql = "select * from pos_plan_elements  ";

		return $this->query($sql, 1);

	}
	function  getplanelements($PlanId)	{

		$sql = "select * from pos_plan_package_element where package_id= '".addslashes($PlanId)."' ";

		return $this->query($sql, 1);

	}
	
	function registrationEmail($arryDetails)
	{		

		global $Config;
		@extract($arryDetails);
		
	
		
		$FullName = ucfirst($arryDetails['VendorProfile']['FirstName'])." ".ucfirst($arryDetails['VendorProfile']['LastName']);
		$Email=$arryDetails['VendorProfile']['Email'];
		// get email template
		$sql = "select * from pos_email_template where TemplateID= '1' ";
		$emailtemplate= $this->query($sql, 1);
		/**** Email to  Customer ******/
		$ContentMsg = "Congratulations! You have successfully registered with us ";
		$contents = $emailtemplate[0]['Content'];
		
		$contents = str_replace("[SiteUrl]",$Config['SiteUrl'],$contents);		
		$contents = str_replace("[ContentMsg]",$ContentMsg,$contents);		
		$contents = str_replace("[USERNAME]",ucfirst($FullName),$contents);
		$contents = str_replace("[FULLNAME]",$FullName,$contents);
		$contents = str_replace("[EMAIL]",$Email,$contents);
		$contents = str_replace("[PASSWORD]",$arryDetails['VendorProfile']['Password'],$contents);		
		$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
		
		
		
		
		$mail = new MyMailer();  
		$mail->IsMail();
		$mail->AddAddress($Email);
		$mail->sender($Config['StoreName']." - ", $Config['NotificationEmail']);
		$mail->Subject = $emailtemplate[0]['subject'];
		$mail->IsHTML(true);
		$mail->Body = $contents;
			
		if($mail->Send()){  return true;
		} else { 
			return false;
		}
		
	}


}
?>
