<script language="JavaScript1.2" type="text/javascript">


function ResetSearch(){	
	$("#prv_msg_div").show();
	$("#frmSrch").hide();
	$("#preview_div").hide();
}
// addeed by Nisha on 24 july 2018.
$(function() {

 $("#save_multi_sales_person").click(function(e) {
        var selectedSalesPersonIds   = []; var selectedSalesPersonName = []; var previousSelectedSalesPerson=[];  var selectedVendorSalesPersonIds   = []; var selectedVendSalesPersonName = [];
        var previousSelectedSalesPersonid    = window.parent.document.getElementById("SalesPersonID").value;
        var previousSelectedSalesPersonname  = window.parent.document.getElementById("SalesPersonName").value;
        var previousVenSelectedSalesPersonname  = window.parent.document.getElementById("vendorSalesPersonName").value;
        var previousVendorSelectedSalesPersonId  = window.parent.document.getElementById("vendorSalesPersonID").value;

        var selectedSalesPersonType          = $("#selectedSalesPersonType").val();
        var number_of_checked_checkbox       = $(".EmpID:checked").length;
    
      	    	$('input[name="EmpID"]:checked').each(function() {
                
                     if(selectedSalesPersonType==0){
                    selectedSalesPersonIds.push(this.value);
                    selectedSalesPersonName.push($(this).data("id"));
                     }

                    else if(selectedSalesPersonType==1){
                    selectedVendorSalesPersonIds.push(this.value);
                    selectedVendSalesPersonName.push($(this).data("id"));
                    }
   
                
               });

        var  empIds = selectedSalesPersonIds.toString();
        var  vendIds = selectedVendorSalesPersonIds.toString();
          if(selectedSalesPersonType==0){
               var dataString="empIds="+escape(empIds)+"&Type="+escape(selectedSalesPersonType)+"&prevVendSales="+escape(previousVendorSelectedSalesPersonId)+"&action=GetCommisionPercentage";
           }

            else if(selectedSalesPersonType==1){
                var dataString="vendIds="+escape(vendIds)+"&Type="+escape(selectedSalesPersonType)+"&prevSales="+escape(previousSelectedSalesPersonid)+"&action=GetCommisionPercentage";
                    }
        
      	$.ajax({
		type: "POST",
		url: "ajax.php",
		dataType: 'json',
		data: dataString,
		async:false,
	    success: function(data){
	    	var venSalesPersonIds   = []; var empSalesPersonIds   = []; 
			if(data <=100){
	            if(selectedSalesPersonType==0){
	                window.parent.document.getElementById("SalesPersonID").value=empIds;
	                 window.parent.document.getElementById("SalesPersonName").value=selectedSalesPersonName;
	            }
	            else if(selectedSalesPersonType==1){
	             window.parent.document.getElementById("vendorSalesPersonID").value=vendIds;
	             window.parent.document.getElementById("vendorSalesPersonName").value=selectedVendSalesPersonName;
	            }
           var selectedSalesPersonNme   = window.parent.document.getElementById("SalesPersonName").value;
           var selectedVenSalesPersonNme   = window.parent.document.getElementById("vendorSalesPersonName").value;
           if(selectedSalesPersonType==0){
           	selectedSalesPersonName = selectedSalesPersonNme;
           	if((previousVenSelectedSalesPersonname!="") && (selectedSalesPersonName!="")){
           		selectedSalesPersonName = selectedSalesPersonName+","+previousVenSelectedSalesPersonname;
           		 
           	}
           	if((previousVenSelectedSalesPersonname!="") && (selectedSalesPersonName=="")){
           		selectedSalesPersonName = previousVenSelectedSalesPersonname;
           		 
           	}
           	window.parent.document.getElementById("SalesPerson").value=selectedSalesPersonName;
           }
            else if(selectedSalesPersonType==1){
            	selectedSalesPersonName = selectedVenSalesPersonNme;
           	if((previousSelectedSalesPersonname!="") && (selectedSalesPersonName!="")){
           		selectedSalesPersonName = previousSelectedSalesPersonname+","+selectedVenSalesPersonNme;
           		}
           		if((previousSelectedSalesPersonname!="") && (selectedSalesPersonName=="")){
           		selectedSalesPersonName = previousSelectedSalesPersonname;
           		}
           	 window.parent.document.getElementById("SalesPerson").value=selectedSalesPersonName;
            }

	          
                //parent.jQuery.fancybox.close();
                //ShowHideLoader('1','P');
			}
			else
			{
				alert("Sum of Commission Percentage Should Be Less Or Equal To 100");
				return false;
			}
		}
		});


    	
    

      
    });

});

