<script language="JavaScript1.2" type="text/javascript">
    function ValidateSearch() {
        document.getElementById("prv_msg_div").style.display = 'block';
        document.getElementById("preview_div").style.display = 'none';
    }
    function filterLead(id)
    {
        location.href = "viewImportEmailId.php?module=email&customview=" + id;
        LoaderSearch();
    }
    $(document).ready(function(){

		$(".to-block").hover(
		function() { 
			$(this).find("a").show(300);
		  },
		  function() {
			 // if($(this).attr('class')!='add-edit-email')
				$(this).find("a").hide();
		
		});
                
                
                $(".flag_white").hide();
                $(".flag_red").show();
                $('.evenbg').hover(function() { 
			$(this).find(".flag_white").show();
                        //$(this).find(".flag_e").css('display','block');
		  },
		  function() {
			 
				$(this).find(".flag_white").hide();
                                //$(this).find(".flag_e").css('display','none');
                });
                $('.oddbg').hover(function() { 
			$(this).find(".flag_white").show();
                        //$(this).find(".flag_e").css('display','block');
		  },
		  function() {
			 
				 $(this).find(".flag_white").hide();
                                 //$(this).find(".flag_e").css('display','none');
                });
                
                
                //jquery show/hide for Delete, Mark as Read, Mark as Unread buttons
                $('#BtnArea').hide();
                $('input[type="checkbox"]').click(function(){
                    if($(this).is(":checked")){
                      
                        $('#BtnArea').show();
       
                    }
                    else if($(this).is(":not(:checked)")){
                        
                        //$('#BtnArea').hide();
                        $('#SelectAll').prop('checked',false);
                        var totalChecked=0;
                        $('input[type="checkbox"]').each(function(){
                            
                            if($(this).is(":checked"))
                            {
                                totalChecked=(totalChecked+1); 
                            }
                        });
                       
                       
                       
                       if((totalChecked==0)) {
                           
                           $('#BtnArea').hide();
                       }
                       if((totalChecked==1) && ($("#SelectAll").is(':checked')==true))
                       { 

                        $('#BtnArea').hide();
                        //$('#SelectAll').prop('checked',false); 
                        
                       }
                       
                       if((totalChecked==1) && ($("#SelectAll").is(':checked')==false))
                       {
                         $('#BtnArea').show();
                       }
                        
                    }
                });
                
                //End jquery show/hide for Delete, Mark as Read, Mark as Unread buttons
  
     });
</script>
<div class="had"><?php 

