
<script language="JavaScript1.2" type="text/javascript">
    function ValidateSearch() {
        document.getElementById("prv_msg_div").style.display = 'block';
        document.getElementById("preview_div").style.display = 'none';
    }
    function filterLead(id)
    {
        location.href = "viewContact.php?module=contact&customview=" + id;
        LoaderSearch();
    }
</script>
<div class="had">Manage Contact</div>
<div class="message" align="center">
<? if (!empty($_SESSION['mess_social'])) {
    echo $_SESSION['mess_social']; ?>
	<script>
	
    parent.jQuery.fancybox.close();
    parent.location.reload(true);
	</script>
<? } ?>

</div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
    <tr>
        <td  valign="top">
            <form action="" method="post" name="form1">
                <div id="prv_msg_div" style="display:none"><img src="<?= $MainPrefix ?>images/loading.gif">&nbsp;Searching..............</div>
                <div id="preview_div">

                    <table <?= $table_bg ?>>

                            <tr align="left"  >
                             <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','AddID','<?= sizeof($arryContact) ?>');" /></td>-->
                                <!--td width="10%"  class="head1" >Contact ID</td-->
                                <td width="15%"  class="head1" >First Name</td>
                                <td width="15%"  class="head1" >Last Name</td>
                                <td width="20%"  class="head1" >Email</td>   
                                <td width="10%"  align="center"  class="head1 head1_action" >Action</td>
                            </tr>
                        <?php
                        if (is_array($arryContact) && $num > 0) {
                            $flag = true;
                            $Line = 0;
                            foreach ($arryContact as $key => $values) {
                                $flag = !$flag;
                                $bgcolor = ($flag) ? ("#FAFAFA") : ("#FFFFFF");
                                $Line++;

                                //if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
                                ?>
                                <tr align="left"  bgcolor="<?= $bgcolor ?>">
                                        <?php if ($_GET["customview"] == 'All') { ?> 
                                        <!--<td ><input type="checkbox" name="AddID[]" id="AddID<?= $Line ?>" value="<?= $values['AddID'] ?>" /></td>-->
                                         <!--td ><?= $values["AddID"] ?></td-->
                                        <td >
                                            <?= stripslashes($values["FirstName"]) ?></a>		 </td>

                                        <td  >
            <?= stripslashes($values["LastName"]) ?>		 </td>


                                        <td><? echo $values['Email'] ; ?></td>

                                        
                      	   <?php   } ?></td> 
                           <td  align="center" class="head1_inner" >
								
	<?php if((empty($_GET['contactid'])) && (!empty($values['FacebookID'])) && ($_GET['type']=="facebook")) { ?>
	<a href="?contactid=<?= $values['AddID'] ?><?php echo $data; ?>&url=<?php echo $_GET['url'];?>&curP=<?= $_GET['curP'] ?>" >Overwrite</a>
	<?php } elseif(empty($_GET['contactid']) && (!empty($values['TwitterID'])) && ($_GET['type']=="twitter")) { ?>
	<a href="?contactid=<?= $values['AddID'] ?><?php echo $data; ?>&url=<?php echo $_GET['url'];?>&curP=<?= $_GET['curP'] ?>" >Overwrite</a>
	<?php } elseif(empty($_GET['contactid']) && (!empty($values['LinkedinID'])) && ($_GET['type']=="linkedin")) {?>
	<a href="?contactid=<?= $values['AddID'] ?><?php echo $data; ?>&url=<?php echo $_GET['url'];?>&curP=<?= $_GET['curP'] ?>" >Overwrite </a>
        <?php } elseif(empty($_GET['contactid']) && (!empty($values['GoogleID'])) && ($_GET['type']=="googleplus")) {?>
	<a href="?contactid=<?= $values['AddID'] ?><?php echo $data; ?>&url=<?php echo $_GET['url'];?>&curP=<?= $_GET['curP'] ?>" >Overwrite </a>
        <?php } elseif(empty($_GET['contactid']) && (!empty($values['InstagramID'])) && ($_GET['type']=="instagram")) {?>
	<a href="?contactid=<?= $values['AddID'] ?><?php echo $data; ?>&url=<?php echo $_GET['url'];?>&curP=<?= $_GET['curP'] ?>" >Overwrite </a>
	<?php } elseif(empty($_GET['contactid'])) { ?>
	<a href="?contactid=<?= $values['AddID'] ?><?php echo $data; ?>&url=<?php echo $_GET['url'];?>&curP=<?= $_GET['curP'] ?>" >Add</a>
	<?php } else { ?>
	
	<?php }?>
                            </td>
							
                                </tr>
                            <?php } // foreach end //?>

<?php } else { ?>
                            <tr align="center" >
                                <td  colspan="8" class="no_record"><?= NO_RECORD ?></td>
                            </tr>
<?php } ?>

                        <tr >  <td  colspan="8" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryContact) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}
?></td>
                        </tr>
                    </table>

                </div> 
                <? if (sizeof($arryContact)) { ?>
                    <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
                        <tr align="center" > 
                            <td height="30" align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'delete', '<?= $Line ?>', 'AddID', 'editContact.php?curP=<?= $_GET[curP] ?>&opt=<?= $_GET[opt] ?>');">
                                <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'active', '<?= $Line ?>', 'AddID', 'editContact.php?curP=<?= $_GET[curP] ?>&opt=<?= $_GET[opt] ?>');" />
                                <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'inactive', '<?= $Line ?>', 'AddID', 'editContact.php?curP=<?= $_GET[curP] ?>&opt=<?= $_GET[opt] ?>');" /></td>
                        </tr>
                    </table>
<? } ?>  

                <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
                <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
            </form>
        </td>
    </tr>
</table>
