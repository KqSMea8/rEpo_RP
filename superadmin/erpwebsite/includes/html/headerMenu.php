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
<? if(!empty($_SESSION['mess_header_menu'])) {echo $_SESSION['mess_header_menu']; unset($_SESSION['mess_header_menu']); }?>
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
                    <td width="39%" align="right"> <!-- <a href="addHeaderMenu.php" class="add">Add Header Menu</a> -->   

<a href="footerSocialLinksList.php" class="grey_bt">Footer Social Link</a>

   </td>
                </tr>

            </table>

            <table <?= $table_bg ?>>
                <tr align="left" >
                    <td width="20%" height="20"  class="head1">Slug</td> 
                    <td width="5%"   height="20" align="center" class="head1">Action&nbsp;&nbsp;</td>
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
                            <td height="26"><?= $values['slug']; ?>     </td>
                            
                            <td height="26" align="center"  valign="top">
                                <a href="addHeaderMenu.php?edit=<?= $values['slug']; ?>&curP=<?php echo $_GET['curP']; ?>" class="Blue"><?= $edit ?></a>
                                            
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
        

  
