<style>
.export-location{
float:right;
}
a.export_button.call-export{
color:#fff;
}
</style>

<script language="JavaScript1.2" type="text/javascript">
    function ValidateSearch() {
        document.getElementById("prv_msg_div").style.display = 'block';
        document.getElementById("preview_div").style.display = 'none';
    }
    function exportCall(){
		if(jQuery('#params').val()!=''){
			window.location="export_calllog.php?1=1&"+jQuery('#params').val();
		}else{
			window.location="export_calllog.php";
			}
      }
    function filterLead(id)
    {
        location.href = "viewContact.php?module=contact&customview=" + id;
        LoaderSearch();
    }

    function filterdata(obj){
        	if(jQuery('.calltype').val()=='all'){
        		jQuery('#ajax-loader').show();
				jQuery('#list_table tr').show();
				jQuery('#ajax-loader').hide();
            	}else if(jQuery('.calltype').val()=='outbond'){    
            		jQuery('#ajax-loader').show();            	
            		//jQuery('#list_table tr.inbond').hide();
            		//jQuery('#list_table tr.outbond').show();
            		//jQuery('#list_table tr').attr('inbond').hide();
            			
            				$('#list_table tr').each(function(){
							if(jQuery(this).attr('data-call')=='outbond'){
								jQuery(this).show();
								}else if(jQuery(this).attr('data-call')=='inbond'){
									jQuery(this).hide();
									}
                		});
            		
            		jQuery('#ajax-loader').hide();
            		
                	}else if(jQuery('.calltype').val()=='inbond'){
                		jQuery('#ajax-loader').show(); 
                		$('#list_table tr').each(function(){
							if(jQuery(this).attr('data-call')=='inbond'){
								jQuery(this).show();
								}else if(jQuery(this).attr('data-call')=='outbond'){
									jQuery(this).hide();
									}
                		});
                		jQuery('#ajax-loader').hide();
                    	}
        }

    function calIcon(obj){
jQuery(obj).parents('li').find('.datebox').focus();

        }
