<?php 


set_time_limit(3000); 

/* connect to gmail with your credentials */
//$hostname = '{imap.gmail.com:993/imap/ssl}INBOX';
//$username = ''; # e.g somebody@gmail.com
//$password = '';

$hostname ='{imap.mail.yahoo.com:993/imap/ssl}INBOX';
$username = 'shravan_33731@yahoo.co.in';
$password = '822129';


/* try to connect */
$imap = imap_open($hostname,$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error());



/* get all new emails. If set to 'ALL' instead 
 * of 'NEW' retrieves all the emails, but can be 
 * resource intensive, so the following variable, 
 * $max_emails, puts the limit on the number of emails downloaded.
 * 
 */
$emails = imap_search($imap,'ALL');

/* useful only if the above search is set to 'ALL' */
$max_emails = 16;

if($emails) {
    
    $count = 1;
    
    /* put the newest emails on top */
    rsort($emails);
    
    
    
    foreach($emails as $uid)
    {  
      
        
        echo $uid;
        echo "<br>";
        
       function getBody($uid, $imap)
        {
            $body = $this->get_part($imap, $uid, "TEXT/HTML");
            // if HTML body is empty, try getting text body
            if ($body == "") {
                $body = $this->get_part($imap, $uid, "TEXT/PLAIN");
            }
            return $body;
        }
        
        exit;
        
       
        
        function get_part($imap, $uid, $mimetype, $structure = false, $partNumber = false)
        {
            if (!$structure) {
                $structure = imap_fetchstructure($imap, $uid, FT_UID);
            }
            if ($structure) {
                if ($mimetype == $this->get_mime_type($structure)) {
                    if (!$partNumber) {
                        $partNumber = 1;
                    }
                    $text = imap_fetchbody($imap, $uid, $partNumber, FT_UID);
                    switch ($structure->encoding) {
                        case 3:
                            return imap_base64($text);
                        case 4:
                            return imap_qprint($text);
                        default:
                            return $text;
                    }
                }

                // multipart
                if ($structure->type == 1) {
                    foreach ($structure->parts as $index => $subStruct) {
                        $prefix = "";
                        if ($partNumber) {
                            $prefix = $partNumber . ".";
                        }
                        $data = $this->get_part($imap, $uid, $mimetype, $subStruct, $prefix . ($index + 1));
                        if ($data) {
                            return $data;
                        }
                    }
                }
            }
            return false;
        }

    function get_mime_type($structure)
        {
            $primaryMimetype = ["TEXT", "MULTIPART", "MESSAGE", "APPLICATION", "AUDIO", "IMAGE", "VIDEO", "OTHER"];

            if ($structure->subtype) {
                return $primaryMimetype[(int)$structure->type] . "/" . $structure->subtype;
            }
            //return "TEXT/PLAIN";
        }

        
        
        
        

        
        if($count++ >= $max_emails) break;
    }
        
  }



?>