$FolderData=$objImportEmail->GetEmailFolderDetails($_GET['FolderId']);
echo ucfirst(mysql_real_escape_string($FolderData[0]['FolderName']));?> Emails</div>
<div class="message" align="center"><? if (!empty($_SESSION['mess_contact'])) {
    echo $_SESSION['mess_contact'];
    unset($_SESSION['mess_contact']);
} ?></div>
<style>
<!--
.evenbg:HOVER,.oddbg:HOVER{  background-color: #efefef;}
.to-block a{
  display: none;
  position: absolute;
  background: #e9e9e9;
  padding: 5px 24px;
    margin-left: -1px;
    margin-top: -5px;
    color:#005dbd;
      border: 1px solid gray;
  border-radius: 5px;
  }
  
  .flag_e:hover{
      cursor:pointer; 
      
  }
  
  
  -->
</style>

 <div class="message" align="center">
               <?php 
               
                 
               
                 if(!empty($_SESSION['TrashCanMsg']))
                 {
                     echo $_SESSION['TrashCanMsg'];
                 }
                  
                 unset($_SESSION['TrashCanMsg']);
               ?>
                
            </div>

 <form action="" method="post" name="form1">
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
        <tr  valign="top" id="BtnArea">

                                              <td align="right" height="40" valign="bottom">
                                    <?php 
                                    
                                    $FolderList=$objImportEmail->ListFolderName('',$_SESSION[AdminID],$_SESSION[CmpID]);
                                      
                                    ?>
                                    <select name="MoveToFolder" id="MoveToFolder" class="inputbox" onchange="SelectFolderName(this.value);">
                                        <option value="">Move To</option>
                                        <option value="Inbox" >Inbox</option>
                                        <option value="Spam" >Spam</option>
                                        <?php
                                        for($i=0;$i<sizeof($FolderList);$i++) {
                                            
                                            if ($FolderList[$i]['FolderId']!=$_GET['FolderId'])
                                            {
                                            ?>
                                            <option value="<?=$FolderList[$i]['FolderId']?>" ><?=$FolderList[$i]['FolderName']?></option>
                                        <?php 
                                            }
                                        }
                                        ?>
                                    
                                    </select>
                                    <input type="submit" name="MarkUnRead" class="button_unread" value="Mark as unread" onclick="javascript: return ValidateMultiple('Email', 'Mark as unread', 'NumField', 'emailID');" title="Mark as unread">
                                    <input type="submit" name="MarkRead" class="button_read" value="Mark as read" onclick="javascript: return ValidateMultiple('Email', 'Mark as read', 'NumField', 'emailID');"  title="Mark as read">
                                    <input type="submit" name="DeleteButton" class="button_delete" value="Delete" onclick="javascript: return ValidateMultiple('Email', 'delete', 'NumField', 'emailID');"  title="Delete Emails">
                                    
                                </td>
                </tr>

<tr>
<td>


                <div id="prv_msg_div" style="display:none"><img src="<?= $MainPrefix ?>images/loading.gif">&nbsp;Searching..............</div>
                <div id="preview_div">

                    <table <?= $table_bg ?>>
                            

                            <tr align="left"  >
                             <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','AddID','<?= sizeof($arryContact) ?>');" /></td>-->
                                <!--td width="10%"  class="head1" >Contact ID</td-->
                                <td width="8%"  class="head1" >From</td>
                                <td width="26%"  align="left" class="head1" >Subject</td>
                                <td width="2%"  align="center" class="head1" ></td>
                                <td width="6%"  align="center"  class="head1 head1_action" >Date</td>
                                <td width="1%" align="center" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll', 'emailID', '<?= sizeof($arryEmailsList) ?>');" /></td>
                            </tr>

                        <?php
                        
                       
                        if (is_array($arryEmailsList) && $num > 0) {
                            
                            
                            $flag = true;
                            $Line = 0;
                            
                            
                            foreach ($arryEmailsList as $key => $values) {
                                $flag = !$flag;
                                $bgcolor = ($flag) ? ("#FAFAFA") : ("#FFFFFF");
                                $Line++;
                                $boldtext ='';
				if($values['Status']) $boldtext = "font-weight:bold;";

                                //if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
                                ?>
                                <tr align="left" >
                                        
                                      <td style="<?=$boldtext?>"><?php 
                                      
                                      
                                        //echo "<span class=to-block>".$values['From_Email']."</span>"; 
                                        echo "<span class=to-block>".$values['From_Email']."<a href='editImportContactList.php?pop=1&edit=".urlencode($values['From_Email'])."' target='_blank' class='fancybox fancybox.iframe add'>Add/Edit Contact</a></span>";
                                      
                                       
                                     
                                       ?></td>
                                      
                                      

                                      <td align="left" style="line-height:30px;">
                                          
                                          
                                          <a href="viewEmail.php?ViewId=<?php echo $values["autoId"] ?>&FolderId=<?=$_GET['FolderId']?>">
                                      <?php echo "<font style='$boldtext'>".stripslashes($values["Subject"]).":-";
                                              if($countt_data=str_word_count($values["EmailContent"]) > 15)
                                              {    
                                               //echo (substr(stripslashes($values["EmailContent"]),0,10)).'....';
                                                  
                                                  for($j=0;$j>=15;$j++)
                                                  {
                                                      $content.=$countt_data[$j].' ';   
                                                  }
                                                  echo $content." ....";
                                              }
                                              else {
                                                  
                                                  echo stripslashes($values["EmailContent"])." ....";
                                              }
                                              
                                              ?>
                                           </font>
                                          </a> 
                                          <span id="flagemail_<?php echo $values["autoId"] ?>" class="flag_e" style="float:right;"><a href="viewFolderEmails.php?FolderId=<?=$_GET['FolderId']?>&flag_id=<?php echo $values["autoId"] ?>"><?php if($values['FlagStatus']==0) {?><img src="images/email_flag.png" alt="Flag" title="Flag" class="flag_white"><?php } if($values['FlagStatus']==1) {?><img src="images/email_flag2.png" alt="Flag" title="Flag" class="flag_red"><?php }?></a> &nbsp;</span>
                                      </td>
                                      <td align="center">
                                            
                                        <?php
                                        
                                          $select_attach="select count(AutoId) as CountAttach from importemailattachments where EmailRefId='".$values['autoId']."'";
                                          $data=mysql_fetch_array(mysql_query($select_attach));
                                          if($data[CountAttach] > 0)
                                          {
                                           echo "<img src='".$MainPrefix."../images/attachment_icon.png'>";
                                          }
                                         ?>
                                      </td>
                                        
        
                                <td  align="center" class="head1_inner" >
                                     <?php $values["ImportedDate"]; 
                                    
                                    echo date("F j, Y, g:i a",strtotime($values["composedDate"]));
                                     ?>
                                  </td>
                                  <td align="center"><input type="checkbox" name="emailID[]" id="emailID<?=$Line?>" value="<?=$values["autoId"]?>"></td>
                                </tr>
                            <?php } // foreach end //?>

<?php } else { ?>
                            <tr align="center" >
                                <td  colspan="8" class="no_record"><?= NO_RECORD ?></td>
                            </tr>
<?php } ?>

                        <tr >  <td  colspan="8" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryEmailsList) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}
