<script language="JavaScript1.2" type="text/javascript">

function SetPunching(){
	var PunchingBlock = document.getElementById('PunchingBlock').value;
	if(PunchingBlock == '0'){
		$('.TrPunching').hide();
		$('.TrRange').hide();
		$('.TrRangeData').hide();
	}else{
		$('.TrPunching').show();
		$('.TrRange').show();
		 

		var PunchingIPRange = document.getElementById("PunchingIPRange").value;
 
		if(PunchingIPRange>0){
			$('.TrRangeData').show();
		}else{
			$('.TrRangeData').hide();
		}
		 
	}
		
}
	
function SetLogin(){
	var LoginBlock = document.getElementById('LoginBlock').value;
	if(LoginBlock == '0'){
		$('.TrLogin').hide();
	}else{
		$('.TrLogin').show();
	}
}
//for punch in/out
$(document).on('click', '.rangDel', function(){ 
	if($(this).closest('td').parent('tr').find('.add_row_po').length) {
	}
	$(this).closest('td').parent('tr').remove(); 
})

function addMoreRangePr(thisobj)
{	
		$('.TrPunching:first').clone().attr('id','TrPunching'+$('.TrPunching').length).insertAfter($('.TrPunching:last')).find('td:last').append('<img src="images/delete.png" class="rangDel" style="cursor:pointer">');
		$('.TrPunching:last a').remove();
		$('.TrPunching:last').find(':input').val('');
}
$(document).on('click','.add_row_po', function(){	addMoreRangePr($(this));	});
//end code forthe punchin punchout
	
//start code for login block ip
	$(document).on('click', '.rangDelloginip', function(){ 
	if($(this).closest('td').parent('tr').find('.add_row_loginip').length) {
	}
	$(this).closest('td').parent('tr').remove(); 
})
function addMoreRangelohinip(thisobj)
{	
		$('.TrLogin:first').clone().attr('id','TrLogin'+$('.TrLogin').length).insertAfter($('.TrLogin:last')).find('td:last').append('<img src="images/delete.png" class="rangDel" style="cursor:pointer">');
		$('.TrLogin:last a').remove();
		$('.TrLogin:last').find(':input').val('');
		$('.TrLogin:last').find(':input').val('');
}
$(document).on('click','.add_row_loginip', function(){	addMoreRangelohinip($(this));	});
//end code for login block ip	






$(document).on("change","input[id^='PunchingIPRangeF']", function(){


var id=$(this).attr("id");

    id1 = id.slice( 16 );

    id1="T"+id1;

var r0= $("#"+id).val();
 r0=r0.split(".");
 for(var i=0;i<r0.length;i++) {
 r0[i]=parseInt(r0[i],10); 
} 
var r1= $("#PunchingIPRange"+id1).val();
 r1=r1.split(".");
 for(var i=0;i<r1.length;i++) {
 r1[i]=parseInt(r1[i],10); 
}


	if($("#PunchingIPRange"+id1).val()!='') {
		if(r0[3]>r1[3] || r0[1]!=r1[1] || r0[0]!=r1[0] || r0[2]!=r1[2]){ 
		     alert("Please Enter Valid IP Range"); 
		     return false;
		}

	}
});




$(document).on("change","input[id^='PunchingIPRangeT']", function(){


var id=$(this).attr("id");

    id1 = id.slice( 16 );
    id1="F"+id1;


var r0= $("#PunchingIPRange"+id1).val();
 r0=r0.split(".");
 for(var i=0;i<r0.length;i++) {
 r0[i]=parseInt(r0[i],10); 
} 
var r1= $("#"+id).val();
 r1=r1.split(".");
 for(var i=0;i<r1.length;i++) {
 r1[i]=parseInt(r1[i],10); 
}


if($("#"+id).val()!='') {

	if(r0[3]>r1[3] || r0[1]!=r1[1] || r0[0]!=r1[0] || r0[2]!=r1[2]){ 
		  alert("Please Enter Valid IP Range"); 
		     return false; 
	}
}

});







