<?php 
	/* start calling */
	require_once(_ROOT."/admin/crm/includes/html/callBlock.php"); 
	/* -- end call -- */
   $currentdep=$Config['CurrentDepID'];

?>
<style type="text/css">
    
      /* HOVER STYLES  facebook*/
      div#pop-upf {
        display: none;
        position: absolute;
        width: 100%;
        min-height: 150px;
        padding: 10px;
        background: #eeeeee;
        color: #000000;
        border: 1px solid #1a1a1a;
        font-size: 90%;
      }
      
      /* HOVER STYLES twitter*/
      div#pop-upt {
        display: none;
        position: absolute;
        width: 100%;
        min-height: 150px;
        padding: 10px;
        background: #eeeeee;
        color: #000000;
        border: 1px solid #1a1a1a;
        font-size: 90%;
      }
      
      /* HOVER STYLES linked*/
      div#pop-upL {
        display: none;
        position: absolute;
        width: 100%;
        min-height: 150px;
        padding: 10px;
        background: #eeeeee;
        color: #000000;
        border: 1px solid #1a1a1a;
        font-size: 90%;
      }
      
      /* HOVER STYLES google*/
      div#pop-upG {
        display: none;
        position: absolute;
        width: 100%;
        min-height: 150px;
        padding: 10px;
        background: #eeeeee;
        color: #000000;
        border: 1px solid #1a1a1a;
        font-size: 90%;
      }
      
      /* HOVER STYLES Instagram*/
      div#pop-upI {
        display: none;
        position: absolute;
        width: 100%;
        min-height: 150px;
        padding: 10px;
        background: #eeeeee;
        color: #000000;
        border: 1px solid #1a1a1a;
        font-size: 90%;
      }
      .tdpopup.sremove > a:hover {
    text-decoration: underline;
}

.fc {
    background: url("../images/close12.png") no-repeat scroll 0 0 rgba(0, 0, 0, 0);
    border-radius: 34px;
    display: inline-block;
    height: 14px;
    margin-left: 29px;
    margin-top: -5px;
    position: absolute;
    width: 14px;
    z-index: 1;
}
    </style>
<script type="text/javascript">
    function confirmDelete(buttonControl,recordId,type,deprt) {
        if(type==1){
            
            var socialType ='facebookdelete';
        }else if(type==2){
              var socialType ='twitterdelete';
        }else if(type==3){
            
             var socialType ='linkeddelete';
        }
        else if(type==4){
            
            var socialType ='googledelete';
            
        }
        else if(type==5){
            
            var socialType ='instagramdelete';
            
        }
  if (confirm("Delete this record?") == true)
     location.href = "../viewprofile.php?id=" + recordId+"&type="+socialType+"&CurrentDep="+deprt;
  return false;
}

//code for popup on hover
      $(function() {
        var moveLeft = 20;
        var moveDown = -210;
        //facebook
        $('a#triggerf').hover(function(e) {
          $('div#pop-upf').show();
          //.css('top', e.pageY + moveDown)
          //.css('left', e.pageX + moveLeft)
          //.appendTo('body');
        }, function() {
          $('div#pop-upf').hide();
        });
        
        $('a#triggerf').mousemove(function(e) {
          $("div#pop-upf").css('top', e.pageY + moveDown).css('left', e.pageX + moveLeft);
        });
        
        //twitter
        
        $('a#triggert').hover(function(e) {
          $('div#pop-upt').show();
          //.css('top', e.pageY + moveDown)
          //.css('left', e.pageX + moveLeft)
          //.appendTo('body');
        }, function() {
          $('div#pop-upt').hide();
        });
        
        $('a#triggert').mousemove(function(e) {
          $("div#pop-upt").css('top', e.pageY + moveDown).css('left', e.pageX + moveLeft);
        });
        
        //Linkdin
        $('a#triggerL').hover(function(e) {
          $('div#pop-upL').show();
          //.css('top', e.pageY + moveDown)
          //.css('left', e.pageX + moveLeft)
          //.appendTo('body');
        }, function() {
          $('div#pop-upL').hide();
        });
        
        $('a#triggerL').mousemove(function(e) {
          $("div#pop-upL").css('top', e.pageY + moveDown).css('left', e.pageX + moveLeft);
        });
        
        //Google-plus
        $('a#GoogleP').hover(function(e) {
          $('div#pop-upG').show();
          //.css('top', e.pageY + moveDown)
          //.css('left', e.pageX + moveLeft)
          //.appendTo('body');
        }, function() {
          $('div#pop-upG').hide();
        });
        
        $('a#GoogleP').mousemove(function(e) {
          $("div#pop-upG").css('top', e.pageY + moveDown).css('left', e.pageX + moveLeft);
        });
        
        
        //Instagram
        $('a#instagram').hover(function(e) {
          $('div#pop-upI').show();
          //.css('top', e.pageY + moveDown)
          //.css('left', e.pageX + moveLeft)
          //.appendTo('body');
        }, function() {
          $('div#pop-upI').hide();
        });
        
        $('a#instagram').mousemove(function(e) {
          $("div#pop-upI").css('top', e.pageY + moveDown).css('left', e.pageX + moveLeft);
        });
        
      });
      
    </script>
