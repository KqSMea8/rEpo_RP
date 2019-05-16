<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(frm){	

if(!ValidateForSimpleBlank(document.getElementById("key"), "Item Sku")){
	return false;
	} else{
		LoaderSearch();
		return true;
	}

	
}
</script>


<div class="had"> <?=$MainModuleName?> </div>



<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

 <tr>
    <td align="right">
	     <? if($num>0){?>
	<!--<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_cand.php?<?=$QueryString?>';" />-->
<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
	  <? } ?>
	      <? if($_GET['key']!='') {?>
		  <a href="<?=$ViewUrl?>" class="grey_bt">View All</a>
		<? }?>
	</td>
 
 </tr>
   
    <tr>
        <td  >
            <div class="message"><? if (!empty($_SESSION['mess_product'])) { echo $_SESSION['mess_product'];} ?>
            </div>
        </td>
    </tr>		

    <tr>
        <td id="ProductsListing">

            <form action="" method="post" name="form1">
                
                <div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
                <table <?= $table_bg ?>>


                    <tr align="left">
                        <!--<td width="4%" class="head1 head1_action" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','ItemID','<?= sizeof($arryItemOrder) ?>');" /></td>-->
                      <td width="9%" class="head1" >Sku</td>
                      <td width="20%" class="head1" >Item Description</td>
                     <td width="15%"  class="head1">Date</td>
					  <td width="15%"  class="head1"> Vendor</td>
                          <td width="15%"  class="head1"> Price</td>
						   <td width="15%"  class="head1"> Currency</td>
                           
                      
                  </tr>

                    <?php

                    if (is_array($arryItemOrder) && $num > 0) {
                        $flag = true;
                        $Line = 0;
                        foreach ($arryItemOrder as $key => $values) {
                            $flag = !$flag;
                             $bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
                            $Line++;

                            //if($values['Status']<=0){ $bgcolor="#000000"; }
                            ?>
                            <tr align="left" valign="middle" bgcolor="<?= $bgcolor ?>">
                                <!--<td class="head1_inner"><input type="checkbox" name="ItemID[]" id="ItemID<?= $Line ?>" value="<?= $values['ItemID']; ?>"></td>-->
                               <td>  
                                    <?= stripslashes($values['sku']); ?> 
                                </td>
                                <td><?= stripslashes($values['description']); ?></td>
				
                                <td><?= date($Config['DateFormat'] , strtotime($values['PostedDate'])); ?></td>
                                <td> <a class="fancybox supp fancybox.iframe" href="../purchasing/suppInfo.php?view=<?=$values['SuppCode']?>"><?=stripslashes($values["SuppCompany"])?></a></td>
                                 <td><?=number_format($values['ItemCost'],2); ?></td>
								 
								 <td><?=$values['Currency']; ?></td>
                                 
                            </tr>
                        <?php } // foreach end // ?>



                    <?php } else { ?>
                        <tr >
                            <td  colspan="5" class="no_record">No Records found.</td>
                        </tr>

                    <?php } ?>



                    <tr >  <td  colspan="10" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryItemOrder) > 0) { ?>
                                &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
                    }
                    ?></td>
                    </tr>
                </table>
</div>
                <? if (sizeof($arryItemOrder)) { ?>
                    <table width="100%" align="center" cellpadding="3" cellspacing="0">
                        <tr align="center" > 
                            <td height="30" align="left" >
                               <!-- <input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('product','delete','<?= $Line ?>','ItemID','editItem.php?curP=<?= $_GET[curP] ?>&dCatID=<?=$_GET['CatID']?>');">-->
                                <!--<input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('product','active','<?= $Line ?>','ItemID','editItem.php?curP=<?= $_GET[curP] ?>&dCatID=<?=$_GET['CatID']?>');" />-->
                                <!--<input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('product','inactive','<?= $Line ?>','ItemID','editItem.php?curP=<?= $_GET[curP] ?>&dCatID=<?=$_GET['CatID']?>');" />--></td>
                        </tr>
                    </table>
                <? } ?>

                <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">


            </form>
        </td>
    </tr>

</table>
