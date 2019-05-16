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

<div class="message" align="center"><? if(!empty($_SESSION['mess_license'])) {echo $_SESSION['mess_license']; unset($_SESSION['mess_license']); }?></div>
        <ul class="site-cl">

            <li><a href="pageList.php">Page Management</a></li>

                       <li>

                <a href="menuManagement.php">Menu Management</a>

                <ul>

                     <li><a href="headerMenu.php">Header Menu</a></li>
                    <li><a href="footerSocialLinksList.php">Footer Social Link</a></li>


                </ul>

            </li>
	  	<li><a href="packegeManagement.php">Package Management</a>
		<ul>

			<li><a href="managePackFeature.php">Manage Package Feature</a></li>
			<li><a href="managePackType.php">Manage Package Type</a></li>
			<li><a href="managePackages.php">Packages</a></li>


		</ul>
	</li>
			<li><a href="bannerManagement.php">Banner Management</a></li>




        </ul>
   <div class="clear"></div> 

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
                    <td width="39%" align="right"> <a href="addPackFeature.php" class="add">Add Pack Feature</a>      </td>
                </tr>

            </table>

            <table <?= $table_bg ?>>
                <tr align="left" >
                    <td width="20%" height="20"  class="head1">Feature</td> 
                    <td width="30%" height="20"  class="head1" align="center">Description</td> 
                    <td  width="10%" height="20"  class="head1" align="center">Type</td>
                    <td  width="10%" height="20"  class="head1" align="center">Status</td>
                    
                    
                    <td width="5%"   height="20" align="right" class="head1">Action&nbsp;&nbsp;</td>
                </tr>
                <?php
                $pagerLink = $objPager->getPager($arryPages, $RecordsPerPage, $_GET['curP']);
                (count($arryShipingMethod) > 0) ? ($arryPages = $objPager->getPageRecords()) : ("");
                if (is_array($arryPages) && $num > 0) {
                    $flag = true;

                    foreach ($arryPages as $key => $values) {
                    	//print_r($values);
                        ?>
                        <tr align="left"  bgcolor="<?= $bgcolor ?>">
                            <td height="26"><?= $values['feature']; ?>     </td>
                            <td height="26" align="center"><?= $values['description']; ?></td>
                             <td height="26" align="center"><?= $values['type']; ?></td>
                            <td align="center" ><?
                        if ($values['Status'] == "Yes") {
                            $status = 'Active';
                        } else {
                            $status = 'InActive';
                        }


                        echo '<a href="addPackFeature.php?active_id=' . $values["id"] . '&curP=' . $_GET["curP"] . '" class="' . $status . '">' . $status . '</a>';
                        ?>
                            </td>
                            <td height="26" align="right"  valign="top">
                                <a href="addPackFeature.php?edit=<?php echo $values['id']; ?>&curP=<?php echo $_GET['curP']; ?>" class="Blue"><?= $edit ?></a>
                                <a href="addPackFeature.php?del_id=<?php echo $values['id']; ?>&curP=<?php echo $_GET['curP']; ?>" onclick="return confDel('<?= $cat_title ?>')" class="Blue" ><?= $delete ?></a>              
                                &nbsp;
                            </td>
                        </tr>
                    <?php } // foreach end //?>
<?php } else { ?>
                    <tr align="center" >
                        <td height="20" colspan="4"  class="no_record">No Pages found. </td>
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
        

  