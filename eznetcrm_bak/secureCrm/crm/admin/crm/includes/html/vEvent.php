
 



<div class="back"><a class="back" href="<?=$RedirectURL?>">Back</a><a class="edit" href="<?=$EditUrl?>">Edit</a></div>
<div class="had">
Manage Event   &raquo; <strong>
	<? 	echo (!empty($_GET['view']))?(" Event Details") :("Add ".$ModuleName); ?>
		
		</strong>
</div>








  
  <? if (!empty($_SESSION['mess_Event'])) {?>

<div  align="center"  class="message"  >
	<? if(!empty($_SESSION['mess_Event'])) {echo $_SESSION['mess_Event']; unset($_SESSION['mess_Event']); }?>	
</div>

<? } ?>
  
  


<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">


  


<tr>
	 <td colspan="2" align="left" class="head">Event Details</td>
</tr>
     <tr>
        <td  align="right"   class="blackbold" width="40%"> Subject  :</td>
        <td   align="left" >
        <?php echo stripslashes($arryEvent[0]['subject']); ?>            </td>
        </tr>

	   <tr>
        <td  align="right"   class="blackbold"> Assigned To  : </td>
        <td   align="left" >
     <?php  echo $arryEvent[0]['AssignTo']; ?> (<b><?=$arryEvent[0]['Department']?></b>) </td>
      </tr>

	   <tr>
        <td  align="right"   class="blackbold"> Event Status  : </td>
        <td   align="left" >

		<?php echo stripslashes($arryEvent[0]['event_status']);?>
            </td>
      </tr>

      <tr>
        <td  align="right"   class="blackbold"> Priority : </td>
        <td   align="left" >

		<?php echo stripslashes($arryEvent[0]['priority']);?>
                     </td>
      </tr>

	  <tr>
        <td  align="right"   class="blackbold">Start Date & Time : </td>
        <td   align="left" >

  <?php  
	   $stdate= $arryEvent[0]["startDate"]." ".$arryEvent[0]["startTime"];
	 echo date($Config['DateFormat']." H:i:s" , strtotime($stdate));?>
		
                    </td>
      </tr>
      
      <tr>
        <td  align="right"   class="blackbold">Close Date & Time : </td>
        <td   align="left" >
<?php  
	   $ctdate= $arryEvent[0]["closeDate"]." ".$arryEvent[0]["closeTime"];
	 echo date($Config['DateFormat']." H:i:s" , strtotime($ctdate));?>
		
                    </td>
      </tr>
	  
	   <tr>
        <td  align="right"   class="blackbold"> Visibility  : </td>
        <td   align="left" >
        <?php echo stripslashes($arryEvent[0]['visibility ']); ?></td>
      </tr>
 <tr>
        <td  align="right"   class="blackbold"> Send Notification : </td>
        <td   align="left" >
<?php 


if($arryEvent[0]['Notification']==1){

$Notification="Yes";
}else{
$Notification="No";
}

echo stripslashes($Notification); ?>  </td>
      </tr>
       <tr>
        <td  align="right"   class="blackbold"> Location : </td>
        <td   align="left" >
        <?php echo stripslashes($arryEvent[0]['location']); ?></td>
      </tr>
      
      <tr>
	 <td colspan="2" align="left" class="head">Reminder</td>
</tr>
       <tr>
        <td  align="right"   class="blackbold"> Reminder : </td>
        <td   align="left" >
        <?php if($arryEvent[0]['reminder']==1){

$reminder="Yes";
}else{
$reminder="No";
}

echo stripslashes($reminder);?> </td>
      </tr>
      

	 <tr>
       		 <td colspan="2" align="left"   class="head">Description Details</td>
        </tr>

		 <tr>
          <td align="right"   class="blackbold" valign="top">Description :</td>
          <td  align="left" >
            <? echo stripslashes($arryEvent[0]['description']); ?>

	          </td>
        </tr>

	
 


   <?php //include("includes/html/box/comment.php");?>




</table>	
  

	
	



