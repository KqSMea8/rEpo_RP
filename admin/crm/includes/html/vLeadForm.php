
<? 


if($_GET['opt'] == 'preview') {?>
    <div class="had">Web to Lead Form for [<?=$_SESSION['DisplayName']?>]</div>
    <div style="padding: 10px;">
       <?php echo stripslashes($arryLeadForm[0]['HtmlForm']) ?>
        
    </div>
<?php } elseif($_GET['opt'] == 'iframe'){ ?>
     <div class="had">Web to Lead Iframe Code for [<?=$_SESSION['DisplayName']?>]</div>
       <div>
            <br><strong><?=LEAD_FORM_SCRIPT_MSG?> </strong><br><br>
       </div>
    <div>
        <textarea name="Description" type="text" class="textarea" id="Description" style="width:900px;height:800px;" readonly  ><iframe width="100%" height="100%" frameborder="0" allowfullscreen="" mozallowfullscreen="" webkitallowfullscreen="" hspace="0" vspace="0" class="fancybox-iframe" scrolling="auto" src="<?php echo $Config['Url'].'/vLeadFormIframe.php?formid='.$_GET['formid'].'&cmp='.md5($_SESSION['CmpID']); ?>"  ></iframe></textarea> 
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

  







