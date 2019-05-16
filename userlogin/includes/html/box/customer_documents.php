<? 
if($_GET['CustID']>0){
	$arryDocument=$objLead->GetCustomerDocument($_GET['CustID']);
?>
<table width="100%" border="0" cellpadding="5" cellspacing="5">
	<tr>
		 <td colspan="2" align="left" >
		 
<div id="preview_div" >
<table id="myTable" cellspacing="1" cellpadding="5" width="100%" align="center">
<? if(sizeof($arryDocument)>0){ ?>
<tr align="left"  >
	<td class="head1" >Title</td>
	<td width="25%"  class="head1" >Description</td>
	<td width="15%"  class="head1" >Download</td>
	<td width="15%" class="head1" >  Created On</td>
	<!--<td width="11%" class="head1" > Assign To</td>-->
</tr>
<?
  	$flag=true;
	$Line=0;
	$MainDir = "upload/Document/".$_SESSION['CmpID']."/";
  	foreach($arryDocument as $key=>$values){
	$flag=!$flag;
	$class=($flag)?("oddbg"):("evenbg");
	$Line++;	
  ?>
<tr align="left"  class="<?=$class?>">
  <td >

<a class="fancybox fancybig fancybox.iframe"  href="../admin/crm/vDocument.php?view=<?php echo $values['documentID'];?>&amp;module=Document&parent_type=<?=$_GET['parent_type']?>&parentID=<?=$_GET['parentID']?>&amp;pop=1" target="_blank" ><?=stripslashes($values['title'])?></a>


</td>
    <td><?=stripslashes($values['description'])?></td>
    <td >

 <? if($values['FileName'] !='' && file_exists($MainDir.$values['FileName']) ){
	$DocExist=1;
	?>
	<a href="dwn.php?file=<?=$MainDir.$values['FileName']?>" class="download">Download</a>	
	
    <? } else {	
	$DocExist=0;
	echo NOT_UPLOADED;
	}
?> 

       </td>
    
      
      
      
      
      
	  <td><? if($values['AddedDate']) echo date($Config['DateFormat'].", H:i:s" , strtotime($values["AddedDate"])); ?> </td>
	  <!--<td><?=$values['AssignTo']?></td>-->  


 
</tr>

 <?
} // foreach end //

?>
  
    <?php }else{?>
    <tr align="center" >
      <td  class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  </table>
</div>
	 
		 </td>
	</tr>	
	

</table>
<? } ?>
