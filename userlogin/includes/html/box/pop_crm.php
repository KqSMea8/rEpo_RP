<? 
/********Connecting to main database*********/
$Config['DbName'] = $_SESSION['CmpDatabase'];
$objConfig->dbName = $Config['DbName'];
$objConfig->connect();
/*******************************************/
$arrayCrmMenus = $objConfig->GetHeaderMenusUser($_SESSION['UserID'],5,'',1);

$arryCMenu= array();

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

$call = $objactivity ->CountActivity('Call');
$Meeting = $objactivity ->CountActivity('Meeting');
$Task = $objactivity ->CountActivity('Task ');

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


if($Config['CurrentDepID']!=5){
	$PopCrmPrefix = $MainPrefix.'crm/';
}
?>

<div class="botpop">

	<div class="boticons">
	   <a class="call-icon <?=$addClass1?>" title="Call"><? if($call >0){?><span class="notfic"><?=$call?></span><? }?></a>
	   <a href="#" class="calendar-icon <?=$addClass2?>" title="Meeting"><? if($Meeting >0){?><span class="notfic"><?=$Meeting?></span><?}?></a>
	   <a href="#" class="metting-icon  <?=$addClass3?>" title="Task"><? if($Task >0){?><span class="notfic"><?=$Task?></span><? }?></a>




<div class="callnoti">
<h4>Calls <img src="../images/close.gif" class="close_call" ></h4>
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
<h4>Meeting <img src="../images/close.gif" class="close_calc" ></h4>
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
<h4>Tasks <img src="../images/close.gif" class="close_meet" ></h4>
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

	$('.metting-icon .notfic').click(function() {
	  $('.callnoti').hide("slow"); 
	  $('.calccnoti').hide("slow");   
	}); 
	$('.calendar-icon .notfic').click(function() {
	    $('.callnoti').hide("slow"); 
	    $('.meetnoti').hide("slow");  
	}); 
	$('.call-icon .notfic').click(function() {
	  $('.meetnoti').hide("slow");  
	  $('.calccnoti').hide("slow"); 
	}); 


	$('.close_call').click(function() {	
	  $('.callnoti').hide("slow");   
	});

	$('.close_calc').click(function() {	
	  $('.calccnoti').hide("slow");   
	});


	$('.close_meet').click(function() {	
	  $('.meetnoti').hide("slow");   
	}); 





}); 
</script>
<? } ?>
