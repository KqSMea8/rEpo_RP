<script language="JavaScript1.2" type="text/javascript">
function ValidateFind(frm){	
	if(!ValidateForSelect(frm.Cid,"Customer")){
		return false;
	}
	ShowHideLoader('1','F');

}
</script>

<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_contact'])) {echo $_SESSION['mess_contact']; unset($_SESSION['mess_contact']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	
	 <tr>
	  <td  valign="top">

	<form action="" method="get" name="formSrch" onSubmit="return ValidateFind(this);">
	  <table id="search_table" cellpadding="0" cellsapcing="0" align="left">
	  <tr><td>Customer  : </td>
	  <td> 
			<select id="Cid" method="get" class="inputbox" name="Cid">
			   <option value="">--- Please Select ---</option>
			     <?php foreach($arryCustomer as $customer){?>
				 <option value="<?=$customer['Cid'];?>" <?php if($_GET['Cid'] == $customer['Cid']){echo "selected";}?>><?php echo $customer['FirstName']." ".$customer['LastName']; ?></option>
				<?php }?>
			</select>

	        
		  </td>
	 <td><input type="submit" value="Go" id="GoSubmitButton" class="button" name="search"></td>
	  </tr>
	  </table>
	</form>

	  </td>
      </tr>
	  <tr>
        <td align="right" valign="top">
		
	 <? if($num>0 && !empty($_GET['Cid'])){?>
            <!--input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_so.php?<?=$QueryString?>';" -->

	    <? } ?>


		</td>
      </tr>
<?php if(!empty($_GET['Cid'])){?>	  
	<tr>
	  <td  valign="top">
	

		<form action="" method="post" name="form1">
		<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
		<div id="preview_div">

		<table <?=$table_bg?>>

		<tr align="left"  >
     <!--<td width="2%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','documentID','<?=sizeof($arryDocument)?>');" /></td>-->
      <!--td width="14%"  class="head1" >Document ID</td-->
	<td class="head1" >Title</td>
	<td width="25%"  class="head1" >Description</td>
	<td width="15%"  class="head1" >Download</td>
	<td width="15%" class="head1" >  Created On</td>
	<!--<td width="11%" class="head1" > Assign To</td>-->
    

	
		    </tr>

		<?php 
		if(is_array($arryDocument) && $num>0){
		$flag=true;
		$Line=0;
		$MainDir = "upload/Document/".$_SESSION['CmpID']."/";
		foreach($arryDocument as $key=>$values){
		$flag=!$flag;
		$class=($flag)?("oddbg"):("evenbg");
		$Line++;

		?>
		<tr align="left"  class="<?=$class?>">
		<!--td ><?=stripslashes($values['documentID'])?></td-->
            <td >

<a href="vDocument.php?view=<?php echo $values['documentID'];?>&amp;module=Document&parent_type=<?=$_GET['parent_type']?>&parentID=<?=$_GET['parentID']?>&amp;curP=<?php echo $_GET['curP'];?>" target="_blank" ><?=stripslashes($values['title'])?></a>


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
		<?php } // foreach end //?>

		<?php }else{?>
		<tr align="center" >
		<td  colspan="12" class="no_record"><?=NO_RECORD?> </td>
		</tr>
		<?php } ?>

		<tr>  <td  colspan="12"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryDocument)>0){?>
		&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
		}?></td>
		</tr>
		</table>

		</div> 


		<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
		
		</form>
</td>
</tr>
<?php } ?>

</table>

