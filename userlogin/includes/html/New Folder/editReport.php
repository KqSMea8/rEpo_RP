
<div class="had">
View Offensive Content Report
</div>
<TABLE WIDTH="650"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<TR>
	  <TD HEIGHT=398 align="center" valign="top"><table width="100%" height="388"  border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td  align="center" valign="middle" >
		  <br><br>
		  <div  align="right"><a href="viewReports.php" class="Blue">List <?=$ModuleName?>s</a>&nbsp;</div><br>
		    <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action="" method="post" onSubmit="return validate(this);">
               
                <tr>
                  <td align="center" valign="top" ><table width="100%" border="0" cellpadding="10" cellspacing="1"  class="borderall">
                    <tr>
                      <td width="23%" align="right" valign="top" =""  class="blackbold">  Posted By :</td>
                      <td width="77%" align="left" valign="top" class="blacknormal"><?=stripslashes($arryReport[0]['Name'])?></td>
                    </tr>
                    
                   <tr>
                      <td width="23%" align="right" valign="top" =""  class="blackbold">  Posted Date :</td>
                      <td width="77%" align="left" valign="top" class="blacknormal"><?=stripslashes($arryReport[0]['Date'])?></td>
                    </tr>
					  
									 <tr >
                      <td align="right" valign="top"  class="blackbold" >Email Address :</td>
                      <td align="left" valign="top" class="blacknormal"><?  echo '<a href="mailto:'.$arryReport[0]['Email'].'">'.$arryReport[0]['Email'].'</a>'; ?></td>
                    </tr>

				<tr >
                      <td align="right" valign="top"  class="blackbold">Contact Number :  </td>
                      <td align="left" valign="top" class="blacknormal"><?=stripslashes($arryReport[0]['Phone'])?></td>
                    </tr>	

			
					
							<tr >
                      <td align="right" valign="top"  class="blackbold">Store / Website :  </td>
                      <td align="left" valign="top" class="blacknormal">
					  <?  echo '<a href="'.$arryReport[0]['Website'].'" target="_blank">'.$arryReport[0]['Website'].'</a>'; ?>					  </td>
                    </tr>		
					<tr >
                      <td align="right" valign="top"  class="blackbold">Offensive Content  :  </td>
                      <td align="left" valign="top" class="blacknormal"><?=nl2br(stripslashes($arryReport[0]['Content']))?></td>
                    </tr>	
				<tr >
                      <td align="right" valign="top"  class="blackbold">Why is the content offensive?  </td>
                      <td align="left" valign="top" class="blacknormal"><?=stripslashes($arryReport[0]['WhyOffensive'])?></td>
                    </tr>	
					
                   
                  </table></td>
                </tr>
				
				
				 <tr>
                   <td align="center" valign="middle" height="40">&nbsp;</td>
				 </tr>
				
				
              </form>
          </table></td>
        </tr>
      </table></TD>
  </TR>
	
</TABLE>