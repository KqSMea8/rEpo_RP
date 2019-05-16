<script language="JavaScript1.2" type="text/javascript">
function ResetSearch(){	
	$("#prv_msg_div").show();
	$("#frmSrch").hide();
	$("#preview_div").hide();
}

function SetbomCode(key){


 //var Bom = document.getElementById("BOM").value = '';

ShowHideLoader('1', 'P');

       var SelID = 1;
      
        var SendUrl = "&action=SearchBomCode&key="+escape(key)+"&r="+Math.random();
 $.ajax({
            type: "GET",
            url: "../sales/ajax.php",
            data: SendUrl,
            dataType : "JSON",
            success: function (responseText) {
           
                   if(responseText["Sku"] == undefined){
													//alert('Item Sku [ '+key+' ] is not exists.');
													DisplayConMsg(document.getElementById("BOM"),'Alert','BOM does not exists.');
													window.parent.document.getElementById("BOM").value='';
													window.parent.document.getElementById("item_id").value='';
													window.parent.document.getElementById("description").value='';
													window.parent.document.getElementById("WoQty").value='';
													ShowHideLoader('2', 'P');
                   }else{ 

												$reqitem = (responseText["RequiredItem"]) ? responseText["RequiredItem"]+'#' : '';  
												window.parent.document.getElementById("req_item").value =  responseText["KitItems"];
												//if(document.getElementById("req_item").value) $("#sku"+SelID).closest('tr').addClass('parent').css("background-color", "#106db2"); 

													window.parent.document.getElementById("BOM").value=responseText["Sku"];
													window.parent.document.getElementById("item_id").value=responseText["ItemID"];
													window.parent.document.getElementById("description").value=responseText["description"];
													window.parent.document.getElementById("WoQty").value='1';
													//document.getElementById("sku" + SelID).focus();         
													ShowHideLoader('2', 'P');  
window.parent.addComponentItem(1);  
parent.$.fancybox.close();             
                      }

            }
        });


}



</script>

<div class="had">Select Bill Number</div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right" valign="bottom">

<form name="frmSrch" id="frmSrch" action="WoBOMList.php" method="get" onSubmit="return ResetSearch();">
	<input type="text" name="key" id="key" placeholder="<?=SEARCH_KEYWORD?>" class="textbox" size="20" maxlength="30" value="<?=$_GET['key']?>">&nbsp;<input type="submit" name="sbt" value="Go" class="search_button">
	<input type="hidden" name="linill_optionk" id="link" value="<?=$_GET['link']?>">
</form>



		</td>
      </tr>
	 
	<tr>
	  <td  valign="top" height="400">
	

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none;padding:50px;"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div">

<table <?=$table_bg?>>
    <tr align="left"  >
        <td width="12%"  class="head1" >BOM No.</td>
     
     <td class="head1" >Description</td>
<td class="head1" >Bill With Option</td>
      
     
    </tr>
   
    <?php 
  if(is_array($arryBOM) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryBOM as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;
	
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
    <td>
	<a href="Javascript:void(0)" onclick="Javascript:SetbomCode('<?=$values["Sku"]?>','<?=$values["bill_option"]?>');"><?=$values["Sku"]?></a>
	</td>
   
     <td><?=stripslashes($values["description"])?></td> 
  <td><?=stripslashes($values["bill_option"])?></td> 
    
   
      
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="3" class="no_record">No Bill of material found</td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="3"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryBOM)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 

  
</form>
</td>
	</tr>
</table>
