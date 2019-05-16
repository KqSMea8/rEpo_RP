<?php
class email extends dbClass {

    //constructor
    function email() {
        $this->dbClass();
    }

    function ListImportEmailId($adminId) {
        global $Config;
        if($Config['GetNumRecords']==1){
		$Columns = " count(id) as NumCount ";		
	}else{
                if($Config['RecordsPerPage']>0){
		$strSQLQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
                }
		$Columns = "  id,EmailId,DECODE(EmailPassw,'" . $Config['EncryptKey'] . "') as EmailPassw,EmailServer,status,name,usrname,DefalultEmail ";
	}

        $strSQLQuery = "select ".$Columns." from importemaillist where AdminId='" . $adminId . "' and AdminType='" .$_SESSION['AdminType'] . "' ".$strSQLQuery;
        return $this->query($strSQLQuery, 1);
    }

    function AddImportEmailId($arryDetails) {


        $sel = "select EmailId from importemaillist where EmailId='" . $arryDetails['Email'] . "'";
        $ddd = $this->query($sel, 1);
        if (empty($ddd[0]['EmailId'])) {
            $strSQLQuery = "insert into importemaillist(EmailId,EmailPassw,EmailServer,AdminID,AdminType,status,name,usrname,CompID,ImapDetails,SmtpDetails) values ('" . strtolower($arryDetails['Email']) . "',ENCODE('" . $arryDetails['EmailPassw'] . "','" . $Config['EncryptKey'] . "'),'" . $arryDetails['EmailServer'] . "','" . $arryDetails['AdminID'] . "','" . $arryDetails['AdminType'] . "','" . $arryDetails['Status'] . "','" . $arryDetails['Name'] . "','" . $arryDetails['usrname'] . "','" . $_SESSION[CmpID] . "','".$arryDetails['ImapDetails']."','".$arryDetails['SmtpDetails']."')";
            return $this->query($strSQLQuery, 1);
        } else {
            return "AlreadyExist";
        }
    }

    function UpdateImportEmailId($arryDetails) {



        $sel = "select EmailId from importemaillist where EmailId='" . strtolower($arryDetails['Email']) . "' and id!='" . $arryDetails['AddID'] . "'";
        $ddd = $this->query($sel, 1);
        $cnt = count($ddd);
        if ($cnt == 0) {

            if (empty($arryDetails['EmailPassw'])) {
                $strSQLQuery = "update importemaillist set EmailId='" . strtolower($arryDetails['Email']) . "',EmailServer='" . $arryDetails['EmailServer'] . "',AdminID='" . $arryDetails['AdminID'] . "',AdminType='" . $arryDetails['AdminType'] . "',status='" . $arryDetails['Status'] . "',name='" . $arryDetails['Name'] . "',usrname='" . $arryDetails['usrname'] . "',ImapDetails='".$arryDetails['ImapDetails']."',SmtpDetails='".$arryDetails['SmtpDetails']."' where id='" . $arryDetails['AddID'] . "'";
            } else {
                $strSQLQuery = "update importemaillist set EmailId='" . strtolower($arryDetails['Email']) . "',EmailPassw=ENCODE('" . $arryDetails['EmailPassw'] . "','" . $Config['EncryptKey'] . "'),EmailServer='" . $arryDetails['EmailServer'] . "',AdminID='" . $arryDetails['AdminID'] . "',AdminType='" . $arryDetails['AdminType'] . "',status='" . $arryDetails['Status'] . "',name='" . $arryDetails['Name'] . "',usrname='" . $arryDetails['usrname'] . "',ImapDetails='".$arryDetails['ImapDetails']."',SmtpDetails='".$arryDetails['SmtpDetails']."' where id='" . $arryDetails['AddID'] . "'";
            }

            return $this->query($strSQLQuery, 1);
        } else {
            return "AlreadyExist";
        }
    }

    function GetEmailId($Id) {

        $strSQLQuery = "select id,EmailId,DECODE(EmailPassw,'" . $Config['EncryptKey'] . "') as EmailPassw,EmailServer,status,name,usrname,ImapDetails,SmtpDetails from importemaillist where id='" . $Id . "'";
        return $this->query($strSQLQuery, 1);
    }

    function RemoveEmailId($delid) {
        $strSQLQuery = "delete from importemaillist where id='" . $delid . "'";
        return $this->query($strSQLQuery, 1);
    }

    function changeEmailIdStatus($active_id) {


        $strSQLQuery = "update importemaillist set status=(status ^ 1) where id='" . $active_id . "'";
        return $this->query($strSQLQuery, 1);
    }

    function updateDefaultEmailId($defaultEmail_id, $AdminId) {

        if (!empty($AdminId) && !empty($defaultEmail_id)) {
            $strSQLQuery = "update importemaillist set DefalultEmail=0 where AdminID='" . $AdminId . "'";
            $data = mysql_query($strSQLQuery);

            if ($data == 1) {
                $strSQLQuery1 = "update importemaillist set DefalultEmail=1 where AdminID='" . $AdminId . "' and id='" . $defaultEmail_id . "'";
                return $this->query($strSQLQuery1, 1);
            }
        }
    }

    function ListImportEmails($ownerId,$sortkey,$keywords) {
        //echo '<pre>iii';print_r($Config);
	global $Config;
        //echo $sortkey."==".$keywords; exit;                      
        $GetEmailID_qry = "select EmailId from importemaillist where id='" . $ownerId . "'";
        $GetEmailID = $this->query($GetEmailID_qry, 1);
             
        $strSQL='';
        if(empty($sortkey) and !empty($keywords))
        {
          $strSQL .=" and ((From_Email like '%".strtolower(trim($keywords))."%') or (Subject like '%".strtolower(trim($keywords))."%') or (EmailContent like '%".strtolower(trim($keywords))."%') or (TotalRecipient like '%".strtolower(trim($keywords))."%'))";                           
        }
        
        if(($sortkey=='email') and !empty($keywords))
        {
          $strSQL .=" and ((From_Email like '%".strtolower(trim($keywords))."%') or (TotalRecipient like '%".strtolower(trim($keywords))."%'))";                          
        }
        if(($sortkey=='subject') and !empty($keywords))
        {
          $strSQL .=" and (Subject like '%".strtolower(trim($keywords))."%')";                          
        }
        if(($sortkey=='content') and !empty($keywords))
        {
          $strSQL .=" and (EmailContent like '%".strtolower(trim($keywords))."%')";                          
        }
       

	if($Config['GetNumRecords']==1){
		$Columns = " count(autoId) as NumCount ";		
	}else{
                if($Config['RecordsPerPage']>0){
		$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
                }
		$Columns = "  Status,From_Email,autoId,Subject,FlagStatus,ImportedDate,composedDate  ";
	}

          $strSQLQuery = "select ".$Columns." from importedemails where To_Email='" . $GetEmailID[0][EmailId] . "'".$strSQL." and MailType='Inbox' order by composedDate desc ".$strAddQuery;
	
          //echo $strSQLQuery;

        return $this->query($strSQLQuery, 1);
    }
    
    function ListUnReadInboxEmails($ownerId)
    {
        
        $GetEmailID_qry = "select EmailId from importemaillist where id='" . $ownerId . "'";
        $GetEmailID = $this->query($GetEmailID_qry, 1);
        $strSQLQuery = "select * from importedemails where To_Email='" . $GetEmailID[0][EmailId] . "' and MailType='Inbox' and Status=1 order by composedDate desc";

	
        return $this->query($strSQLQuery, 1);
    }
 
 function ListSpamEmails($ownerId,$sortkey,$keywords) {
        global $Config;

        $GetEmailID_qry = "select EmailId from importemaillist where id='" . $ownerId . "'";
        $GetEmailID = $this->query($GetEmailID_qry, 1);
        
        $strSQL='';
        if(empty($sortkey) and !empty($keywords))
        {
          $strSQL .=" and ((From_Email like '%".strtolower(trim($keywords))."%') or (Subject like '%".strtolower(trim($keywords))."%') or (EmailContent like '%".strtolower(trim($keywords))."%') or (Recipient like '%".strtolower(trim($keywords))."%') or (Cc like '%".strtolower(trim($keywords))."%') or (Bcc like '%".strtolower(trim($keywords))."%'))";                           
        }
        
        if(($sortkey=='email') and !empty($keywords))
        {
          $strSQL .=" and ((From_Email like '%".strtolower(trim($keywords))."%') or (Recipient like '%".strtolower(trim($keywords))."%') or (Cc like '%".strtolower(trim($keywords))."%') or (Bcc like '%".strtolower(trim($keywords))."%'))";                          
        }
        if(($sortkey=='subject') and !empty($keywords))
        {
          $strSQL .=" and (Subject like '%".strtolower(trim($keywords))."%')";                          
        }
        if(($sortkey=='content') and !empty($keywords))
        {
          $strSQL .=" and (EmailContent like '%".strtolower(trim($keywords))."%')";                          
        }
        if($Config['GetNumRecords']==1){
		$Columns = " count(autoId) as NumCount ";		
	}else{
                if($Config['RecordsPerPage']>0){
		$strSQLQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
                }
		$Columns = "  Status,From_Email,autoId,Subject,FlagStatus,ImportedDate,composedDate  ";
	}
        
        $strSQLQuery = "select ".$Columns." from importedemails where To_Email='" . $GetEmailID[0][EmailId] . "'".$strSQL." and MailType='Spam' order by composedDate desc".$strSQLQuery;
        //echo $strSQLQuery;                   
        return $this->query($strSQLQuery, 1);
    }