<div class="right_box">
<? if($_GET['tab']=="contact"){?>


  <table width="100%"  border="0" cellpadding="0" cellspacing="0">
    <form name="form1" action="<?=$ActionUrl?>"  method="post" onSubmit="return validate_<?=$_GET['tab']?>(this);" enctype="multipart/form-data">
      <? if (!empty($_SESSION['mess_contact'])) {?>
      <tr>
        <td  align="center"  class="message"  ><? if(!empty($_SESSION['mess_contact'])) {echo $_SESSION['mess_contact']; unset($_SESSION['mess_contact']); }?>
        </td>
      </tr>
      <? } ?>
      <tr>
        <td  align="center" valign="top" >
        <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
            
<?php
//By chetan 11Dec// 
$head = 1;
$arrayVal = $arryContact[0];
for($h=0;$h<sizeof($arryHead);$h++){
    if($arryHead[$h]['head_value'] != 'Assign Role')
    {
    ?>
                    
    <tr>
        <td colspan="8" align="left" class="head"><?=$arryHead[$h]['head_value']?></td>
    </tr>

<?php 

$arryField = $objField->getFormField('',$arryHead[$h]['head_id'],'1'); 
$Narry = array_map(function($arr){
            if($arr['fieldname'] == 'FullName' || $arr['fieldname'] == 'contact')
            {
                unset($arr);
            }else{
               return $arr; 
            }
        },$arryField);

    $arryField = array_values(array_filter($Narry));   
include("includes/html/box/viewCustomFieldsNew.php");
    }

}
 //End//
?>       
                        
                        

                        
            <tr>
                <td colspan="8" align="left" class="head_social">Social Information</td>
            </tr>
           
		 	<tr>      		   
          		<td class="tdpopup"  align="center" colspan="3" >          	
           			 <?php if(!empty($arryContact[0]['FacebookID'])){$socialdata=stripslashes(nl2br($arryContact[0]['FacebookID']));
           			$socialdata = (!empty($socialdata)) ? @unserialize($socialdata) : '';
                                        echo '<a href="javascript:void(0)" class="fc" onclick="confirmDelete(this,'.$_GET['view'].',1,'.$currentdep.')"></a>';
           				echo '<a href="javascript:void(0)" class="facebookview v_facebook fancybox fancybox.iframe" id="triggerf"></a>';
           			 }else{echo '&nbsp;';}?>
                        <div id="pop-upf" style="width: 530px; z-index: 999;">
                               <?php echo '<iframe  src="../viewprofile.php?id='.$arryContact[0]['FacebookID'].'&type=facebook" style="min-height:180px; width: 530px">
</iframe>';?>
                            </div>
                        
                        
           			  <?php if(!empty($arryContact[0]['TwitterID'])){$socialdata=stripslashes(nl2br($arryContact[0]['TwitterID']));
           			$socialdata = ($socialdata) ? @unserialize($socialdata) : '';
                                        echo '<a class="fc" href="javascript:void(0)" onclick="confirmDelete(this,'.$_GET['view'].',2,'.$currentdep.')"></a>';
           				echo '<a href="javascript:void(0)" id="triggert" class="v_Twitter"></a>';
           			 }else{echo '&nbsp;';}?>
                        <div id="pop-upt" style="width: 530px; z-index: 999;">
                                <?php echo '<iframe  src="../viewprofile.php?id='.$arryContact[0]['TwitterID'].'&type=twitter" style="min-height:180px; width: 100%;">
</iframe>';?>
                            </div>
                        
                        
           			  <?php $id='';
           			$t=''; if(!empty($arryContact[0]['LinkedinID'])){$socialdata=stripslashes(nl2br($arryContact[0]['LinkedinID']));
           			$socialdata = ($socialdata) ? @unserialize($socialdata) : '';
           			$id=$arryContact[0]['LinkedinID'];
           			$t='linkedin';
           			 echo '<a class="fc" href="javascript:void(0)" onclick="confirmDelete(this,'.$_GET['view'].',3,'.$currentdep.')"></a>';
           			 echo '<a href="javascript:void(0)" class="linkedinview v_Linkedin fancybox fancybox.iframe" id="triggerL"></a>';
           			 }else{echo '&nbsp;';}?>
                        <div id="pop-upL" style="width: 530px; z-index: 999;">
                                <?php echo '<iframe  src="../viewprofile.php?id='.$id.'&type='.$t.'" style="min-height:180px; width: 100%;">
</iframe>';?>
                            </div>
                            
                            <!-- start googple-plus -->
                            <?php $id='';
           			$t=''; if(!empty($arryContact[0]['GoogleID'])){$socialdata=stripslashes(nl2br($arryContact[0]['GoogleID']));
           			$socialdata = ($socialdata) ? @unserialize($socialdata) : '';
           			$id=$arryContact[0]['GoogleID'];
           			$t='googleplus';
           			 echo '<a class="fc" href="javascript:void(0)" onclick="confirmDelete(this,'.$_GET['view'].',4,'.$currentdep.')"></a>';
           			 echo '<a href="javascript:void(0)" class="linkedinview v_GooglePlus fancybox fancybox.iframe" id="GoogleP"></a>';
           			 }else{echo '&nbsp;';}?>
                        <div id="pop-upG" style="width: 530px; z-index: 999;">
                                <?php echo '<iframe  src="../viewprofile.php?id='.$id.'&type='.$t.'" style="min-height:180px; width: 100%;">
</iframe>';?>
                            </div>
                            <!-- End googple-plus -->
                            <!-- start Instagram-profile -->
                            <?php $id='';
           			$t=''; if(!empty($arryContact[0]['InstagramID'])){$socialdata=stripslashes(nl2br($arryContact[0]['InstagramID']));
           			$socialdata = ($socialdata) ? @unserialize($socialdata) : '';
           			$id=$arryContact[0]['InstagramID'];
           			$t='instagram';
           			 echo '<a class="fc" href="javascript:void(0)" onclick="confirmDelete(this,'.$_GET['view'].',5,'.$currentdep.')"></a>';
           			 echo '<a href="javascript:void(0)" class="linkedinview v_instagram fancybox fancybox.iframe" id="instagram"></a>';
           			 }else{echo '&nbsp;';}?>
                        <div id="pop-upI" style="width: 530px; z-index: 999;">
                                <?php echo '<iframe  src="../viewprofile.php?id='.$id.'&type='.$t.'" style="min-height:180px; width: 100%;">
</iframe>';?>
                            </div>
                            <!-- End Instagram-profile -->
                            
                        
                        </td>
				</tr>
                                
          </table></td>
      </tr>
      <tr>
       		 <td colspan="8" align="left"   ><?php include("includes/html/box/comment.php");  ?></td>
        </tr>
    </form>
  </table><? }?>



 <?  if($_GET['tab']=="Campaign"){?>

	<div id="preview_div">
          
  <TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right">
        <a class="button" style="font-size:12px; color:#FFFFFF;" href="#" onclick="return window.open('leadCompaign.php?module=<?=$_GET['tab']?>&amp;return_module=<?=$_GET['module']?>&amp;parent_type=<?=$_GET['module']?>&amp;parentID=<?=$_GET['view']?>','test','width=640,height=602,resizable=0,scrollbars=0');" ><b>Select Campaign</b></a>
        
         
     
        
        </td>
      </tr>
      
      
      
	<tr>
	  <td  valign="top">
    <table <?=$table_bg?>>
   
    

	 <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','CampaignID','<?=sizeof($arryCampaign)?>');" /></td>-->
      <td width="18%"  class="head1" >Campaign Name</td>
      <td width="14%"  class="head1" >Campaign Type</td>
      <td width="12%"  class="head1" >Campaign Status</td>
       <td width="12%" class="head1" >Expected Revenue</td>
     <td width="13%" class="head1" >Expected Close Date</td>
     
      <td width="16%"  align="center" class="head1" >Assign To</td>
      <td width="15%"  align="center" class="head1" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryCampaign) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryCampaign as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?("#FDFBFB"):("");
	$Line++;
	
	//if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
     <!-- <td ><input type="checkbox" name="CampaignID[]" id="CampaignID<?=$Line?>" value="<?=$values['campaignID']?>" /></td>-->
      <td ><?=stripslashes($values["campaignname"])?></td>
      <td height="20" > <?=stripslashes($values["campaigntype"])?>	 </td>
	    <td height="20" > <?=stripslashes($values["campaignstatus"])?>	 </td>
			
		<td><?=$values['expectedrevenue']?> <?=$Config['Currency']?></td>
        <td height="20" > 
	<?  	if($values["closingdate"]!="0000-00-00"){//echo $Config['DateFormat'];
		echo date($Config['DateFormat'] , strtotime($values["closingdate"])); }?> </td>
     
	  <td><?=$values['AssignTo']?>(<?=$values['Department']?>)</td>
	  
   
      <td  align="center"  >
	   <a href="vCampaign.php?view=<?=$values['campaignID']?>&module=Campaign&curP=<?=$_GET['curP']?>" ><?=$view?></a>
	 
	  <a href="editCampaign.php?edit=<?php echo $values['campaignID'];?>&module=Campaign&amp;curP=<?php echo $_GET['curP'];?>&tab=Edit" ><?=$edit?></a>
	  
	<a href="editCampaign.php?del_id=<?php echo $values['campaignID'];?>&module=Campaign&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a>   </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="8" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryCampaign)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>      </td>
        </tr>
        
        </TABLE>
        
      </div> 
        <? }?>
     <? if($_GET['tab']=='Comments'){ include("comment.php");  }?>
