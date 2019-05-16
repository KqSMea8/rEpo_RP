<style>

td i{
    color: red;
}

</style>
<div class="had">Hostbill Setting</div>
<div class="message"><? if(!empty($_SESSION['mess_hostbill'])) {echo $_SESSION['mess_hostbill']; unset($_SESSION['mess_hostbill']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >	 
		 <td valign="top">
			<form action="" method="POST">
			<table width="100%" border="0" cellspacing="0" cellpadding="5" class="borderall">
				<tbody>
			 		<tr>
			          <td valign="top" align="right" class="blackbold">Api ID :<i>*</i></td>
			          <td align="left"> 
			         	 <input type="text" class="inputbox" name="id" value="<?php echo $hostbillConfig['api_id']?>"> <br/>          
			          	
			       		
			       	</td>
			        </tr>
			        	<tr>
			          <td valign="top" align="right" class="blackbold">Api Key :<i>*</i></td>
			          <td align="left"> 
			         	 <input type="text" class="inputbox" name="key" value="<?php echo $hostbillConfig['api_key']?>"> <br/>           
			          	
			       		
			       	</td>
			        </tr>
			        	<tr>
			          <td valign="top" align="right" class="blackbold">IP :<i>*</i></td>
			          <td align="left"> 
			         	 <input type="text" class="inputbox" name="ip" value="<?php echo $hostbillConfig['ip']?>"> <br/>           
			          	
			       		
			       	</td>
			        </tr>
			        <tr>
			          <td valign="top" align="right" class="blackbold">Hostbill Url :<i>*</i></td>
			          <td align="left"> 
			         	 <input type="text" class="inputbox" name="api_url" value="<?php echo $hostbillConfig['api_url']?>"> <br/>           
			          	
			       		
			       	</td>
			        </tr>
			        <tr>
			          <td valign="top" align="right" class="blackbold"></td>
			          <td align="left"> 
			         	<input type="submit" class="button" value="save" name="hostbillconfigsubmit">      
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
