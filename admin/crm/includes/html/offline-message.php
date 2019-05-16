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
                </form>
                             
                 <div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
                <div id="preview_div">

                    <table <?= $table_bg ?>>
                            <tr align="left">   
                           	 	<th width="10%"  class="head1" >Sr. No.</th>                         
                                <th width="15%"  class="head1" >Customer Name</th>
                                <th width="15%"  class="head1" >Customer Email</th>     
                                 <th width="20%"  class="head1" >Status</th>                           
                                <th width="20%"  class="head1" >Date</th> 
                               	<th width="10%"  class="head1" >Action</th>                                      
                            </tr>
                        <?php                        
                        if(!empty($responce->offlinemessage)){$i=0;
                        	foreach($responce->offlinemessage as $res){
//http://www.geoplugin.net/php.gp?ip=180.151.87.122
				 $flag = !$flag;
                                $bgcolor = ($flag) ? ("#FAFAFA") : ("#FFFFFF");
                                $Line++;
                                $LeadNo++;
                        	?>
                         	<tr align="left" bgcolor="<?= $bgcolor ?>">   
                           	 	<td width="10%"><?php echo $i+1;?></td>                         
                                <td width="15%"   ><a href="javascript:void(0)" class="message-click"><?php echo !empty($res->name)?$res->name:'--';?></a><div class="message-off" style="display:none;"><?php echo !empty($res->msg)?$res->msg:'No Message';?></div>
                                </td>
                                <td width="15%" ><?php echo !empty($res->email)?$res->email:'--';?></td>
                                <td width="15%" ><?php echo !empty($res->status)?$res->status:'--';?></td>
                                <td width="20%" ><?php echo !empty($res->time)?$res->time:'--';?></td>      
                                <td width="10%" >
                                	<input type="hidden" class="messageid" value="<?php echo $res->_id;?>" />
                                <?php
								if($res->status=='open'){
	                                if(in_array('Sales',$chatrole) && $res->ptype=='Sales'){
	                                
	                                ?>
	                                <a href="javascript:void(0);" class="convert-lead convert">Convert to lead</a>
	                              <?php   }
	                                if(in_array('Support',$chatrole) && $res->ptype=='Support'){                              
	                                	?>
	                                   <a href="javascript:void(0);" class="convert-ticket convert">Convert to ticket</a>
	                                   <?php }
                                }else{
                                echo '<span style="color:red;">Closed</span>';
                                }?><br>
                                <a href="javascript:void(0)" class="message-click">Preview</a>
                              </td>                                  
                            </tr>
                        <?php $i++;}}else{ ?>
                            <tr align="center" >
                                <td  colspan="6" class="no_record"><?= NO_RECORD ?></td>
                            </tr>
                            <?php }?> 
   <tr >  <td  colspan="11" >Total Record(s) : &nbsp;<?php echo count($responce->offlinemessage); ?>  </td>
                        </tr>
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
						$('.convert').click(function(){
							var id=$(this).siblings('.messageid').val();
							var  html='';
							var mode='';
							if($(this).hasClass('convert-lead'))
								mode='Lead';
							else if($(this).hasClass('convert-ticket')){
								mode='Ticket';
								}
							html +='<form action="" method="POST"><div class="convert-box"><br/><label>Title</label><input type="text" name="title" class="input" /><br/><input type="submit" class="button" value="Convert To '+mode+'" ><input type="hidden" name="refid" value="'+id+'" /><input type="hidden" name="mode" class="mode" value="'+mode+'" /></div></form>';
							$( ".dialog-message").html(html);
							$( ".dialog-message" ).dialog({ title: "Convert To "+mode, closeText: "Close",draggable: false, dialogClass: "offline-message"});
						});
						$('.message-click').click(function(){
							
							var  html='';
							var mode='';
						
						
							html +=jQuery(this).parents('tr').find('.message-off').html();
							console.log(html);
							
							$( ".dialog-message").html(html);
							$( ".dialog-message" ).dialog({ title: "Offline Message", closeText: "Close",draggable: false, dialogClass: "offline-message"});
						});
					});
</script>
<div class="dialog-box">
	<div class="dialog-message"></div>
</div>
<style>
.offline-message .ui-widget-header{
width:auto;
}
.offline-message .ui-dialog-titlebar-close {
    visibility: initial;
}
.input {
    margin-bottom: 16px;
    padding: 5px 0;
}

.convert-box {
    text-align: center;
}

.convert-box > label {
    margin-right: 13px;
}
</style>
