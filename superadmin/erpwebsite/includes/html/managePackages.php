<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';
		/*
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  { 
			   location.href = 'viewLicense.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewLicense.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
			return false;
			*/
	}
</script>
<?php include('siteManagementMenu.php');?>
<div class="clear"></div>
<br>
<div class="message" align="center">
<? if(!empty($_SESSION['mess_packages'])) {echo $_SESSION['mess_packages']; unset($_SESSION['mess_packages']); }?>
</div>

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <div class="message"><? if (!empty($_SESSION['mess_Page'])) {
    echo stripslashes($_SESSION['mess_Page']);
    unset($_SESSION['mess_Page']);
} ?></div>
            <table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                    <td width="61%" height="32">&nbsp;</td>
                    <!--  <td width="39%" align="right"> <a href="packages.php" class="add">Add Package</a>      </td>-->
                </tr>

            </table>

            <table <?= $table_bg ?>>
                <tr align="left" >
                    <td width="10%" height="20"  class="head1">Name</td> 
                    <td width="15%" height="20"  class="head1">Type</td> 
                    <td width="5%" height="20"  class="head1">Users</td> 
                     <td width="10%" height="20"  class="head1">$ Price </td> 
                    <td width="10%" height="20"  class="head1">Duraton</td>
                     
                     <td width="20%" height="20"  class="head1">Free Space (GB)</td> 
                     <td  height="20"  class="head1">$ Additional Space Price (Per/10 GB)</td> 
                    <!--td  width="10%" height="20"  class="head1" align="center">Status</td-->
                    <td width="5%"   height="20" align="right" class="head1">Action&nbsp;&nbsp;</td>
                </tr>
                <?php
                $pagerLink = $objPager->getPager($arryPages, $RecordsPerPage, $_GET['curP']);
                (count($arryShipingMethod) > 0) ? ($arryPages = $objPager->getPageRecords()) : ("");
                if (is_array($arryPages) && $num > 0) {
                    $flag = true;

                    foreach ($arryPages as $key => $values) {
                    	//echo "<pre>";print_r($values);
                        ?>
                        <tr align="left"  bgcolor="<?= $bgcolor ?>">
                            <td height="26"><?= $values['name']; ?></td>
                            <td height="26"><?= $values['type']; ?></td>
                              <td height="26"><?= $values['allow_users']; ?></td>
                            <td height="26"><?= $values['price']; ?></td>
                            <td height="26"><?= $values['duration']; ?></td>
                              
                              <td height="26"><?= $values['space']; ?></td>
                               <td height="26"><?= $values['additional_spaceprice']; ?></td>
                          
                            <!-- td align="center" ><?
                        if ($values['Status'] == "Yes") {
                            $status = 'Active';
                        } else {
                            $status = 'InActive';
                        }


                        echo '<a href="packages.php?active_id=' . $values["id"] . '&curP=' . $_GET["curP"] . '" class="' . $status . '">' . $status . '</a>';
                        ?>
                            </td-->
                            <td height="26" align="center"  valign="top">
                                <a href="packages.php?edit=<?php echo $values['id']; ?>&curP=<?php echo $_GET['curP']; ?>" class="Blue"><?= $edit ?></a>
                                <!--  <a href="packages.php?del_id=<?php echo $values['id']; ?>&curP=<?php echo $_GET['curP']; ?>" onclick="return confDel('<?= $cat_title ?>')" class="Blue" ><?= $delete ?></a> -->          
                                &nbsp;
                            </td>
                        </tr>
                    <?php } // foreach end //?>
<?php } else { ?>
                    <tr align="center" >
                        <td height="20" colspan="4"  class="no_record">No Record Found. </td>
                    </tr>
<?php } ?>

                <tr>  
                    <td height="20" colspan="4" >Total Record(s) : &nbsp;<?php echo $num; ?>    
<?php if (count($arryShipingMethod) > 0) { ?>&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
} ?>       
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
        

  