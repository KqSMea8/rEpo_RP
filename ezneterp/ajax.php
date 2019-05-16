<?php 
session_start();
require_once("includes/settings.php");
require_once('includes/function.php');

//$Config['AdminEmail'] = 'parwez005@gmail.com';

if(empty($_SERVER['HTTP_REFERER'])){
		echo 'Protected.';exit;
	}


if(isset($_POST['NewsletterEmail'])){
	$NewsletterEmail=$_POST['NewsletterEmail'];
	$id=useerSubcription($NewsletterEmail);exit;
}


if(!isset($_POST['editon'])){

if ($_SESSION["code"] == $_POST["captcha"]) {
    echo "Form submitted successfully....!";
    
$to = $Config['AdminEmail'];
$subject = "eZnetCRM :: Contact Us Enquiry";

$message = "
<Div class='divnormal'>
<table border='0' cellspacing='5' cellpadding='5' class='tablenormal'>
  <tr>
	<td class='blacknormal'>
  
        
       Contact Us Form Details : <BR>
  <BR>
        Name  :  " .$_POST['name']."<BR>
        Email   :  " .$_POST['email']."<BR>
        Phone   :  " .$_POST['phone']."<BR>

     </td>
  </tr>
   <tr>
	<td class='blackbold'>
	 Comments   : <br> " .$_POST['comments']."<BR>
	</td>
  </tr>
</table>
</Div>
";


$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= "From: ".$_POST['name']. "<".$_POST['email'].">\r\n" .
"Reply-To: ".$_POST['email']. "\r\n" .
"X-Mailer: PHP/" . phpversion();


mail($to,$subject,$message,$headers);

   
	} else {
	   echo "Wrong TEXT Entered";
	}

}



if(isset($_POST['editon'])){
if ($_SESSION["code"] == $_POST["captcha"]) {
    echo "Form submitted successfully....!";
    
$to = $Config['AdminEmail'];

$subject = "eZnetCRM :: Price Quote Enquiry";

$message = "
<Div class='divnormal'>
<table border='0' cellspacing='5' cellpadding='5' class='tablenormal'>
  <tr>
	<td class='blacknormal'>
  
        
       Price Quote Form Details : <BR>
  <BR>
        Name  :  " .$_POST['name']."<BR>
        Email   :  " .$_POST['email']."<BR>
        Phone   :  " .$_POST['phone']."<BR>       
        User  :  " .$_POST['user']."<BR>
        Editon   :  " .$_POST['editon']."<BR>    
        Company   :  " .$_POST['company']."<BR>
        Comments   :  " .$_POST['comments']."<BR>

     </td>
  </tr>
   <tr>
	<td class='blackbold'>
	
	</td>
  </tr>
</table>
</Div>
";


$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= "From: ".$_POST['name']. "<".$_POST['email'].">\r\n" .
"Reply-To: ".$_POST['email']. "\r\n" .
"X-Mailer: PHP/" . phpversion();


mail($to,$subject,$message,$headers);

   
} else {
   echo "Wrong TEXT Entered";
}
}

?>


