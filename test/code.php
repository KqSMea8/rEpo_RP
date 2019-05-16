<?php
include_once('include/session.php');



  function set_path(){

      $file_path = getcwd(); #Where to write file attachments to //
      
    return $file_path;
  }


$sql_fetch="select * from  email_account";

$sql=mysql_query($sql_fetch);
$fetch_record=mysql_fetch_array($sql);
$username = $fetch_record[1];
$password = $fetch_record[2];


$imapmainbox = "INBOX";

//Select messagestatus as ALL or UNSEEN which is the unread email
$messagestatus = "UNSEEN";

//-------------------------------------------------------------------


$imapaddress = "{imap.gmail.com:993/imap/ssl/novalidate-cert}";


$hostname = $imapaddress . $imapmainbox;

//Open the connection
$connection = imap_open($hostname,$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error());

//Grab all the emails inside the inbox
$emails = imap_search($connection,$messagestatus);

//number of emails in the inbox
$totalemails = imap_num_msg($connection);
  
echo "Total Emails: " . $totalemails . "<br>";
$max_emails = 10;  
if($emails) {

  $count = 1;
  //sort emails by newest first
  rsort($emails);
  
  //loop through every email int he inbox
  foreach($emails as $email_number) {

    //grab the overview and message
   $header = imap_fetch_overview($connection,$email_number,0);

    //Because attachments can be problematic this logic will default to skipping the attachments    
    $message = imap_fetchbody($connection,$email_number,1.1);
         if ($message == "") { // no attachments is the usual cause of this
        $message = imap_fetchbody($connection, $email_number, 1);
    }
    
    //split the header array into variables
    $status = ($header[0]->seen ? 'read' : 'unread');
    $subject = $header[0]->subject;
    $from = $header[0]->from;
    $date = $header[0]->date;
    

       $year  = date('Y');
  $month = date('m');

  $dir_n = $year . "_" . $month;

chmod(getcwd().'/'.$dir_n, 0777);
  if (is_dir(getcwd().'/'.$dir_n)) {
     $path= $dir_n .'/';
  } else {
    mkdir(getcwd().'/'.$dir_n, 0777);
    $path= $dir_n .'/';
  }
$mail_date=explode('+',$date);
   $sql = "INSERT INTO emailtodb_email (IDEmail, EmailFrom, EmailFromP, EmailTo, DateE, DateDb, Subject, Message,Kind) VALUES
        ('".$email_number."',
        '".$from."',
        '".addslashes(strip_tags($from))."',
        '".$username."',
        '".date("Y-m-d H:i:s",strtotime($mail_date[0]))."',
        '".date("Y-m-d H:i:s")."',
        '".addslashes($subject)."',
        '".addslashes($message)."',
 '".'1'."')";
    $rs = mysql_query($sql);
    $newid = mysql_insert_id();

 $structure = imap_fetchstructure($connection, $email_number);
if($subject)
{
$sql_match=mysql_query("select Word  from emailtodb_words");
$i=1;
$so='';
while($record=mysql_fetch_object($sql_match))
{
$search = $record->Word;
if(strpos($subject,$search))

{

$so=$so.','.$search;
}

}

 $searchtext=  implode(',', array_keys(array_flip(explode(',', $so))));
 $strlenth=strlen($searchtext);
$match=substr($searchtext,1,$strlenth-1);
$sql = "UPDATE emailtodb_email SET matchkeyword = '".$match."' WHERE ID = '".$newid."'";

    $rs = mysql_query($sql);
}

if($message)
{
$sql_match=mysql_query("select Word  from emailtodb_words");
$i=1;
$so='';
while($record=mysql_fetch_object($sql_match))
{
$search = $record->Word;
if(strpos($message,$search))

{
$so=$so.','.$search;
}

}

 $searchtext=  implode(',', array_keys(array_flip(explode(',', $so))));
 $strlenth=strlen($searchtext);
$match=substr($searchtext,1,$strlenth-1);
$sql_search=mysql_query("select matchkeyword from emailtodb_email where id='$newid'");
$serach_record=mysql_fetch_array($sql_search);
$match_data=$serach_record[0].','.$match;
$sql = "UPDATE emailtodb_email SET matchkeyword = '".$match_data."' WHERE ID = '".$newid."'";

    $rs = mysql_query($sql);
}

 
 
    
        $attachments = array();
 
        /* if any attachments found... */
        if(isset($structure->parts) && count($structure->parts)) 
        {
            for($i = 0; $i < count($structure->parts); $i++) 
            {
                $attachments[$i] = array(
                    'is_attachment' => false,
                    'filename' => '',
                    'name' => '',
                    'attachment' => ''
                );
 
                if($structure->parts[$i]->ifdparameters) 
                {
                    foreach($structure->parts[$i]->dparameters as $object) 
                    {
                        if(strtolower($object->attribute) == 'filename') 
                        {
                            $attachments[$i]['is_attachment'] = true;
                            $attachments[$i]['filename'] = $object->value;
                        }
                    }
                }
 
                if($structure->parts[$i]->ifparameters) 
                {
                    foreach($structure->parts[$i]->parameters as $object) 
                    {
                        if(strtolower($object->attribute) == 'name') 
                        {
                            $attachments[$i]['is_attachment'] = true;
                            $attachments[$i]['name'] = $object->value;
                        }
                    }
                }
 
                if($attachments[$i]['is_attachment']) 
                {
                    $attachments[$i]['attachment'] = imap_fetchbody($connection, $email_number, $i+1);
 
               
                    if($structure->parts[$i]->encoding == 3) 
                    { 
                        $attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
                    }
                 
                    elseif($structure->parts[$i]->encoding == 4) 
                    { 
                        $attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
                    }
                }
				
            }
	
        }
 
        /* iterate through each attachment and save it */
        foreach($attachments as $attachment)
        {
		
            if($attachment['is_attachment'] == 1)
            {
			
               $filename = $attachment['name'];
                if(empty($filename)) $filename = $attachment['filename'];
 
                if(empty($filename)) $filename = time() . ".dat";
 
                /* prefix the email number to the filename in case two emails
                 * have the attachment with the same file name.
                 */

				$file= $path.$email_number . "-" . $filename;
              $fp = fopen($path.$email_number . "-" . $filename, "w+");
                fwrite($fp, $attachment['attachment']);
                fclose($fp);
				chown($path.$email_number . "-" . $filename, 'apache');
				
/******************** this code has been done for extarcting keyword from file ************************/
 $sql=mysql_query("select Word  from emailtodb_words");
$i=1;
$so='';
while($record=mysql_fetch_object($sql))
{
set_path().'/'.$file;
$search = $record->Word;
     $fileHandle = fopen(set_path().'/'.$file, "r");
        $line = @fread($fileHandle, filesize($file));   
        $lines = explode(chr(0x0D),$line);
        $outtext = "";
        foreach($lines as $thisline)
          {
            $pos = strpos($thisline, chr(0x00));
            if (($pos !== FALSE)||(strlen($thisline)==0))
              {
              } else {
                $outtext .= $thisline." ";
              }
          }
         $outtext = preg_replace("/[^a-zA-Z0-9\s\,\.\-\n\r\t@\/\_\(\)]/","",$outtext);
       // echo  $outtext;
if(strpos($outtext,$search))

{
 $so=$so.','.$search;
}


}
/******************** this code has been done for extarcting keyword from file ************************/
$searchtext=  implode(',', array_keys(array_flip(explode(',', $so))));
$strlenth=strlen($searchtext);
$match=substr($searchtext,1,$strlenth-1);
$sql_search=mysql_query("select matchkeyword from emailtodb_email where id='$newid'");
$serach_record=mysql_fetch_array($sql_search);
$match_data=$serach_record[0].','.$match;

 $sql = "UPDATE emailtodb_email SET matchkeyword = '".$match_data."' WHERE ID = '".$newid."'";
    $rs = mysql_query($sql);
	
		 $sql2 = "INSERT INTO emailtodb_attach (IDEmail, FileNameOrg, Filename,matchkeyword) VALUES
                        ('".$newid."',
                        '".addslashes($filename)."',
                        '".addslashes($path.$email_number . "-" . $filename)."','".$match_data."')";
          $rs_1 = mysql_query($sql2);

            }
 
        }
 

 if($count++ >= $max_emails) 

{
echo "<progress value=\"50%\" max=\"200\">50%</progress>";  
 echo "<meta http-equiv=\"refresh\" content=\"1; url=mail_list.php\">";
}
  }
  
} 
else
  {
echo "<progress value=\"50%\" max=\"200\">50%</progress>";     
echo "No Recent Mail";
echo "<meta http-equiv=\"refresh\" content=\"1; url=mail_list.php\">";
  }  

// close the connection
imap_close($connection);
?>

