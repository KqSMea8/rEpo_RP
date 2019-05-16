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
        <td  align="right" >

               <? if($num>0){?>
	<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_adjustment.php?<?=$QueryString?>';" />
<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
	  <? } ?>
            <a href="editAdjustment.php?curP=<?= $_GET['curP'] ?>" class="add">Add New Adjustment</a>			
        </td>
    </tr>	
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
                       <!-- <td width="4%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','ItemID','<?= sizeof($arryAdjustment) ?>');" /></td>-->
                      <td width="10%" class="head1" align="center"><?=ADJ_NO?></td>
                      <td width="10%"  class="head1" ><?=ADJ_DATE?></td>
                      <td class="head1" width="12%" ><?=ADJ_WAREHOUSE?></td>
                        <td width="12%" class="head1" ><?=ADJ_REASON?> </td>
                      <td width="10%" class="head1" ><?=TOT_ADJ_REASON?></td>
                      <td width="8%" class="head1" ><?=TOTAL_ADJUST_VALUE?></td>
											<td  class="head1" >Created By</td>
                      <td width="10%" class="head1 head1_inner" align="center"><?=VIEW_STATUS?></td>
                          
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
                                <!--<td><input type="checkbox" name="adjustmentID[]" id="ItemID<?= $Line ?>" value="<?= $values['adjID']; ?>"></td>-->
                                <td align="center">  
                                    <?= stripslashes($values['adjustNo']); ?>
                                </td>
                                <td><?= date($Config['DateFormat'] , strtotime($values['adjDate'])); ?></td>
                                 <td><?= stripslashes($values['warehouse_name']); ?></td>
                                 <td><?= stripslashes($values['adjust_reason']); ?></td>
                                  <td><?= stripslashes($values['total_adjust_qty']); ?></td>
                                  <td><?= stripslashes($values['total_adjust_value']); ?></td>
																	<td> <? if($values['created_by']=='admin'){echo 'Admin';}else{
																	echo '<a class="fancybox fancybox.iframe"	href="../userInfo.php?view=.'.$values['EmpID'].'"> '.$values['UserName'].'</a>';
																	}
																		?>     </td>  
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
                                      <a href="vAdjustment.php?view=<?=$values['adjID']?>&curP=<?=$_GET['curP']?>" ><?=$view?></a>
                                      
                                      <? if($values['Status'] != 2){?>
                                    <a href="editAdjustment.php?edit=<? echo $values['adjID']; ?>&curP=<?php echo $_GET['curP']; ?>"><?= $edit ?></a>  
                                    <a href="editAdjustment.php?del_id=<? echo $values['adjID']; ?>&curP=<?php echo $_GET['curP']; ?>" onClick="return confDel('Product')"  ><?= $delete ?></a>
                        <? }?>
                        </td>
                                      
                            
                            </tr>
                        <?php } // foreach end // ?>



                    <?php } else { ?>
                        <tr >
                            <td  colspan="9" class="no_record"><?=NO_RECORD_ADJUST?></td>
                        </tr>

                    <?php } ?>



                    <tr >  <td class="head1_inner" colspan="9" ><?=TOTAL_ADJUST_RECORD?> : &nbsp;<?php echo $num; ?>      <?php if (count($arryAdjustment) > 0) { ?>
                                &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
                    }
                    ?></td>
                    </tr>
                </table>

                <? if (sizeof($arryAdjustment)) { ?>
                    <table width="100%" align="center" cellpadding="3" cellspacing="0">
                        <tr align="center" > 
                            <td height="30" align="left" >
                                <!--input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('product','delete','<?= $Line ?>','ItemID','editItem.php?curP=<?= $_GET['curP'] ?>&dCatID=<?=$_GET['CatID']?>');">
                                <!--<input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('product','active','<?= $Line ?>','ItemID','editItem.php?curP=<?= $_GET['curP'] ?>&dCatID=<?=$_GET['CatID']?>');" />-->
                                <!--<input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('product','inactive','<?= $Line ?>','ItemID','editItem.php?curP=<?= $_GET['curP'] ?>&dCatID=<?=$_GET['CatID']?>');" />--></td>
                        </tr>
                    </table>
                <? } ?>

                <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">


            </form>
        </td>
    </tr>

</table>
