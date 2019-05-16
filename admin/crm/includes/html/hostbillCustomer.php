<link href='fullcalendar/fullcalendar.css' rel='stylesheet' />
<link href='fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
<style>
	.ui-widget-overlay{
		opacity: 0.6 !important;
	}	
	#loading {
		position: absolute;
		top: 5px;
		
		right: 5px;
		}

	#calendar {
		width: 100%;
		margin: 0 auto;
		}
		.fc-event-title{
		 color:#FFFFFF;
		}
		
		.fc-event-inner .fc-event-time{ color:#FFFFFF;}		
		.list > li {
		    border: 1px solid;
		    float: left;
		    margin-bottom: 5px;
		    margin-top: 5px;
		    padding: 10px 0;
		    width: 100%;
		}
		.emp-list.list {
   			 float: left;
		}
		.agen-list.list {
   			 float: right;
		}
		.list {
	  	 	 width: 45%;
		}		
		.list-box {
		    border: 1px solid;
		    float: left;
		    width: 100%;
		}		
		.emp-name {
		    float: left;
		    margin-left: 8px;
		}
		
		.emp-list li .agent-name {
		    float: right;
		    margin-right: 10px;
		}
		.hide{
		display:none;
		}
		.close-box{
			float:right;
			 margin-right: 10px;
		}
		.close-box > a {
  			  font-size: 15px;
		}
		.synchronize-tr {
    display: block;
    padding: 13px 0;
}

.synchronize-button {
    display: inline-block;
    margin-left: 20px;
     color: #fff !important;
}
</style>


<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>
<link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
<link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />
<script type="text/javascript">
jQuery(function() {
jQuery( ".agen-list li" ).draggable({  revert: true});
jQuery( ".emp-list li" ).droppable({
	drop: function( event, ui ) {
		if(jQuery(this).find('.agentID').val()==''){	
	var draghtml=	ui.draggable;
	var agentname=	draghtml.find('.agent-name').html();
	console.log(jQuery(ui.draggable).find('.agent-name').html());
	jQuery(this).find('.agent-name').html(jQuery(ui.draggable).find('.agent-name').html());
	jQuery(this).find('.agentID').val(jQuery(ui.draggable).find('.EmpID').val());
	jQuery(this).find('.close-box').html('<a href="javascript:void(0);" onclick="closeempConnect(this)">X</a>');
	
	jQuery( this ).addClass( "ui-state-highlight" )	;

	 //destroy clone
	jQuery(ui.draggable).addClass('hide'); //remove from list
		}else{
				jQuery(this).css('border-color','red');
			}
	}
	});
});


function closeempConnect(obj){
var agentid=jQuery(obj).parents('li').find('.agentID').val();
jQuery('.agen-list li.agentId-'+agentid).removeClass('hide');
jQuery(obj).parents('li').find('.agentID').val('');
jQuery(obj).parents('li').find('.agent-name').html('');
jQuery(obj).parents('li').removeClass('ui-state-highlight');
//jQuery(obj).parents('li').droppable( "option", "disabled", true );;

jQuery(obj).remove();
	
}

function closeempConnectper(obj,agent_id,user_id,server_id){
	var r= confirm('do you want to delete?');
	if(r==true){
		var request=jQuery.ajax({
				type:'post',
				url:'<?php echo _SiteUrl;?>/admin/crm/ajax.php?action=delete_CallEmployee',
				data:{
					server_id:server_id,
					user_id:user_id,
					agent_id:agent_id
					},success:function(data){

							if(data==0){
								alert('There is some technical problem');
							}else{
								closeempConnect(obj);
								}
						}
			});
		}else{

			}
}
</script>
</head>
<body>
<div id="Event" >
<div class="message"><?php if(!empty($_SESSION['mess_phone'])){echo $_SESSION['mess_phone'];unset($_SESSION['mess_phone']);}?></div>
<? if($ModifyLabel==1){?>
 <table <?=$table_bg?>>
	 <tr>
	 	<td class="head1">Connect</td>
	 </tr>
	  <tr class="synchronize-tr"><td><label>Last Invoice Synchronize :  </label>
	  <?php echo $synchronizedate[0]['meta_date'];?>
	  <a class="synchronize-button search_button" href="<?php echo $Config['Url'].'admin/synchronize-hostbill.php?process=Importinvoice';?>">Invoice Synchronize</a></td></tr>
	 
	 <tr>
	 	<td>	 	
	 	<form  method="post" action="" id="frmSrch" name="frmSrch">
                 	 CRM Customer <span class="red">*</span> <select style="width: 110px;" class="textbox" id="crmEmployee" name="cid">
                 	<option value="">Select CRM Customer</option>
                 	<?php if(!empty($selectcustomer)){ 
                               	
	                 	foreach($selectcustomer as $k=>$val){	 
	                 		$val=trim($val);
	                 		if(!empty($val)){            
	                 		echo '<option value="'.$k.'">'.htmlentities($val).'</option>';
	                 		}
	                 	
	                 	}
                 	}?>
                 	 </select>&nbsp;&nbsp;
                     Hostbill Customer <span class="red">*</span> <select style="width: 110px;" class="textbox" id="elastixUser" name="hostbillcid">
                     	<option value="">Select Hostbill User</option>
                     	<?php if(!empty($selectClient)){                 	
			                 	foreach($selectClient as $k=>$val){		
				                 	if(!in_array($k,$assigneHostbillcustomer))	 {                		
				                 		echo '<option value="'.$k.'">'.$val.'</option>';
				                 	}	                 	
			                 	}
                 			}?>
                     </select>
                   
               <input type="hidden" value="Search" id="search" name="search">
               <input type="submit" class="search_button" value="Go" name="sbt">
            </form></td>
            
	 </tr>
	 
	<tr>	
	    <td  align="center" valign="top"  id="searchfbbox">	
	    <table width="100%" align="center" cellspacing="1" cellpadding="3" id="list_table">
   
    <tbody>
    <tr align="left">
                <td width="30%" align="left" class="head1">Customer Name</td>
                <td width="10%" align="center" class="head1">Hostbill User</td>			
                <td width="10%" align="center" class="head1">Action</td>
    </tr>  
  
   
  <?php if(is_array($listcustomer) && !empty($listcustomer)){
	  	$flag=true;
		$Line=0;
		$invAmnt=0;
		
  	foreach($listcustomer as $key=>$values){
		$flag=!$flag;
		$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
		$Line++;	
  ?>
	<tr align="left"  bgcolor="<?=$bgcolor?>">  	   
      <td align="left"><?php echo $values['FullName'];?></td>     
      <td align="center"><?php echo $selectClient[$values['refid']];?></td>     
      <td align="center"> 
          <a  href="hostbillCustomer.php?del_id=<?php echo base64_encode($values['cid']);?>" onclick="return confirm('Are you sure you want to delete this connection?');"><img border="0" onmouseout="hideddrivetip()" ;="" onmouseover="ddrivetip('&lt;center&gt;Delete&lt;/center&gt;', 40,'')" src="<?php echo _SiteUrl?>/admin/images/delete.png"></a>
      </td>
    </tr>
        <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="6" class="no_record"><?=NO_RECORD?> </td>
    </tr>
    <?php } ?>	
  </table>	   
		</td>
	  </tr>
</table>
<? }else{?>

<div class="redmsg" align="center">Sorry, you are not authorized to access this section.</div>
<? }?>
</div>
<script>
function SaveSocialData(obj,id,type){
	jQuery('.userid-set').val(id);
	jQuery('.action-type').val(type);
	jQuery('#socialfrom').submit();
	
	}


</script>