function validateForm(frm)
{ 

  
		var PunchingBlock = document.getElementById("PunchingBlock").value;
		var PunchingIPRange = document.getElementById("PunchingIPRange").value;
	
		if(PunchingBlock>0 && PunchingIPRange>0){ 
 
			for(var j=1;j<=PunchingIPRange;j++){
			

				if(document.getElementById("PunchingIPRangeF"+j) != null){

					if(!ValidateForSimpleBlank(document.getElementById("PunchingIPRangeF"+j), "From IP")){
						return false;
					}
				
				
				}
				
				if(document.getElementById("PunchingIPRangeT"+j) != null){

					if(!ValidateForSimpleBlank(document.getElementById("PunchingIPRangeT"+j), "To IP")){
						return false;
					}
				
				}
				
				
				
			}
			
			
		} 

		ShowHideLoader(1,'S');
		
}



function AddRowsIPRange() {
	var i;
	var cols = "";
    	var PunchingIPRange = parseInt(document.getElementById("PunchingIPRange").value);
   	if(PunchingIPRange>0){
		$('.TrRangeData').show();
	}else{
		$('.TrRangeData').hide();
	}
	var IPRangeCount = parseInt(document.getElementById("IPRangeCount").value);
	document.getElementById("IPRangeCount").value = PunchingIPRange;

	if(PunchingIPRange<IPRangeCount){
 
		$("table.order-list").empty();
	}else{
		PunchingIPRange =  PunchingIPRange - IPRangeCount;
	}

 

 
 	var counter = $('#myTable tr').length +1;
 
	  for(i=0;i<PunchingIPRange;i++){
		  
	      
 
		var newRow = $("<tr class='itembg'>");
		var cols = "";

	    cols += '<td width="48%" align="right" class="blackbold">Range '+counter+':</td><td><input type="text" onkeypress="return isDecimalKey(event);" maxlength="15" size="10" Placeholder="From" value="" name="PunchingIPRange'+counter+'[]" id="PunchingIPRangeF'+counter+'" class="textbox IPRangecls"> - <input type="text" onkeypress="return isDecimalKey(event);" maxlength="15" size="10" Placeholder="To" value="" name="PunchingIPRange'+counter+'[]" id="PunchingIPRangeT'+counter+'" class="textbox IPRangecls" ></td>';
 
		newRow.append(cols);
		//if (counter == 4) $('#addrow').attr('disabled', true).prop('value', "You've reached the limit");
		$("table.order-list").append(newRow);
 
		counter++;


	
	}


}


</script>
<div class="had"><?=$MainModuleName?></div>



<form name="form1" id="form1" action="" method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">

<table width="100%"  border="0" cellpadding="0" cellspacing="0">

  <? if (!empty($_SESSION['mess_ip'])) {?>
<tr>
<td  align="center"  class="message"  >
	<? echo $_SESSION['mess_ip']; unset($_SESSION['mess_ip']); ?>	
</td>
</tr>
<? } ?>

<tr>
	 <td>




			  
