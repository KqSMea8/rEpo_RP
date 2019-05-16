<body>
<link href='fullcalendar/socialfbtwlin.css' rel='stylesheet' />
<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>
<link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
<link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />

<a class="back" href="javascript:void(0)" onclick="window.history.back();">Back</a>
<a href="ViewchimpCampaign.php" class="fancybox add_quick">List Campaign</a>
<div class="had">Create Campaign </div>

<div>
<TABLE WIDTH="100%"   BORDER=0 align="center"  >
	
  
<tr>
<td align="left" valign="top">
 <form name="form1" action=""  method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
<table width="100%"  border="0" cellpadding="0" cellspacing="0">

			<?php if (!empty($_SESSION['message'])) {?>
			<tr>
			<td  align="center"  class="message"  >
			<?php if(!empty($_SESSION['message'])) {echo $_SESSION['message']; unset($_SESSION['message']); }?>	
			</td>
			</tr>
			<?php } ?>
  
		<tr>
			<td  align="center" valign="top" >
			<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
			<tr>
			<td colspan="2" align="left"  class="head" >Campaign Information</td>
			</tr>
                        <tr>
			<td  align="right" width="40%"   class="blackbold">Title: </td>
			<td   align="left" >
			<input name="title" type="text" class="inputbox" id="title" value="<?php echo !empty($_POST['title'])?$_POST['title']:'';?>"/></td>
			</tr>
			<tr>
			<td  align="right" width="40%"   class="blackbold">Subject: </td>
			<td   align="left" >
			<input name="subject" type="text" class="inputbox" id="title" value="<?php echo !empty($_POST['subject'])?$_POST['subject']:'';?>"/></td>
			</tr>
			<tr>
			<td  align="right" width="40%"  class="blackbold">From Email:<span class="red">*</span> </td>
			<td   align="left" >
			<input name="femail" type="email" class="inputbox" id="title" value="<?php echo !empty($_POST['femail'])?$_POST['femail']:'';?>"/></td>
			</tr>
			<tr>
			<td  align="right" width="40%"  class="blackbold">From Name:<span class="red">*</span> </td>
			<td   align="left" >
			<input name="frname" type="text" class="inputbox" id="title" value="<?php echo !empty($_POST['frname'])?$_POST['frname']:'';?>"/></td>
			</tr>
			<tr>
			<td  align="right" width="40%"  class="blackbold">Select Template:<span class="red">*</span> </td>
			<td   align="left" >
			<?php //echo '<pre>'; print_r($listtamplate);die; ?>
			<select name="Tempn" style="width: 198px; height: 21px; border:1px solid #DAE1E8;">
			<option value="">select</option>
			        
			<?php 
			if (is_array($listtamplate['user'])) {
                            $flag = true;
                            $Line = 0;
                            $LeadNo = 0;
                            $LeadNo = ($_GET['curP'] - 1) * $RecordsPerPage;
                            foreach($listtamplate['user'] as $key => $values) {
                                $flag = !$flag;
                                $bgcolor = ($flag) ? ("#FAFAFA") : ("#FFFFFF");
                                $Line++;
                                $LeadNo++;
			        ?>

			        
                  <option name="Tempid[]" value="<?= (!empty($values['id'])) ? (stripslashes($values['id'])) : (NOT_SPECIFIED) ?>"><?= (!empty($values['name'])) ? (stripslashes($values['name'])) : (NOT_SPECIFIED) ?></option>
                 
                
                <?php 
						} //end foreach
                  } //end if						
						 ?> 
						 </select> 
			</td>
			</tr>
			<tr>
			<td  align="right" width="40%"  class="blackbold">Select Segment:<span class="red">*</span> </td>
			<td   align="left" >
			<?php //echo '<pre>'; print_r($ChimpSegmentList);die; ?>
			      <select name="Seg" style="width: 198px; height: auto; border:1px solid #DAE1E8;">
			      <option value="">select</option>
			      <?php 
                        if (is_array($ChimpSegmentList) && $num > 0) {
                            $flag = true;
                            $Line = 0;
                            $LeadNo = 0;
                            $LeadNo = ($_GET['curP'] - 1) * $RecordsPerPage;
                            foreach($ChimpSegmentList as $key => $values) {
                                $flag = !$flag;
                                $bgcolor = ($flag) ? ("#FAFAFA") : ("#FFFFFF");
                                $Line++;
                                $LeadNo++;
                            ?>
                  <option name="Segid[]" value="<?= (!empty($values['segment_id'])) ? (stripslashes($values['segment_id'])) : (NOT_SPECIFIED) ?>"><?= (!empty($values['name'])) ? (stripslashes($values['name'])) : (NOT_SPECIFIED) ?></option>
                  <?php 
						} //end foreach
                  } //end if						
						 ?> 
                </select> 
			</td>
			</tr>
			
			</table>	
			</td>
		</tr>
		 

		<tr>
			<td  align="center" >
			<div id="SubmitDiv" style="display:none1">
			<input name="Submit" type="submit" class="button" id="SubmitButton" value="Submit" />
			</div>
			</td>
		</tr>
   
   
</table></form>
	</td>
    </tr>
 
</table>
</div>