</script>
<div class="had">Call List</div>
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
           
                <div id="prv_msg_div" style="display:none"><img src="<?= $MainPrefix ?>images/loading.gif">&nbsp;Searching..............</div>
                <div id="preview_div">
                 <form action="" method="get" name="form1">
                <ul class="date-filter">
                <li class="date-li"><label>From</label><input id="from" name="from" readonly="" class="datebox"
			value="<?php echo !empty($_GET['from'])?$_GET['from']:'';?>" type="text">
			<img class="ui-datepicker-trigger" src="../images/cal.png" alt="..." title="..." onclick="calIcon(this)">
			</li>
                <li class="date-li"><label>To</label><input id="to" name="to" readonly="" class="datebox"
				value="<?php echo !empty($_GET['to'])?$_GET['to']:'';?>" type="text">
				<img class="ui-datepicker-trigger" src="../images/cal.png" alt="..." title="..." onclick="calIcon(this)">
				</li>
				 <li><label>Users</label><select class="textbox" name="empId"><option value="">Select CRM User</option>
				 <?php if(!empty($arryEmployee)){
				 foreach($arryEmployee as $Employee){	
				 $select='';
				 $emply = base64_decode($_GET['empId']);
				 if(!empty($_GET['empId']) AND $Employee['EmpID']== $emply ){
					 $select='selected="selected"';				 
				 }		 
					 echo '<option value="'.base64_encode($Employee['EmpID']).'" '.$select.'>'.$Employee['UserName'].'</option>';
				 } }?>
				 </select></li>
				 <li><input type="submit"  value="Go" class="button"> </li>
                </ul>
                <?php  if (!empty($allcalldetailBond->cdrs)) {?>
               	 <ul class="export-location"><li><a href="javascript:void(0);" class="export_button call-export" onclick="exportCall()">Export To Excel</a></li></ul>
             		<input type="hidden" id="params" value="<?php echo !empty($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'';?>">
                <?php } ?>
                </form>
                             
                <div align="center" id="ajax-loader" style="display: none;"><img src="../images/loading.gif">&nbsp;Loading.......</div>

                    <table <?= $table_bg ?>>
                            <tr align="left">   
                           	 	 <td width="10%"  class="head1" >Sr. No.</td>                         
                                <td width="15%"  class="head1" >Date</td>
                                <td width="15%"  class="head1" >Time</td>
                                <td width="20%"  class="head1" >Call Duration</td>  
                                <td width="20%"  class="head1" >Call Type</td>  
                                <td width="20%" class="head1"> From </td>
                                  <td width="20%"  class="head1" >Source</td>   
                                <td width="10%"  align="center"  class="head1 head1_action" >Status</td>
                            </tr>
                        <?php
                        
                    
                        if (count($results)>0) {
							
                            $flag = true;
                            $Line = 0;
                            $i=0;
                            foreach ($results as $key => $values) {
                                $flag = !$flag;
                                $bgcolor = ($flag) ? ("#FAFAFA") : ("#FFFFFF");
                                $Line++;

                                //if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
                               
                                if(in_array($values[1],$extension_array) OR in_array($values[2],$extension_array)){
								if(in_array($values[1],$extension_array) && in_array($values[2],$extension_array)){
									$from =$values[1];
									$bond='Self';
									$source=$values[1].'-->'.$values[2];
								}	
									
                                elseif(in_array($values[1],$extension_array)){
                                $from=$values[1];
                                $bond='Outgoing';
                                $source=$values[2];
                                }
                                elseif(in_array($values[2],$extension_array)){
                                $bond='Incoming';
                                $source=$values[1];
                                 $from=$values[2];
                                }else {
                                 $bond='--';
                                 $source='--';
                                }
                                ?>
                                
                                
                                <tr align="left"  bgcolor="<?= $bgcolor ?>" class="<?php if($bond=='Outgoing'){  echo 'outbond';}elseif($bond=='Incoming'){ echo 'inbond'; }?>"  data-call="<?php if($bond=='Outgoing'){  echo 'outbond';}elseif($bond=='Incoming'){ echo 'inbond'; }?>">                                    
                                <td><?php echo $i+1 ;?> </td>
                                <td  ><?php echo date('m-d-Y',strtotime($values[0]));?></td>
                                <td  ><?php echo date('H:i:s',strtotime($values[0]));?></td>                                
                                <td  ><?php 
                                                                                      
                               	$min = gmdate("i",  $values[7]); 
                                $sec = gmdate("s",  $values[7]);   
                                $du='';
                                if(!empty($min) AND $min!='00')
                                  $du .=$min.' min ';
                                  $du .= $sec .' sec';                                 
                            	  echo   $du;                            	  
                                ?></td>                                
                                <td><?php echo $bond;?>   </td>
                                <td><?php echo $empDetailByid[$empByAgent[$from]];?>   </td>
                                <td><?php echo $source;?></td> 
                                <td><?php echo $values[5];?></td>

                                </tr>
                            <?php $i++;} } // foreach end //?>
<?php 
                        if(empty($i)){?>
                          <tr align="center" >
                                <td  colspan="8" class="no_record"><?= NO_RECORD ?></td>
                            </tr>
                     <?php    }
                        } else { ?>
                            <tr align="center" >
                                <td  colspan="8" class="no_record"><?= NO_RECORD ?></td>
                            </tr>
<?php } ?> </table>

                </div> 
            
        </td>
    </tr>
</table>
				<script>
					$(function() {
					$( "#from" ).datepicker({	
						beforeShow:function(e,l)	{
						$( "#to" ).val('');
						$( "#from" ).datepicker( "option", "maxDate", null );
						}	,			
					onClose: function( selectedDate ) {
					$( "#to" ).datepicker( "option", "minDate", selectedDate );
					}
					});
					$( "#to" ).datepicker({					
					onClose: function( selectedDate ) {
					$( "#from" ).datepicker( "option", "maxDate", selectedDate );
					}
					});
					});
				</script>
