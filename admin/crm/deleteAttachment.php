<?php 	
        session_start();
        
	$Prefix = "../../"; 
    	require_once($Prefix."includes/config.php");
	require_once($Prefix."classes/dbClass.php");
    	require_once($Prefix."includes/function.php");
        require_once($Prefix."classes/admin.class.php");
	require_once($Prefix."classes/email.class.php");

        $objConfig=new admin();
	/********Connecting to main database*********/
        
	$Config['DbName'] = $_SESSION['CmpDatabase'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/
        
        $objEmail=new email();
          

$output_dir = "upload/emailattachment/";
if($_SESSION['AdminType']!='admin')
{
    $OwnerEmailId=$_SESSION['EmpEmail'];
}else{
     $OwnerEmailId=$_SESSION['AdminEmail'];
}
$output_dir=$output_dir."/".$OwnerEmailId."/";
 
if(isset($_POST["op"]) && $_POST["op"] == "delete" && isset($_POST['name']))
{
	
       
    
        $_POST['drafftId']."--".$_POST['Frrom']."==".$_POST['name'].'=='.$_POST['OrgFile']; 
        $fileName =$_POST['name']; 

        $fileName=str_replace("[","",$fileName);
        $fileName=str_replace("]","",$fileName);
        $fileName=str_replace('"','',$fileName);
     
	   $filePath = $output_dir. $fileName; 
        
          if(empty($_POST['Frrom']) && (!empty($_POST['name'])) && (!empty($_POST['OrgFile'])))
            {
                
                $fName=$_POST['OrgFile'];
                if($_POST['type']=='Draft'){ $fName=$_POST['name'];}
                if($_POST['Action']==''){ $fName=$_POST['OrgFile'];}
                $filePath = $output_dir. $fName;
                if (file_exists($filePath)) 
                { 
                  
                   //echo "session".$_SESSION['attcfile'][$fileName];
                   $objEmail->DeleteAttachedFile($fName);
                   /*code for delete attachment file*/
                   if(!empty($_POST['drafftId']))
                   {
                       
                       
                       //echo 'INN';
                       $objEmail->GetEmailAttactedSizeDelete($filePath);
                   }
                   /*code for delete attachment file*/
                    unlink($filePath);
                   unset($_SESSION['attcfile'][$fName]);
                   unset($_SESSION['attcfile'][$fileName]);
                   
                   echo "1Deleted File ".$_POST['OrgFile'];
                   
                }
                
            } 
            
          if(!empty($_POST['Frrom']))
            {
                //echo $_POST['drafftId']."--".$_POST['Frrom']."==".$_POST['name'].'=='.$_POST['OrgFile']; 
            
               if (file_exists($filePath)) 
                {
                   
                   /**code for delete save attachment file save**/
                   if(!empty($_POST['drafftId']))
                   {
                        $SaveFileNameFormated=$SaveFileName=array();
                        $SaveFileName=$objEmail->GetFileNameArrayByDraftId($_POST['drafftId']);
                        $k=0;
                        foreach($SaveFileName as $val){
                            $SaveFileNameFormated[$k]=$val['FileName'];
                            $k++;
                        }
                        //echo $filePath.'oooin_ary<br />';
                        //echo '<pre>'; print_r($SaveFileNameFormated);
                        if (in_array($fileName,$SaveFileNameFormated)){
                            //echo $filePath.'<br />';
                             
                             $objEmail->DeleteAttachedFile($fileName);
                            $objEmail->GetEmailAttactedSizeDelete($filePath);
                            //$objEmail->DeleteAttachedFile($fileName);
                        }
                       
                   }
                   /**code for delete save attchment file save**/
                   
                   $objEmail->DeleteAttachedFile($fileName);
                   unlink($filePath);
                   //echo "session".$_SESSION['attcfile'][$fileName];
                   unset($_SESSION['attcfile'][$fileName]);
                   
                   echo "2Deleted File ".$fileName;

                } 
                
                
            }  
            
            
                
          // if($_POST['drafftId'] > 0) 
           // {
              //echo $_POST['drafftId']."==".$_POST['OrgFile']; exit; 
             //$objEmail->DeleteAttachedFile($_POST['OrgFile']);
           // } 
            
           
            
       
        
        
	
        
	//echo "Deleted File ".$fileName."<br>";
}



?>
