
 



<div class="back"><a href="<?=$RedirectURL?>">Back</a></div>
<div class="had">
View Ticket Comments   &raquo; <strong>
	<? 	echo (!empty($_GET['edit']))?("View Ticket Details") :("Add ".$ModuleName); ?>
		
		</strong>
</div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<? if (!empty($errMsg)) {?>
  <tr>
    <td height="2" align="center"  class="red" ><?php echo $errMsg;?></td>
    </tr>
  <? } ?>
  
	<tr>
	<td align="left" valign="top">

<div class="left_box">
	<p class='active'><a href="#"><?=stripslashes(substr($arryTicket[0]['title'],0,25))?>..</a></p>
		
</div>	
<div class="right_box">
<table width="100%"  border="0" cellpadding="0" cellspacing="0">

  
  <? if (!empty($_SESSION['mess_ticket'])) {?>
<tr>
<td  align="center"  class="message"  >
	<? if(!empty($_SESSION['mess_ticket'])) {echo $_SESSION['mess_ticket']; unset($_SESSION['mess_ticket']); }?>	
</td>
</tr>
<? } ?>
  
   <tr>
    <td  align="center" valign="top" >


<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<? if (!empty($errMsg)) {?>
  <tr>
    <td height="2" align="center"  class="red" ><?php echo $errMsg;?></td>
    </tr>
  <? } ?>
  
	<tr>
	<td align="left" valign="top">

	<div class="right_box">
<table width="100%"  border="0" cellpadding="0" cellspacing="0">

  
  <? if (!empty($_SESSION['mess_ticket'])) {?>
<tr>
<td  align="center"  class="message"  >
	<? if(!empty($_SESSION['mess_ticket'])) {echo $_SESSION['mess_ticket']; unset($_SESSION['mess_ticket']); }?>	
</td>
</tr>
<? } ?>
  
   <tr>
    <td  align="center" valign="top" >


<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">


  


<tr>
	 <td colspan="2" align="left" class="head">Ticket Information</td>
</tr>
     <tr>
        <td  align="right"   class="blackbold"> Title  :</td>
        <td   align="left" >
        <?php echo stripslashes($arryTicket[0]['title']); ?>            </td>
        </tr>

	   <tr>
        <td  align="right"   class="blackbold"> Assigned To  : </td>
        <td   align="left" >
     <?php echo stripslashes($arryTicket[0]['AssignedTo']); ?> </td>
      </tr>

	   <tr>
        <td  align="right"   class="blackbold"> Status  : </td>
        <td   align="left" >

		<?php echo stripslashes($arryTicket[0]['Status']);?>
            </td>
      </tr>

      <tr>
        <td  align="right"   class="blackbold"> Priority : </td>
        <td   align="left" >

		<?php echo stripslashes($arryTicket[0]['priority']);?>
                     </td>
      </tr>

	  <tr>
        <td  align="right"   class="blackbold">Ticket Category : </td>
        <td   align="left" >

		<?php echo stripslashes($arryTicket[0]['category']);?>
                    </td>
      </tr>
	  
	   <tr>
        <td  align="right"   class="blackbold"> Days : </td>
        <td   align="left" >
        <?php echo stripslashes($arryTicket[0]['day']); ?> </td>
      </tr>
 <tr>
        <td  align="right"   class="blackbold"> Hours : </td>
        <td   align="left" >
<?php echo stripslashes($arryTicket[0]['hours']); ?>  </td>
      </tr>

	 <tr>
       		 <td colspan="2" align="left"   class="head">Description Details</td>
        </tr>

		 <tr>
          <td align="right"   class="blackbold" valign="top">Description :</td>
          <td  align="left" >
            <? echo stripslashes($arryTicket[0]['description']); ?>

	          </td>
        </tr>

	<tr>
       		 <td colspan="2" align="left"   class="head">Ticket Resolution</td>
        </tr>
   
	  
       <tr>
          <td align="right"   class="blackbold" valign="top">Solution :</td>
          <td  align="left" >
            <?=stripslashes($arryTicket[0]['solution'])?>		          </td>
        </tr>
 


   <?php include("includes/html/box/comment.php");?>




</table>	
  </div>

	</td>
   </tr>
</table>


	
	



