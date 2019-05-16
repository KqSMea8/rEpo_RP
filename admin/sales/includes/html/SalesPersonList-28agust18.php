<script language="JavaScript1.2" type="text/javascript">


function ResetSearch(){	
	$("#prv_msg_div").show();
	$("#frmSrch").hide();
	$("#preview_div").hide();
}
function SetEmployee(EmpID,UserName,JobTitle,SalesPersonType){	
	ResetSearch();
	var SelID = $("#SelID").val();
	//window.parent.document.getElementById("EmpID"+SelID).value=EmpID;
	//window.parent.document.getElementById("EmpName"+SelID).value=UserName+' ['+JobTitle+']';
	window.parent.document.getElementById("SalesPersonID").value=EmpID;
	window.parent.document.getElementById("SalesPerson").value=UserName;
	window.parent.document.getElementById("SalesPersonType").value=SalesPersonType;
	parent.jQuery.fancybox.close();
	ShowHideLoader('1','P');

}
function GetSalesPerson(str,dv,Department){
	ResetSearch();
	location.href = "SalesPersonList.php?sp="+str+"&dv="+dv+"&Department="+Department;   	
}


 

</script>

<link href="<?=$Prefix?>css/select2.min.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?=$Prefix?>js/select2.min.js"></script>

<div class="had">Select Sales Person</div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_Sale'])) {echo $_SESSION['mess_Sale']; unset($_SESSION['mess_Sale']); }?></div>
<TABLE WIDTH="100%" BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0>
<? if($CommissionAp==1){ ?>
	<tr>
		<td valign="top" >
		<table border="0" cellpadding="3" cellspacing="0" id="search_table" style="margin: 0">

	
			<tr>
				<td valign="bottom"> 
	<select id="SalesPerson" class="inputbox" name="SalesPerson" onChange="Javascript: GetSalesPerson(this.value,'<?php echo $_GET["dv"]?>','<?php echo $_GET["Department"]?>');">
	 
	<option value="0" <?=($_GET["sp"]=='0')?("selected"):("")?>>Employees</option>
	<option value="1" <?=($_GET["sp"]=='1')?("selected"):("")?>>Vendor</option>
	</select></td>
<script>
$("#SalesPerson").select2();
</script> 

				
			</tr>
		</table>
		
		</td>

	</tr>
<? } ?>

	<tr>
		<td align="right" valign="bottom" height="40">

		<form name="frmSrch" id="frmSrch" action="SalesPersonList.php" method="get"
			onSubmit="return ResetSearch();">

		<table   border="0" cellpadding="3" cellspacing="0" id="search_table" style="margin: 0">			
			<tr>
				<?php if($_GET['sp']=="0") { ?><td>
			<select name="Department" class="textbox" id="Department" <? if($_GET["d"]>0){ echo 'disabled';}?> >
  <option value="">--- All Department ---</option>
  <? for($i=0;$i<sizeof($arryInDepartment);$i++) {?>
  <option value="<?=$arryInDepartment[$i]['depID']?>" <?=($_GET["Department"]==$arryInDepartment[$i]['depID'])?("selected"):("")?> >
  <?=$arryInDepartment[$i]['Department']?>
  </option>
  <? } ?>
</select>
			</td>
			<?php } ?> 
			
			<td >
			<input type="text" name="key"
			id="key" placeholder="<?=SEARCH_KEYWORD?>" class="textbox" size="20"
			maxlength="30" value="<?=$_GET['key']?>">&nbsp;<input type="submit"
			name="sbt" value="Go" class="search_button"> <input type="hidden" name="id" value="<?=$_GET['id']?>" readonly><input type="hidden" name="dv" id="dv" value="<?=$_GET['dv']?>" readonly><input type="hidden"
			name="sp" id="sp" value="<?=$_GET['sp']?>">
			</td>
			
			</tr>

		</table>


	    </form>
	</td>
	</tr>

</table>

			

<div class="message" align="center"><? if(!empty($_SESSION['mess_salr'])) {echo $_SESSION['mess_sale']; unset($_SESSION['mess_sale']); }?></div>
<TABLE WIDTH="100%" BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0>


	<tr>
		<td valign="top" height="400">

		
		<form action="" method="post" name="form1">
		<div id="prv_msg_div" style="display: none; padding: 50px;"><img
			src="../images/ajaxloader.gif"></div>
		<div id="preview_div">
 
		<table <?=$table_bg?>>
			<tr align="left">
				<td width="25%" class="head1" >Sales Person Name</td>
		<td width="25%"  class="head1" >Sales Person Code</td>
       <td width="25%" class="head1" >Department</td>
      <td  class="head1" >Email</td>
			</tr>
 <?php 
  if(is_array($arryEmployee) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryEmployee as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;

	if(!isset($values["JobTitle"])) $values["JobTitle"]='';
	
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
    <td>
	<a href="Javascript:void(0)" onclick="Javascript:SetEmployee('<?=$values["EmpID"]?>','<?=stripslashes($values["UserName"])?>','<?=stripslashes($values["JobTitle"])?>','<?=$_GET['sp']?>');"><?=stripslashes($values["UserName"])?></a>
	</td>
    <td><?=$values["EmpCode"]?></td> 
    <td><?=stripslashes($values["Department"])?></td> 
    <td><?=stripslashes($values["Email"])?></td>
      
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="5" class="no_record"><?=NO_EMPLOYEE?></td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="5"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryEmployee)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
		</table>
		 
		</div>

		
			
		</form>
		
		</td>
	</tr>
</table>
	




