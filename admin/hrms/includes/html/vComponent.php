<a href="<?=$RedirectURL?>" class="back">Back</a>

<a href="<?=$EditUrl?>"  class="edit">Edit</a>
<div class="had">
Performance Components    <span> &raquo;
	<? 	echo (!empty($_GET['view']))?("Component Detail") :(""); ?>
		
		</span>
</div>

		 
		    <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
              
                <tr>
                  <td align="center"  ><table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
                    <tr>
                      <td width="20%" align="right"    class="blackbold">
					   Component Title : </td>
                      <td  align="left" >
					<?=stripslashes($arryComponent[0]['heading'])?>				    </td>
                    </tr>


								
                    <tr>
                      <td  class="blackbold"  valign="top"  align="right">Description :</td>
                      <td  align="left" valign="top" >
					 <?=stripslashes($arryComponent[0]['detail'])?>
					  
					   </td>
                    </tr>
                    
                 
					
                    <tr >
                      <td align="right"   class="blackbold">Status  :</td>
                      <td align="left" >
				 <?  echo ($arryComponent[0]['Status'] == 1)?("Active"):(" InActive");  ?>


                                                   </td>
                    </tr>	
								  

                  
                  </table></td>
                </tr>
				
				
              </form>
          </table>