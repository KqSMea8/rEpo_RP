<script language="JavaScript1.2" type="text/javascript">
function ResetSearch(){	
	$("#prv_msg_div").show();
	$("#frmSrch").hide();
	$("#preview_div").hide();
}


/*
function SetbomCode(bomCode){	
	ResetSearch();
       
        //var warehouse= window.opener.document.getElementById("warehouse").value;
        
        //alert(warehouse);

	if(document.getElementById("link").value != ''){
		window.parent.location.href= document.getElementById("link").value+"?bc="+bomCode;
	}else{

				var SendUrl = "&action=bomInfo&bomCode="+escape(bomCode)+"&r="+Math.random(); 
				 

				$.ajax({
					type: "GET",
					url: "ajax.php",
					data: SendUrl,
					dataType : "JSON",
					success: function (responseText) {

					window.parent.document.getElementById("bom_code").value=bomCode;
					window.parent.document.getElementById("Sku").value=responseText["Sku"];
					window.parent.document.getElementById("item_id").value=responseText["ItemID"];
                                        window.parent.document.getElementById("on_hand_qty").value=responseText["qty_on_hand"];
					window.parent.document.getElementById("description").value=responseText["description"];
					window.parent.document.getElementById("qty").value='1';
					window.parent.document.getElementById("price").value=responseText["sell_price"];
					window.parent.document.getElementById("qty").focus();

						parent.jQuery.fancybox.close();
						ShowHideLoader('1','P');


					}
				});

	}


}
*/





$(document).ready(function () {
	/* Get the checkboxes values based on the class attached to each check box */
	$("#buttonClass").click(function() {
	    getValueUsingClass();
	});
	
	/* Get the checkboxes values based on the parent div id */
	$("#buttonParent").click(function() {
	    getValueUsingParentTag();
	});
});

function getValueUsingClass(){
	/* declare an checkbox array */
	var chkArray = [];
	var NumCount =0;
	/* look for all checkboes that have a class 'chk' attached to it and check if it was checked */
	$(".chk:checked").each(function() {
		chkArray.push($(this).val());
                NumCount++;
	});
	
	/* we join the array separated by the comma */
	var selected;
	selected = chkArray.join(',') + ",";
	var Line = $("#Line").val();
	/* check if there is selected checkboxes, by default the length is 1 as it contains one single comma */
	if(selected.length > 1){
if(window.parent.document.getElementById("qty"+Line).value == NumCount ){
                   window.parent.document.getElementById("qty"+Line).value=NumCount;
                   window.parent.document.getElementById("serial_number"+Line).value=selected;
                   //$("#qty"+Line).parent().attr("disabled", "disabled");
                   parent.$.fancybox.close();
}else{
alert("Please Select Only  serial Number");
}
		//alert("You have selected " + selected);	
	}else{
		alert("Please at least one of the serial Number");	
	}
}

function getValueUsingParentTag(){
	var chkArray = [];
	
	/* look for all checkboesgetValueUsingParentTag that have a parent id called 'checkboxlist' attached to it and check if it was checked */
	$("#serialID input:checked").each(function() {
		chkArray.push($(this).val());
	});
	
	/* we join the array separated by the comma */
	var selected;
	selected = chkArray.join(',') + ",";
	
	/* check if there is selected checkboxes, by default the length is 1 as it contains one single comma */
	if(selected.length > 1){
		alert("You have selected " + selected);	
	}else{
		alert("Please at least one of the serial Number");	
	}
}
</script>

<div class="had">Select Serial Number</div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right" valign="bottom">

<form name="frmSrch" id="frmSrch" action="SerialList.php" method="get" onSubmit="return ResetSearch();">


	<input type="text" name="key" id="key" placeholder="<?=SEARCH_KEYWORD?>" class="textbox" size="20" maxlength="30" value="<?=$_GET['key']?>">&nbsp;<input type="submit" name="sbt" value="Go" class="search_button">
	<input type="hidden" name="link" id="link" value="<?=$_GET['link']?>">
<input type="hidden" name="Sku" id="Sku" value="<?=$_GET['Sku']?>">
</form>



		</td>
      </tr>
<tr>

<td align="left" valign="bottom">
<input type="submit" name="Select" id="buttonClass" value="Select" class="search_button">
</td>
</tr>
	<tr>
	  <td  valign="top" height="400">
	

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none;padding:50px;"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div">

<table <?=$table_bg?>>


 <tr align="left">
	<td width="4%" class="head1 head1_action" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','SerialID','<?= sizeof($arrySerial) ?>');" />
<input type="hidden" name="Line" id="Line" value="<?=$_GET['Line']?>">
</td>
	<td width="15%"  class="head1">Serial Number</td>
	<td width="15%"  class="head1"> Warehouse Name</td>
	<td width="9%" class="head1" >Sku</td>
		              
                      
                       
                           
                      
                  </tr>

                    <?php



                    if (is_array($arrySerial) && $num > 0) {
                        $flag = true;
                        $Line = 0;
                        foreach ($arrySerial as $key => $values) {
                            $flag = !$flag;
                             $bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
                            $Line++;

                            //if($values['Status']<=0){ $bgcolor="#000000"; }
                            ?>
                            <tr align="left" valign="middle" bgcolor="<?= $bgcolor ?>">
                                <td class="head1_inner"><input type="checkbox" class="chk" name="serialID[]" id="serialID<?= $Line ?>" value="<?= $values['serialID']; ?>"></td>

  <td><?= stripslashes($values['serialNumber']); ?></td>
                                <td>  
                                    <?= stripslashes($values['warehouse_name']); ?>
                                </td>
                                <td>  
                                    <?= stripslashes($values['Sku']); ?>
                                </td>
                              
				
                               
                                 
                            </tr>
                        <?php } // foreach end // ?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="4" class="no_record">No Serial Number found</td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="4"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arrySerial)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>
</div>
</form>
