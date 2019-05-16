<script language="JavaScript1.2" type="text/javascript">
    function ResetSearch() {
        $("#prv_msg_div").show();
        $("#frmSrch").hide();
        $("#preview_div").hide();
        $("#msg_div").html("");
    }

    function ShowList() {
        $("#prv_msg_div").hide();
        $("#frmSrch").show();
        $("#preview_div").show();
    }

    function SetItemCode(binid, bin) {
        var NumLine = window.parent.document.getElementById("NumLine").value;

        /******************/
        var SkuExist = 0;
 var SelID = $("#id").val();
      
                    window.parent.document.getElementById("bin" + SelID).value = bin;
                    window.parent.document.getElementById("binid" + SelID).value = binid;
                   



                    parent.ProcessTotal();
                    /**********************************/


                    parent.jQuery.fancybox.close();
                    ShowHideLoader('1', 'P');




            

    }
function showConfirmBox(ItemID,Sku,AliasID,SelID){


if(AliasID ==''){
					if(confirm("Display Alias Item!")) {
					
							$('#tr'+SelID).slideToggle('slow');
					    
					} else{

					   SetItemCode(ItemID,Sku,'');
					}
  }
}
</script>

<div class="had">
    Select Bin Location
</div>


<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td align="center" height="20">
            <div id="msg_div" class="redmsg"></div>
        </td>
    </tr>	

    <tr>
        <td align="right" valign="top">

            <form name="frmSrch" id="frmSrch" action="SelectBinLoc.php" method="get" onSubmit="return ResetSearch();">
                <input type="text" name="key" id="key" placeholder="<?= SEARCH_KEYWORD ?>" class="textbox" size="20" maxlength="30" value="<?= $_GET['key'] ?>">&nbsp;<input type="submit" name="sbt" value="Go" class="search_button">
                <input type="hidden" name="id" id="id" value="<?= $_GET["id"] ?>">
 <input type="hidden" name="WID" id="WID" value="<?= $_GET["WID"] ?>">
                <input type="hidden" name="proc" id="proc" value="<?= $_GET["proc"] ?>">
            </form>



        </td>
    </tr>

    <tr>
        <td id="ProductsListing" height="400" valign="top">

            <form action="" method="post" name="form1">
                <div id="prv_msg_div" style="display:none; padding:50px;"><img src="../images/ajaxloader.gif"></div>
                <div id="preview_div">

                    <table <?= $table_bg ?>>


                        <tr align="left">
                            <td width="30%" class="head1">Bin</td>
                            <td class="head1" >Warehouse</td>
                         
                        </tr>
<?php /* if (count($arryWbin) > 0) {
$i=0;
	foreach ($arryWbin as $ItemBin) {
$i++;
	?>
	<tr class="evenbg" bgcolor="#ffffff" align="left">
	
	<td ><?=$ItemBin['binlocation_name']?></td>
<td ><?=$ItemBin['warehouse_name']?></td>

	
	
	</tr>
	<?php  }
	} else {
	?>
	<tr valign="middle" bgcolor="#ffffff" align="left">
	<td class="no_record" colspan="7">No Records Found.</td>

	</tr>
	<?php } */?>

                        <?php
                        //echo $num;
                        //pr($arryProduct);
                        if (is_array($arryProduct) && $num > 0) {
                            $flag = true;
                            $Line = 0;
                            foreach ($arryProduct as $key => $values) {
                                $flag = !$flag;
                                //$bgcolor=($flag)?(""):("#F3F3F3");
                                $Line++;
                                                              
                                ?>
                                <tr align="left" valign="middle" bgcolor="<?= $bgcolor ?>">
                                    
             <td><a href="Javascript:void(0)"  onclick="Javascript:SetItemCode('<?=$values["binid"]?>','<?=$values["binlocation_name"]?>','');" ><?= stripslashes($values["binlocation_name"]); ?></a>  
                                  
                                    <td><?= stripslashes($values['wCode']); ?></td>



                                </tr>
                               
                                
                                <!--End-->
                                
                                
                                
    <?php } // foreach end //  ?>



<?php } else { ?>
                            <tr >
                                <td  colspan="7" class="no_record"><?= NO_RECORD ?></td>
                            </tr>

<?php } ?>



                        <tr >  <td  colspan="10" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryProduct) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php
                                    echo $pagerLink;
                                }
                                ?></td>
                        </tr>
                    </table>
                </div>



            </form>
        </td>
    </tr>

</table>

