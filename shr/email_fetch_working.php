<?php 
set_time_limit(4000);
 
// Connect to gmail
//$imapPath = '{imap.gmail.com:993/ssl/novalidate-cert}[Gmail]/All Mail';

//$imapPath ='{imap.gmail.com:993/imap/ssl}INBOX';
$imapPath ='{imap.mail.yahoo.com:993/imap/ssl}INBOX';
$username = 'shravan_33731@yahoo.co.in';
$password = '822129';
 
// try to connect
$inbox = imap_open($imapPath,$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error());

$emails = imap_search($inbox,'UNSEEN');

print_r($emails); exit;

$output = '';
 
foreach($emails as $mail) {
  
  
$headerInfo = imap_headerinfo($inbox,$mail);
$output .= $headerInfo->subject.'<br/>';
$output .= $headerInfo->toaddress.'<br/>';
$output .= $headerInfo->date.'<br/>';
$output .= $headerInfo->fromaddress.'<br/>';
$output .= $headerInfo->reply_toaddress.'<br/>';





$emailStructure = imap_fetchstructure($inbox,$mail);
if(!isset($emailStructure->parts)) {
//$output .= imap_body($inbox, $mail, FT_PEEK);
} else {
    //
}
   echo $output;
   $output = '';
   
   
   
}
 
// colse the connection
imap_expunge($inbox);
imap_close($inbox);



?>