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
      
  <input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
   <a href="editCustomSearch.php" class="add" >Add Custom Search</a>        
        </td>
        
    </tr>
	  
	  <tr>
            <td  valign="top">

                <div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
                <div id="preview_div">

                    <table <?= $table_bg ?>>

                            <tr align="left"  >
                                <td width="42%" align="center" class="head1">Search Name  </td>
                                <td width="42%" align="center" class="head1" > Module</td>                             
                                <td width="15%"  align="center" class="head1 head1_action" >Action</td>
                              
                            </tr>
                             <?php 
                                if(count($searchLists) > 0){
				foreach ($searchLists as $key => $values) { ?>
                            <tr align="left">
                               
                                  <td width="42%" align="center" ><?php echo $values['search_name']; ?> </td>
                                  <td width="42%" align="center" ><?php $res = $objadmin->getParentModuleID($values['moduleID'],''); echo (!empty($res)) ? $res[0]['Module'] : 'Not Specified';?> </td>
                                  <td align="center">
				 
 <a href="vcsearch.php?view=<?php echo $values['search_ID'];?>&amp;curP=<?php echo $_GET['curP']; ?>"><?= $view ?></a>
<? if($_SESSION['AdminType'] == 'admin' || $_SESSION['AdminID'] == $values['recordInsertedBy']){?>

				  <a href="editCustomSearch.php?edit=<?php echo $values['search_ID'];?>&amp;curP=<?php echo $_GET['curP']; ?>"><?= $edit ?></a>

				  <a href="viewCustomSearch.php?Del_ID=<?php echo $values['search_ID'];?>&amp;curP=<?php echo $_GET['curP']; ?>" onclick="return confirmDialog(this,'<?= $MainModuleName ?>'); "><?= $delete ?></a> 
<? }?>
				  </td>
                            </tr>
                            
                                <?php }}else{ ?>
                                        <tr align="center" >
                                           <td  colspan="11" class="no_record">No record found. </td>
                                       </tr>
                                <?php }?>
                            <tr >  <td  colspan="11" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if ($num > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}
?></td>
                        </tr>
                             
                            
                            
	  </table>
	  </div>
	  </td>
	  </tr>
	  
</TABLE>	  
	  
