<?
require("class.phpmailer.php");
require("class.smtp.php");

class MyMailer extends PHPMailer {
    // Set default variables for all new objects
    //public $From     = "cp@accessti.com";
    var $From ;
    var $FromName;
    //var $FromName = "CP Singh";
    //var $Host     = "mail.accessti.com";
    var $Mailer   = "sendmail";                         // Alternative to IsSMTP()
    var $WordWrap = 75;
	var $ContentType= "text/html";   

    // Replace the default error_handler
    function error_handler($msg) {
        print("My Site Error");
        print("Description: ");
        printf("%s", $msg);
        exit;
    }

    // Create an additional function
    function sender($FromName,$FromEmail) 
	{
		$this->From = $FromEmail;
      	$this->FromName = $FromName;
        // Place your new code here
    }
}

?>
