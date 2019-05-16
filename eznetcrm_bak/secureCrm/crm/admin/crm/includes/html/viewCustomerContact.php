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
	 
</table>
<? if(!empty($_GET['Cid'])){
	$CustID = $_GET['Cid'];
	include("../includes/html/box/customer_contacts.php");

} ?>
