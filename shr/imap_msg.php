<?php


$hostname ='{imap.mail.yahoo.com:993/imap/ssl}INBOX';
$username = 'shravan_33731@yahoo.co.in';
$password = '822129';

$connection = imap_open($hostname, $username, $password);

$emails = imap_search($connection,'ALL');
$max_emails = 16;
if($emails) {
    
    $count = 1;
    
    /* put the newest emails on top */
    rsort($emails);
    
    
    echo "<pre>";
    
    /* for every email... */
    foreach($emails as $messageNumber) 
    {
$structure = imap_fetchstructure($connection, $messageNumber);

print_r($structure);
$flattenedParts = flattenParts($structure->parts);
 
$count_flattened= count($flattenedParts);
if($count_flattened> 0)
{
foreach($flattenedParts as $partNumber => $part) {
    
        
       if($part->subtype=='HTML')
       {   
              
	switch($part->type) {
		
		case 0:
			// the HTML or plain text part of the email
			echo $message = getPart($connection, $messageNumber, $partNumber, $part->encoding);
			echo "enddddddddddeedddddddddd--";
                        // now do something with the message, e.g. render it
		break;
	
		case 1:
			// multi-part headers, can ignore
	
		break;
		case 2:
			// attached message headers, can ignore
		break;
	
		case 3: // application
		case 4: // audio
		case 5: // image
		case 6: // video
		case 7: // other
			$filename = getFilenameFromPart($part);
			if($filename) {
				// it's an attachment
				 $attachment = getPart($connection, $messageNumber, $partNumber, $part->encoding);
				// now do something with the attachment, e.g. save it somewhere
			}
			else {
				// don't know what it is
			}
		break;
	
	}
        
       } //if end 
	
}

    }//count end 
    
    else {
        
                getSimple($connection,$messageNumber,$structure,0);
        
    }
      if($count++ >= $max_emails) break;          
    }
   }



function flattenParts($messageParts, $flattenedParts = array(), $prefix = '', $index = 1, $fullPrefix = true) {

	foreach($messageParts as $part) {
		$flattenedParts[$prefix.$index] = $part;
		if(isset($part->parts)) {
			if($part->type == 2) {
				$flattenedParts = flattenParts($part->parts, $flattenedParts, $prefix.$index.'.', 0, false);
			}
			elseif($fullPrefix) {
				$flattenedParts = flattenParts($part->parts, $flattenedParts, $prefix.$index.'.');
			}
			else {
				$flattenedParts = flattenParts($part->parts, $flattenedParts, $prefix);
			}
			unset($flattenedParts[$prefix.$index]->parts);
		}
		$index++;
	}

	return $flattenedParts;
			
}

function getPart($connection, $messageNumber, $partNumber, $encoding) {
	
	$data = imap_fetchbody($connection, $messageNumber, $partNumber);
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




function getSimple($mbox,$mid,$p,$partno) {
    // $partno = '1', '2', '2.1', '2.1.3', etc for multipart, 0 if simple
    
    global $htmlmsg,$plainmsg,$charset,$attachments;

    // DECODE DATA
    $data = ($partno)?
        imap_fetchbody($mbox,$mid,$partno):  // multipart
        imap_body($mbox,$mid);  // simple
    // Any part may be encoded, even plain text messages, so check everything.
    if ($p->encoding==4)
         $data = quoted_printable_decode($data);
    elseif ($p->encoding==3)
         $data = base64_decode($data);

    // PARAMETERS
    // get all parameters, like charset, filenames of attachments, etc.
    $params = array();
    if ($p->parameters)
        foreach ($p->parameters as $x)
            $params[strtolower($x->attribute)] = $x->value;
    if ($p->dparameters)
        foreach ($p->dparameters as $x)
            $params[strtolower($x->attribute)] = $x->value;

    // ATTACHMENT
    // Any part with a filename is an attachment,
    // so an attached text file (type 0) is not mistaken as the message.
    if ($params['filename'] || $params['name']) {
        // filename may be given as 'Filename' or 'Name' or both
        $filename = ($params['filename'])? $params['filename'] : $params['name'];
        // filename may be encoded, so see imap_mime_header_decode()
        $attachments[$filename] = $data;  // this is a problem if two files have same name
    }

    // TEXT
    if ($p->type==0 && $data) {
        // Messages may be split in different parts because of inline attachments,
        // so append parts together with blank row.
        if (strtolower($p->subtype)=='plain')
             $plainmsg.= trim($data) ."\n\n";
        else
             $htmlmsg= $data;
        $charset = $params['charset'];  // assume all parts are same charset
    }

    // EMBEDDED MESSAGE
    // Many bounce notifications embed the original message as type 2,
    // but AOL uses type 1 (multipart), which is not handled here.
    // There are no PHP functions to parse embedded messages,
    // so this just appends the raw source to the main message.
    elseif ($p->type==2 && $data) {
         $plainmsg.= $data."\n\n";
    }
    
    echo $htmlmsg;

    // SUBPART RECURSION
    if ($p->parts) {
        foreach ($p->parts as $partno0=>$p2)
            getSimple($mbox,$mid,$p2,$partno.'.'.($partno0+1));  // 1.2, 1.2.1, etc.
    }
}







?>