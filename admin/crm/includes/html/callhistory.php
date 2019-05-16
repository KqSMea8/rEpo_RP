
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
									}else if(jQuery(this).attr('data-call')=='self'){
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
									else if(jQuery(this).attr('data-call')=='self'){
									jQuery(this).hide();
									}
                		});
                		jQuery('#ajax-loader').hide();
						
                    	}else if(jQuery('.calltype').val()=='self'){
                		jQuery('#ajax-loader').show(); 
                		$('#list_table tr').each(function(){
							if(jQuery(this).attr('data-call')=='self'){
								jQuery(this).show();
								}else if(jQuery(this).attr('data-call')=='outbond'){
									jQuery(this).hide();
									}else if(jQuery(this).attr('data-call')=='inbond'){
									jQuery(this).hide();
									}
                		});
                		jQuery('#ajax-loader').hide();
                    	}
        }
</script>
<div class="had">Call Detail</div>
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
                <select class="calltype">
                <option value="all">All</option>
                <option value="inbond">Incoming</option>
                <option value="outbond">Outgoing</option>
				 <option value="self">Self</option>
                </select> <input type="button" class="button" value="Filter" onclick="filterdata(this);">                
                <div align="center" id="ajax-loader" style="display: none;"><img src="../images/loading.gif">&nbsp;Loading.......</div>

                    <table <?= $table_bg ?>>

                            <tr align="left">                            
                                <td width="15%"  class="head1" >Date</td>
                                <td width="15%"  class="head1" >Time</td>
                                <td width="20%"  class="head1" >Call Duration</td>  
                                <td width="20%"  class="head1" >Call Type</td>  
                                  <td width="20%"  class="head1" >Source</td>   
                                <td width="10%"  align="center"  class="head1 head1_action" >Status</td>
                            </tr>
                        <?php
                        
                   
                        if (count($results)>0) {
                            $flag = true;
                            $Line = 0;
                            $i=0;
							
							// echo "<pre>";print_r($results);
							 //echo "<pre>";print_r($results);die;
                            foreach ($results as $key => $values) {
								
								
                                $flag = !$flag;
                                $bgcolor = ($flag) ? ("#FAFAFA") : ("#FFFFFF");
                                $Line++;

								
                                //if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
                                //if($values[1]==$extesion OR $values[2]==$extesion){
									
							//echo $values[1]."<br>".$values[2]."<pre>";print_r($extension_array); 		
                                if(in_array($values[1],$extension_array) OR in_array($values[2],$extension_array)){
									
								if(in_array($values[1],$extension_array) && in_array($values[2],$extension_array)){
									
									$bond='Self';
									$source=$values[1].'-->'.$values[2];
								}	
                                elseif(in_array($values[1],$extension_array)){
                                $bond='Outgoing';
                                $source=$values[2];
                                }
                                elseif(in_array($values[2],$extension_array)){
                                $bond='Incoming';
                                $source=$values[1];
                                }else {
                                 $bond='--';
                                 $source='--';
                                }
                                ?>
                                <tr align="left"  bgcolor="<?= $bgcolor ?>" class="<?php if($bond=='Outgoing'){  echo 'outbond';}elseif($bond=='Incoming'){ echo 'inbond'; }elseif($bond=='Self'){echo 'self';}?>"  data-call="<?php if($bond=='Outgoing'){  echo 'outbond';}elseif($bond=='Incoming'){ echo 'inbond'; }elseif($bond=='Self'){ echo 'self'; }?>">                                    
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
                                <td  ><?php echo $bond;?>   </td>
                                <td  ><?php echo $source;?></td> 
                                <td ><?php echo $values[5];?></td>

                                </tr>
                            <?php $i++; } } // foreach end //?>
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
            </form>
        </td>
    </tr>
</table>
