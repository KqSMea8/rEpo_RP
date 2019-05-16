<table width="100%" border="0" cellspacing="0" cellpadding="0">
 
  <tr>
       
    <td align="left"  valign="top" width="100%">



<table width="100%" border="0" cellspacing="0" cellpadding="0" >
  <? if($_GET['AdvancedSearch']==1){ ?>
   <tr>
        <td  align="left" valign="middle" class="heading">
		Advanced Product Search
			</td>
      </tr>
	   <tr>
        <td height="32" align="left" valign="middle" class="pagenav">
		<span ><?=$Nav_Home?>  <a href="advanceSearch.php">Advanced Product Search</a> </span> Search Result</td>
      </tr>
      
  <? } else{ ?>
 <tr>
        <td  align="left" valign="middle" class="heading">Search</td>
      </tr>
	  
	  <tr>
        <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?>  Search</td>
      </tr>
<? } ?>
      <tr>
        <td height="15" align="right"></td>
      </tr>
 
  
  <tr>
       
    <td align="left" width="100%" valign="top">
	<table width="100%" cellspacing="0" cellpadding="0"  align="left"  >


		 
            
		<? if(!empty($_GET['topkey'])) { ?>	
			<tr>
              <td align="left" height="50" valign="top" >
			  <span class="heading2">You searched for :</span> <b><?=$_GET['topkey']?></b>			  </td>
            </tr>
			
	 	
		<? } ?>
        <tr>
        <td height="15" align="right" class="skytxt">
		 <? if($_GET['AdvancedSearch']!=1){ ?>
		<a href="advanceSearch.php">Try Our Advanced Search</a>
		<? } ?>
		</td>
      </tr>
	   
	   
		<tr>
              <td align="left" height="40" class="graybox"  >
			  Search result for items
			 		  </td>
            </tr>
		
		<tr>
		<td align="center" valign="top" class="outline" >
			 <?
			  $num = $numProduct;
			 require_once("includes/html/box/product-listing.php"); ?>	
		</td>
		</tr>	
	
		<? if($numStore>0){?>
			<tr>
              <td align="left" height="40"  >
			 		  </td>
            </tr>

			<tr>
              <td align="left" height="40" class="graybox"  >
			  Search result for shops
			 		  </td>
            </tr>
		
		<tr>
		<td align="center" valign="top" class="outline" >
			 <? 
			 $num = $numStore;
			 require_once("includes/html/box/store-listing.php"); ?>	
		</td>
		</tr>	
		<? } ?>
		
		
		<? if($_GET['AdvancedSearch']==1 && $numProduct<=0){ ?>
		<tr>
              <td align="left"   >
			  
	<table cellspacing="0" cellpadding="0" width="100%" align="center">
      
	  
     
      
	  <tr>
        <td ><Div id="MsgDiv_Contact" class="redtxt" style="text-align:center" ></Div></td>
      </tr>
	   <tr>
        <td height="35">&nbsp;</td>
      </tr>  
	  
 <tr>
        <td  id="ContactFormTD">
		
	
		<table width="90%" border="0" align="left" cellpadding="0" cellspacing="0">
         <form name="ContactForm" action=""  method="post" onSubmit="return validateContact(this);">
		  <tr>
        <td height="40" colspan="2" class="graybox" >Please fill the below fields to send a notification to us. </td>
      </tr>
          <tr>
            <td width="21%" height="30" align="left" valign="middle" > Name <span class="bluestar">*</span></td>
            <td height="30" align="left" valign="middle" >
              <input name="Name" id="Name" maxlength="30" type="text"  class="txtfield_normal" />
            </td>
          </tr>
          
          <tr>
            <td height="30" align="left" valign="middle" >Email Address <span class="bluestar">*</span></td>
            <td height="30" align="left" valign="middle" >
              <input name="ContactEmail" id="ContactEmail" maxlength="70" type="text"  class="txtfield_normal" />            </td>
          </tr>
          
          <tr>
            <td height="30" align="left" valign="top" >Your Comments <span class="bluestar">*</span></td>
            <td height="30" align="left" valign="middle" ><textarea name="comments"  id="comments"  rows="5"  class="txtfield" style="width:300px;resize: none;"></textarea></td>
          </tr>
          <tr>
            <td height="30" align="left" valign="middle" >&nbsp;</td>
            <td height="50" align="left" valign="middle" ><table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="right"><input name="SubmitButton" id="SubmitButton" type="submit" value="Submit" class="button" /></td>
                <td>&nbsp;</td>
                <td align="right"><input type="reset" name="Reset"  value="Reset" class="button" /></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="35" colspan="2" valign="bottom">&nbsp;</td>
          </tr>
		  </form>
        </table></td>
      </tr>	  
	  
    </table>		  
			  
			  
			   
			 		  </td>
            </tr>
		<? } ?>
		
		
          </table></td>
		
		
  </tr>
</table></td>

<td align="right" valign="top">
		 		 
  <? include("includes/html/box/right_panel.php"); ?>

		 
		 </td>
  </tr>
</table>

