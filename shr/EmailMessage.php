<?php
set_time_limit(3000); 

// server needs to be full server connection string, as in the example below
$server = '{imap.mail.yahoo.com:993/imap/ssl}INBOX';
// another example
//$server = '{pop3.example.com:110/pop3}';
// and put your login and password here
$login = 'shravan_33731@yahoo.co.in';
$password = '822129';

$connection = imap_open($server, $login, $password);


$emails = imap_search($connection,'ALL');

/* useful only if the above search is set to 'ALL' */
$max_emails = 16;


if($emails) {
    
    $count = 1;
    
    /* put the newest emails on top */
    rsort($emails);
    
    
    echo "<pre>";
    
    /* for every email... */
    foreach($emails as $email_number) 
    {

        // the number in constructor is the message number
        $emailMessage = new EmailMessage($connection, $email_number);
        // set to true to get the message parts (or don't set to false, the default is true)
        $emailMessage->getAttachments = false;
        $emailMessage->fetch();
        
        print_r($emailMessage);
        if($count++ >= $max_emails) break;
        continue; 
        
        //print_r($emailMessage->bodyHTML);
        // match inline images in html content
        preg_match_all('/src="cid:(.*)"/Uims', $emailMessage->bodyHTML, $matches);
        
        
        
        

        // if there are any matches, loop through them and save to filesystem, change the src property
        // of the image to an actual URL it can be viewed at
        if(count($matches)) {

                // search and replace arrays will be used in str_replace function below
                $search = array();
                $replace = array();

                foreach($matches[1] as $match) {
                        // work out some unique filename for it and save to filesystem etc
                    
                        $uniqueFilename =  time(). "-" . $emailMessage->attachments[$match]['filename'];
                        
  
                        // change /path/to/images to actual path
                        //file_put_contents(getcwd().'/attach_doc/'.$uniqueFilename, $emailMessage->attachments[$match]['data']);
                        $fp = fopen(getcwd().'/attach_doc/'.$uniqueFilename, "w+");
                
                       fwrite($fp, $emailMessage->attachments[$match]['data']);
                       //fwrite($fp, $cnnnttt);
                       fclose($fp);
                       
                       
                       
                        $search[] = "src=\"cid:$match\"";
                        // change www.example.com etc to actual URL
                        $img_url='/attach_doc/'.$uniqueFilename;
                        
                        $replace[] = "src=\".$img_url\"";
                }

                // now do the replacements
                echo $emailMessage->bodyHTML = str_replace($search, $replace, $emailMessage->bodyHTML);

        }
        
        
        
       
        
                        
        
    }
}

imap_close($connection);
exit;

class EmailMessage {

	protected $connection;
	protected $messageNumber;
	
	public $bodyHTML = '';
	public $bodyPlain = '';
	public $attachments;
	
	public $getAttachments = true;
	
	public function __construct($connection, $messageNumber) {
	
		$this->connection = $connection;
		$this->messageNumber = $messageNumber;
		
	}

	public function fetch() {
		
		$structure = @imap_fetchstructure($this->connection, $this->messageNumber);
                
                
		if(!$structure) {
			return false;
		}
		else {
                    
                        
			$this->recurse($structure->parts);
			return true;
		}
		
	}
	
	public function recurse($messageParts, $prefix = '', $index = 1, $fullPrefix = true) {

		foreach($messageParts as $part) {
			
			$partNumber = $prefix . $index;
			
			if($part->type == 0) {
				if($part->subtype == 'PLAIN') {
					$this->bodyPlain .= $this->getPart($partNumber, $part->encoding);
				}
				else {
					$this->bodyHTML .= $this->getPart($partNumber, $part->encoding);
				}
			}
			elseif($part->type == 2) {
				$msg = new EmailMessage($this->connection, $this->messageNumber);
				$msg->getAttachments = $this->getAttachments;
				$msg->recurse($part->parts, $partNumber.'.', 0, false);
				$this->attachments[] = array(
					'type' => $part->type,
					'subtype' => $part->subtype,
					'filename' => '',
					'data' => $msg,
					'inline' => false,
				);
			}
			elseif(isset($part->parts)) {
				if($fullPrefix) {
					$this->recurse($part->parts, $prefix.$index.'.');
				}
				else {
					$this->recurse($part->parts, $prefix);
				}
			}
			elseif($part->type > 2) {
				if(isset($part->id)) {
					$id = str_replace(array('<', '>'), '', $part->id);
					$this->attachments[$id] = array(
						'type' => $part->type,
						'subtype' => $part->subtype,
						'filename' => $this->getFilenameFromPart($part),
						'data' => $this->getAttachments ? $this->getPart($partNumber, $part->encoding) : '',
						'inline' => true,
					);
				}
				else {
					$this->attachments[] = array(
						'type' => $part->type,
						'subtype' => $part->subtype,
						'filename' => $this->getFilenameFromPart($part),
						'data' => $this->getAttachments ? $this->getPart($partNumber, $part->encoding) : '',
						'inline' => false,
					);
				}
			}
			
			$index++;
			
		}
		
	}
	
	function getPart($partNumber, $encoding) {

		$data = imap_fetchbody($this->connection, $this->messageNumber, $partNumber);
		switch($encoding) {
			case 0: return $data; // 7BIT
			case 1: return $data; // 8BIT
			case 2: return $data; // BINARY
			case 3: return base64_decode($data); // BASE64
			case 4: return quoted_printable_decode($data); // QUOTED_PRINTABLE
			case 5: return $data; // OTHER
		}


	}
	
	function getFilenameFromPart($part) {

		$filename = '';

		if($part->ifdparameters) {
			foreach($part->dparameters as $object) {
				if(strtolower($object->attribute) == 'filename') {
					$filename = $object->value;
				}
			}
		}

		if(!$filename && $part->ifparameters) {
			foreach($part->parameters as $object) {
				if(strtolower($object->attribute) == 'name') {
					$filename = $object->value;
				}
			}
		}

		return $filename;

	}

}