
<?
(!isset($_GET['menu'])) ? $_GET['menu'] = '' : '';
if($ModuleParentID > 0 && $ModuleParentID!='195' && $ModuleParentID!='6001' && $NotAllowed!=1 ) { 
			/******  Sub menu ****/
			if($ModuleParentID == 49) { 
				$arrayMenu1 = $objMenu->GetContentCategory('');
			}elseif(!empty($RoleGroupUserId)){	
                		$arraySubMenus = $objConfig->GetHeaderMenusUserGroupNew($RoleGroupUserId,'',$ModuleParentID,2);
			}else{			
				 $arraySubMenus = $objConfig->GetHeaderMenusUserNew($_SESSION['UserID'],'',$ModuleParentID,2);
			}
			$InnerPage = 1;

 
?>



<div class="left-main-nav">	
	<h3><span class="icon"></span>Main Menu</h3>
	<ul>
		 
		<? 
		 if($ModuleParentID == 49) { 
		 	if(empty($_GET['CatID'])) $_GET['CatID']=1;
			 for($i=0;$i<sizeof($arrayMenu1);$i++) {
			 	$PageTitle = str_replace(" ","&nbsp;",stripslashes($arrayMenu1[$i]['Name']));
				$Class = ($_GET['CatID'] == $arrayMenu1[$i]['CatID'])?("active"):("");
				echo '<li class="submenu '.$Class.'"><a href="cms.php?CatID='.$arrayMenu1[$i]['CatID'].'" >'.$PageTitle.' Pages</a></li>';
				//if($i<sizeof($arrayMenu1)-1) { echo '&nbsp; | &nbsp;'; } 
			}
		 }else{
			   
			 if($Config['CurrentDepID']==5 && $ModuleParentID==2025){

				 if(!empty($_GET['ViewId'])){
				 	$objConfig->updateSendMailStatus($_GET['ViewId']);
				 }


				  $EmailListId=$objConfig->GetEmailListId($_SESSION[AdminID],$_SESSION[CmpID]);
                                  if($_SESSION['AdminType']!='admin')
                                                {
                                                   
                                                   $OwnerEmailId=$_SESSION['EmpEmail'];
                                                }else {
                                                
                                                  $OwnerEmailId=$_SESSION['AdminEmail'];
                                                } 
                                  
                                  
				  for($i=0;$i<sizeof($arraySubMenus);$i++){ 
					$Class = ($MainModuleID == $arraySubMenus[$i]['ModuleID'])?("active"):("");
					$CountEmail='';
					if($arraySubMenus[$i]['Module']=="Inbox"){
						$NumInbox = $objConfig->ListUnReadInboxEmails($EmailListId[0][id]);
						$CountEmail='<strong><span id="inboxnum">'.$NumInbox5.'</span></strong>';

					}else if($arraySubMenus[$i]['Module']=="Draft"){
                                        
                                                  
						$NumDraft = $objConfig->draftItems($OwnerEmailId,'',$EmailListId[0][EmailId]);
						if($NumDraft>0)$CountEmail='<strong>(<span id="draftnum">'.$NumDraft.'</span>)</strong>';
					}

					echo '<li class="submenu '.$Class.'"><a href="'.$arraySubMenus[$i]['Link'].'">'.$arraySubMenus[$i]['Module'].' '.$CountEmail.'</a></li>';
						
				
				   }	



				/******Folder Li************/

				 echo '<li class="submenu"><a class="fancybox fancybox.iframe" href="editEmailFolder.php">Create Folder <img src="../images/add.gif" border="0"></a></li>';

				$FolderList=$objConfig->ListFolderName('',$_SESSION[AdminID],$_SESSION[CmpID]);
                               for($i=0;$i<sizeof($FolderList);$i++) {
				 	$folderName = mysql_real_escape_string(($FolderList[$i]['FolderName']));
					$Class = ($_GET['FolderId'] == $FolderList[$i]['FolderId'])?("active"):("");
					
					$NumFolderEmails = $objConfig->CountTotalFolderEmails($FolderList[$i]['FolderId']);
					$CountFolderEmail='';
					if($NumFolderEmails>0)$CountFolderEmail='<strong>(<span id="foldernum_'.$FolderList[$i]['FolderId'].'">'.$NumFolderEmails.'</span>)</strong>';
					
					
		                        echo '<li class="subfolder '.$Class.'"><a href="viewFolderEmails.php?FolderId='.$FolderList[$i]['FolderId'].'" >'.$folderName.' '.$CountFolderEmail.'</a>
	 <a href="#" onclick="ConfirmDeleteFolder('.$FolderList[$i]['FolderId'].');"><img src="../images/cross.png" border="0"></a>
		        <a class="fancybox fancybox.iframe" href="editEmailFolder.php?edit='.$FolderList[$i]['FolderId'].'"><img src="../images/edit.png" border="0"></a>
	</li>';
				}

			
				/*******Auto import email for read email*********/

			    if(empty($_SESSION['fetchAutoEmail']))
			    { 
				   require_once($Prefix."classes/email.class.php");
				   $objImportEmail=new email();
				   //$objImportEmail->fetchEmailsFromServer($EmailListId[0][id],'',5);
				   $_SESSION['fetchAutoEmail']='1';
			    }

				/*****************************/
				?>

<script language="JavaScript1.2" type="text/javascript">
    $(document).ready(function(){
		var inboxnum = '';
		if(document.getElementById("notficemailpop") != null){		
			inboxnum = '('+$("#notficemailpop").html()+')';
		}
		
		
		$("#inboxnum").html(inboxnum);

		$(".subfolder a img").hide();

		$('.subfolder').hover(function() { 
			$(this).find("img").show();		
		},
		function() {		 
			$(this).find("img").hide();	
			
		});

     });

    function ConfirmDeleteFolder(FolderId)
    {
       var MsgReturn=confirm('Are you sure you want to delete folder? This will delete folder and messages will be moved to Inbox.');  
       //confirm("Press a button!");
       if(MsgReturn==true){
          
           window.location='editEmailFolder.php?delete_id='+FolderId;
       }
    }



</script>




		<?

			 }else{
				 

				 for($i=0;$i<sizeof($arraySubMenus);$i++){ 
						$Class = ($MainModuleID == $arraySubMenus[$i]['ModuleID'])?("active"):("");
						echo '<li class="submenu '.$Class.'"><a href="'.$arraySubMenus[$i]['Link'].'">'.$arraySubMenus[$i]['Module'].'</a></li>';
						
				
				   }
					
				/*---------------- Added by sanjiv for dynamic folder in crm---------*/
			   		if($ModuleParentID == 102) { 
			   			$_SESSION['ModuleParentID'] = $ModuleParentID;
					    echo '<li class="submenu"><a class="fancybox fancybox.iframe" href="CreateFolder.php">Create Folder <img src="../images/add.gif" border="0"></a></li>';
		
						$FolderList1=$objConfig->getFolderList('',$_SESSION['AdminID'],$_SESSION['CmpID'],$_SESSION['ModuleParentID']);
		                 for($i=0;$i<sizeof($FolderList1);$i++) {
						 	$folderName = mysql_real_escape_string(($FolderList1[$i]['FolderName']));
							$Class = (isset($_GET['FolderId']) && $_GET['FolderId'] == $FolderList1[$i]['FolderId'])?("active"):("");
							
	                        echo '<li class="subfolder '.$Class.'"><a href="viewLead.php?module=lead&FolderId='.$FolderList1[$i]['FolderId'].'" >'.wordwrap($folderName,15,"<br>\n").'</a>';
	                        if($_SESSION['AdminType']=='admin'){
	                        	echo	'<a href="#" onclick="ConfirmDeleteFolderDynamic('.$FolderList1[$i]['FolderId'].');"><img src="../images/cross.png" border="0"></a>
								        <a class="fancybox fancybox.iframe" href="CreateFolder.php?edit='.$FolderList1[$i]['FolderId'].'"><img src="../images/edit.png" border="0"></a>';
	                        }else if($_SESSION['AdminID']==$FolderList1[$i]['AdminID'] && $_SESSION['CmpID'] ==$FolderList1[$i]['CompID']){
							 		echo	'<a href="#" onclick="ConfirmDeleteFolderDynamic('.$FolderList1[$i]['FolderId'].');"><img src="../images/cross.png" border="0"></a>
								        <a class="fancybox fancybox.iframe" href="CreateFolder.php?edit='.$FolderList1[$i]['FolderId'].'"><img src="../images/edit.png" border="0"></a>';
	                        }
							echo '</li>';
							 		
						}
			        }
			       /*---------------- end ------------------------------------------------*/  

	/*---------------- Added by Chetan for Custom Reports Listing in crm Reports on 26 Sept. 2016---------*/
				if($ModuleParentID == 116) { 
					$_SESSION['ModuleParentID'] = $ModuleParentID;
					require_once($Prefix."classes/custom_reports.class.php");
					$objReports	=	new customreports();
					$ReportList	=	$objReports->GetReportLists();
				for($i=0;$i<sizeof($ReportList);$i++) {
			
					$ReportName = mysql_real_escape_string(($ReportList[$i]['report_name']));
					$Class = (($_GET['view'] !='' && $_GET['menu'] == 1 && $_GET['view'] == $ReportList[$i]['report_ID'])?("active"):(""));
		
					echo '<li class="submenu '.$Class.'"><a href="vcreport.php?view='.$ReportList[$i]['report_ID'].'&menu=1&curP=1" >'.$ReportName.'</a>';
					echo '</li>';
						 		
					}
				}

/*---------------- Added by Chetan for Custom Search Listing in Inventory Item Master on 26 Sept. 2016---------*/
				if($ModuleParentID == 601) { 
					$_SESSION['ModuleParentID'] = $ModuleParentID;
					require_once($Prefix."classes/custom_search.class.php");
					$objSearch	=	new customsearch();
					$searchList	=	$objSearch->GetSearchLists();
				for($i=0;$i<sizeof($searchList);$i++) {
			
					$SearchName = mysql_real_escape_string(($searchList[$i]['search_name']));
					$Class = (($_GET['view'] !='' && $_GET['menu'] == 1 && $_GET['view'] == $searchList[$i]['search_ID'])?("active"):(""));
		
					echo '<li class="submenu '.$Class.'"><a href="vcsearch.php?view='.$searchList[$i]['search_ID'].'&menu=1&tab=look" >'.$SearchName.'</a>';
					echo '</li>';
						 		
					}
				}
			       /*---------------- end ------------------------------------------------*/  


/****************** For licensee report***********************************/

if($ModuleParentID == 805 && $_SESSION['DisplayName'] =='bhoodev' ) { 
					$_SESSION['ModuleParentID'] = $ModuleParentID;
					
					$Class = ($SelfPage=="viewPosLicenseeReport.php")?("active"):("");
		
					echo '<li class="submenu '.$Class.'"><a href="viewPosLicenseeReport.php" >Licensee Report</a>';
					echo '</li>';
						 		
					}
				

/****************************End******************************************/





			}
	    }
	   
	   
	   $Class = ($SelfPage=="changePassword.php")?("active"):("");
	  /*  echo '<li class="chanpass '.$Class.'"><a class="fancybox fancybox.iframe" href="'.$MainPrefix.'chPassword.php" >Change Password</a></li>';
	  
	   echo '<li class="chanpass '.$Class.'"><a href="'.$MainPrefix.'changePassword.php" >Change Password</a></li>';
	   echo '<li class="logoff"><a href="'.$MainPrefix.'logout.php" >Log Out</a></li>';
	   */
	   ?>
	   
	 	<script language="JavaScript1.2" type="text/javascript">
	   function ConfirmDeleteFolderDynamic(FolderId)
	    {
	       var MsgReturn=confirm('Are you sure you want to delete folder? This will delete all records also.');
	       //confirm("Press a button!");
	       if(MsgReturn==true){
	          
	           window.location='CreateFolder.php?delete_id='+FolderId;
	       }
	    }
	   </script>  
	   
</ul>
	</div> 
	
<? }

?>
