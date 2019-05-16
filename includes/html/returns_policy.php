<table cellspacing="0" cellpadding="0" width="100%" align="center">
      
	    <tr>
        <td  align="left" valign="middle" class="heading">Returns policy</td>
      </tr>
	  <tr>
        <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?> </span> Returns policy</td>
      </tr>
     
	   
	  
      <tr>
        <td height="15"></td>
      </tr>
      <tr>
        <td height="32" class="txt">
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