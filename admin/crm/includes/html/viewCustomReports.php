<div class="had"><?=$MainModuleName?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
 <tr>
    <td  align="center"  class="message"  >
        <?php if (!empty($_SESSION['message'])) {
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        } ?>	
    </td>
</tr>

<tr>
  <td  align="right">
      
<!--<ul class="export_menu">
<li><a class="hide" href="javascript:;">Export Report</a>
<ul>
<li class="excel"><a href="javascript:;" ><?=EXPORT_EXCEL?></a></li>
<li class="pdf" ><a href="javascript:;" ><?=EXPORT_PDF?></a></li>
<li class="csv" ><a href="javascript:;" ><?=EXPORT_CSV?></a></li>	
<li class="doc" ><a href="javascript:;" ><?=EXPORT_DOC?></a></li>				
</ul>
</li>
</ul> -->
  <input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
   <a href="editCustomReports.php" class="add" >Add Custom Reports</a>        
        </td>
        
    </tr>
	  
	  <tr>
            <td  valign="top">

                <div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
                <div id="preview_div">

                    <table <?= $table_bg ?>>

                            <tr align="left"  >
                                <td width="42%" align="center" class="head1">Report Name  </td>
                                <td width="42%" align="center" class="head1" > Description</td>                             
                                <td width="15%"  align="center" class="head1 head1_action" >Action</td>
                              
                            </tr>
                             <?php 
                                if(count($showsavedata) > 0){
				foreach ($showsavedata as $key => $values) { ?>
                            <tr align="left">
                               
                                  <td width="42%" ><?php echo stripcslashes($values['report_name']); ?> </td>
                                  <td width="42%" ><?php echo stripcslashes($values['report_desc']); ?> </td>
                                  <td align="center">
				  <a href="vcreport.php?view=<?php echo $values['report_ID'];?>&amp;curP=<?php echo $_GET['curP']; ?>"><?= $view ?></a>
				  <a href="editCustomReports.php?edit=<?php echo $values['report_ID'];?>&amp;curP=<?php echo $_GET['curP']; ?>"><?= $edit ?></a>
				  <a href="viewCustomReports.php?Del_ID=<?php echo $values['report_ID'];?>&amp;curP=<?php echo $_GET['curP']; ?>" onclick="return confirmDialog(this,'<?= $MainModuleName ?>'); "><?= $delete ?></a> 
				  </td>
                            </tr>
                            
                                <?php }}else{ ?>
                                        <tr align="center" >
                                           <td  colspan="11" class="no_record">No record found. </td>
                                       </tr>
                                <?php }?>
                            <tr >  <td  colspan="11" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($showsavedata) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}
?></td>
                        </tr>
                             
                            
                            
	  </table>
	  </div>
	  </td>
	  </tr>
	  
</TABLE>	  
	  
