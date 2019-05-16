
<? 


if($_GET['opt'] == 'preview') {?>
    <div class="had">Web to RMA Form for [<?=$_SESSION['DisplayName']?>]</div>
    <div style="padding: 10px;">
       <?php echo stripslashes($arryLeadForm[0]['HtmlForm']) ?>
        
    </div>
<? }else{ ?>
    <div class="had">Web to RMA HTML Code for [<?=$_SESSION['DisplayName']?>]</div>
 
       <div>
   <br><strong>Copy and paste the below HTML code into the back-end of your website. If you are not sure where to put this code contact your web designer or software administrator.  </strong><br><br>
       </div>
       

    <div >
        <textarea name="Description" type="text" class="textarea" id="Description" style="width:900px;height:800px;" readonly  ><?php echo htmlentities(stripslashes($arryLeadForm[0]['HtmlForm'])) ?></textarea> 
    
    </div>
<? } ?>

	







