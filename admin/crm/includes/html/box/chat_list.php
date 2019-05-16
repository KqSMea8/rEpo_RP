<div class="had"><?=$MainModuleName?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
    <tr>
        <td  valign="top">
           
                <div id="prv_msg_div" style="display:none"><img src="<?= $MainPrefix ?>images/loading.gif">&nbsp;Searching..............</div>
                <div id="preview_div">
                 <form action="" method="get" name="form1">
                <ul class="date-filter">
                <li class="date-li"><label>From</label><input id="from" name="from" readonly="" class="datebox"
					value="<?php echo !empty($_GET['from'])?$_GET['from']:'';?>" type="text">
					<img class="ui-datepicker-trigger" src="../images/cal.png" alt="..." title="..." >
				</li>
                <li class="date-li"><label>To</label><input id="to" name="to" readonly="" class="datebox"
				value="<?php echo !empty($_GET['to'])?$_GET['to']:'';?>" type="text">
				<img class="ui-datepicker-trigger" src="../images/cal.png" alt="..." title="..." >
				</li>
				
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
                           	<th width="10%"  class="head1" >Sr. No.</th>                         
                                <th width="15%"  class="head1" >Customer Name</th>
                                <th width="15%"  class="head1" >Customer Email</th>
                                <th width="20%"  class="head1" >Location</th>  
                                <th width="20%"  class="head1" >Date</th> 
                               	<th width="10%"  class="head1" >Action</th>                                      
                            </tr>
                        <?php
                        if(!empty($responce->talkslist)){$i=0;
                        	foreach($responce->talkslist as $res){
//http://www.geoplugin.net/php.gp?ip=180.151.87.122

                        	
                        	?>
                         	<tr align="left">   
                           	 	<td width="10%"  class="head1" ><?php echo $i+1;?></td>                         
                                <td width="15%"  class="head1" ><?php echo !empty($res->visitorname)?$res->visitorname:'--';?></td>
                                <td width="15%"  class="head1" ><?php echo !empty($res->visitoremail)?$res->visitoremail:'--';?></td>
                                <td width="20%"  class="head1" ><?php echo !empty($res->ip)?$res->ip:'--';?>
                                <?php if(!empty($res->ip)){
                                //echo "http://www.geoplugin.net/php.gp?ip=".$res->ip;
                            // $location=  json_decode(get_file_contents("http://www.geoplugin.net/php.gp?ip=".$res->ip));
                             if(!empty($location)){
                             
                            // print_R($location);
                             }else{}
                                }else{ };?>
                                </td>  
                                <td width="20%"  class="head1" ><?php echo !empty($res->time)?$res->time:'--';?></td>      
                                <td width="10%"  class="head1" ><a href="chat-history.php?refid=<?php echo $res->refid;?>" class="fancybox fancybox.iframe">Chat History</a></td>                                  
                            </tr>
                        <?php $i++;}}else{ ?>
                            <tr align="center" >
                                <td  colspan="6" class="no_record"><?= NO_RECORD ?></td>
                            </tr>
                            <?php }?> 
						 </table>

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
					},buttonImage:'http://199.227.27.207/erp/admin/images/cal.png'
					});
					$( "#to" ).datepicker({					
					onClose: function( selectedDate ) {
					$( "#from" ).datepicker( "option", "maxDate", selectedDate );
					}
					});
					});

					
				</script>
