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
                
     });
</script>
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
-->
</style>
<div class="had">Sent Emails</div>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >


    
    <tr>
        <td  valign="top">


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
                <tr>
                                <td align="right" height="40" valign="bottom">
                                    <!--input type="submit" name="DeleteButton" class="button" value="Delete" onclick="javascript: return ValidateMultiple('Email', 'delete', 'NumField', 'emailID');"-->
                                     <input type="submit" name="DeleteButton" class="button_delete" value="Delete" onclick="javascript: return ValidateMultiple('Email', 'delete', 'NumField', 'emailID');" title="Delete Emails">
                                </td>
                            </tr>
                <div id="prv_msg_div" style="display:none"><img src="<?= $MainPrefix ?>images/loading.gif">&nbsp;Searching..............</div>
                <div id="preview_div">

                    <table <?= $table_bg ?>>
                            

                            <tr align="left"  >
                             <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','AddID','<?= sizeof($arryContact) ?>');" /></td>-->
                                <!--td width="10%"  class="head1" >Contact ID</td-->
                                <td width="8%"  class="head1" >To</td>
                                <td width="26%"  align="left" class="head1" >Subject</td>
                                <td width="2%"  align="center" class="head1" ></td>
                                <td width="6%"  align="center"  class="head1 head1_action" >Date</td>
                                <td width="1%" align="center" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll', 'emailID', '<?= sizeof($arrySentItems) ?>');" /></td>
                            </tr>

                        <?php
                        
                       
                        if (is_array($arrySentItems) && $num > 0) {
                            $flag = true;
                            $Line = 0;
                            
                            
                            foreach ($arrySentItems as $key => $values) {
                                $flag = !$flag;
                                $bgcolor = ($flag) ? ("#FAFAFA") : ("#FFFFFF");
                                $Line++;
                                $boldtext ='';
				if($values['Status']) $boldtext = "font-weight:bold;";

                                //if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
                                ?>
                                <tr align="left" >
                                        
                                      <td style="<?=$boldtext?>"><?php 
                                      
                                      $total_recipient=explode(',',$values["Recipient"]);
                                      if(count($total_recipient) > 2)
                                      {
                                        echo "<span class=to-block>".htmlspecialchars($total_recipient[0])."</span>,<span class=to-block>".$total_recipient[1]."</span>...";  
                                      } 
                                      else{
                                      	$x = explode(",", $values["Recipient"]);
                                      	$i = 0;
                                      	foreach ($x as $emails){
                                      		if($i>0) echo ", ";
                                        	echo "<span class=to-block>".htmlspecialchars($emails)."<a href='editImportContactList.php?pop=1&edit=".urlencode($emails)."' target='_blank' class='fancybox fancybox.iframe add'>Add/Edit Contact</a></span>";
                                      		$i++;
                                      	}
                                       
                                      }
                                       ?></td>
                                      
                                      

                                      <td align="left" style="line-height:30px;" >
                                          
                                          <a href="viewEmail.php?ViewId=<?php echo $values["autoId"] ?>&type=sent">
                                      <?php echo "<font style='$boldtext'>".stripslashes($values["Subject"])." :-";
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
                                          <span id="flagemail_<?php echo $values["autoId"] ?>" class="flag_e" style="float:right;"><a href="sentEmails.php?flag_id=<?php echo $values["autoId"] ?>"><?php if($values['FlagStatus']==0) {?><img src="images/email_flag.png" alt="Flag" title="Flag" class="flag_white"><?php } if($values['FlagStatus']==1) {?><img src="images/email_flag2.png" alt="Flag" title="Flag" class="flag_red"><?php }?></a> &nbsp;</span>
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
                                    
                                    echo date("F j, Y, g:i a",strtotime($values["ImportedDate"]));
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

                        <tr >  <td  colspan="8" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arrySentItems) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}
?></td>
                        </tr>
                    </table>

                </div> 
                

                <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
                <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
                <input type="hidden" name="NumField" id="NumField" value="<?= sizeof($arrySentItems) ?>">

            </form>
        </td>
    </tr>
</table>


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
							if(confirm("This will go to Trashcan folder. Continue ??")){
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

</script>
