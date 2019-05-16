<script>
    function reply_comment(id) {
        if (document.getElementById('reply_' + id).style.display = 'none') {
            document.getElementById('reply_' + id).style.display = 'block';
        } else {
            document.getElementById('reply_' + id).style.display = 'block';
        }
    }
</script>


<? if ($_GET['pop'] != 1) { ?>

    <div class="had">
      Ticket Details 
 
    </div>
<? } ?>


<? if ($_GET['tab'] == "Information") { ?>

    <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
  
        <tr>
            <td  align="right"  class="blackbold"> Title  :</td>
            <td   align="left" >
                <?php echo stripslashes($arryTicket[0]['title']); ?>            </td>

            <td  align="right"   class="blackbold"> Assigned To  : </td>
            <td   align="left" > <? if ($arryTicket[0]['AssignType'] == 'Group') { ?>
                        <?= $AssignName ?> <br>
                    <? } ?>
                <div> <? 
			if(!empty($arryAssignee)){
				foreach ($arryAssignee as $values) {
                    ?>
                        <a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?= $values['EmpID'] ?>" ><?= $values['UserName'] ?></a>,
    <? } }?>
            </td>
        </tr>

        <tr>
            <td  align="right"   class="blackbold" width="20%">Ticket Status  : </td>
            <td   align="left" width="30%">
    <?= (!empty($arryTicket[0]['Status'])) ? (stripslashes($arryTicket[0]['Status'])) : (NOT_SPECIFIED) ?>

            </td>

            <td  align="right"   class="blackbold" width="20%"> Priority : </td>
            <td   align="left" >
    <?= (!empty($arryTicket[0]['priority'])) ? ($arryTicket[0]['priority']) : (NOT_SPECIFIED) ?>

            </td>
        </tr>

        <tr>
            <td  align="right"   class="blackbold">Ticket Category : </td>
            <td   align="left" >

    <?php echo stripslashes($arryTicket[0]['category']); ?>
            </td>

            <td  align="right"   class="blackbold"> Days : </td>
            <td   align="left" >
    <?php echo stripslashes($arryTicket[0]['day']); ?> </td>
        </tr>
        <tr>
            <td  align="right"   class="blackbold"> Hours : </td>
            <td   align="left" >
    <?php echo stripslashes($arryTicket[0]['hours']); ?>  </td>

            <td  align="right"   class="blackbold">  Customer : </td>
            <td   align="left" >
    <? if (!empty($arryCustomer[0]['FullName'])) { ?><a class="fancybox fancybox.iframe" href="../custInfo.php?view=<?= $arryCustomer[0]['CustCode'] ?>"><?= (stripslashes($arryCustomer[0]['FullName'])) ?> </a> <? } else {
        echo NOT_SPECIFIED; ?> <? } ?>	    

            </td>
        </tr>


    </table>	
<? } ?>

	




