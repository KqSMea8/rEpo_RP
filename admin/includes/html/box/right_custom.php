<? $arryfilter = $objFilter->getCustomView('', $_GET['module']); ?> 


<fieldset>
    <label>Filter: </label>
    <div class="sel-wrap">
        <select name="customview" class="inputbox" id="customview" onchange="return  filterLead(this.value);"  >

            <option value="All" selected > All </option>

            <? for ($i = 0; $i < sizeof($arryfilter); $i++) { ?>
                <option value="<?= $arryfilter[$i]['cvid'] ?>"  <? if ($arryfilter[$i]['cvid'] == $_GET['customview']) {
                echo "selected";
            } ?>> <?= $arryfilter[$i]['viewname'] ?> </option>

<? } ?>
        </select>   
    </div> 

    <div> <a  href="customFilter.php?type=<?= $_GET['module'] ?>" >

            <img border="0" onmouseout="hideddrivetip()" ;="" onmouseover="ddrivetip('<center>New </center>', 40, '')" src="../images/add.gif">

        </a>
        <?
        if (!empty($_GET['customview'])) {

            $arryfilterDetail = $objFilter->getCustomView($_GET['customview'], '');
		$filteruserid = !empty($arryfilterDetail[0]['userid'])?($arryfilterDetail[0]['userid']):('');

            if (($_SESSION['AdminType'] == 'admin' || $filteruserid == $_SESSION['UserID'] || $ModifyLabel==1) && $_GET['customview'] != "All") {
                ?>

        <!--a href="viewTicket.php?customview=<?= $_GET['customview'] ?>&module=<?= $_GET['module'] ?>&Approve=1" >Approve</a-->&nbsp;&nbsp;

                        <a disabled href="customFilter.php?type=<?= $_GET['module'] ?>&edit=<?= $_GET['customview'] ?>" ><?= $edit ?></a>&nbsp;&nbsp;
               
<?  
$ThisPageNameArray = explode("?",$ThisPageName);
if(!empty($ThisPageNameArray[1])){
	$CustomLink = $ThisPageName.'&';
}else{
	$CustomLink = $ThisPageName.'?';
}
?>

 <a href="<?=$CustomLink?>del_id=<?= $_GET['customview'] ?>&Approve=1" onclick="return confirmDialog(this, 'Filter')" ><?= $delete ?></a>

<?
/*
if($Config['CurrentDepID'] == '8' || $Config['CurrentDepID'] == '3' || $Config['CurrentDepID'] == '2'){

        if($_GET['module']!=''){?>
        <a href="<?=$ThisPageName?>&del_id=<?= $_GET['customview'] ?>&Approve=1" onclick="return confirmDialog(this, 'Filter')" ><?= $delete ?></a> <? }else{ ?>
        
        <a href="<?=$ThisPageName?>?del_id=<?= $_GET['customview'] ?>&Approve=1" onclick="return confirmDialog(this, 'Filter')" ><?= $delete ?></a> <? }?>
        
        
       <? }else{ 
		 if($_GET['module']!=''){?>
       <a href="<?=$ThisPageName?>&del_id=<?= $_GET['customview'] ?>&Approve=1" onclick="return confirmDialog(this, 'Filter')" ><?= $delete ?></a><? }else{ ?>
       
        <a href="<?=$ThisPageName?>?del_id=<?= $_GET['customview'] ?>&Approve=1" onclick="return confirmDialog(this, 'Filter')" ><?= $delete ?></a>
       <? 

		} 
       }

*/





            }

        }
        ?>







    </div>

</fieldset>
<br /><br />
