<?php 
session_start();
require_once("settings.php");
include ('function.php');

if(isset($_POST['email'])){
	$emial=$_POST['email'];
	$id=useerSubcription($emial);
}

if ($_SESSION["code"] == $_POST["captcha"]) {
    echo "Form Submitted successfully....!";
    
$to = "madhurendra.yadav@gmail.com";
$subject = "Contact Us";

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
	
	</td>
  </tr>
</table>
</Div>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <info@eznetcrm.com>' . "\r\n";
//$headers .= 'Cc: myboss@example.com' . "\r\n";
mail($to,$subject,$message,$headers);

   
} else {
   echo "Wrong TEXT Entered";
}

?>

<?php 
if(isset($_POST['editon'])){
if ($_SESSION["code"] == $_POST["captcha2"]) {
    echo "Form Submitted successfully....!";
    
$to = "madhurendra.yadav@gmail.com";
$subject = "Price Quote";

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

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <info@eznetcrm.com>' . "\r\n";
//$headers .= 'Cc: myboss@example.com' . "\r\n";
mail($to,$subject,$message,$headers);

   
} else {
   echo "Wrong TEXT Entered";
}
}

?>