<? /****************Code by Shravan ***********/?>
	<? if($_GET['tab']=='Email'){ 
	$EmailForInbox=stripslashes($arryContact[0]['Email']);
	include("../includes/html/box/combinedEmail.php");  
      }?>
<? /***************************/?>	
<? if($_GET['tab']=='Ticket'){?>
 

<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right">
        
        <a href="<?=$AddUrl?>" class="add" >Add  Ticket</a>
        <a class="button" style="font-size:12px; color:#FFFFFF; padding: 3px 5px 4px 20px;font-size: 12px;line-height: normal;border-radius: 2px 2px 2px 2px;" href="#" onclick="return window.open('leadCompaign.php?module=<?=$_GET['tab']?>&amp;return_module=<?=$_GET['module']?>&amp;parent_type=<?=$_GET['module']?>&amp;parentID=<?=$_GET['view']?>','test','width=640,height=602,resizable=0,scrollbars=0');" ><b>Select Ticket</b></a>
        
         
     
        
        </td>
      </tr>
      
      
      
	<tr>
	  <td  valign="top">

<table <?=$table_bg?>>
   
    <tr align="left"  >
      <!--<td width="0%"  class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','TicketID','<?=sizeof($arryTicket)?>');" /></td>-->
      <td width="13%"  class="head1" >Ticket ID</td>
      <td width="25%"  class="head1" >Title</td>
      <td width="14%" class="head1" > Add Date</td>
	  <td width="16%" class="head1" > Assign To</td>
    
      <td width="12%"  align="center" class="head1" >Status</td>
      <td width="20%"  align="center" class="head1 head1_action" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryTicket) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryTicket as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?("#FDFBFB"):("");
	$Line++;
	
	//if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
     <!-- <td ><input type="checkbox" name="TicketID[]" id="TicketID<?=$Line?>" value="<?=$values['TicketID']?>" /></td>-->
      <td ><?=$values["TicketID"]?></td>
      <td > 
	  <?
		  echo stripslashes($values['title']);
		  
		  
		  ?>		       </td>
        <td> <? echo date($Config['DateFormat']  , strtotime($values["ticketDate"]));?></td>
     
	  <td><?=$values['AssignTo']?>(<?=$values['Department']?>)</td>
       
    <td align="center">
	
	 

	<? echo $values['Status'];
		
	 ?></td>
      <td  align="center"  ><a href=" vTicket.php?view=<? echo $values['TicketID']?>&module=<?php echo $_GET['tab'];?>&curP=<?php echo $_GET['curP'];?>&tab=Information" ><?=$view?></a>&nbsp;
	 &nbsp;&nbsp; <a href="<?=$editTicket?><?php echo $values['TicketID'];?>&curP=<?php echo $_GET['curP'];?>&tab=Information" ><?=$edit?></a>
	  
	&nbsp;&nbsp;<a href="<?=$DelTicket?><?php echo $values['TicketID'];?>&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a>   </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="8" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryTicket)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>
  </td>
  </tr>
  </TABLE>
  
  </div> 

<? }?>

</div>


<SCRIPT LANGUAGE=JAVASCRIPT>
<? if($_GET["tab"]=="contact"){ ?>
	StateListSend();
<? } ?>
<? if($_GET["tab"]=="account"){ ?>
	ShowPermission();
<? } ?>
</SCRIPT>