    function fetchEmailsFromServer($activeEmailid,$mailImportType,$NumDays) {
         
        
        $mailImportType;
        unset($_SESSION['Importattcfile']);
        
        $strSQLQuery = "select id,EmailId,DECODE(EmailPassw,'" . $Config['EncryptKey'] . "') as EmailPassw,EmailServer,status,ImapDetails,SmtpDetails from importemaillist where id='" . $activeEmailid . "'";
        $emailData = $this->query($strSQLQuery, 1);

        //$imap_array = array();

        if ($emailData[0][EmailServer] == 'Yahoo') {
            $imapPathInbox = '{imap.mail.yahoo.com:993/imap/ssl/novalidate-cert}Inbox';
            $imapPathSpam = '{imap.mail.yahoo.com:993/imap/ssl/novalidate-cert}Bulk Mail';
            $imapPathSent= '{imap.mail.yahoo.com:993/imap/ssl/novalidate-cert}Sent';
            $imap_array = array($imapPathInbox, $imapPathSpam,$imapPathSent);
            $username = $emailData[0][EmailId];
            $password = $emailData[0][EmailPassw];
        }

        if ($emailData[0][EmailServer] == 'Gmail') {
            $imapPathInbox = '{imap.gmail.com:993/imap/ssl/novalidate-cert}INBOX';
            $imapPathSpam = '{imap.gmail.com:993/imap/ssl/novalidate-cert}[Gmail]/Spam';
            $imapPathSent= '{imap.gmail.com:993/imap/ssl/novalidate-cert}[Gmail]/Sent Mail';
            $imap_array = array($imapPathInbox, $imapPathSpam,$imapPathSent);
            $username = $emailData[0][EmailId];
            $password = $emailData[0][EmailPassw];
        }

        if ($emailData[0][EmailServer] == 'Hotmail') {
            $imapPathInbox = '{imap-mail.outlook.com:993/imap/ssl/novalidate-cert}Inbox';
            $imapPathSpam = '{imap-mail.outlook.com:993/imap/ssl/novalidate-cert}Junk';
            $imapPathSent= '{imap-mail.outlook.com:993/imap/ssl/novalidate-cert}Sent';
            $imap_array = array($imapPathInbox, $imapPathSpam,$imapPathSent);
            $username = $emailData[0][EmailId];
            $password = $emailData[0][EmailPassw];
        }

	 if($emailData[0][EmailServer] == 'Zoho') {
            $imapPathInbox = '{imap.zoho.com:993/imap/ssl/novalidate-cert}INBOX';
            $imapPathSpam = '{imap.zoho.com:993/imap/ssl/novalidate-cert}Spam';
            $imapPathSent= '{imap.zoho.com:993/imap/ssl/novalidate-cert}Sent';
            $imap_array = array($imapPathInbox, $imapPathSpam,$imapPathSent);

            $username = $emailData[0][EmailId];
            $password = $emailData[0][EmailPassw];

        }
        
        if ($emailData[0][EmailServer] == 'Other') {
            
            
            $emailData[0][EmailServer]=$emailData[0][ImapDetails];
            $imapPathInbox = '{'.$emailData[0][ImapDetails].'}Inbox';
            $imapPathSpam = '{'.$emailData[0][ImapDetails].'}Junk E-Mail';
            $imapPathSent= '{mail.ezcloudmail.com:587}Sent Items';
            $imap_array = array($imapPathInbox, $imapPathSpam,$imapPathSent);
            $username = $emailData[0][EmailId];
            $password = $emailData[0][EmailPassw];
     
        }
        

         //for($c=0;$c < count($imap_array);$c++)                       
         foreach ($imap_array as $keys => $imapPath)
            {
            
             $readStatus=1;
             $flagStatus=0;

            if($keys==0){
                $ttype='Inbox';
                $mailttype='Inbox';
                $OrgMailType='Inbox';
                
            }
            if($keys==1){
                $ttype='Spam';
                $mailttype='Spam';
                $OrgMailType='Inbox';
            }
            
            if($keys==2){
                $ttype='Sent';
                $mailttype='Sent';
                $OrgMailType='Sent';
                $readStatus=0;
                $NumDays=2;
                
            }
            
            
            
            if(empty($mailImportType))
            {
                $mailImportType='ALL';
              
            }
            else {
                $mailImportType=$mailImportType;
            }
            
            
            
           if($imapPath!='')
           {   
             
            
               if($_SESSION['AdminType']=='admin')
                {
                   $OwnerEmailId= $_SESSION['AdminEmail'];           
                }else {
                   $OwnerEmailId= $_SESSION['EmpEmail']; 
                }
             
                
               $FromEmail=''; 
               
               if($ttype=='Sent') $FromEmail=$OwnerEmailId;                
             
             if($_GET['em']==1){
           $connection = imap_open($imapPath, $username, $password) or die('Cannot connect to ' . $EmailServer . ': ' . imap_last_error());
            }
            
            $connection = imap_open($imapPath, $username, $password);

       


            if($NumDays==5)
            {
               //code for fetching 5 days before emails from current date
                
                $days_ago = date('d-M-Y', strtotime('-5 days', strtotime(date('Y-m-d'))));
                $emails = imap_search($connection, 'SINCE "'.$days_ago.'"');// working
               
            }else if($NumDays==30)
            {
                
                $days_ago = date('d-M-Y', strtotime('-30 days', strtotime(date('Y-m-d'))));
                $emails = imap_search($connection, 'SINCE "'.$days_ago.'"');// working
                
            }else if($NumDays==2)
            {
                
                //in case of sent emails
                $days_ago = date('d-M-Y', strtotime('-2 days', strtotime(date('Y-m-d'))));
                $emails = imap_search($connection, 'SINCE "'.$days_ago.'"');// working
                
            }
            else {
                
                
                $emails = imap_search($connection,$mailImportType);
            }
            
            
            
            
            $output = '';
            
           

            rsort($emails);
            $count = 1;
            $max_emails = 250;
             
            		
            foreach ($emails as $messageNumber) {
                
                    $EmailExitCount=0;   
          
                   // if($NumDays > 0) {
                       
                  //  }
                
                $headerInfo = imap_headerinfo($connection, $messageNumber);
                if($_GET['d']==1){echo '<pre>';print_r($headerInfo);exit;}
                $UniqueMsgID=$headerInfo->message_id;
                $MsgUdate=$headerInfo->udate;
                
                
                /****checking for existing emails***/
                $EmailExitCount=$this->CheckExistingEmail($messageNumber,$username,$emailData[0][EmailServer],$OwnerEmailId,$UniqueMsgID,$MsgUdate);  
                        if($EmailExitCount > 0)
                       {
                          
                           continue;
                       }
                /****end  for existing emails***/ 
                       
                $recipients='';
                $Cc='';
                for($g=0; $g< count($headerInfo->to);$g++)
                {
                    $recipients.=$headerInfo->to[$g]->mailbox."@".$headerInfo->to[$g]->host.",";           
                }
                
                for($h=0;$h< count($headerInfo->cc);$h++)
                {
                    $Cc.=$headerInfo->cc[$h]->mailbox."@".$headerInfo->cc[$h]->host.",";           
                }
                
                 if(!empty($recipients))
                { 
                   $recipients=rtrim($recipients, ',');
                }
                 
                if(!empty($Cc))
                { 
                   $Cc=rtrim($Cc, ',');
                   $total_recipient = $recipients.",".$Cc;
                }else {
                    
                   $total_recipient = $recipients;           
                }
                
                $OrgDate=$headerInfo->Date;
                $From_Email=$headerInfo->from[0]->mailbox."@".$headerInfo->from[0]->host;
                $To_Email=$emailData[0][EmailId];
                
                $Subject=mysql_real_escape_string($headerInfo->subject);
                $exploded_date=explode(' ',$headerInfo->Date);
                $composedDate=date('Y-m-d',strtotime($headerInfo->Date))." ".$exploded_date[4];
                
                $importFromEmailID=$emailData[0][EmailId];
                $importFromServer=$emailData[0][EmailServer];
                $msgID=$messageNumber;
                
                
                
                
                
                    
                
                                
                $structure = imap_fetchstructure($connection, $messageNumber);

                $flattenedParts = $this->flattenParts($structure->parts);

                $count_flattened = count($flattenedParts);
                
                if ($count_flattened > 0) {

                    //start new code //
                    $attachmentss = array();
                    for ($i = 0; $i < count($structure->parts); $i++) {
                        $attachmentss[$i] = array(
                            'is_attachment' => false,
                            'filename' => '',
                            'name' => '',
                            'attachment' => '',
                            'attach_condition' => ''
                        );



                        if ($structure->parts[$i]->ifdparameters) {
                            foreach ($structure->parts[$i]->dparameters as $object) {
                                if (strtolower($object->attribute) == 'filename') {
                                    $attachmentss[$i]['is_attachment'] = true;
                                    $attachmentss[$i]['filename'] = $object->value;
                                    $attachmentss[$i]['attach_condition'] = $structure->parts[$i]->disposition;
                                }
                            }
                        }

                        if ($structure->parts[$i]->ifparameters) {
                            foreach ($structure->parts[$i]->parameters as $object) {
                                if (strtolower($object->attribute) == 'name') {
                                    $attachmentss[$i]['is_attachment'] = true;
                                    $attachmentss[$i]['name'] = $object->value;
                                    $attachmentss[$i]['attach_condition'] = $structure->parts[$i]->disposition;
                                }
                                //this code is written for hotmail to virtual stacks email //
                                if (strtolower($object->attribute) == 'filename') {
                                    $attachmentss[$i]['is_attachment'] = true;
                                    $attachmentss[$i]['name'] = $object->value;
                                    $attachmentss[$i]['attach_condition'] = $structure->parts[$i]->disposition;
                                }
                                //this code end  hotmail to virtual stacks email //
                            }
                        }

                        if ($attachmentss[$i]['is_attachment']) {
                            $attachmentss[$i]['attachment'] = imap_fetchbody($connection, $messageNumber, $i + 1);

                            /* 4 = QUOTED-PRINTABLE encoding */
                            if ($structure->parts[$i]->encoding == 3) {
                                $attachmentss[$i]['attachment'] = base64_decode($attachmentss[$i]['attachment']);
                            }
                            /* 3 = BASE64 encoding */ elseif ($structure->parts[$i]->encoding == 4) {
                                $attachmentss[$i]['attachment'] = quoted_printable_decode($attachmentss[$i]['attachment']);
                            }
                        }
                    }

                    //print_r($attachmentss);
                    /* iterate through each attachment and save it */

			$MainDir = "upload/emailattachment/".$_SESSION['AdminEmail']."/";						
			if (!is_dir($MainDir)) {
				mkdir($MainDir);
				chmod($MainDir,0777);
			}

                    foreach ($attachmentss as $attachment) {
                        if ($attachment['is_attachment'] == 1) {
                            $filename = $attachment['name'];

                            if (empty($filename))
                                $filename = $attachment['filename'];

                            if (empty($filename))
                                $filename = time() . ".dat";

                            /* prefix the email number to the filename in case two emails
                             * have the attachment with the same file name.
                             */



                            $fp = fopen(getcwd() . "/upload/emailattachment/" . $_SESSION['AdminEmail'] . "/" . $messageNumber . "-" . $filename, "w+");

                            fwrite($fp, $attachment['attachment']);
                            //fwrite($fp, $cnnnttt);
                            fclose($fp);
                            if(($emailData[0][EmailServer] == 'Yahoo') && ($attachment['attach_condition']=='attachment') && !empty($filename))
                            { 
                                $newfilename=$messageNumber."-".$filename;
                                $_SESSION['Importattcfile'][$newfilename]=$newfilename;   
                            }
                            else {
                                $newfilename=$messageNumber."-".$filename;
                                $_SESSION['Importattcfile'][$newfilename]=$newfilename;
                            }
                        }
                    }
                    //end new code //




                    foreach ($flattenedParts as $partNumber => $part) {

                        if ($part->subtype == 'HTML') {

                            switch ($part->type) {

                                case 0:
                                    // the HTML or plain text part of the email
                                    $message = $this->getPart($connection, $messageNumber, $partNumber, $part->encoding);
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
                                    $filename = $this->getFilenameFromPart($part);
                                    if ($filename) {
                                        // it's an attachment
                                        $attachment = $this->getPart($connection, $messageNumber, $partNumber, $part->encoding);
                                        // now do something with the attachment, e.g. save it somewhere
                                    } else {
                                        // don't know what it is
                                    }
                                    break;
                            }
                        } //if end
                        else {

                            if (isset($part->id)) {

                                $id = str_replace(array('<', '>'), '', $part->id);
                                $attachments1[$id] = array(
                                    'type' => $part->type,
                                    'subtype' => $part->subtype,
                                    'filename' => $this->getFilenameFromPart($part),
                                    'data' => '',
                                    'inline' => true,
                                    'b' => '',
                                );
                            }
                        }//else end;
                    }
                }//count end 
                else {

                    $message = $this->getSimple($connection, $messageNumber, $structure, 0);
                }

                $message;

                // match inline images in html content
                preg_match_all('/src="cid:(.*)"/Uims', $message, $matches);

                if (count($matches)) {

                    // search and replace arrays will be used in str_replace function below
                    $search = array();
                    $replace = array();

                    foreach ($matches[1] as $match) {
                        // work out some unique filename for it and save to filesystem etc
                        //echo $emailMessage->attachments[$match]['filename'];
                        $uniqueFilename = $messageNumber . "-" . $attachments1[$match]['filename'];
                        $search[] = "src=\"cid:$match\"";
                        // change www.example.com etc to actual URL
                        $img_url = "upload/emailattachment/".$_SESSION['AdminEmail']."/".$uniqueFilename;

                        $replace[] = "src=\"$img_url\"";
                    }

                    // now do the replacements
                    $message = str_replace($search, $replace, $message);
                }

           
            /***********checking rule for importing emails and importing according to rule************/
                
                
                
               // $readStatus=1;
                //$flagStatus=0;
               // $RuleDataArray[0]["MoveToFolder"]=0;
                $RuleDataArray1=$this->CheckExistRule($From_Email,$emailData[0][EmailId],$_SESSION[AdminID],$_SESSION[CmpID]);
                
                
                
                    if($RuleDataArray1[0]["RuleStatus"] > 0)
                    {

                       $isFlagged= $RuleDataArray1[0]["FlaggedEmail"]; 
                       $isRead= $RuleDataArray1[0]["ReadEmail"];
                       $folderName= $RuleDataArray1[0]["FolderName"];
                       $folderID= $RuleDataArray1[0]["FolderID"];



                       if(($RuleDataArray1[0]["MoveToFolder"]==1) && !empty($folderName)) 
                       {
                           
                           if($folderID > 0)
                           {
                              $FolderDetailss=$this->GetEmailFolderDetails($folderID);
                              if(!empty($FolderDetailss[0]["FolderId"]))
                              {
                                $ttype=$folderName;
                              }else{
                                 $ttype=$mailttype; 
                              }
                           }
                           
                       } else { $ttype=$mailttype; }   

                       if($isRead==1) $readStatus=0;
                       if($isFlagged==1) $flagStatus=1;
                    
                }else {
                    
                   $ttype=$mailttype;           
                }
                
                
                //echo $RuleDataArray[0]["RuleStatus"]."==".$From_Email."==".$ttype."<br>";
            /***********ending rule for importing emails************/     
               //echo $message;
                //insertion into table //  
            $insert_qry="insert into importedemails"
         . "(From_Email,To_Email,OwnerEmailId,emaillistID,Subject,EmailContent,Recipient,Cc,TotalRecipient,MailType,OrgMailType,Action,AdminId,AdminType,CompID,ImportedDate,composedDate,importFromServer,importFromEmailID,msgID,OrgDate,FromDD,FolderId,Status,FlagStatus,UniqueMsgID,MsgUdate,FromEmail)"
         . " values ('".$From_Email."','".$To_Email."','".$OwnerEmailId."','".$activeEmailid."','".$Subject."','".mysql_real_escape_string($message)."','".$recipients."','".$Cc."','".$total_recipient."','".$ttype."','".$OrgMailType."','Import','".$_SESSION['AdminID']."','".$_SESSION['AdminType']."','".$_SESSION['CmpID']."','".date('Y-m-d H:i:s')."','".$composedDate."','".$importFromServer."','".$importFromEmailID."','".$msgID."','".$OrgDate."','".$To_Email."','".$folderID."','".$readStatus."','".$flagStatus."','".$UniqueMsgID."','".$MsgUdate."','".$FromEmail."')";          
         
           
          
           $this->query($insert_qry, 1);
           $new_iid = mysql_insert_id(); 
           /**sachin */
           $EmailContentSize=strlen(mysql_real_escape_string($message));
            $EmailContentSize=$EmailContentSize*0.00098;
            /**sachin */
                //insertion end//  
                if(!empty($_SESSION['Importattcfile'])){
                foreach($_SESSION['Importattcfile'] as $key=>$imgName)
                {
                     //echo $imgName."==".$_SESSION['Importattcfile'][$imgName];
                    
                    $insertattach_qry = "insert into importemailattachments(EmailRefId,FileName) values('" . mysql_real_escape_string($new_iid) . "','" . mysql_real_escape_string($imgName) . "')";
                    $this->query($insertattach_qry, 1);
                     /*code for storage size*/
                    $fileNameWithPathImportedEmail="upload/emailattachment/" . $_SESSION['AdminEmail'] . "/" . $imgName;
                    $this->GetEmailAttactedSizeAdd($fileNameWithPathImportedEmail,$EmailContentSize);
                    /*code for storage size*/
                     unset($_SESSION['Importattcfile'][$imgName]);
                }
                }
                else{
                    $this->EmailImportedSizeIncrease($EmailContentSize);
                }
                
                //if($NumDays > 0){
                        if ($count++ >= $max_emails)
                        {
                            break;
                        }
                //}
                
                
            } // email-messagenumber loop end here
            
        }
            
        }
        
        return "Email Imported";
    }
    
    
    function CheckExistingEmail($msgID,$username,$EmailServer,$OwnerEmailId,$UniqueMsgID,$MsgUdate)
    {
        //echo $msgID."--".$username."--".$EmailServer."--".$OwnerEmailId;exit; 
        
        #$checkemail_qry = "select count(autoId) as TotalCount from importedemails where To_Email='" . $username . "' and OwnerEmailId='".$OwnerEmailId."' and importFromServer='".$EmailServer."' and msgID='".$msgID."' and UniqueMsgID='".$UniqueMsgID."' and MsgUdate='".$MsgUdate."'";

	 $checkemail_qry = "select count(autoId) as TotalCount from importedemails where To_Email='" . $username . "'  and importFromServer='".$EmailServer."' and UniqueMsgID='".$UniqueMsgID."' and MsgUdate='".$MsgUdate."'";

             
	//echo $checkemail_qry;exit;
                
        $CountResult=$this->query($checkemail_qry, 1);
        return $CountResult[0][TotalCount];
    }

