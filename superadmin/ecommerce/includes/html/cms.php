<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';
		
	}
</script>
<div class="had">Static Contents &raquo;   Pages</div>
   <div class="clear"></div> 
   <br>
<div class="message" align="center">
<? //if(!empty($_SESSION['mess_pg'])) {echo $_SESSION['mess_pg']; unset($_SESSION['mess_pg']); }?>
</div>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <div class="message"><? ?></div>
            <table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                    <td width="61%" height="32">&nbsp;</td>
                    <td width="39%" align="right"> <a href="cms_pageAdd.php" class="add">Add New Page</a> 
                    <a href="index.php" class="back">Back</a>     </td>
                </tr>

            </table>

            <table <?= $table_bg ?>>
                <tr align="left" >
                    <td width="50%" height="20"  class="head1">Page Name</td> 
                    <td width="10%" height="20"  class="head1" align="center">Slug</td> 
                    <td width="10%" height="20"  class="head1" align="center">Title</td>
                    <td width="10%" height="20"  class="head1" align="center">Status</td>
                    <td width="5%"  height="20"  align="right" class="head1">Action&nbsp;&nbsp;</td>
                </tr>
		
                <?php 
			if(!empty($arryPages)){
			foreach ($arryPages as $values) {  ?>
                        
                        <tr align="left"  bgcolor="<?= $bgcolor ?>">
                            <td height="26"><?php echo $values->Name; ?>     </td>
                            <td height="26" align="center"><?= $values->page_slug; ?></td>
                            <td height="26" align="center"><?= $values->Title; ?></td>
                        <td align="center" >
						<?
                        if ($values->Status == 1) {
                            $status = 'Active';
                        } else {
                            $status = 'InActive';
                        }


                        echo '<a href="cms_pageAdd.php?active_id=' . $values->id . '&Status=' .  $values->Status . '" class="' . $status . '">' . $status . '</a>';
                        ?>
                            </td>
                            <td height="26" align="right"  valign="top">
                                <a href="cms_pageAdd.php?edit=<?php echo $values->id; ?>" class="Blue"><?= $edit ?></a>
                                <a  href="cms_delete.php?del_id=<?php echo $values->id; ?>" class="Blue" onclick="return confirm('Are You Sure Delete This Page');" ><?= $delete ?></a>              
                                &nbsp;
                            </td>
                        </tr>
                    <?php } }// foreach end //?>

                <tr>  
                    <td height="20" colspan="4" >Total Record(s) : &nbsp;<?php echo $num; ?>    
<?php if (count($arryPages) > 0) { ?>&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pageslink;
} ?>       
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<script type="text/javascript">
function confirm_delete()
{
	return confirm("Are You Sure Delete User Account");
}
<? //require_once("includes/footer.php"); ?>
