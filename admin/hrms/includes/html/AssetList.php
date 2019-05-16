<script language="JavaScript1.2" type="text/javascript">
function ResetSearch(){	
	$("#prv_msg_div").show();
	$("#frmSrch").hide();
	$("#preview_div").hide();
}
function SetAssetID(AssetID,AssetName,TagID){
        window.parent.document.getElementById("AssetName").value=AssetName;
	   window.parent.document.getElementById("AssetID").value=AssetID;
	   window.parent.document.getElementById("TagID").value=TagID;
	  parent.jQuery.fancybox.close();
	 ShowHideLoader('1','P');
}

</script>

<div class="had">Select Asset</div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right" valign="bottom">

		<form name="frmSrch" id="frmSrch" action="AssetList.php" method="get" onSubmit="return ResetSearch();">
			<input type="text" name="key" id="key" placeholder="<?=SEARCH_KEYWORD?>" class="textbox" size="20" maxlength="30" value="<?=$_GET['key']?>">&nbsp;<input type="submit" name="sbt" value="Go" class="search_button">
			<input type="hidden" name="link" id="link" value="<?=$_GET['link']?>">
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
	<td class="head1" width="14%">Asset Name</td>
	  <td class="head1" width="10%">Tag ID</td>
		<td class="head1" width="14%">Serial Number</td>
		<!--td width="14%" class="head1">Category</td-->
		<td width="14%" class="head1">Model</td>
    </tr>
   
    <?php 
  if(is_array($arryAsset) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryAsset as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;
	
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
	
    <td>
	<a href="Javascript:void(0)" onMouseover="ddrivetip('<?=CLICK_TO_SELECT?>', '','')"; onMouseout="hideddrivetip()" onclick="Javascript:SetAssetID('<?=$values["AssetID"]?>','<?=$values["AssetName"]?>','<?=$values["TagID"]?>');"><?=$values["AssetName"]?></a>
	</td>
<td><?=stripslashes($values["TagID"])?></td>

<td><?=stripslashes($values["SerialNumber"])?></td>

    <!--td><?=stripslashes($values["Category"])?></td--> 
	<td><?=stripslashes($values["Model"])?></td>

      
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="6" class="no_record"><?=NO_ASSET_FOUND?></td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="7"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryAsset)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 

  
</form>
</td>
	</tr>
</table>
