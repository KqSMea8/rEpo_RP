
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
</style>


<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>
<link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
<link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />
</head>
<body>
<div >
<div class="message"><?php if(!empty($_SESSION['mess_phone'])){echo $_SESSION['mess_phone'];unset($_SESSION['mess_phone']);}?></div>
<? if($ModifyLabel==1){?>
<div style="margin-bottom:5px;" class="had">Call Quota</div>
 <table>	
	<tr>	
	    <td  align="center" valign="top" >
	    <form action="" method="POST">	
	   <table cellspacing="1" cellpadding="5" border="0">
				<tbody>			
				<tr>
                      <td width="45%" align="right" class="blackbold">
					 Duaration :
					  </td>
                      <td align="left">
					<select name="duration" id="duration" class="inputbox">
						<option value="month">Monthly</option>
						<option value="quarter">Quarterly</option>
						<option value="year">Yearly</option>
					</select>
					  </td>
                    </tr>
			
					 <tr>
						  <td valign="top" align="right" class="blackbold">Time (in minutes) <span class="red">*</span>:</td>
						  <td align="left">
							<input type="text" name="q_time" class="inputbox">
							
							</td>
						</tr>
 							<tr>
						  <td valign="top" align="right" class="blackbold">&nbsp;</td>
						  <td align="left">
								<input type="submit" name="save" value="Save" class="button">							
							</td>
						</tr>

                                      
                  </tbody></table>
	    </form>
	    
	    
	    		
			<!--<? if (!empty($_SESSION['mess_social'])) {?>
			<div><span  align="center"  class="message"  >
				<? if(!empty($_SESSION['mess_social'])) {echo $_SESSION['mess_social']; unset($_SESSION['mess_social']); }?>	
			</span></div>
			<? } ?>
			<form name="form1" action="" id="socialfrom"  method="post"  enctype="multipart/form-data">
				
				<div class="list-box"><ul class="emp-list list">
					<?php if(!empty($arryEmployee)){
					foreach($arryEmployee as $Employee){?>
					<li class="droppable <?php echo ($AgentByEmp[$Employee['EmpID']])?'ui-state-highlight':'';?>">
						<span class="emp-name"><?php echo $Employee['UserName']?></span>
						<span class="close-box">
						<?php if(!empty($AgentByEmp[$Employee['EmpID']])){?>
							<a href="javascript:void(0);" onclick="closeempConnectper(this,'<?php echo $AgentByEmp[$Employee['EmpID']]?>','<?php echo $Employee['EmpID']?>','<?php echo $server_id?>')">X</a>
						<?php }?></span>
						<span class="agent-name"><?php if(!empty($AgentByEmp[$Employee['EmpID']]) AND !empty($AnameByAid[$AgentByEmp[$Employee['EmpID']]])){
							echo $AnameByAid[$AgentByEmp[$Employee['EmpID']]];
						}?></span>						
						<input type="hidden" class="EmpID" name="empdata[<?php echo $Employee['EmpID']?>][EmpID]" value="<?php echo $Employee['EmpID']?>">
						<input type="hidden" class="agentID" name="empdata[<?php echo $Employee['EmpID']?>][agentID]" value="<?php echo ($AgentByEmp[$Employee['EmpID']])?$AgentByEmp[$Employee['EmpID']]:'';?>">
					</li>
					<?php }}?>
				</ul>
				<ul class="agen-list list">
					<?php if(!empty($agents)){
					foreach($agents as $agent){?>
					<li class="agentId-<?php echo $agent[0]?> <?php echo (in_array($agent[0],$saveagents))?'hide':'';?>"  >
						<span class="agent-name"><?php echo $agent[2]?></span>
						<input type="hidden" class="EmpID" value="<?php echo $agent[0]?>">						
					</li>
					<?php }}?>
				</ul>
				</div>
				<div class="form-action"><input type="submit" value="Connect" class="button"></div>
			 </form>-->
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