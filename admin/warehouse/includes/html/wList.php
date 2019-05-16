<script language="JavaScript1.2" type="text/javascript">
function ResetSearch(){	
	$("#prv_msg_div").show();
	$("#frmSrch").hide();
	$("#preview_div").hide();
}
function SetSuppCode44(SuppCode){	
	window.parent.document.getElementById("SuppCode").value=SuppCode;
	parent.jQuery.fancybox.close();
	ShowHideLoader('1','P');
}


function SetWarCode(WID){	
	ResetSearch();
	var SendUrl = "&action=WarehouseInfo&WID="+escape(WID)+"&r="+Math.random(); 

	$.ajax({
		type: "GET",
		url: "ajax.php",
		data: SendUrl,
		dataType : "JSON",
		success: function (responseText) {
		//alert(responseText);
                  window.parent.document.getElementById("WarehouseCode").value=responseText["warehouse_code"];
                  window.parent.document.getElementById("WarehouseName").value=responseText["warehouse_name"];
                  window.parent.document.getElementById("WID").value=responseText["WID"];

			parent.jQuery.fancybox.close();
			ShowHideLoader('1','P');


		}
	});

}

</script>

<div class="had">Select Warehouse</div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right" valign="bottom">

<form name="frmSrch" id="frmSrch" action="wList.php" method="get" onSubmit="return ResetSearch();">
	<input type="text" name="key" id="key" placeholder="<?=SEARCH_KEYWORD?>" class="textbox" size="20" maxlength="30" value="<?=$_GET['key']?>">&nbsp;<input type="submit" name="sbt" value="Go" class="search_button">
</form>



		</td>
      </tr>
	 
	<tr>
	  <td  valign="top">
	

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div">

<table <?=$table_bg?>>
    <tr align="left"  >
      <td width="20%"  class="head1" >Warehouse Code</td>
      <td width="20%" class="head1" >Warehouse Name</td>
      <td width="18%"  class="head1" >Contact Name</td>
      <td width="10%" class="head1" >City</td>
      <td width="18%"  class="head1" >State</td>
      <td width="20%" class="head1" >Country</td>
      
      
    </tr>
   
    <?php 
  if(is_array($arryWarehouse) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryWarehouse as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;
	
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
    <td>
	<a href="Javascript:void(0)" onclick="Javascript:SetWarCode('<?=$values["WID"]?>');"><?=$values["warehouse_code"]?></a>
	</td>
    <td ><?=$values["warehouse_name"]?></td> 
    
    <td height="20" ><?=stripslashes($values["ContactName"])?></td>
    
      <td height="20" ><?=stripslashes($values["City"])?></td>
      
        <td height="20" ><?=stripslashes($values["State"])?></td>
        
          <td height="20" ><?=stripslashes($values["Country"])?></td>

      
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="6" class="no_record"><?=NO_WAREHOUSE?></td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="6"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryWarehouse)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 
  
</form>
</td>
	</tr>
</table>

