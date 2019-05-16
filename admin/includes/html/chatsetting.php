
<div class="had">Chat Setting</div>
<div class="message"><? if(!empty($_SESSION['mess_chat'])) {echo $_SESSION['mess_chat']; unset($_SESSION['mess_chat']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >	  
	<tr>
		 <td valign="top">
		 <form action="" method="POST">
			<table width="100%" border="0" cellspacing="0" cellpadding="5" class="borderall">
				<tbody>
			 		<tr>
			          <td valign="top" align="right" class="blackbold">Code :</td>
			          <td align="left"> <?php if(!empty($licence->status)){?>
			          <textarea class="bigbox code"><?php echo htmlentities('<script>var chat={id:Math.floor(1e6*Math.random()+1),name:"",empemail:"",lis:"'.$licence->licence.'"};!function(){console.log(chat);var e=document.createElement("script");e.type="text/javascript",e.async=!0,e.src=document.location.protocol+"//'.$_SERVER['HTTP_HOST'].'/erp/js/chatjs/vimyjs.js";var t=document.getElementsByTagName("script")[0];t.parentNode.insertBefore(e,t)}();</script>');?></textarea>			           
			          </label>
			         <?php  }else{echo '<input type="submit" class="button" value="Ganerate" name="ganerate">';}?> </td>
			        </tr>
				</tbody>
			</table>
			</form>
			<tr>
		 <td valign="top">
			<form action="" method="POST">
			<table width="100%" border="0" cellspacing="0" cellpadding="5" class="borderall">
				<tbody>
			 		<tr>
			          <td valign="top" align="right" class="blackbold">Ideal Time :</td>
			          <td align="left"> 
			         	 <input type="text" class="inputbox" name="idealtime" value="<?php echo $idealtime?>"> Min<br/>           
			          	
			       		 <input type="submit" class="button" value="save" name="idealtimesubmit">
			       	</td>
			        </tr>
				</tbody>
			</table>
			</form>
			</td>
			</tr>
		</td>
	</tr>
</table>