function GetSalesPerson(str,dv,Department){
	ResetSearch();
	if(str=="") {
		str = 0;
	}
	location.href = "SalesPersonList.php?sp="+str+"&dv="+dv+"&Department="+Department;   	
}


 // Nisha added on 23 july 2018
 function SelectCheckBoxes(actionName,className)
{

     if ($("#"+actionName).is(':checked')) {
            $('.'+className).each(function(){
                this.checked = true;
            });
        } else {
           $('.'+className).each(function(){
                this.checked = false;
            });
        }
    
}

$(function() {
	var  vendorSpId = window.parent.document.getElementById("vendorSalesPersonID").value;
	var empSpId = window.parent.document.getElementById("SalesPersonID").value;

	if(empSpId.indexOf(',') != -1){
		empSpId =empSpId.split(",");
   $.each(empSpId, function (index, value) {
  $("#EmpID"+value+'_0').prop('checked', true);
});
	 
}
else
{
$("#EmpID"+empSpId+'_0').prop('checked', true);
}
	if(vendorSpId.indexOf(',') != -1){
		vendorSpId =vendorSpId.split(",");
   $.each(vendorSpId, function (index, value) {
  $("#EmpID"+value+'_1').prop('checked', true);
});
	 
}
else
{
$("#EmpID"+vendorSpId+'_1').prop('checked', true);
}
});

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
<?php if(empty($_GET['sp'])){  
	$_GET['sp'] =0;}?>
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
			<input type="text" name="key" id="key" placeholder="<?=SEARCH_KEYWORD?>" class="textbox" size="20" maxlength="30" value="<?=$_GET['key']?>">&nbsp;
			<input type="submit" name="sbt" value="Go" class="search_button">
			<input type="hidden" name="id" value="<?=$_GET['id']?>" readonly>
			<input type="hidden" name="dv" id="dv" value="<?=$_GET['dv']?>" readonly>
			<input type="hidden" name="sp" id="sp" value="<?=$_GET['sp']?>">
			
			</td>
			
			</tr>

		</table>

<input type="submit" value="Select Sales Person" id="save_multi_sales_person" class="button" name="Submit" style="margin-right: 666px;margin-top: -27px;">
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
		<td width="1%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll', 'EmpID');" /></td>
		<td width="25%" class="head1" >Sales Person Name</td>
		<td width="25%"  class="head1" >Sales Person Code</td>
       <td width="25%" class="head1" >Department</td>
      <td  class="head1" >Email</td>
      <td  width="12%" class="head1" >Commission %</td>
			</tr>
 <?php 
  if(is_array($arryEmployee) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryEmployee as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;
$CountCheck = $values["EmpID"];
	if(!isset($values["JobTitle"])) $values["JobTitle"]='';
	
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
    <td><input type="checkbox" name="EmpID" id="EmpID<?=$CountCheck?>_<?=$_GET['sp']?>"  class="EmpID" value="<?php echo $values["EmpID"]?>" data-id="<?=stripslashes($values["UserName"])?>">
    <input type="hidden" name="selectedSalesPersonType" id="selectedSalesPersonType" value="<?=$_GET['sp']?>"></td>
    <td><?=stripslashes($values["UserName"])?></td>
    <td><?=$values["EmpCode"]?></td> 
    <td><?=stripslashes($values["Department"])?></td> 
    <td><?=stripslashes($values["Email"])?></td>
    <td><?=stripslashes($values["CommPercentage"])?></td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="6" class="no_record"><?=NO_EMPLOYEE?></td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="6"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryEmployee)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
		</table>
		</div>

		
			
		</form>
		
		</td>
	</tr>
</table>
	




			