    //send email with attachment(if file attached by user)  
    function sendEmailToUser($arrDetails) {
        global $Config;



        extract($arrDetails);

        if (!empty($recipients)) {
            $Message = (!empty($Message)) ? ($Message) : (NOT_SPECIFIED);

            #$CreatedBy = ($arrySale[0]['AdminType'] == 'admin')? ('Administrator'): ($arrySale[0]['CreatedBy']);


            /*             * ******************* */

            $contents = ($mailcontent);

            $mail = new MyMailer();
            $mail->IsMail();
            $mail->AddAddress($recipients);
            if (!empty($Cc))
                $mail->AddCC($Cc);
            if (!empty($Bcc))
                $mail->AddBCC($Bcc);
            //if(!empty($Attachment)) $mail->AddAttachment(getcwd()."/".$Attachment);
            //if(!empty($AttachDocument)){
            //$mail->AddAttachment(getcwd()."/".$AttachDocument);
            //}

            $recipent_arr = explode(',', $recipients);


            $CC_arr = explode(',', $Cc);
            $BCC_arr = explode(',', $Bcc);

            $total_arr = array_merge($recipent_arr, $CC_arr);

            $total_arr = array_unique(array_merge($total_arr, $BCC_arr));

            $total_recipient = implode(',', $total_arr);

            $total_recipient = rtrim($total_recipient, ',');


            $GetConfigId_qry = "select * from importemaillist where EmailId='" . $FromDD . "'";
            $GetConfigId = $this->query($GetConfigId_qry, 1);



            if ($draftId > 0) {
                $getAttachedfile = "select FileName from importemailattachments where EmailRefId='" . $draftId . "'";
                $attached_data = $this->query($getAttachedfile, 1);

                if (count($attached_data) > 0) {
                    $ddd = 0;
                    foreach ($attached_data as $key => $value) {

                        $mail->AddAttachment(getcwd() . "/upload/emailattachment/" . $_SESSION['AdminEmail'] . "/" . $attached_data[$ddd][FileName]);
                        $ddd++;
                    }
                }
            }

            if ($draftId) {
                $insert_qry = "update importedemails set MailType='Sent',composedDate='" . date('Y-m-d H:i:s') . "',Status='0' where autoId = '".$draftId."' ";
                $this->query($insert_qry, 1);
                $new_iid = $draftId;


                //$mail->AddAttachment(getcwd()."/upload/emailattachment/".$_SESSION['AdminEmail']."/".$value);
            } else {
                $insert_qry = "insert into importedemails(OwnerEmailId,emaillistID,Subject,EmailContent,Recipient,Cc,Bcc,FromEmail,TotalRecipient,MailType,Action,ActionMailId,AdminId,ImportedDate,FromDD,AdminType,CompID,From_Email,To_Email,composedDate,OrgMailType,Status) values('" . $_SESSION['AdminEmail'] . "','" . $_SESSION['AdminID'] . "','" . $Subject . "','" . mysql_real_escape_string($contents) . "','" . $recipients . "','" . $Cc . "','" . $Bcc . "','" . $_SESSION['AdminEmail'] . "','" . $total_recipient . "','Sent','Compose','','" . $_SESSION['AdminID'] . "','" . date('Y-m-d H:i:s') . "','" . $FromDD . "','" . $_SESSION[AdminType] . "','" . $_SESSION[CmpID] . "','" . $FromDD . "','','" . date('Y-m-d H:i:s') . "','Sent',0)";
                $this->query($insert_qry, 1);
                $emailContentSezeAdd=strlen(mysql_real_escape_string($contents));
                $emailContentSezeAdd=$emailContentSezeAdd*0.00098;
                $new_iid = mysql_insert_id();
            }
            if (!empty($_SESSION['attcfile'])) {
            foreach ($_SESSION['attcfile'] as $key => $value) {

                $insert_qry = "insert into importemailattachments(EmailRefId,FileName) values('" . $new_iid . "','" . $value . "')";
                $this->query($insert_qry, 1);
                /*storage code*/
                $fileNameWithPath="upload/emailattachment/" . $_SESSION['AdminEmail'] . "/" . $value;
                $this->GetEmailAttactedSizeAdd($fileNameWithPath,$emailContentSezeAdd);
                /*storage code $objCompany=new company();*/
            }

            foreach ($_SESSION['attcfile'] as $key => $value) {

                getcwd() . "/upload/emailattachment/" . $_SESSION['AdminEmail'] . "/" . $value;
                $mail->AddAttachment(getcwd() . "/upload/emailattachment/" . $_SESSION['AdminEmail'] . "/" . $value);
                unset($_SESSION['attcfile'][$value]);
            }
            }
             else{
            $this->EmailImportedSizeIncrease($emailContentSezeAdd);
            }

            $get_fromname = "select name from importemaillist where EmailId='" . $FromDD . "'";
            $data_fromname = mysql_fetch_array(mysql_query($get_fromname));

            $mail->sender($data_fromname[name], $FromDD);
            $mail->Subject = $Subject;
            $mail->IsHTML(true);
            $mail->Body = $contents;
            //echo $recipients.$Cc.$Config['SiteName'].$Config['AdminEmail'].$FromDD.$contents; exit;
            if ($Config['Online'] == '1') {


                $mail->Send();
            }
        }
        return 1;
    }

