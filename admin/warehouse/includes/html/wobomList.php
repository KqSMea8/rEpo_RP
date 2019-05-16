<script language="JavaScript1.2" type="text/javascript">
function ResetSearch(){	
	$("#prv_msg_div").show();
	$("#frmSrch").hide();
	$("#preview_div").hide();
}



function SetItemCode(bomID,Sku){
    var NumLine = window.parent.document.getElementById("NumLine").value;   
    
    
   //alert(ItemID);
    /******************/
    var SkuExist = 0;

    for(var i=1;i<=NumLine;i++){
        if(window.parent.document.getElementById("bomID"+i) != null){
            if(window.parent.document.getElementById("bomID"+i).value == bomID){
                SkuExist = 1;
                break;
            }
        }
    }
    /******************/
    if(SkuExist == 1){
         $("#msg_div").html('Item BOM [ '+Sku+' ] has been already selected.');
    }else{
        ResetSearch();
        var SelID = $("#id").val();
    
        var SendUrl = "&action=BomInfo&bomID="+escape(bomID)+"&r="+Math.random();

        /******************/
        $.ajax({
            type: "GET",
            url: "ajax.php",
            data: SendUrl,
            dataType : "JSON",
            success: function (responseText) {
          

							window.parent.document.getElementById("sku"+SelID).value=responseText["Sku"];
							window.parent.document.getElementById("item_id"+SelID).value=responseText["ItemID"];
							window.parent.document.getElementById("bomID"+SelID).value=responseText["bomID"];
							window.parent.document.getElementById("BomDate"+SelID).value = responseText["UpdatedDate"];
							window.parent.document.getElementById("description"+SelID).value=responseText["description"];
							window.parent.document.getElementById("BomQty"+SelID).focus();

                    parent.jQuery.fancybox.close();
                    ShowHideLoader('1','P');
               
           


            }
        });
       
    }

}

</script>

<div class="had">Select Bill Number</div>

<div id="msg_div" class="message"></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right" valign="bottom">

<form name="frmSrch" id="frmSrch" action="bomList.php" method="get" onSubmit="return ResetSearch();">
	<input type="text" name="key" id="key" placeholder="<?=SEARCH_KEYWORD?>" class="textbox" size="20" maxlength="30" value="<?=$_GET['key']?>">&nbsp;<input type="submit" name="sbt" value="Go" class="search_button">
<input type="hidden" name="id" id="id" value="<?=$_GET["id"]?>">
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
	<a href="Javascript:void(0)" onclick="Javascript:SetItemCode('<?=$values["bomID"]?>','<?=$values["Sku"]?>');"><?=$values["Sku"]?></a>
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
