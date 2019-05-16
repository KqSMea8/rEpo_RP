<script language="JavaScript1.2" type="text/javascript">
function ResetSearch(){	
	$("#prv_msg_div").show();
	$("#frmSrch").hide();
	$("#preview_div").hide();
}




function getserial(Serl){


window.parent.document.getElementById("serial_Num").value = Serl;
				
					//ShowHideLoader('1','P');
 parent.$.fancybox.close();
}

</script>

<div class="had">Select Serial Number</div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right" valign="bottom">

<form name="frmSrch" id="frmSrch" action="ParentSerialList.php" method="get" onSubmit="return ResetSearch();">


	<input type="text" name="key" id="key" placeholder="<?=SEARCH_KEYWORD?>" class="textbox" size="20" maxlength="30" value="<?=$_GET['key']?>">&nbsp;<input type="submit" name="sbt" value="Go" class="search_button">
	<input type="hidden" name="link" id="link" value="<?=$_GET['link']?>">
<input type="hidden" name="Sku" id="Sku" value="<?=$_GET['Sku']?>">
</form>



		</td>
      </tr>
<!--tr >

<td align="left" valign="bottom">
<input type="submit" name="Select" id="buttonClass" value="Select" class="search_button">
</td>
</tr-->
	<tr>
	  <td  valign="top" height="400">
	

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none;padding:50px;"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div">

<table <?=$table_bg?>>


 <tr align="left">
	<!--td width="4%" class="head1 head1_action" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','SerialID','<?= sizeof($arrySerial) ?>');" />
<input type="hidden" name="Line" id="Line" value="<?=$_GET['Line']?>">
</td-->
	<td width="15%"  class="head1">Serial Number</td>
<td width="15%"  class="head1">description</td>
	
	
		              
                      
                       
                           
                      
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
                                <!--td class="head1_inner"><input type="checkbox" class="chk" name="serialID[]" id="serialID<?= $Line ?>" value="<?= $values['serialID']; ?>"></td-->

  <td><a href="" onclick="getserial('<?= stripslashes($values['serialNumber']); ?>');" ><?= stripslashes($values['serialNumber']); ?></a></td>
<td>  
                                    <?= stripslashes($values['description']); ?>
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
