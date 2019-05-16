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
		<!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','AddID','<?=sizeof($arryContact)?>');" /></td>-->
		<td width="13%" class="head1" >Name</td>
		<td class="head1" >Address</td>
		<td width="12%" class="head1">City</td>
		<td width="8%"  class="head1" >State</td>
		<td width="8%"  class="head1" >Country</td>
		<td width="8%"   class="head1" >Zip Code</td>
		<td width="8%"   class="head1" >Mobile</td>
		<td width="8%"   class="head1" >Landline</td>
		<td width="8%"   class="head1" >Fax</td>
		<td width="8%"   class="head1" >Email</td>
		<!--td width="10%"  align="center" class="head1 head1_action" >Action</td-->
		</tr>

		<?php 
		if(is_array($arryContact) && $num>0){
		$flag=true;
		$Line=0;
		foreach($arryContact as $key=>$values){
		$flag=!$flag;
		$class=($flag)?("oddbg"):("evenbg");
		$Line++;

		?>
		<tr align="left"  class="<?=$class?>">
		<!--<td ><input type="checkbox" name="AddID[]" id="AddID<?=$Line?>" value="<?=$values['AddID']?>" /></td>-->
		<td height="20"><?=stripslashes($values["FullName"])?></td>
		<td><?=stripslashes($values["Address"])?></td>
		<td><?=htmlentities($values["CityName"], ENT_IGNORE)?></td> 
		<td ><?=stripslashes($values["StateName"])?></td>
		<td ><?=stripslashes($values["CountryName"])?></td>
		<td ><?=stripslashes($values["ZipCode"])?></td>
		<td ><?=stripslashes($values["Mobile"])?></td>
		<td ><?=stripslashes($values["Landline"])?></td>
		<td ><?=stripslashes($values["Fax"])?></td>
		<td ><?=stripslashes($values["Email"])?></td>

		<!--td  align="center" class="head1_inner"></td-->
		</tr>
		<?php } // foreach end //?>

		<?php }else{?>
		<tr align="center" >
		<td  colspan="12" class="no_record"><?=NO_RECORD?> </td>
		</tr>
		<?php } ?>

		<tr>  <td  colspan="12"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryContact)>0){?>
		&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
		}?></td>
		</tr>
		</table>

		</div> 


		<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
		<input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
		</form>
</td>
</tr>
<?php } ?>

</table>

