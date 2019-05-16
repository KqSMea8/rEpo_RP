<div class="had"><?=$MainModuleName?> </div>
<? if(!empty($_SESSION['mess_send_request'])) {echo '<div class="message" align="center">'.$_SESSION['mess_send_request'].'</div>'; unset($_SESSION['mess_send_request']); }?>
<? if(!empty($ErrorMsg)){ ?> 
	  <div align="center" id="ErrorMsg" class="redmsg">
	  <br><?=$ErrorMsg?>
	  </div>
<? }else{ ?>  

<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Loading..............</div>
<div id="preview_div" >	
<table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              
                <tr>
                  <td align="center">
                   
				  <?php	include("includes/html/box/send_request_form.php");?>

                  </td>
                </tr>

          </table>
</div>
		
<? } ?>		
	   