    function SentItems($AdminEmail, $ItemId, $activeEmailId) {
        global $Config;
        $strQry = '';
        if (!empty($ItemId)) {
            $strQry = " and autoId='" . $ItemId . "'";
        }
        $type = "Sent";
        if (!empty($_GET['type']) && $_GET['type'] == "Draft"){
        $type = "Draft";}
        /***new code for pagging***/
        //echo '<pre>';print_r($Config);
        if($Config['GetNumRecords']==1){
		$Columns = " count(autoId) as NumCount ";		
	}else{
             
                //echo $Config['RecordsPerPage'].'eee'.$Config['StartPage'];
                 if($Config['RecordsPerPage']>0){
		$select_qry .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
                 }
		$Columns = "  Recipient,autoId,Subject,FlagStatus,ImportedDate,Status ";
	}
        /***new code for pagging***/
        $select_qry = "select ".$Columns." from importedemails where FromEmail='" . $AdminEmail . "' and FromDD='" . $activeEmailId . "' and MailType='$type'" . $strQry . " order by composedDate desc ".$select_qry;
        //echo $select_qry;
        return $this->query($select_qry, 1);
    }
    function SentItemsWithSearch($AdminEmail, $ItemId, $activeEmailId,$Sortby,$keyword)
    {   global $Config;
        $strQry = '';
        $strSQL ='';
        $type = "Sent";
        /***new code for pagging***/
        if($Config['GetNumRecords']==1){
		$Columns = " count(autoId) as NumCount ";		
	}else{
                if($Config['RecordsPerPage']>0){
		$select_qry .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
                 }
		$Columns = "  Recipient,autoId,Subject,FlagStatus,ImportedDate,Status ";
	}
        /***new code for pagging***/
        //$select_qry = "select ".$Columns." from importedemails where FromEmail='" . $AdminEmail . "' and FromDD='" . $activeEmailId . "' and MailType='$type'" . $strQry . " order by composedDate desc ".$select_qry;
        
        if(($Sortby=='email') && !empty($keyword))
        {
            
          $strSQL .=" and ((Recipient like '%".strtolower(trim($keyword))."%') or (Cc like '%".strtolower(trim($keyword))."%') or (Bcc like '%".strtolower(trim($keyword))."%'))";                             
          //$select_qry = "select ".$Columns." from importedemails where FromEmail='" . $AdminEmail . "' and FromDD='" . $activeEmailId . "' and MailType='$type'" . $strSQL . " order by composedDate desc ".$select_qry;                      
        }
        if(($Sortby=='subject') && !empty($keyword))
        {
          $strSQL .=" and ((Subject like '%".strtolower(trim($keyword))."%'))";                             
          //$select_qry = "select ".$Columns." from importedemails where FromEmail='" . $AdminEmail . "' and FromDD='" . $activeEmailId . "' and MailType='$type'" . $strSQL . " order by composedDate desc ".$select_qry;                                           
        }
        if(($Sortby=='content') && !empty($keyword))
        {
          $strSQL .=" and ((EmailContent like '%".strtolower(trim($keyword))."%'))";                             
          //$select_qry = "select ".$Columns." from importedemails where FromEmail='" . $AdminEmail . "' and FromDD='" . $activeEmailId . "' and MailType='$type'" . $strSQL . " order by composedDate desc ".$select_qry;                                           
        }
        
        if(($Sortby=='') && !empty($keyword))
        {
          $strSQL .=" and ((Subject like '%".strtolower(trim($keyword))."%') or (EmailContent like '%".strtolower(trim($keyword))."%') or (Recipient like '%".strtolower(trim($keyword))."%') or (Cc like '%".strtolower(trim($keyword))."%') or (Bcc like '%".strtolower(trim($keyword))."%'))";                             
          //$select_qry = "select ".$Columns." from importedemails where FromEmail='" . $AdminEmail . "' and FromDD='" . $activeEmailId . "' and MailType='$type'" . $strSQL . " order by composedDate desc ".$select_qry;                                           
        }
        $select_qry = "select ".$Columns." from importedemails where FromEmail='" . $AdminEmail . "' and FromDD='" . $activeEmailId . "' and MailType='$type'" . $strSQL . " order by composedDate desc ".$select_qry;  
        //echo $select_qry;

        return $this->query($select_qry, 1);                         
    }

    function GetAttachmentFileName($EmailID) {

        $select_attach = "select * from importemailattachments where EmailRefId='" . $EmailID . "'";

        return $this->query($select_attach, 1);
    }

    # Read update

    function updateSendMailStatus($id = null) {
        $sql = "update importedemails set Status = '0' where autoId='".$id."'";
        return $this->query($sql, 1);
    }
    
    # Unread update
    function MarkAsUnRead($id = null) {
       $sql = "update importedemails set Status = '1' where autoId='".$id."'";
       return $this->query($sql, 1);
    }

    # 24 march 15 added by shravan #

    function GoToTrashCan($emailAutoID) {
        $update_query = "update importedemails set MailType='TrashCan',FolderId='0' where autoId='" . $emailAutoID . "'";
	
        return $this->query($update_query, 1);
    }

    function GetTrashEmail($AdminEmail, $ItemId, $activeEmailId) {
        global $Config;
        $strQry = '';
        if (!empty($ItemId)) {
            $strQry = " and autoId='" . $ItemId . "'";
        }
        
        /***new code for pagging***/
        if($Config['GetNumRecords']==1){
		$Columns = " count(autoId) as NumCount ";		
	}else{
                 if($Config['RecordsPerPage']>0){
		$select_qry .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
                 }
		$Columns = "  Recipient,autoId,Subject,FlagStatus,ImportedDate,Status ";
	}
        /***new code for pagging***/
         $select_qry = "select ".$Columns." from importedemails where OwnerEmailId='" . $AdminEmail . "' and FromDD='" . $activeEmailId . "' and MailType='TrashCan'" . $strQry . " order by composedDate desc".$select_qry;
         //echo $select_qry;
        return $this->query($select_qry, 1);
    }
    
    function TrashEmailWithSearch($AdminEmail, $ItemId, $activeEmailId,$Sortby,$keyword) {
        global $Config;
        $strQry ='';
        $strSQL =''; 
         //$select_qry = "select * from importedemails where OwnerEmailId='" . $AdminEmail . "' and FromDD='" . $activeEmailId . "' and MailType='TrashCan'" . $strQry . " order by composedDate desc";
         
         if(($Sortby=='email') && !empty($keyword))
        {
            
          $strSQL .=" and ((From_Email like '%".strtolower(trim($keyword))."%') or (Recipient like '%".strtolower(trim($keyword))."%') or (Cc like '%".strtolower(trim($keyword))."%') or (Bcc like '%".strtolower(trim($keyword))."%'))";                             
          //$select_qry = "select * from importedemails where OwnerEmailId='" . $AdminEmail . "' and FromDD='" . $activeEmailId . "' and MailType='TrashCan'" . $strSQL . " order by composedDate desc";
        }
        if(($Sortby=='subject') && !empty($keyword))
        {
          $strSQL .=" and ((Subject like '%".strtolower(trim($keyword))."%'))";                             
          //$select_qry = "select * from importedemails where OwnerEmailId='" . $AdminEmail . "' and FromDD='" . $activeEmailId . "' and MailType='TrashCan'" . $strSQL . " order by composedDate desc";
        }
        if(($Sortby=='content') && !empty($keyword))
        {
          $strSQL .=" and ((EmailContent like '%".strtolower(trim($keyword))."%'))";                             
          //$select_qry = "select * from importedemails where OwnerEmailId='" . $AdminEmail . "' and FromDD='" . $activeEmailId . "' and MailType='TrashCan'" . $strSQL . " order by composedDate desc";
        }
        
        if(($Sortby=='') && !empty($keyword))
        {
          $strSQL .=" and ((Subject like '%".strtolower(trim($keyword))."%') or (EmailContent like '%".strtolower(trim($keyword))."%') or (From_Email like '%".strtolower(trim($keyword))."%') or (Recipient like '%".strtolower(trim($keyword))."%') or (Cc like '%".strtolower(trim($keyword))."%') or (Bcc like '%".strtolower(trim($keyword))."%'))";                             
          //$select_qry = "select * from importedemails where OwnerEmailId='" . $AdminEmail . "' and FromDD='" . $activeEmailId . "' and MailType='TrashCan'" . $strSQL . " order by composedDate desc";
        }
        /***new code for pagging***/
        if($Config['GetNumRecords']==1){
		$Columns = " count(autoId) as NumCount ";		
	}else{
                if($Config['RecordsPerPage']>0){
		$select_qry .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
                }
		$Columns = "  Recipient,autoId,Subject,FlagStatus,ImportedDate,Status ";
	}
        /***new code for pagging***/
        
        $select_qry = "select ".$Columns." from importedemails where OwnerEmailId='" . $AdminEmail . "' and FromDD='" . $activeEmailId . "' and MailType='TrashCan'" . $strSQL . " order by composedDate desc".$select_qry; 
          //echo $select_qry; 
         return $this->query($select_qry, 1);
    }

