<style>
.image {
	clear:both;
	float:left;
	max-height: 160px;	
	text-align:center;
	overflow: hidden;
}

.image img {
	float: left;
	width: 80px;
	height: 80px;
	border-radius: 50%;
	   display: none;
}

.body {
	text-align:center;
	width: 40%;
	display: block;
	margin:0px auto 650px;
	background-color: #ffffff;
	color: #637277;
}

.chats {
	list-style-type: none;
	margin-top:10px;
}

.me {
	clear:both;
	float:right;
	margin-bottom:10px;
}

.you {
	clear:both;
	float:left;
	margin-bottom:10px;
}

.you .image{
	float:left;
}
.me .image{
	float:right;
	 margin-left: 3px;
}

.chats .me p {
	text-align:left;
	float: left;
	display: inline-block;
	margin-left: 20px;
	margin-bottom:30px;
	padding: 2px 4px;
	min-width: 160px;
	min-height: 10px;
	max-width: 341px;
	background-color: #FFC;
	border-radius: 3px;
	box-shadow: 0px 3px 3px #E3E4E6;
	color: #637277;
	line-height: 1.4;
	word-wrap: break-word;
}

.chats .you p {
	text-align:left;
	float: left;
	display: inline-block;
	margin-right:20px;
	margin-bottom:30px;
	padding: 2px 4px;
	min-width: 160px;
	min-height: 10px;
	max-width: 341px;
	background: none repeat scroll 0 0 #595959;
	border-radius: 3px;
	box-shadow: 0px 3px 3px #E3E4E6;
	  color: #fff;
	line-height: 1.4;
	word-wrap: break-word;
}

.image b {
	overflow: hidden;
	display: block;
	clear: both;
	padding-top: 7px;
}

.image i{
	font-size: 12px;
	line-height: 1.2;
	display: block;
	opacity: 0.8;
	padding-top: 4px;
	 margin-left: 4px;
}
.me .image i{
 padding-left: 5px;
}

.you .image i{
  padding-right: 5px;
}
.chat-box {
  width: 624px;
  margin: 0 auto;
   font-size: 15px;
    
 }
.chats{
    max-height: 500px;  
 	 overflow-y: auto;   
    }
.me i, .you i{
     display: block; 
    font-size: 8px;
    text-align: right;
    vertical-align: text-bottom;
    }
   
</style>
<?php $MainModuleName="Chat History";?>
<div class="had"><?=$MainModuleName?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr><td><input type="button" Value="Export" onclick="exporturl()" class="button"></td></tr>
    <tr>    
        <td  valign="top">           
                <div id="prv_msg_div" style="display:none"><img src="<?= $MainPrefix ?>images/loading.gif">&nbsp;Searching..............</div>
                <div id="preview_div">             
                             
                <div align="center" id="ajax-loader" style="display: none;"><img src="../images/loading.gif">&nbsp;Loading.......</div>
			<div class="chat-box">
				<ul class="chats">
				 <?php  if(!empty($responce->chathistory)){$i=0;
                        	foreach($responce->chathistory as $res){?>
                       
				<li class='<?php echo ($res->type=='empeznetusr')?'me':'you';?>'>
					<div class="image">					
						<b><?php echo !empty($res->user)?$res->user:'--';?></b>
						
					</div>
				<p><span><?php echo !empty($res->msg)?$res->msg:'--';?></span>
				<i class="timesent" data-time='now'><?php echo !empty($res->time)?$res->time:'--';?></i></p>
				</li>
				
				 <?php $i++;}}else{echo '<li>No chat</li>';}?> 
				
				</ul>
				</div>
                  <!--  <table <?= $table_bg ?>>
                            <tr align="left">   
                           	 	<th width="10%"  class="head1" >Sender</th>                         
                                <th width="15%"  class="head1" >Message</th>
                                <th width="15%"  class="head1" >Date</th>                                                                 
                            </tr>
                        <?php
                        if(!empty($responce->chathistory)){$i=0;
                        	foreach($responce->chathistory as $res){  ?>
                         	<tr align="left">                              	                        
                                <td width="15%"  ><?php echo !empty($res->user)?$res->user:'--';?></td>
                                <td width="15%"  ><?php echo !empty($res->msg)?$res->msg:'--';?></td>                                
                                <td width="20%"  ><?php echo !empty($res->time)?$res->time:'--';?></td>   
                            </tr>
                        <?php $i++;}}else{ ?>
                            <tr align="center" >
                                <td  colspan="3" class="no_record"><?= NO_RECORD ?></td>
                            </tr>
                            <?php }?> 
						 </table>
-->
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
					function exporturl(){
						window.location="export_chat.php?refid=<?php echo $_GET['refid']?>";
						}
				</script>