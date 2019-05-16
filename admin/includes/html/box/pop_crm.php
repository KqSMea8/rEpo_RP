<? 
/********Connecting to main database*********/
$Config['DbName'] = $_SESSION['CmpDatabase'];
$objConfig->dbName = $Config['DbName'];
$objConfig->connect();
/*******************************************/
$arrayCrmMenus = $objConfig->GetHeaderMenusUserNew($_SESSION['UserID'],5,'',1);
if(!empty($arrayCrmMenus[0]['ModuleID'])){

foreach($arrayCrmMenus as $key=>$valuesC){ 
	$arryCMenu[] = $valuesC['ModuleID'];
}
 

if(in_array('136',$arryCMenu)){

/********Connecting to main database*********/
$Config['DbName'] = $_SESSION['CmpDatabase'];
$objConfig->dbName = $Config['DbName'];
$objConfig->connect();
/*******************************************/

require_once($Prefix."classes/event.class.php");
$objactivity = new activity();	
require_once($Prefix."classes/edi.class.php"); // added by karishma for edi notification
$ediObj=new edi(); 

$call = $objactivity ->CountActivity('Call');
$Meeting = $objactivity ->CountActivity('Meeting');
$Task = $objactivity ->CountActivity('Task');
$Edi=$ediObj->CountRequestedEDI('Reqest');

$addClass1=$addClass2=$addClass3=$addClass4=$addClass5='';

if($call >0){
	$addClass1 = "active";
	$arryCall = $objactivity ->GetActivityDeshboard('Call');
}
if($Meeting >0){
	$arryMeeting = $objactivity ->GetActivityDeshboard('Meeting');
	$addClass2 = "active";
}
if($Task >0){
	$arryTask = $objactivity ->GetActivityDeshboard('Task');
	$addClass3 = "active";
}

if($Edi>0){

$arryEdi = $ediObj ->GetRequestedEDI('Reqest');
$addClass5 = "active";

}
/************/
$nEmail=0;
$EmailActive=$objConfig->isEmailActive(); 
if($EmailActive==1){
	$nEmail = $objConfig->CountImportEmailsBott(); 
	if($nEmail >0){	
		$arryNEmail=$objConfig->ListImportEmailsBott();
		$addClass4 = "active";
	}
}
/**********/


$PopCrmPrefix = '';
if($Config['CurrentDepID']!=5){
	$PopCrmPrefix = $MainPrefix.'crm/';
}
?>

<div class="botpop">

	<div class="boticons">
	   <a class="call-icon <?=$addClass1?>" title="Call"><? if($call >0){?><span class="notfic"><?=$call?></span><? }?></a>
	   <a href="#" class="calendar-icon <?=$addClass2?>" title="Meeting"><? if($Meeting >0){?><span class="notfic"><?=$Meeting?></span><?}?></a>
	   <a href="#" class="metting-icon  <?=$addClass3?>" title="Task"><? if($Task >0){?><span class="notfic"><?=$Task?></span><? }?></a>
	 <a href="#" class="email-icon  <?=$addClass4?>" title="Email"><? if($nEmail >0){?><span class="notfic" id="notficemailpop"><?=$nEmail?></span><? }?></a>
<a href="#" class="edi-icon <?=$addClass5?>" title="EDI"><? if($Edi >0){?><span class="notfic"><?=$Edi?></span><? }?></a>  
<!-- EDI Functionality  and class added in css admin.css-->


<div class="callnoti">
<h4>Calls <img src="<?=$MainPrefix?>images/close.gif" class="close_call" ></h4>
<div class="boxbgf">
<table cellspacing="0" cellpadding="0" border="0" width="100%" class="poptable">
<tbody>
<?php 
if($call>0){
foreach($arryCall as $key=>$CallValue){?>
   <tr class="even">
      <td><a href="<?=$PopCrmPrefix?>vActivity.php?view=<?=$CallValue['activityID']?>&amp;mode=Call&amp;module=Activity" target="_blank"><?=stripslashes($CallValue['subject']);?></a></td>
    </tr>                            
 <? } } else{?>
 <tr class="even">
      <td>No calls.</td>
    </tr> 
<? }?>                       
                             </tbody>
                               </table>
</div>

</div>






<div class="calccnoti">
<h4>Meeting <img src="<?=$MainPrefix?>images/close.gif" class="close_calc" ></h4>
<div class="boxbgf">
<table cellspacing="0" cellpadding="0" border="0" width="100%" class="poptable">
<tbody>
<?php 

if($Meeting >0){
foreach($arryMeeting as $key=>$MeetingValue){?>
   <tr class="even">
      <td><a href="<?=$PopCrmPrefix?>vActivity.php?view=<?=$MeetingValue['activityID']?>&amp;mode=Call&amp;module=Activity" target="_blank"><?=stripslashes($MeetingValue['subject']);?></a></td>
    </tr> 
<? } } else{?>
 <tr class="even">
      <td>No events.</td>
    </tr> 
<? }?>
  </tbody>
</table></div>
</div>






<div class="meetnoti">
<h4>Tasks <img src="<?=$MainPrefix?>images/close.gif" class="close_meet" ></h4>
<div class="boxbgf">
<table cellspacing="0" cellpadding="0" border="0" width="100%" class="poptable">
 <tbody>
<?php 
if($Task>0){
foreach($arryTask as $key=>$TaskValue){?>
   <tr class="even">
      <td><a href="<?=$PopCrmPrefix?>vActivity.php?view=<?=$TaskValue['activityID']?>&amp;mode=Call&amp;module=Activity" target="_blank"><?=stripslashes($TaskValue['subject']);?></a></td>
    </tr>                            
 <? } } else{?>
 <tr class="even">
      <td>No tasks.</td>
    </tr> 
<? }?>  

          </tbody>
  </table>
</div>
</div>



<div class="emailnoti">
<h4>Email <img src="<?=$MainPrefix?>images/close.gif" class="close_email" ></h4>
<div class="boxbgf">
<table cellspacing="0" cellpadding="0" border="0" width="100%" class="poptable">
 <tbody>
<?php 
if($nEmail>0){
foreach($arryNEmail as $key=>$EmailValue){?>
   <tr class="even">
      <td><a href="<?=$PopCrmPrefix?>viewEmail.php?ViewId=<?=$EmailValue['autoId']?>&type=inbox"><?=substr(stripslashes($EmailValue['Subject']),0,45)?>...</a></td>
    </tr>                            
<? }?>
  <tr class="red">
      <td align="right"><a href="<?=$PopCrmPrefix?>viewImportedEmails.php" target="_blank">More...</a></td>
    </tr> 
<? } else{?>
 <tr class="even">
      <td>No Emails.</td>
    </tr> 
<? }?>  

          </tbody>
  </table>
</div>
</div>


<div class="edinoti" style="display:none;">
 <h4>EDI <img src="<?=$MainPrefix?>images/close.gif" class="close_edi" ></h4>
 <div class="boxbgf"> 
<table cellspacing="0" cellpadding="0" border="0" width="100%" class="poptable">
 <tbody>
 <?php if($Edi>0){
    foreach($arryEdi as $key=>$EdiValue){?>
 <tr class="even"> <td><a href="../admin/edi/requestEDI.php?type=Reqest" ><?=stripslashes($EdiValue['RequestedCompName']).' requested to enable EDI.';?></a></td>
 </tr> 
<? } } else{?> 
<tr class="even">
 <td>No EDI Request.</td> 
</tr> <? }?> 
</tbody>
 </table>
 </div>
 </div>



</div>








<script type="text/javascript">
$( document ).ready(function() {
	$('.call-icon .notfic').click(function() {
	  $('.callnoti').animate({   
		bottom:'38px',
	    	height: 'toggle',
		display:'block'
	  }, 500, function() {
	    
	  });
	}); 

	$('.calendar-icon .notfic').click(function() {
	  $('.calccnoti').animate({   
		bottom:'38px',
	    	height: 'toggle',
		display:'block'
	  }, 500, function() {
	    
	  });
	});

	$('.metting-icon .notfic').click(function() {
	  $('.meetnoti').animate({   
		bottom:'38px',
	    	height: 'toggle',
		display:'block'
	  }, 500, function() {
	    
	  });
	});


	$('.email-icon .notfic').click(function() {
	  $('.emailnoti').animate({   
		bottom:'38px',
	    	height: 'toggle',
		display:'block'
	  }, 500, function() {
	    
	  });
	});
$('.edi-icon').click(function() { $('.edinoti').animate({ bottom:'38px', height: 'toggle', display:'block' }, 500, function() { }); });

	$('.edi-icon .notfic').click(function() {
	  $('.edinoti').animate({   
		bottom:'38px',
	    	height: 'toggle',
		display:'block'
	  }, 500, function() {
	    
	  });
	});

	$('.metting-icon .notfic').click(function() {
	  $('.callnoti').hide("slow"); 
	  $('.calccnoti').hide("slow");  
	   $('.emailnoti').hide("slow");    
	}); 
	$('.calendar-icon .notfic').click(function() {
	    $('.callnoti').hide("slow"); 
	    $('.meetnoti').hide("slow"); 
	     $('.emailnoti').hide("slow");    
	}); 
	$('.call-icon .notfic').click(function() {
	  $('.meetnoti').hide("slow");  
	  $('.calccnoti').hide("slow"); 
	   $('.emailnoti').hide("slow");   
	}); 

	$('.email-icon .notfic').click(function() {
	  $('.callnoti').hide("slow"); 
	  $('.calccnoti').hide("slow");  
	   $('.meetnoti').hide("slow");    
	}); 

$('.edi-icon .notfic').click(function() { 
$('.callnoti').hide("slow"); 
$('.calccnoti').hide("slow"); 
$('.meetnoti').hide("slow");
 $('.edinoti').hide("slow"); });

	$('.close_call').click(function() {	
	  $('.callnoti').hide("slow");   
	});

	$('.close_calc').click(function() {	
	  $('.calccnoti').hide("slow");   
	});


	$('.close_meet').click(function() {	
	  $('.meetnoti').hide("slow");   
	}); 

	$('.close_email').click(function() {	
	  $('.emailnoti').hide("slow");   
	}); 

$('.close_edi').click(function() {	$('.edinoti').hide("slow"); });

}); 
</script>
<? }
} ?>