    function DeletePermanentEmail($emailuniqueId) {
        /*code for email content*/
        global $Config;
     //$objCompany=new company();
            $EmailContentPermanentDelete="SELECT EmailContent  FROM `importedemails` WHERE `autoId` = '".$emailuniqueId."' ORDER BY `autoId` DESC";
            $EmailContentPermanentDel = $this->query($EmailContentPermanentDelete, 1);
            
            $EmailContentSizeDel=strlen($EmailContentPermanentDel[0]['EmailContent']);
            $EmailContentSizeDell=$EmailContentSizeDel*0.00098;
            //echo $EmailContentSizeDel;die;
            
        /*code for email content*/

        $delete_email_qry = "delete from importedemails where autoId='" . $emailuniqueId . "'";

        $delet_qry = mysql_query($delete_email_qry) or mysql_error('mysql_error');

        if ($delet_qry == 1) {

            $select_attachment_file = "select FileName from importemailattachments where EmailRefId='" . $emailuniqueId . "'";
            $attach_val = $this->query($select_attachment_file, 1);
            if (count($attach_val) > 0) {
                foreach ($attach_val as $key => $filename) {

                    /*email file size delete code*/
                    $this->GetEmailAttactedSizeDelete("upload/emailattachment/" . $_SESSION['AdminEmail'] . "/" . $filename[FileName],$EmailContentSizeDell);
                    /*email file size delete code*/
                    unlink(getcwd() . "/upload/emailattachment/" . $_SESSION['AdminEmail'] . "/" . $filename[FileName]);
                    $delete_attach_row = "delete from importemailattachments where EmailRefId='" . $emailuniqueId . "'";
                    $this->query($delete_attach_row, 1);
                }
            }
            else{
            $this->EmailImportedSizeDelete($EmailContentSizeDell);
            }
        }
    }

 /* function ViewEmail16july2015($AdminEmail, $ItemId) {

        $strQry = '';
        if (!empty($ItemId)) {
            $strQry = " and autoId='" . $ItemId . "'";
        }
        $select_qry = "select * from importedemails where OwnerEmailId='" . $AdminEmail . "'" . $strQry . " order by composedDate desc";

        return $this->query($select_qry, 1);
    }*/

function ViewEmail($AdminEmail, $ItemId) {
        $strQry = '';
        if (!empty($ItemId)) {
            $strQry = "autoId='" . $ItemId . "'";
            $select_qry = "select * from importedemails where " . $strQry . " order by composedDate desc";
        }
        //$select_qry = "select * from importedemails where OwnerEmailId='" . $AdminEmail . "'" . $strQry . " order by composedDate desc";
        return $this->query($select_qry, 1);
    }


    # 24 march 15 end #
    # draft

    function draftItems($AdminEmail, $ItemId, $activeEmailId) {
        global $Config;
        $strQry = '';
        /***new code for pagging***/
        //echo '<pre>';print_r($Config);
        if($Config['GetNumRecords']==1){
		$Columns = " count(autoId) as NumCount ";		
	}else{
             
                //echo $Config['RecordsPerPage'].'eee'.$Config['StartPage'];
                if($Config['RecordsPerPage']>0){
		$select_qry .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
                 }
		$Columns = "  Recipient,autoId,Subject,FlagStatus,ImportedDate,Status ";
	}
        /***new code for pagging***/
        if (!empty($ItemId)) {
            $strQry .= " and autoId='" . $ItemId . "'";
        }
        $select_qry = "select ".$Columns." from importedemails where FromEmail='" . $AdminEmail . "' and FromDD='" . $activeEmailId . "' and MailType='Draft'" . $strQry . " order by composedDate desc".$select_qry;
        //echo $select_qry;die;
        return $this->query($select_qry, 1);
    }
    
    function draftEmailWithSearch($AdminEmail, $ItemId, $activeEmailId,$Sortby,$keyword) {
        global $Config;
        $strQry = '';
        $strSQL='';
        /***new code for pagging***/
        //echo '<pre>';print_r($Config);
        if($Config['GetNumRecords']==1){
		$Columns = " count(autoId) as NumCount ";		
	}else{
             
                //echo $Config['RecordsPerPage'].'eee'.$Config['StartPage'];
                if($Config['RecordsPerPage']>0){
		$select_qry .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
                }
		$Columns = "  Recipient,autoId,Subject,FlagStatus,ImportedDate,Status ";
	}
        /***new code for pagging***/
        //$select_qry = "select * from importedemails where FromEmail='" . $AdminEmail . "' and FromDD='" . $activeEmailId . "' and MailType='Draft'" . $strQry . " order by composedDate desc";

        if(($Sortby=='email') && !empty($keyword))
        {
            
          $strSQL .=" and ((Recipient like '%".strtolower(trim($keyword))."%') or (Cc like '%".strtolower(trim($keyword))."%') or (Bcc like '%".strtolower(trim($keyword))."%'))";                             
          //$select_qry = "select * from importedemails where FromEmail='" . $AdminEmail . "' and FromDD='" . $activeEmailId . "' and MailType='Draft'" . $strSQL . " order by composedDate desc";
        }
        if(($Sortby=='subject') && !empty($keyword))
        {
          $strSQL .=" and ((Subject like '%".strtolower(trim($keyword))."%'))";                             
          //$select_qry = "select * from importedemails where FromEmail='" . $AdminEmail . "' and FromDD='" . $activeEmailId . "' and MailType='Draft'" . $strSQL . " order by composedDate desc";
        }
        if(($Sortby=='content') && !empty($keyword))
        {
          $strSQL .=" and ((EmailContent like '%".strtolower(trim($keyword))."%'))";                             
          //$select_qry = "select * from importedemails where FromEmail='" . $AdminEmail . "' and FromDD='" . $activeEmailId . "' and MailType='Draft'" . $strSQL . " order by composedDate desc";
        }
        
        if(($Sortby=='') && !empty($keyword))
        {
          $strSQL .=" and ((Subject like '%".strtolower(trim($keyword))."%') or (EmailContent like '%".strtolower(trim($keyword))."%') or ((Recipient like '%".strtolower(trim($keyword))."%') or (Cc like '%".strtolower(trim($keyword))."%') or (Bcc like '%".strtolower(trim($keyword))."%')))";                             
          //$select_qry = "select * from importedemails where FromEmail='" . $AdminEmail . "' and FromDD='" . $activeEmailId . "' and MailType='Draft'" . $strSQL . " order by composedDate desc";
        }
        
        $select_qry = "select ".$Columns." from importedemails where FromEmail='" . $AdminEmail . "' and FromDD='" . $activeEmailId . "' and MailType='Draft'" . $strSQL . " order by composedDate desc".$select_qry;
        //echo $select_qry;
        
        
        return $this->query($select_qry, 1);
    }

    function saveToDarft($arrDetails) {
        global $Config;
        extract($arrDetails);


        $GetConfigId_qry = "select * from importemaillist where EmailId='" . $FromDD . "'";
        $GetConfigId = $this->query($GetConfigId_qry, 1);



        $recipent_arr = explode(',', $recipients);
        $CC_arr = explode(',', $Cc);
        $BCC_arr = explode(',', $Bcc);
        $total_arr = array_merge($recipent_arr, $CC_arr);
        $total_arr = array_unique(array_merge($total_arr, $BCC_arr));
        $total_recipient = implode(',', $total_arr);
        $total_recipient = rtrim($total_recipient, ',');

        $Message = (!empty($Message)) ? ($Message) : (NOT_SPECIFIED);
        $contents = ($mailcontent);



        if (isset($draftId) && $draftId > 0) {
            $insert_qry = "UPDATE importedemails SET Subject='" . $Subject . "', EmailContent='" . mysql_real_escape_string($contents) . "',Recipient='" . $recipients . "',Cc='" . $Cc . "',Bcc='" . $Bcc . "',TotalRecipient='".$total_recipient."',ImportedDate='" . date('Y-m-d H:i:s') . "',composedDate='" . date('Y-m-d H:i:s') . "' WHERE autoId='" . $draftId . "' ";
            $this->query($insert_qry, 1);
            $new_iid = $draftId;
        } else {
            $insert_qry = "insert into importedemails(OwnerEmailId,emaillistID,Subject,EmailContent,Recipient,Cc,Bcc,FromEmail,TotalRecipient,MailType,Action,ActionMailId,AdminId,ImportedDate,FromDD,AdminType,CompID,From_Email,To_Email,composedDate,OrgMailType) values('" . $OwnerEmailId . "','" . $GetConfigId[0][id] . "','" . $Subject . "','" . mysql_real_escape_string($contents) . "','" . $recipients . "','" . $Cc . "','" . $Bcc . "','" . $OwnerEmailId . "','" . $total_recipient . "','Draft','Compose','','" . $_SESSION['AdminID'] . "','" . date('Y-m-d H:i:s') . "','" . $FromDD . "','" . $_SESSION[AdminType] . "','" . $_SESSION[CmpID] . "','" . $FromDD . "','','" . date('Y-m-d H:i:s') . "','Draft')";
            $this->query($insert_qry, 1);
            $emailContentSezeAdd=strlen(mysql_real_escape_string($contents));
            $emailContentSezeAdd=$emailContentSezeAdd*0.00098;
            $new_iid = mysql_insert_id();
        }



        if (!empty($_SESSION['attcfile'])) {

            foreach ($_SESSION['attcfile'] as $key => $value) {
                //$abc.=$_SESSION['attcfile'][$value]."==";
                $insert_qry = "insert into importemailattachments(EmailRefId,FileName) values('" . $new_iid . "','" . $value . "')";
                $this->query($insert_qry, 1);
                /*new code*/
                           $fileNameWithPath="upload/emailattachment/" . $_SESSION['AdminEmail'] . "/" . $value;
                           $this->GetEmailAttactedSizeAdd($fileNameWithPath,$emailContentSezeAdd);
                           /*new code*/
                unset($_SESSION['attcfile'][$value]);
            }
        }
        else{
            $this->EmailImportedSizeIncrease($emailContentSezeAdd);
        }



        return $new_iid;
    }

    function editComposeMail($id) {
        $select_qry = "SELECT * from importedemails WHERE autoId='".$id."'";
        return $this->query($select_qry, 1);
    }

