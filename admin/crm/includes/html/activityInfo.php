<div class="had">
Event Details
</div>

<? if($_GET['tab']=='Activity'){?>

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

      <!---Recurring Start-->

		<?php   
        $arryRecurr = $arryActivity;

        include("../includes/html/box/recurring_2column_daily_view.php");
        ?>  
       
        <!--Recurring End-->
        
     <tr>
        <td  align="right"   class="blackbold" width="20%"> Subject  :</td>
        <td   align="left"  width="25%">
        <?php echo stripslashes($arryActivity[0]['subject']); ?>            </td>
        
        <td  align="right"   class="blackbold" valign="top"  width="25%"> Assigned To  : </td>
        <td   align="left" >

<? 

if(!empty($arryActivity[0]['assignedTo'])){

if($arryActivity[0]['AssignType'] == 'Group'){ ?>
            <?=$AssignName ?> <br>
<? }?>
<div> <? foreach($arryAssignee as $values) {

?>
<a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?=$values['EmpID']?>" ><?=$values['UserName']?></a>,
<? } } else{  echo NOT_SPECIFIED;}?>



     </td>
      </tr>

	  

	  <tr>
        <td  align="right"   class="blackbold">Start Date & Time : </td>
        <td   align="left" >

  <?php  
	   $stdate= $arryActivity[0]["startDate"]." ".$arryActivity[0]["startTime"];
	 echo date($Config['DateFormat']." ".$Config['TimeFormat'] , strtotime($stdate));?>
		
                    </td>
    
        <td  align="right"   class="blackbold">Close Date & Time : </td>
        <td   align="left" >
<?php  
	   $ctdate= $arryActivity[0]["closeDate"]." ".$arryActivity[0]["closeTime"];
	 echo date($Config['DateFormat']." ".$Config['TimeFormat'] , strtotime($ctdate));?>
		
                    </td>
      </tr>
       <tr>
        <td  align="right"   class="blackbold">  Status  : </td>
        <td   align="left" >

		<?php echo stripslashes($arryActivity[0]['status']);?>
            </td>
      
        <td  align="right"   class="blackbold">  Customer : </td>
        <td   align="left" >
<? if(!empty($arryCustomer[0]['FullName'])){?><a class="fancybox fancybox.iframe" href="../custInfo.php?view=<?=$arryCustomer[0]['CustCode']?>"><?=(stripslashes($arryCustomer[0]['FullName']))?> </a> <?} else { echo NOT_SPECIFIED;?> <? }?>	    

            </td>
            </tr>

      <tr>
        <td  align="right"   class="blackbold"> Activity Type : </td>
        <td   align="left" >
<?=(!empty($arryActivity[0]['activityType']))?(stripslashes($arryActivity[0]['activityType'])):(NOT_SPECIFIED)?>
		
                     </td>
	 
<td  align="right"   class="blackbold"> Priority : </td>
<td   align="left" >
<?=(!empty($arryActivity[0]['priority']))?(stripslashes($arryActivity[0]['priority'])):(NOT_SPECIFIED)?>
</td>
</tr>


<? if($arryActivity[0]['activityType']!='Task'){?>

   <tr>  
<td  align="right"   class="blackbold"> Send Notification : </td>
<td   align="left" >
<?php if($arryActivity[0]['Notification']==1){ $Notification="Yes";}else{$Notification="No";}echo stripslashes($Notification); ?>  </td>

	<? if($_GET['pop']!=1){?>	

	<td  align="right"   class="blackbold"> Location : </td>
	<td   align="left" >
	<?=(!empty($arryActivity[0]['location']))?(stripslashes($arryActivity[0]['location'])):(NOT_SPECIFIED)?>
	</td>

	<? }?>

 </tr>


<? } } ?>

</table>	

