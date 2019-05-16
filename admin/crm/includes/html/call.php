
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
</style>


<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>
<link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
<link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />

</head>
<body>
<span class="had" style="display:none;">CRM</span>
<span class="TitleBar"></span>
<div id="Event" >
<div class="message"><?php if(!empty($_SESSION['mess_phone'])){echo $_SESSION['mess_phone'];unset($_SESSION['mess_phone']);}?></div>
<? if($ModifyLabel==1){?>
 <table <?=$table_bg?>>
	 <tr>
	 	<td class="head_comment">Call Comment</td>
	 </tr>
         <?php if($HideNavigation!=1){?>
	 <tr>
	 	<td ><form  method="get" action="" id="frmSrch" name="frmSrch">
                 	Start Date <span class="red">*</span> <script>
					$(function() {
					$( "#from" ).datepicker({					
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
				    <input id="from" name="from" readonly="" class="datebox" value="<?php  if(isset($_REQUEST['from'])){ echo $_REQUEST['from']; } ?>"  type="text" >&nbsp;&nbsp;
                     End Date <span class="red">*</span> <input id="to" name="to" readonly="" class="datebox" value="<?php  if(isset($_REQUEST['to'])){ echo $_REQUEST['to']; } ?>"  type="text" > 
                   
               <input type="hidden" value="Search" id="search" name="search">
               <input type="submit" class="search_button" value="Go" name="sbt">
            </form></td>
	 </tr>
         <?php }?>
	<tr>	
	    <td  align="center" valign="top"  id="searchfbbox">	
	    <table width="100%" align="center" cellspacing="1" cellpadding="3" id="list_table">
   
    <tbody>
    <tr align="left">
                <td width="70%" align="left" class="head1">Comment</td>
				<td width="15%" align="center" class="head1">Date</td>	
				<td width="15%" align="center" class="head1">Action</td>		
                
    </tr>  
  
   
  <?php if(is_array($getComment) && count($getComment)>0){
	  	$flag=true;
		$Line=0;
		$invAmnt=0;
  	foreach($getComment as $key=>$values){
		$flag=!$flag;
		$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
		$Line++;	
  ?>
	<tr align="left"  bgcolor="<?=$bgcolor?>">       
      <td align="left"><?php echo $values->Comment;?></td>
       <td align="center"><?php echo date('m-d-Y h:i:s', strtotime($values->CommentDate));?></td>
      <td align="center"><a onclick="return confirmDialog(this, 'Comment')" href="call.php?action=delete&cid=<?php echo  $values->CommentID; ?>"><img border="0" onmouseout="hideddrivetip()" ;="" onmouseover="ddrivetip('&lt;center&gt;Delete&lt;/center&gt;', 40,'')" src="<?php echo _SiteUrl?>/admin/images/delete.png"></a>  </td>
    </tr>
	
        <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" > 
      <td  colspan="8" class="no_record"><?=NO_RECORD?> </td>
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