?></td>
                        </tr>
                    </table>

                </div> 
                

                <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
                <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
                <input type="hidden" name="NumField" id="NumField" value="<?= sizeof($arryEmailsList) ?>">

            
        </td>
    </tr>
</table>
</form>

<script>
    
 function ValidateMultiple(moduleName,actionToPerform,NumFieldName,ToSelect){
     
        
		var checkedFlag = 0;
		var ids = '';
		TotalRecords = document.getElementById(NumFieldName).value;
                
                
		if(TotalRecords > 0){
				for(var i=1;i<=TotalRecords;i++){
					if(document.getElementById(ToSelect+i).checked==true){
						if(checkedFlag == 0){
							checkedFlag = 1;
						}
						ids += document.getElementById(ToSelect+i).value+',';
					}
				}
                                
                                

				if(checkedFlag == 0){
					alert("You must select atleast one "+moduleName+" to "+actionToPerform+".");
                                        
				}else{
					if(actionToPerform=="delete"){
							if(confirm("Are you sure you sure you want to move the selected emails in trash?")){
								ShowHideLoader(1,'P');
								return true;
							}else{
								return false;
							}
					}else if(actionToPerform=="Mark as read"){
							if(confirm("Are you sure you sure you want to mark all selected emails as read?")){
								
                                                                ShowHideLoader(1,'P');
								return true;
							}else{
								return false;
							}
					}else if(actionToPerform=="Mark as unread"){
							if(confirm("Are you sure you sure you want to mark all selected emails as unread?")){
								
                                                                ShowHideLoader(1,'P');
								return true;
							}else{
								return false;
							}
					}else{
						ShowHideLoader(1,'P');
						return true;
					}

				}
		}
		return false;
			
}

function SelectFolderName(FolderId)
{
        //alert(FolderId);return false;
        document.form1.submit();  
}

</script>
