<script language="JavaScript1.2" type="text/javascript">
    function ValidateSearch(SearchBy){
        /*
          var frm  = document.form1;
          var frm2 = document.form2;
           if(SearchBy==1)  {
                   location.href = 'viewProducts.php?curP='+frm.CurrentPage.value+'&MemberID='+document.topForm.MemberID.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value)+'&CatID='+document.topForm.CatID.value;
           } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
                   location.href = 'viewProducts.php?curP='+frm.CurrentPage.value+'&MemberID='+document.topForm.MemberID.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value)+'&CatID='+document.topForm.CatID.value;
                }
		
                return false;*/
    }


    function submitThisForm(frm){	
        if(document.getElementById("ProductsListing") != null){
            document.getElementById("ProductsListing").innerHTML= '<img src="images/loading.gif"><br><br><br><br>';
        }
        document.topForm.submit();
    }

</script> 


<div class="had">
    <?=$MainModuleName?> <?= $MainParentCategory ?>  <span><?= $ParentCategory ?></span>
</div>



<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

 
   	
    <tr>
        <td  >
            <div class="message"><? if (!empty($_SESSION['mess_adjustment'])) {
    echo $_SESSION['mess_adjustment'];
    unset($_SESSION['mess_adjustment']);
} ?>
            </div>
        </td>
    </tr>		

    <tr>
        <td id="ProductsListing">

            <form action="" method="post" name="form1">
                <table <?= $table_bg ?>>


                    <tr align="left">
                       <!-- <td width="4%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','ItemID','<?= sizeof($arryProduct) ?>');" /></td>-->
                      <td width="12%" class="head1" align="center"><?=ADJ_NO?></td>
                      <td width="12%"  class="head1" ><?=ADJ_DATE?></td>
                      <td width="12%"  class="head1" ><?=ADJ_WAREHOUSE?></td>
                      
                        <td width="16%" class="head1" ><?=ADJ_REASON?> </td>
                      <td width="15%" class="head1" ><?=TOT_ADJ_REASON?></td>
                      <td width="14%" class="head1" ><?=TOTAL_ADJUST_VALUE?></td>
                      <td width="10%" class="head1" align="center"><?=VIEW_STATUS?></td>
                          
                      <td width="10%"  align="center" class="head1" ><?=Action?></td>
                  </tr>

                    <?php
                    if (is_array($arryAdjustment) && $num > 0) {
                        $flag = true;
                        $Line = 0;
                        foreach ($arryAdjustment as $key => $values) {
                           $flag=!$flag;
	                  $bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	                  $Line++;

                            //if($values['Status']<=0){ $bgcolor="#000000"; }
                            ?>
                            <tr align="left" valign="middle" bgcolor="<?= $bgcolor ?>">
                                <!--<td><input type="checkbox" name="adjustmentID[]" id="ItemID<?= $Line ?>" value="<?= $values['adjustmentID']; ?>"></td>-->
                                <td align="center">  
                                    <?= stripslashes($values['adjustNo']); ?>
                                </td>
                                <td><?= date($Config['DateFormat'] , strtotime($values['adjDate'])); ?></td>
                                 <td><?= stripslashes($values['warehouse_name']); ?></td>
                                 <td><?= stripslashes($values['adjust_reason']); ?></td>
                                  <td><?= stripslashes($values['total_adjust_qty']); ?></td>
                                  <td><?= stripslashes($values['total_adjust_value']); ?></td>
                                  <td width="10%" align="center"><?
                                    if ($values['Status'] == 1) {
                                        $status = 'Parked';
                                        $Class = 'green';
                                    } else if($values['Status'] == 2){
                                        $status = 'Completed';
                                        $Class = 'green';
                                    }else{
                                        
                                      $status = 'Cancel';
                                      $Class = 'red';
                                    }

                               

                                    echo '<span class="'.$Class.'" >' . $status . '</span>';
                                    ?></td>
							
                          
                                 
                                   
                          <td width="10%"  align="center" class="head1_inner"  >
                                     
                                    <a class="no_record" href="editStockIn.php?adj=<? echo $values['adjID']; ?>&curP=<?php echo $_GET['curP']; ?>">Stock In</a>  
                                    	</td>
                  </tr>
                        <?php } // foreach end // ?>



                    <?php } else { ?>
                        <tr >
                            <td  colspan="8" class="no_record"><?=NO_RECORD_ADJUST?></td>
                        </tr>

                    <?php } ?>



                    <tr >  <td  colspan="8" ><?=TOTAL_ADJUST_RECORD?> : &nbsp;<?php echo $num; ?>      <?php if (count($arryAdjustment) > 0) { ?>
                                &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
                    }
                    ?></td>
                    </tr>
                </table>

                <? if (sizeof($arryProduct)) { ?>
                    <table width="100%" align="center" cellpadding="3" cellspacing="0">
                        <tr align="center" > 
                            <td height="30" align="left" >
                                <input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('product','delete','<?= $Line ?>','ItemID','editItem.php?curP=<?= $_GET[curP] ?>&dCatID=<?=$_GET['CatID']?>');">
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
