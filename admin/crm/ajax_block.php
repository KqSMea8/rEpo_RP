<? 

session_start();
$Prefix = "../../";
require_once($Prefix . "includes/config.php");
require_once($Prefix . "includes/function.php");
require_once($Prefix . "classes/dbClass.php");
require_once($Prefix . "classes/admin.class.php");
require_once($Prefix . "classes/lead.class.php");
require_once($Prefix."classes/event.class.php"); 
require_once($Prefix."classes/quote.class.php");
require_once($Prefix."classes/email.class.php");
$objConfig = new admin();
$objLead = new lead();
$objActivity=new activity();
$objQuote=new quote();
$objImportEmail=new email();

if(empty($_SERVER['HTTP_REFERER'])){
	echo 'Protected.';exit;
}



/********Connecting to main database*********/
$Config['DbName'] = $_SESSION['CmpDatabase'];
$objConfig->dbName = $Config['DbName'];
$objConfig->connect();
/*******************************************/

CleanPost();

switch ($_POST['action']) {
    case 'leadListing':
	$arryMyLead=$objLead->GetWorkspaceLead($_POST['leadType']);
	
          $AjaxHtml = '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
	 if(sizeof($arryMyLead)>0){

		$AjaxHtml .= '
                <thead>
                <tr class="head"> 	
                  <td class="darkcolor">Lead Name</td>
                  <td class="darkcolor">Lead Type</td>
                </tr>
                </thead>';

		$flag=true;
		$Line=0;
		foreach($arryMyLead as $key=>$lead){
			$flag=!$flag;
			#$bgcolor=($flag)?("#FDFBFB"):("");
			$Line++;
			$LeadName = stripslashes($lead['FirstName']).' '.stripslashes($lead['LastName']);

			$AjaxHtml .= '<tr class="even">
			<td><a class="fancybox fancybox.iframe" href="vLead.php?view='.$lead['leadID'].'&curP=1&module=lead&pop=1">'.substr($LeadName,0,30).'</a></td>
			<td ><a class="fancybox fancybox.iframe" href="vLead.php?view='.$lead['leadID'].'&curP=1&module=lead&pop=1">'.$lead['type'].'</a></td>
			</tr>'; 
                          
                 }
                 $AjaxHtml .= '<tr>
                           <td  colspan="2">
                           <a href="viewLead.php?module=lead">More...</a>
                           </td>
                           </tr>'; 
						   
                         
              }else{
                    $AjaxHtml .= '<tr>
                                <td  colspan="2" class="blockmsg" >
                          No lead found.
                           </td>
                           </tr>';
             }
                           
             $AjaxHtml .= '</table>';
        break;
  

    case 'ticketListing':
	$arryTicket=$objLead->GetWorkspaceTicket($_POST['ticketType']);
	
	$AjaxHtml = '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
	 if(sizeof($arryTicket)>0){

		

		$flag=true;
		$Line=0;
		foreach($arryTicket as $key=>$Ticket){
		$flag=!$flag;
		#$bgcolor=($flag)?("#FDFBFB"):("");
		$Line++;

			$AjaxHtml .= '<tr>
			<td><a class="fancybox fancybox.iframe" href="vTicket.php?module=Ticket&view='.$Ticket['TicketID'].'&pop=1">'.substr(stripslashes($Ticket['title']),0,50).'</a></td>			
			</tr>'; 
                          
                 }
                 $AjaxHtml .= '<tr>
                           <td  colspan="2">
                           <a href="viewTicket.php?module=Ticket">More...</a>
                           </td>
                           </tr>'; 
						   
                         
              }else{
                    $AjaxHtml .= '<tr>
                                <td  colspan="2" class="blockmsg" >
                          No ticket found.
                           </td>
                           </tr>';
             }
                           
             $AjaxHtml .= '</table>';
        break;

case 'oppListing':
	$arryTopOpp=$objLead->GetWorkspaceOpp($_POST['oppType'],$_POST['SalesStage']);
	
          $AjaxHtml = '<table width="100%" border="0" cellspacing="0" cellpadding="0">';

	  if(sizeof($arryTopOpp)>0){

		$AjaxHtml .= '<thead>
                <tr class="head"> 	
                  <td class="darkcolor">Opportunity Name</td>
                  <td class="darkcolor">Amount</td>
                </tr>
                </thead>';

		$flag=true;
		$Line=0;
		foreach($arryTopOpp as $key=>$opportunity){
			$flag=!$flag;
			$Line++;

			$AjaxHtml .= '<tr class="even">
                              <td><a class="fancybox fancybox.iframe"  href="vOpportunity.php?view='.$opportunity['OpportunityID'].'&module=Opportunity&pop=1">'.substr(stripslashes($opportunity['OpportunityName']),0,30).' </a></td>
                              <td ><a class="fancybox fancybox.iframe"  href="vOpportunity.php?view='.$opportunity['OpportunityID'].'&module=Opportunity&pop=1">'.$Config['Currency'].' '.$opportunity['AmountVal'].'</a></td>
                            </tr>';
                          
                 }
                 $AjaxHtml .= '<tr>
                           <td  colspan="2">
                           <a href="viewOpportunity.php?module=Opportunity">More...</a>
                           </td>
                           </tr>'; 
						   
                         
              }else{
                    $AjaxHtml .= '<tr>
                                <td  colspan="2" class="blockmsg" >
                          No opportunity found.
                           </td>
                           </tr>';
             }
                           
             $AjaxHtml .= '</table>';
        break;



case 'activityListing':

	$arryActivity=$objActivity->GetWorkspaceActivity($_POST['activityType']);

	$AjaxHtml = '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
	if(sizeof($arryActivity)>0){

		

		$flag=true;
		$Line=0; 
		foreach($arryActivity as $key=>$Activity){
		$flag=!$flag;
		
		$Line++;

			$AjaxHtml .= '<tr>
                              <td><a class="fancybox fancybox.iframe" href="vActivity.php?view='.$Activity['activityID'].'&pop=1&module=Activity&mode='.$Activity['activityType'].'">'.substr(stripslashes($Activity['subject']),0,50).' </a></td>
                             
                            </tr>'; 
                          
                 }
                 $AjaxHtml .= '<tr>
                           <td  colspan="2">
                           <a href="viewActivity.php?module=Activity">More...</a>
                           </td>
                           </tr>'; 
						   
                         
              }else{
                    $AjaxHtml .= '<tr>
                                <td  colspan="2" class="blockmsg" >
                          No activity found.
                           </td>
                           </tr>';
             }
                           
             $AjaxHtml .= '</table>';
        break;

case 'quoteListing':
	$arryQuote=$objQuote->GetWorkspaceQuote($_POST['quoteType'], $_POST['quotestage']);
	//echo sizeof($arryQuote);exit;
          
	$AjaxHtml = '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
	 if(sizeof($arryQuote)>0){
	

		$flag=true;
		$Line=0;
		foreach($arryQuote as $key=>$Quote){
			$flag=!$flag;			
			$Line++;
			

			$AjaxHtml .= '<tr><td>
			<a class="fancybox fancybox.iframe"  href="vQuote.php?view='.$Quote['quoteid'].'&module=Quote&pop=1">'.substr(stripslashes($Quote['subject']),0,50).'</a>
			</td></tr>'; 
                          
                 }
                 $AjaxHtml .= '<tr>
                           <td >
                           <a href="viewQuote.php?module=Quote">More...</a>

                           </td>
                           </tr>'; 
						   
                         
              }else{
                    $AjaxHtml .= '<tr>
                                <td  colspan="2" class="blockmsg" >
                          No quote found.
                           </td>

                           </tr>';
             }
                           
             $AjaxHtml .= '</table>';
        break;

 case 'campListing':
	 $arryCampaign=$objLead->GetWorkspaceCampaign($_POST['campType']);
	        
	 $AjaxHtml = '<table width="100%" border="0" cellspacing="0" cellpadding="0">';  
	 if(sizeof($arryCampaign)>0){
	
		$flag=true;
		$Line=0;
		foreach($arryCampaign as $key=>$Campaign){
			$flag=!$flag;
			$Line++;
		
			$AjaxHtml .= '<tr class="even">
<td><a class="fancybox fancybox.iframe"  href="vCampaign.php?view='.$Campaign['campaignID'].'&module=Campaign&pop=1">'.substr(stripslashes($Campaign['campaignname']),0,50).'</a></td>
			</tr>'; 
                          
                 }
                 $AjaxHtml .= '<tr>
                           <td  colspan="2">
                           <a href="viewCampaign.php?module=Campaign">More...</a>

                           </td>
                           </tr>'; 
						   
                         
              }else{
                    $AjaxHtml .= '<tr>
                                <td  colspan="2" class="blockmsg" >
                          No campaign found.
                           </td>

                           </tr>';
             }
                           
             $AjaxHtml .= '</table>';
        break;

 case 'emailListing':
	/********Auto import********/
	$EmailListId=$objImportEmail->GetEmailListId($_SESSION['AdminID'],$_SESSION['CmpID']);
	if(!empty($EmailListId[0]['id'])){
        	$countExist=$objImportEmail->GetInboxEmailCount($EmailListId[0]['id']);
	}
       	if(!empty($EmailListId[0]['id']) && !empty($countExist[0]['TotalRecords'])){            
		$objImportEmail->fetchEmailsFromServer($EmailListId[0]['id'],'UNSEEN','');      
	}
	/************************/
	$arryDEmail=$objConfig->GetWorkspaceEmail($_POST['emailType']);
	
          $AjaxHtml = '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
	 if(!empty($arryDEmail)){

		$flag=true;
		$Line=0;
		foreach($arryDEmail as $key=>$values){
			$flag=!$flag;			
			$Line++;
			$boldtext ='';
			if($values['Status']) $boldtext = "font-weight:bold;";

			$AjaxHtml .= '<tr>
			<td><a onclick="Javascript:SetUnbold(this);" style="'.$boldtext.'" class="fancybox fancybox.iframe" href="viewEmail.php?ViewId='.$values['autoId'].'&type=inbox&pop=1" >'.substr(stripslashes($values['Subject']),0,50).'...</a></td>
			</tr>'; 
                          
                 }
                 $AjaxHtml .= '<tr>
                           <td  colspan="2">
                           <a href="viewImportedEmails.php">More...</a>
                           </td>
                           </tr>'; 
						   
                         
              }else{
                    $AjaxHtml .= '<tr>
                                <td  colspan="2" class="blockmsg" >
                          No email found.
                           </td>
                           </tr>';
             }
                           
             $AjaxHtml .= '</table>';
        break;
  



}


if (!empty($AjaxHtml)) {
    echo $AjaxHtml;
    exit;
}


?>
