<script language="JavaScript1.2" type="text/javascript">

		    function ValidateSearch(SearchBy) {
		        document.getElementById("prv_msg_div").style.display = 'block';
		        document.getElementById("preview_div").style.display = 'none';
		
		    }
		    function filterwarehouse(id)
		    {
		        LoaderSearch();
		        if(id>0){
		        location.href = "viewRmaAction.php?warehouse=" + id + "&asc=Desc";
		        }else{
		            
		           location.href = "viewRmaAction.php"; 
		        }
		    }
//viewManageBin.php?sortby=w.warehouse_name&key=W004&asc=Desc&module=&search=Search
//http://localhost/erp/admin/warehouse/viewManageBin.php?sortby=w.warehouse_name&key=+%09TESTER&asc=Desc&module=&search=Search
</script>
			<div class="had"><?= $MainModuleName ?></div>
			<div class="message" align="center"><? if (!empty($_SESSION['mess_warehouse'])) {
			    echo $_SESSION['mess_warehouse'];
			    unset($_SESSION['mess_warehouse']);
			} ?></div>
			<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
			
			<?php /*?>
			 WareHouse Name : <select name="rma" id="rma" class="textbox" onchange="return filterwarehouse(this.value);">
			        <option value="">--Select--</option>
			<?php foreach ($warehouse_listted as $warehouse_data): ?>
			            <option value="<?php echo $warehouse_data['id']; ?>" <?=($warehouse_data['WID'] == $_GET['warehouse'])?("selected"):("")?>><?php echo $warehouse_data['warehouse_name']; ?></option>
			<?php endforeach; ?>
			    </select> <?php */?>                				
			
			    <?php /*?><tr> 
			    <td  valign="top" align="right">
			     <a href="editRMAAction.php" class="add" >Add RMAAction</a>
			    </td>
			</tr><?php */?>
			
			<tr>
			    <td  valign="top">
			
			        <form action="" method="post" name="form1">
			            <div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
			            <div id="preview_div">
			
			                <table <?= $table_bg ?>>
			
			                    <tr align="left"  >
			                        
			                        <td width="10%"   class="head1 head1_action" >RMA Action</td>
			                        <?php /*?><td width="5%"  class="head1" >WID</td><?php */?>
			                       <td width="10%"   class="head1 " >Warehouse Name</td>
			                        <td width="10%" align="center"   class="head1 " >Action</td>
			                    </tr>
			
			                    <?php
			
			             if (is_array($data_Collection) && $num > 0) {
			                            $flag = true;
			                            $Line = 0;
			                            foreach ($data_Collection as $key => $values) {
			                                $flag = !$flag;
			                                $bgcolor = ($flag) ? ("#FAFAFA") : ("#FFFFFF");
			                                $Line++;
			
			                                //if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
			                                ?>
			                                <tr align="left"  bgcolor="<?= $bgcolor ?>">
			                                 <td><?= stripslashes($values["action"]) ?></td>
			                               <?php /*?> <td><?= stripslashes($values["w_id"]) ?></td><?php */?>
			                                 <td><?= stripslashes($values["warehouse_name"]) ?></td>
			
			                                <td  align="center" class="head1_inner"  >
			
			                                        <a href="editRmaAction.php?edit=<?php echo $values['id']; ?>&amp;curP=<?php echo $_GET['curP']; ?>&amp;tab=Warehouse" ><?= $edit ?></a>
			                                           
			                                </td>
			                            </tr>
			                        <?php } // foreach end //?>
			
			    <?php
			} else {
			    ?>
			                        <tr align="center" >
			                            <td  colspan="8" class="no_record">No record found. </td>
			                        </tr>
			  <?php }
			?>
			
			                    <tr >  
			                        <td  colspan="8" >Total Record(s) : &nbsp;<?php echo $num; ?>      </td>
			                    </tr>
			                </table>
			
			            </div> 
			
			            <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
			            <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
			        </form>
			    </td>
			</tr>
			</table>