<table width="100%" cellspacing="0" cellpadding="5" border="0" class="borderall">
<? if(empty($arryCompany[0]['Department']) || substr_count($arryCompany[0]['Department'],1)==1){ ?>
<tr>
	 <td align="left" class="head" colspan="4">Punch In/Out</td>
</tr>
 
<tr>
	<td width="48%" align="right" class="blackbold">Block IP:</td>
	<td  valign="top" align="left">
	<select name="PunchingBlock"  id="PunchingBlock" class="textbox" onchange="SetPunching()" >
	<option value="0"  >No</option>
	<option value="1" <?php if($arryCompany[0]['PunchingBlock']=='1') {echo 'selected';} ?> >Yes</option>
	</select>
	</td>
   
</tr>
 
 <?php  

       		$PunchingIP	= explode(',',$arryCompany[0]['PunchingIP']);	
		$count 		= count($PunchingIP);
		for($i=0;$i<$count;$i++){
			 

?>               
<tr id="TrPunching" style="display:none;" class="TrPunching">
	
    <td  align="right" class="blackbold" valign="top">Allow IP Address :</td>
	<td  valign="top" align="left">
		


	<input name="PunchingIP[]" type="text" class="inputbox track" id="PunchingIP" value="<?php echo stripslashes($PunchingIP[$i]); ?>"  maxlength="15" onkeypress="return isDecimalKey(event);" />     <? if($i==0){?>		<a href="javascript:;" class="add_row_po" id="addmore">Add More</a> <?}?> <? if($i>=1){?> <img src="images/delete.png" class="rangDel" style="cursor:pointer"> <? }?>    
	</td>
</tr>
<? }?> 



<?  
 
$IPRangeCount=0;
if(!empty($arryCompany[0]['PunchingIPRange'])){
 $PunchingIPRange = explode('#',$arryCompany[0]['PunchingIPRange']);	
 $IPRangeCount 	= count($PunchingIPRange);
}
?>
<tr class="TrRange">
	<td width="48%" align="right" class="blackbold">IP Range:</td>
	<td  valign="top" align="left">
	<select name="PunchingIPRange"  id="PunchingIPRange" class="textbox" onchange="AddRowsIPRange()" >
	<option value="0" >None</option>
	 <?php for($i=1;$i<=10;$i++){?>
               <option value="<?=$i?>"<?=($IPRangeCount==$i)?('selected'):('')?>><?=$i?></option>
	<?php } ?>
	
	</select>
	</td>
   
</tr> 

	

<tr class="TrRangeData">	 
	<td colspan="2">

<table width="100%" id="myTable" class="order-list" cellpadding="0" border="0"
	cellspacing="1" style="display: none1;border:0">

 <?php  
 

		for($i=0;$i<$IPRangeCount;$i++){
		
		    	$arryIPRange = explode('-',$PunchingIPRange[$i]);
                	 	
 	 
?>
                
		<tr class='itembg'>
			
<td width="48%" align="right" class="blackbold">Range <?=$i+1?>:</td>
<td>

<input type="text" onkeypress="return isDecimalKey(event);" maxlength="15" size="10" value="<?php echo stripslashes($arryIPRange[0]); ?>" name="PunchingIPRange<?=$i+1?>[]" id="PunchingIPRangeF<?=$i+1?>" class="textbox IPRangecls"> - <input type="text" onkeypress="return isDecimalKey(event);" maxlength="15" size="10" value="<?php echo stripslashes($arryIPRange[1]); ?>" name="PunchingIPRange<?=$i+1?>[]" id="PunchingIPRangeT<?=$i+1?>" class="textbox IPRangecls" >

</td>


		</tr>
                <?php } ?>	
</table>
<input type="hidden" name="IPRangeCount" id="IPRangeCount"  value="<?=$IPRangeCount?>">
</td>   
</tr> 

<SCRIPT LANGUAGE=JAVASCRIPT>
SetPunching();
</SCRIPT>
		
<? } ?>  
<tr>
	 <td align="left" class="head" colspan="4">Login</td>
</tr>

<tr>
	<td  width="48%" class="blackbold" align="right">Block IP: </td>
	<td  valign="top" align="left">
	<select name="LoginBlock" id="LoginBlock" class="textbox" onchange="SetLogin()">
	<option value="0" >No</option>
	<option value="1" <?php if($arryCompany[0]['LoginBlock']=='1') {echo 'selected';} ?>>Yes</option>
	</select>
	</td>
</tr>
       <?php  

	$loginIps = explode(',',$arryCompany[0]['LoginIP']);	
	$counter  = count($loginIps);
	for($j=0;$j<$counter;$j++){
		
?>
                
<tr id="TrLogin" style="display:none;" class="TrLogin">
	<td align="right" valign="top" class="blackbold">Allow IP Address :</td>
	<td  valign="top" align="left">
				

	<input name="LoginIP[]" type="text" class="inputbox track" id="LoginIP" value="<?php echo stripslashes($loginIps[$j]); ?>"  maxlength="15" onkeypress="return isDecimalKey(event);" />     <? if($j==0){?>		<a href="javascript:;" class="add_row_loginip" id="addmore">Add More</a> <?}?> <? if($j>=1){?> <img src="images/delete.png" class="rangDelloginip" style="cursor:pointer"> <? }?>    
	</td>
</tr>
<? }?> 


</table>


</td>
</tr>

<tr><td align="center"><input type="submit" value=" Update " id="SubmitButton" class="button" name="Submit"></td></tr>

</table>

</form>




<SCRIPT LANGUAGE=JAVASCRIPT>
SetLogin();
</SCRIPT>
