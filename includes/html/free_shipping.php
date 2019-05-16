<link href="css/stylesheet.css" rel="stylesheet" type="text/css">
<table cellspacing="0" cellpadding="8" width="100%" align="center">
     <tr>
        <td  align="left" valign="middle" class="heading">Free Shipping 	</td>
      </tr>  
	  
	
	 
	  
      <tr>
        <td height="15"></td>
      </tr>
      <tr>
        <td height="200" valign="top"  class="txt" >
		<?
	if($arrayContents[0]['PageContent'] != ''){
	 	echo  stripslashes($arrayContents[0]['PageContent']); 
	}else{
		echo '<Div align=center  class=redtxt>'.INACTIVE_PAGE.'</Div>';
	}
	
	?>
        </td>
      </tr>
    </table>