    function getReplyForwardMsg($emailNo, $action) {


        $select_qry = "SELECT * from importedemails WHERE autoId='".$emailNo."'";
        $EmailData = $this->query($select_qry, 1);

        if ($action == 'Forward') {
            $Content = "<br><br><br>---------- Forwarded message ----------<br>";

            if ($EmailData[0]['OrgMailType'] == 'Inbox') {
                $Content.="From:&nbsp;" . $EmailData[0]['From_Email'] . "<br>";
            } else {
                $Content.="From:&nbsp;" . $EmailData[0]['FromDD'] . "<br>";
            }
            $Content.="Date:&nbsp;" . date("F j, Y, g:i a", strtotime($EmailData[0]['ImportedDate'])) . "<br>";
            $Content.="Subject:&nbsp;" . $EmailData[0]['Subject'] . "<br>";
            $Content.="To:&nbsp;" . $EmailData[0]['Recipient'] . "<br>";
            if (!empty($EmailData[0]['Cc'])) {
                $Content.="Cc:&nbsp;" . $EmailData[0]['Cc'] . "<br>";
            }
            $Content.="<br><br><br>";
        } else if (($action == 'Reply') || ($action == 'ReplyToAll')) {
            if ($EmailData[0]['OrgMailType'] == 'Inbox') {
                $Content = "<br><br><br>--On " . date("F j, Y, g:i a", strtotime($EmailData[0]['ImportedDate'])) . "  ,<strong>" . $EmailData[0]['From_Email'] . "</strong>  wrote ::--<br><br><br>";
            } else {
                $Content = "<br><br><br>--On " . date("F j, Y, g:i a", strtotime($EmailData[0]['ImportedDate'])) . "  ,<strong>" . $EmailData[0]['FromDD'] . "</strong>  wrote ::--<br><br><br>";
            }
        }

        return $Content;
    }

    function GetAdminEmailId($adminId, $compId) {

        //$Config['DbName'] = $Config['DbMain'];
        //$objConfig->dbName = $Config['DbName'];
        //$objConfig->connect(); 

        $sel_query = "select Email from user_email where RefID='" . $adminId . "' and CmpID='" . $compId."'";
        return $this->query($sel_query, 1);
    }

    function DeleteAttachedFile($fileName) {



        $deleteAttachedfile = "delete from importemailattachments where FileName='" . $fileName . "'";
        return $this->query($deleteAttachedfile, 1);
    }

    function GetEmailListId($adminId, $compId) {

        $sel_query = "select id,EmailId from importemaillist where AdminID='".$adminId."' and AdminType='" .$_SESSION['AdminType'] . "' and CompID='".$compId."' and status='1' and DefalultEmail='1'";
        return $this->query($sel_query, 1);
    }
    
    function GetInboxEmailCount($activatelistId)
    {
        $sel_query = "select count(autoId) as TotalRecords from importedemails where emaillistID='".$activatelistId."' and OrgMailType='Inbox'";
        return $this->query($sel_query, 1);                        
    }
    
     function ListCombinedEmails($emailID)
    {
        
       $strSQLQuery = "SELECT * FROM importedemails where (To_Email='' and FromDD='".$emailID."' and MailType='Sent') or (To_Email!='' and To_Email='".$emailID."' and MailType='Inbox') or (From_Email='".$emailID."' and MailType='Inbox') or ((Recipient like '%".$emailID."%' or Cc like '%".$emailID."%' or Bcc like '%".$emailID."%') and (MailType='Sent')) ORDER BY composedDate desc"; 

	//$strSQLQuery = "SELECT * FROM importedemails where (To_Email!='' and From_Email='".$emailID."' and MailType='Inbox') or (Recipient like '%".$emailID."%' or Cc like '%".$emailID."%' or Bcc like '%".$emailID."%' and MailType='Sent') ORDER BY composedDate desc";  


      return $this->query($strSQLQuery, 1);  
                           
      
    }
    
     /*Combined Email next- previous fn */
    
     function CombinedNextEmail($emailID,$ItemId)
   {
       
      $emailInfo=$this->GetEmailInfoById($ItemId); 
      $strSQLQuery = "SELECT * FROM importedemails where ((To_Email='' and FromDD='".$emailID."' and MailType='Sent') or (To_Email!='' and To_Email='".$emailID."' and MailType='Inbox') or (From_Email='".$emailID."' and MailType='Inbox') or ((Recipient like '%".$emailID."%' or Cc like '%".$emailID."%' or Bcc like '%".$emailID."%') and (MailType='Sent'))) and (composedDate < '".$emailInfo[0]['composedDate']."') ORDER BY composedDate desc LIMIT 1";  
      return $this->query($strSQLQuery, 1);                        
   }
   
   function CombinedPrevEmail($emailID,$ItemId)
   {
      $emailInfo=$this->GetEmailInfoById($ItemId); 
      $strSQLQuery = "SELECT * FROM importedemails where ((To_Email='' and FromDD='".$emailID."' and MailType='Sent') or (To_Email!='' and To_Email='".$emailID."' and MailType='Inbox') or (From_Email='".$emailID."' and MailType='Inbox') or ((Recipient like '%".$emailID."%' or Cc like '%".$emailID."%' or Bcc like '%".$emailID."%') and (MailType='Sent'))) and (composedDate > '".$emailInfo[0]['composedDate']."') ORDER BY composedDate asc LIMIT 1";  
      return $this->query($strSQLQuery, 1);                          
   }
    
     /*End Combined Email next- previous fn */
    
     function CombinedViewEmail($UserEmail, $ItemId,$mailtype) {
         
         

        $strQry = '';
        if (!empty($ItemId)) {
            $strQry = " and autoId='" . $ItemId . "'";
        }
        
        if($mailtype=='Inbox')
         $select_qry = "select * from importedemails where ((To_Email='" . $UserEmail . "') or (From_Email='" . $UserEmail . "') or (Recipient like '%".$UserEmail."%' or Cc like '%".$UserEmail."%' or Bcc like '%".$UserEmail."%')) " . $strQry . " order by composedDate desc";

        if($mailtype=='Sent')
         $select_qry = "select * from importedemails where ((FromDD='" . $UserEmail . "') or (Recipient like '%".$UserEmail."%' or Cc like '%".$UserEmail."%' or Bcc like '%".$UserEmail."%'))" . $strQry . " order by composedDate desc";
        
        
        if($fromFlagged=='Yes')
        {
          //echo "flagged is true2222";
        }
        
        //echo $select_qry;
        if($_GET['d']==1){echo $select_qry; exit;}
        return $this->query($select_qry, 1);
    }
    
    
    function NextEmail($ItemId,$mailtype,$OwnerEmailId,$ActivatedId,$fromFlagged) {
        
        
        $emailInfo=$this->GetEmailInfoById($ItemId);
        
        
        
        if($mailtype=='sent') $mailtype='Sent';
        if($mailtype=='Draft') $mailtype='Draft';
        if($mailtype=='trash') $mailtype='TrashCan';
        
         $sel_query = "select autoId  from importedemails where composedDate < '".$emailInfo[0]['composedDate']."' and MailType='".$mailtype."' and FromDD='".$ActivatedId ."' and OwnerEmailId='".$OwnerEmailId."'  ORDER BY composedDate DESC LIMIT 1"; 
        
        if($mailtype=='Draft')
        {   
            $mailtype='Draft';
            $sel_query = "select autoId  from importedemails where composedDate < '".$emailInfo[0]['composedDate']."' and MailType='".$mailtype."' and FromDD='".$ActivatedId ."' and OwnerEmailId='".$OwnerEmailId."'  ORDER BY composedDate DESC LIMIT 1"; 
        }
        
        if($mailtype=='spam')
        {   
            $mailtype='Spam';
            $sel_query = "select autoId  from importedemails where composedDate < '".$emailInfo[0]['composedDate']."' and MailType='".$mailtype."' and To_Email='".$ActivatedId ."' and OwnerEmailId='".$OwnerEmailId."' ORDER BY composedDate DESC LIMIT 1"; 
        }
        if($mailtype=='inbox')
        {
            $mailtype='Inbox';
            $sel_query = "select autoId  from importedemails where composedDate < '".$emailInfo[0]['composedDate']."' and MailType='".$mailtype."' and To_Email='".$ActivatedId ."' and OwnerEmailId='".$OwnerEmailId."' ORDER BY composedDate DESC LIMIT 1"; 
        }
        
        if($fromFlagged=='Yes')
        { 
          $sel_query = "select autoId from importedemails where composedDate < '".$emailInfo[0]['composedDate']."' and FromDD='" . $ActivatedId . "' and FlagStatus='1'" . $strQry . " order by composedDate desc limit 1"; 
        }
        
        
        
         
        return $this->query($sel_query, 1);   
        
        
    }
    function PrevEmail($ItemId,$mailtype,$OwnerEmailId,$ActivatedId,$fromFlagged) {
        
        
        
        $emailInfo=$this->GetEmailInfoById($ItemId);
        
        if($mailtype=='sent') $mailtype='Sent';
        if($mailtype=='Draft') $mailtype='Draft';
        if($mailtype=='trash') $mailtype='TrashCan';
        
        $sel_query = "select autoId  from importedemails where composedDate > '".$emailInfo[0]['composedDate']."' and MailType='".$mailtype."' and FromDD='".$ActivatedId ."' and OwnerEmailId='".$OwnerEmailId."' ORDER BY composedDate ASC LIMIT 1"; 
        
        if($mailtype=='spam')
        {   
            $mailtype='Spam';
            $sel_query = "select autoId  from importedemails where composedDate > '".$emailInfo[0]['composedDate']."' and MailType='".$mailtype."' and To_Email='".$ActivatedId ."' and OwnerEmailId='".$OwnerEmailId."' ORDER BY composedDate ASC LIMIT 1"; 
        }
        if($mailtype=='inbox')
        {
            $mailtype='Inbox';
            $sel_query = "select autoId  from importedemails where composedDate > '".$emailInfo[0]['composedDate']."' and MailType='".$mailtype."' and To_Email='".$ActivatedId ."' and OwnerEmailId='".$OwnerEmailId."' ORDER BY composedDate ASC LIMIT 1"; 
        }
        
         if($fromFlagged=='Yes')
        { 
          $sel_query = "select autoId from importedemails where composedDate > '".$emailInfo[0]['composedDate']."' and FromDD='" . $ActivatedId . "' and FlagStatus='1'" . $strQry . " order by composedDate asc limit 1"; 
        }
        
        

       return $this->query($sel_query, 1);                          
    }
    
