

<div class="had">Select Customer</div>
<TABLE WIDTH="100%" BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0>

	<td valign="top" height="400">


	<form action="" method="post" name="form1">
	<div id="prv_msg_div" style="display: none; padding: 50px;"><img
		src="../images/ajaxloader.gif"></div>
	<div id="preview_div">

	<table <?=$table_bg?>>
		<tr>
			<td width="40%" align="right" valign="top" class="blackbold">Select
			Customer Will Be Assigned For Item :
			</td>
			<td width="60%" align="left" valign="top"></td>
		</tr>
		<tr>

			<td colspan="2">
			<div id="move_div">
			<table width="100%" border="0" cellpadding="5" cellspacing="0"
				class="borderall">
				<tr>
					<td align="center" class="head" width="40%">Available Customers</td>
					<td class="head"></td>
					<td align="center" class="head" width="40%">Selected Customers</td>
				</tr>
				<tr>
					<td align="center">
					<?php 

echo '<select name="columnFrom[]" id="columnFrom"  class="inputbox" style="width:300px;height:300px;  " multiple>';



	foreach($CustomersArray as $key=>$value){
		echo '<option value="'.$value['Cid'].'" ';
		if(!empty($CustomerID)){
			if(in_array($value['Cid'], $CustomerID)){
				echo 'selected="selected"';
			}
		}
		echo '>'.$value['FullName'].'</option>';
	}


echo '</select>';

?></td>
					<td align="center" valign="top"><br>
					<br>
					<br>
					<br>
					<input type="button" value=" &raquo; &raquo; " name="fromall"
						id="fromall" class="grey_bt" style="padding: 5px; width: 40px;"
						onMouseover="ddrivetip('<center>Move All</center>', 100,'')"
						; onMouseout="hideddrivetip()"> <br>
					<br>
					<input type="button" value=" &raquo;  " name="frombt" id="add"
						class="grey_bt" style="padding: 5px; width: 40px;"
						onMouseover="ddrivetip('<center>Move Selected</center>', 100,'')"
						; onMouseout="hideddrivetip()"> <br>
					<br>
					<input type="button" value=" &laquo;  " name="tobt" id="remove"
						class="grey_bt" style="padding: 5px; width: 40px;"
						onMouseover="ddrivetip('<center>Remove Selected</center>', 100,'')"
						; onMouseout="hideddrivetip()"> <br>
					<br>

					<input type="button" value=" &laquo; &laquo; " name="tobt"
						id="removeall" class="grey_bt" style="padding: 5px; width: 40px;"
						onMouseover="ddrivetip('<center>Remove All</center>', 100,'')"
						; onMouseout="hideddrivetip()"></td>
					<td align="center"><? 
					echo '<select name="select_customer[]" id="select_customer"  class="inputbox" style="width:300px;height:300px; background: rgb(255, 255, 255) none repeat scroll 0 0;" multiple>';
					foreach($SelectedCustomersArray as $key=>$value){
					echo '<option value="'.$value['Cid'].'" selected="selected" >'.$value['FullName'].'</option>';
				}
					echo '</select>';


					?></td>
				</tr>
				
			</table>
			</div>
			</td>
		</tr>
		
		<tr>
            <td align="center" height="135" valign="top"><br>
            <input name="Submit" type="button" class="button" onclick="SetCustomer();" value="Submit" />
              &nbsp; </td>
          </tr>
	</table>

	</div>


	</form>
	</td>
	</tr>
</table>
<script type="text/javascript">
function ddrivetip(thetext, thewidth, thecolor){
	if (ns6||ie){
	if (typeof thewidth!="undefined") tipobj.style.width=thewidth+"px"
	if (typeof thecolor!="undefined" && thecolor!="") tipobj.style.backgroundColor=thecolor
	tipobj.innerHTML=thetext
	enabletip=true
	return false
	}
	}

function hideddrivetip(){

	if (ns6||ie){
	enabletip=false
	tipobj.style.visibility="hidden"
	pointerobj.style.visibility="hidden"
	tipobj.style.left="-1000px"
	tipobj.style.backgroundColor=''
	tipobj.style.width=''
	}
	}

function MoveFields() {
    $("#first_div").hide();
    $("#add_all_div").hide();
    $("#move_div").show();
    $("#cancel").show();
    $("#submit").show();
    $("#other_info").show();
    $("#entry_all").val("0");
}



 
 $().ready(function() { 
     
  $('#fromall').click(function() { 
   return !$('#columnFrom option').remove().appendTo('#select_customer');  
  });  
  $('#add').click(function() { 
   return !$('#columnFrom option:selected').remove().appendTo('#select_customer');  
  });  
  $('#remove').click(function() {  
   return !$('#select_customer option:selected').remove().appendTo('#columnFrom');  
  });  
  $('#removeall').click(function() { 
   return !$('#select_customer option').remove().appendTo('#columnFrom');  
  });
 });

function SetCustomer(){
	var selectedCust='';
	$("#select_customer :selected").map(function(i, el) {
		selectedCust=selectedCust+$(el).val()+',';
	    
	});
	var selectedCust = selectedCust.substr(0,selectedCust.length - 1);
	window.parent.document.getElementById("CustomerID").value=selectedCust;
	parent.jQuery.fancybox.close();
}
   
</script>
