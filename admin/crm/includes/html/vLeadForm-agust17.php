
<? 


if($_GET['opt'] == 'preview') {?>
    <div class="had">Web to Lead Form for [<?=$_SESSION['DisplayName']?>]</div>
    <div style="padding: 10px;">
       <?php echo stripslashes($arryLeadForm[0]['HtmlForm']) ?>
        
    </div>
<? }else{ ?>
    <div class="had">Web to Lead HTML Code for [<?=$_SESSION['DisplayName']?>]</div>
 
       <div>
   <br><strong><?=LEAD_FORM_SCRIPT_MSG?> </strong><br><br>
       </div>
       

    <div >
        <textarea name="Description" type="text" class="textarea" id="Description" style="width:900px;height:800px;" readonly  ><?php echo htmlentities(stripslashes($arryLeadForm[0]['HtmlForm'])) ?></textarea> 
    
    </div>
<? } ?>

	