    function GetEmailInfoById($ItemId)
    {
        $sel_query = "select * from importedemails where autoId='".$ItemId."'";
        return $this->query($sel_query, 1);
    }
    function ChangeFlagStatus($EmailAutoId)
    {
        
        $sqlQuery="update importedemails set FlagStatus=(FlagStatus^1) where autoId='".$EmailAutoId."'";                       
        return $this->query($sqlQuery, 1);                      
        
    } 
    
    function AddEmailFolderName($arryDetails)
    {
       
      extract($arryDetails); 
      $strSQLQuery = "insert into importedemailfolder(FolderName,AdminID,AdminType,Status,CompID,EmailListId,EmailListName) values ('".mysql_real_escape_string($Name)."','".$AdminID."','".$AdminType."',1,'".$_SESSION['CmpID']."','".$EmailListId."','".$EmailListName."')";
      return $this->query($strSQLQuery, 1);
        
       
    }
    function AddEmailFolderNameAjax($arryDetails)
    {
       
      extract($arryDetails); 
      $strSQLQuery = "insert into importedemailfolder(FolderName,AdminID,AdminType,Status,CompID,EmailListId,EmailListName) values ('".mysql_real_escape_string($Name)."','".$AdminID."','".$AdminType."',1,'".$_SESSION['CmpID']."','".$EmailListId."','".$EmailListName."')";
      $this->query($strSQLQuery, 1);
      return mysql_insert_id();
        
       
    }
    function UpdateEmailFolderName($arryDetails)
    {
     
      extract($arryDetails); 
      $strSQLQuery = "update importedemailfolder set FolderName='".mysql_real_escape_string($Name)."' where FolderId='".$FolderID."'";
      return $this->query($strSQLQuery, 1);        
               
    }
    function CheckFolderName($FolderName,$FolderID,$AdminId,$CompId)
    {
      
      if(empty($FolderID))
      {
        $strSQLQuery = "select count(FolderId) as FolderCount from importedemailfolder where FolderName='".mysql_real_escape_string($FolderName)."' and AdminID='".$AdminId."' and CompID='".$CompId."'";
        $FolderData=$this->query($strSQLQuery, 1);
        return $FolderData[0][FolderCount]; exit;
      }
      if(!empty($FolderID) && ($FolderID > 0))
      {
        $strSQLQuery = "select count(FolderId) as FolderCount from importedemailfolder where FolderId!='".$FolderID."' and FolderName='".mysql_real_escape_string($FolderName)."' and AdminID='".$AdminId."' and CompID='".$CompId."'";
        $FolderData=$this->query($strSQLQuery, 1);
        return $FolderData[0][FolderCount]; exit;
      }
    }
    
    function ListFolderName($FolderId,$AdminId,$CompId,$activateEmailID) {

                    $strQry = '';
                    if (!empty($FolderId)) {
                        $strQry = " and FolderId='" . $FolderId . "'";
                    }
                    $strSQLQuery = "select FolderId,FolderName from importedemailfolder where EmailListName='".$activateEmailID."' and AdminID='".$AdminId."' and AdminType='".$_SESSION['AdminType']."' and CompID='".$CompId."'" . $strQry . " order by FolderName asc";
                   
                    return $this->query($strSQLQuery, 1);

                    
                }
     function GetEmailFolderDetails($FolderId)
     {
          $strSQLQuery = "select * from importedemailfolder where FolderId='".$FolderId."' order by FolderName asc";                      
          return $this->query($strSQLQuery, 1);                      
          
     }
     
     function AssignFolderToEmail($emailID,$folderID)
     {
            if($folderID=='Inbox')
            {
                
                $FolderData[0]['FolderName']='Inbox';
                $folderID=0;
            }else if($folderID=='Spam')
            {
               $FolderData[0]['FolderName']='Spam';
               $folderID=0;                 
            }
            else {
              $FolderData=$this->GetEmailFolderDetails($folderID);  
            }
            
            $update_query = "update importedemails set MailType='".mysql_real_escape_string($FolderData[0]['FolderName'])."', FolderId='".$folderID."' where autoId='" .$emailID ."'";
            return $this->query($update_query, 1);
            
     }
     
     function ListFolderEmails($FolderID)
     {
        
        $strSQLQuery = "select * from importedemails where FolderId='".$FolderID."' order by composedDate desc";
        return $this->query($strSQLQuery, 1);
     }
     function CountTotalFolderEmails($FolderID)
     {
        $strSQLQuery = "select count(autoId) as totalEmail from importedemails where FolderId='".$FolderID."' and Status='1'";
        $arryRow=$this->query($strSQLQuery, 1);
                   
        if($arryRow[0]['totalEmail'] > 0) {
             return $arryRow[0]['totalEmail'];
        }else {
              return 0;
          }
     }
     function DeleteEmailFolder($FolderID)
     {
        /***                        
        $select_folderqry="select autoId from importedemails where FolderId='".$FolderID."'"; 
        $total_email=$this->query($select_folderqry, 1);
         *****/
         
        
        $delete_folderqry="delete from importedemailfolder where FolderId='".$FolderID."'"; 
        $this->query($delete_folderqry, 1);
        
        $update_email_qry = "update importedemails set FolderId=0,MailType='Inbox' where FolderId='".$FolderID."'";
        $this->query($update_email_qry, 1);
        
        
        /***** deletion of folder emails and their attached files*****  
        if (count($total_email) > 0) {
                foreach ($total_email as $key => $emails) {
               
                $delete_email_qry = "delete from importedemails where autoId='" . $emails[autoId] . "'";
                $delet_qry = mysql_query($delete_email_qry) or mysql_error('mysql_error');

                if ($delet_qry == 1) {

                    $select_attachment_file = "select FileName from importemailattachments where EmailRefId='" . $emails[autoId] . "'";
                    $attach_val = $this->query($select_attachment_file, 1);
                    if (count($attach_val) > 0) {
                        foreach ($attach_val as $key => $filename) {


                            unlink(getcwd() . "/upload/emailattachment/" . $_SESSION['AdminEmail'] . "/" . $filename[FileName]);
                            $delete_attach_row = "delete from importemailattachments where EmailRefId='" . $emailuniqueId . "'";
                            $this->query($delete_attach_row, 1);
                        }
                    }
                }
                
               
                
                
                
                
              }
        } 
             ***** end deletion of folder emails and their attached files*****/ 
         
         
     }
     
 
     function FlaggedEmails($AdminEmail, $ItemId, $activeEmailId) {
         global $Config;
            $strQry = '';
        if (!empty($ItemId)) {
            $strQry = " and autoId='" . $ItemId . "'";
        }
        
        if($Config['GetNumRecords']==1){
		$Columns = " count(autoId) as NumCount ";		
	}else{
                 if($Config['RecordsPerPage']>0){
		$select_qry .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
                 }
		$Columns = "  Status,From_Email,autoId,Subject,FlagStatus,ImportedDate,composedDate,MailType,To_Email,Recipient  ";
	}
        
         $select_qry = "select ".$Columns." from importedemails where FromDD='" . $activeEmailId . "' and FlagStatus='1'" . $strQry . " order by composedDate desc".$select_qry;
        
        return $this->query($select_qry, 1);
    }
    
   
    
    function AddEmailRule($arryDetails)
    {
       extract($arryDetails);
       
       if($MovetoFolder > 0)
       {
            if(($FolderID=='Inbox') || ($FolderID=='Spam'))
            {
               $FolderName=$FolderID; 
               $FolderID=0;
            }
            else {

               $FolderData=$this->GetEmailFolderDetails($FolderID);

               $FolderName=$FolderData[0]['FolderName']; 
               $FolderID=$FolderData[0]['FolderId'];   
            }
       }else {
           $FolderID=0;
       }
       
       $insert_qry="insert into importedemailrules(RuleForEmail,EmailListName,EmailListId,OwnerEmail,AdminID,AdminType,CompID,RuleStatus,ReadEmail,FlaggedEmail,MoveToFolder,FolderName,FolderID) values('".$RuleForEmail."','".$EmailListName."','".$EmailListId."','".$OwnerEmailId."','".$AdminID."','".$AdminType."','".$_SESSION[CmpID]."',1,'".$Markread."','".$MarkasFlagged."','".$MovetoFolder."','".$FolderName."','".$FolderID."')";
       return $this->query($insert_qry, 1);
       
       }
       
     function UpdateEmailRule($arryDetails)
     {
         
         extract($arryDetails);
       
       if($MovetoFolder > 0)
       {
            if(($FolderID=='Inbox') || ($FolderID=='Spam'))
            {
               $FolderName=$FolderID; 
               $FolderID=0;
            }
            else {

               $FolderData=$this->GetEmailFolderDetails($FolderID);

               $FolderName=$FolderData[0]['FolderName']; 
               $FolderID=$FolderData[0]['FolderId'];   
            }
       }else {
           $FolderID=0;
       }
       
       $update_qry="update importedemailrules set ReadEmail='".$Markread."',FlaggedEmail='".$MarkasFlagged."',MoveToFolder='".$MovetoFolder."',FolderName='".$FolderName."',FolderID='".$FolderID."' where RuleID='".$RuleID."'";
       return $this->query($update_qry, 1);
         
         
     }
       
       function GetEmailRuleDetails($RuleID)
     {
          $strSQLQuery = "select * from importedemailrules where RuleID='".$RuleID."' order by RuleID desc";                      
          return $this->query($strSQLQuery, 1);                      
          
     }
     
     function CheckExistRule($RuleForEmail,$ActivatedEmail,$AdminID,$CompID)
     {
        $strSQLQuery = "select * from importedemailrules where RuleForEmail='".$RuleForEmail."' and EmailListName='".$ActivatedEmail."' and AdminID='".$AdminID."' and CompID='".$CompID."'";                      
        return $this->query($strSQLQuery, 1);                        
     }
     
     function ListEmailRules($ActivatedEmail,$AdminID,$CompID)
     {
         global $Config;
         
         if($Config['GetNumRecords']==1){
		$Columns = " count(RuleID) as NumCount ";		
	}else{
                if($Config['RecordsPerPage']>0){
		$strSQLQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
                }
		$Columns = "  *  ";
	}
        $strSQLQuery = "select ".$Columns." from importedemailrules where EmailListName='".$ActivatedEmail."' and AdminID='".$AdminID."' and CompID='".$CompID."' order by RuleID desc".$strSQLQuery;                      
        //echo $strSQLQuery;
        return $this->query($strSQLQuery, 1);                       
     }
     
     function RemoveRuleId($RuleID)
     {
        $strSQLQuery = "delete from importedemailrules where RuleID='".$RuleID."'";                     
        return $this->query($strSQLQuery, 1);                         
     }
     function UpdateStatusRuleId($RuleID)
     {
        $strSQLQuery = "update importedemailrules set RuleStatus=(RuleStatus^1) where RuleID='".$RuleID."'";                     
        return $this->query($strSQLQuery, 1);                        
     }
     
     function SyncSentItemFromQuote($EmailDetailsArray,$FileNameArray)
      {
                
               
                extract($EmailDetailsArray);
                extract($FileNameArray);
                $insert_qry = "insert into importedemails(OwnerEmailId,emaillistID,Subject,EmailContent,Recipient,Cc,FromEmail,TotalRecipient,MailType,Action,ActionMailId,AdminId,ImportedDate,FromDD,AdminType,CompID,From_Email,To_Email,composedDate,OrgMailType,Status)
                                values('".$OwnerEmailId."','".$emaillistID."','" . $Subject . "','" . mysql_real_escape_string($EmailContent) . "','" . $Recipient . "','" . $Cc . "','" . $OwnerEmailId . "','" . $TotalRecipient . "','Sent','Compose','','" . $_SESSION['AdminID'] . "','" . date('Y-m-d H:i:s') . "','" . $From_Email . "','" . $_SESSION['AdminType'] . "','" . $_SESSION['CmpID'] . "','" . $From_Email . "','','" . date('Y-m-d H:i:s') . "','Sent','0')";
                $this->query($insert_qry, 1);
                $new_iid = mysql_insert_id();
                if($new_iid > 0){
                
                  
                  foreach ($FileNameArray as $key => $value) {

                        $insert_qry = "insert into importemailattachments(EmailRefId,FileName) values('" . $new_iid . "','" . $value . "')";
                        $this->query($insert_qry, 1);
                    }
                }
      }
    
    
    
    //=============start functions used for fetching emails using impap========start//
function flattenParts($messageParts, $flattenedParts = array(), $prefix = '', $index = 1, $fullPrefix = true) {

    foreach ($messageParts as $part) {
        $flattenedParts[$prefix . $index] = $part;
        if (isset($part->parts)) {
            if ($part->type == 2) {
                $flattenedParts = $this->flattenParts($part->parts, $flattenedParts, $prefix . $index . '.', 0, false);
            } elseif ($fullPrefix) {
                $flattenedParts = $this->flattenParts($part->parts, $flattenedParts, $prefix . $index . '.');
            } else {
                $flattenedParts = $this->flattenParts($part->parts, $flattenedParts, $prefix);
            }
            unset($flattenedParts[$prefix . $index]->parts);
        }
        $index++;
    }

    return $flattenedParts;
}

function getPart($connection, $messageNumber, $partNumber, $encoding) {

    $data = imap_fetchbody($connection, $messageNumber, $partNumber);
    switch ($encoding) {
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

    if ($part->ifdparameters) {
        foreach ($part->dparameters as $object) {
            if (strtolower($object->attribute) == 'filename') {
                $filename = $object->value;
            }
        }
    }

    if (!$filename && $part->ifparameters) {
        foreach ($part->parameters as $object) {
            if (strtolower($object->attribute) == 'name') {
                $filename = $object->value;
            }
        }
    }

    return $filename;
} 

function getSimple($mbox, $mid, $p, $partno) {
    // $partno = '1', '2', '2.1', '2.1.3', etc for multipart, 0 if simple

    global $htmlmsg, $plainmsg, $charset, $attachments;

    // DECODE DATA
    $data = ($partno) ?
            imap_fetchbody($mbox, $mid, $partno) : // multipart
            imap_body($mbox, $mid);  // simple
    // Any part may be encoded, even plain text messages, so check everything.
    if ($p->encoding == 4)
        $data = quoted_printable_decode($data);
    elseif ($p->encoding == 3)
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
        $filename = ($params['filename']) ? $params['filename'] : $params['name'];
        // filename may be encoded, so see imap_mime_header_decode()
        $attachments[$filename] = $data;  // this is a problem if two files have same name
    }

    // TEXT
    if ($p->type == 0 && $data) {
        // Messages may be split in different parts because of inline attachments,
        // so append parts together with blank row.
        if (strtolower($p->subtype) == 'plain')
            $plainmsg.= trim($data) . "\n\n";
        else
            $htmlmsg = $data;
        $charset = $params['charset'];  // assume all parts are same charset
    }

    // EMBEDDED MESSAGE
    // Many bounce notifications embed the original message as type 2,
    // but AOL uses type 1 (multipart), which is not handled here.
    // There are no PHP functions to parse embedded messages,
    // so this just appends the raw source to the main message.
    elseif ($p->type == 2 && $data) {
        $plainmsg.= $data . "\n\n";
    }

    return $htmlmsg;

    // SUBPART RECURSION
    if ($p->parts) {
        foreach ($p->parts as $partno0 => $p2)
            $this->getSimple($mbox, $mid, $p2, $partno . '.' . ($partno0 + 1));  // 1.2, 1.2.1, etc.
    }
}

//=============end functions used for fetching emails using impap========end//
    
 /***code by sachin ****/

function EmailImportedSizeDelete($size){
     global $Config;
     //$objCompany=new company();
//    $objConfig=new admin();
//     $Config['DbName'] = $Config['DbMain'];
//			$objConfig->dbName = $Config['DbName'];
//			$objConfig->connect();
//                        
     $AttEmailStrorageVal=$this->GetCurrentCompanystorage($_SESSION['CmpID']);
     //echo '<pre>';print_r($AttEmailStrorageVal);die;
     $TotalStorageVal=$AttEmailStrorageVal[0]['Storage']-$size;
     $this->InserEmailStorageInCompany($_SESSION['CmpID'],$TotalStorageVal);
    
    
}

function EmailImportedSizeIncrease($size){
    global $Config;
    
                        
     $AttEmailStrorageVal=$this->GetCurrentCompanystorage($_SESSION['CmpID']);
     //echo '<pre>';print_r($AttEmailStrorageVal);die;
     $TotalStorageVal=$AttEmailStrorageVal[0]['Storage']+$size;
     //echo $TotalStorageVal;die('fun');
     $this->InserEmailStorageInCompany($_SESSION['CmpID'],$TotalStorageVal);
}
 function GetEmailAttactedSizeAdd($fileName,$contentSize){
     global $Config;
     
     $size=filesize($fileName);
     $size=$size*0.00098;
     if(!empty($contentSize)){
     $size=$size+$contentSize;
     }
    
     $AttEmailStrorageVal=$this->GetCurrentCompanystorage($_SESSION['CmpID']);
     
     $TotalStorageVal=$AttEmailStrorageVal[0]['Storage']+$size;
     $this->InserEmailStorageInCompany($_SESSION['CmpID'],$TotalStorageVal);
     
 }
 function GetEmailAttactedSizeDelete($fileName,$contentsize){
     global $Config;
    
     $size=filesize($fileName);
     $size=$size*0.00098;
     if(!empty($contentsize)){
     $size=$size+$contentsize;
     }
    
                        
     $AttEmailStrorageVal=$this->GetCurrentCompanystorage($_SESSION['CmpID']);
     
     $TotalStorageVal=$AttEmailStrorageVal[0]['Storage']-$size;
     
     $this->InserEmailStorageInCompany($_SESSION['CmpID'],$TotalStorageVal);
     
 }
function GetCurrentCompanystorage($CmpId){
            global $Config;            
            $sql="SELECT * FROM erp.company where CmpID='".$CmpId."'";
            
            return $this->query($sql, 1);
        }
        
function InserEmailStorageInCompany($CmpId,$val){
               global $Config;     
            $sql="update erp.company SET Storage='".$val."' where CmpID='".$CmpId."'";
            
            return $this->query($sql, 1);
            
        }
        
function GetFileNameArrayByDraftId($id){
    global $Config;
    $sql="Select FileName from importemailattachments where EmailRefId='".$id."'";
   
    return $this->query($sql, 1);
}


 function SaveSentEmailForVendorCustomer($arrayData)
    { 
     
     extract($arrayData);
     //$insert_qry = "insert into importedemails(OwnerEmailId,emaillistID,Subject,EmailContent,Recipient,Cc,Bcc,FromEmail,TotalRecipient,MailType,Action,ActionMailId,AdminId,ImportedDate,FromDD,AdminType,CompID,From_Email,To_Email,composedDate,OrgMailType) values('" . $OwnerEmailId . "','" . $emaillistID . "','" . $Subject . "','" . mysql_real_escape_string($contents) . "','" . $recipients . "','" . $Cc . "','" . $Bcc . "','" . $OwnerEmailId . "','" . $total_recipient . "','Sent','Compose','','" . $_SESSION['AdminID'] . "','" . date('Y-m-d H:i:s') . "','" . $FromDD . "',FromDD,AdminType,CompID,From_Email,To_Email,composedDate,OrgMailType,'" . $_SESSION[AdminType] . "','" . $_SESSION[CmpID] . "','" . $FromDD . "','','" . date('Y-m-d H:i:s') . "','Draft')";
     $insert_qry = "insert into importedemails(OwnerEmailId,emaillistID,Subject,EmailContent,Recipient,Cc,Bcc,FromEmail,TotalRecipient,MailType,Action,ActionMailId,AdminId,ImportedDate,FromDD,AdminType,CompID,From_Email,To_Email,composedDate,OrgMailType) values('" . $OwnerEmailId . "','" . $emaillistID . "','" . $Subject . "','" . mysql_real_escape_string($EmailContent) . "','" . $Recipient . "','" . $Cc . "','" . $Bcc . "','" . $FromEmail . "','" . $TotalRecipient . "','".$MailType."','".$Action."','".$ActionMailId."','" . $AdminId . "','" . $ImportedDate . "','" . $FromDD . "','" . $AdminType . "','" . $CompID . "','" . $From_Email . "','".$To_Email."','" . date('Y-m-d H:i:s') . "','".OrgMailType."')";
     //echo $insert_qry;die;
     //return $this->query($insert_qry, 1);
     $this->query($insert_qry, 1);
      $new_iid = mysql_insert_id();

      if(!empty($FileName)){
		$sql = "insert into importemailattachments(EmailRefId,FileName) values('" . $new_iid . "','" . $FileName . "')";
		//echo $sql;die;
		$this->query($sql, 1);

		/*new code for Storage
		$fileNameWithPath="../crm/upload/emailattachment/" . $_SESSION['AdminEmail'] . "/" . $FileName;
		$this->GetEmailAttactedSizeAdd($fileNameWithPath,'');
		/*new code for Storage*/
      }
      return 1;
    }

/*****end code sachin **/   
    
    

}

?>
