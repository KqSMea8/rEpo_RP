
<div class="had">
View Store Review
</div>
<TABLE WIDTH="650"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<TR>
	  <TD HEIGHT=398 align="center" valign="top"><table width="100%" height="388"  border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td  align="center" valign="middle" >
		  <br><br>
		  <div  align="right"><a href="viewReviews.php" class="Blue">List <?=$ModuleName?>s</a>&nbsp;</div><br>
		    <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action="" method="post" onSubmit="return validate(this);">
               
                <tr>
                  <td align="center" valign="top" ><table width="100%" border="0" cellpadding="10" cellspacing="1"  class="borderall">
                    <tr>
                      <td width="23%" align="right" valign="top" =""  class="blackbold">  Store  :</td>
                      <td width="77%" align="left" valign="top" >
					  <?
		$StoreLink = $Config['Url'].$Config['StorePrefix'].$arryReview[0]['UserName'].'/store.php';
		echo '<Span class=red>&nbsp;<a href="'.$StoreLink.'" target="_blank" >'.stripslashes($arryReview[0]['CompanyName']).'</a></span>';
	  ?>					  </td>
                    </tr>
                    
                    <tr>
                      <td align="right" valign="top" =""  class="blackbold">Rating : </td>
                      <td align="left" valign="top" ><img src="../images_small/<?=$arryReview[0]['Points']?>star.png"></td>
                    </tr>
                    <tr>
                      <td align="right" valign="top" =""  class="blackbold">Rated By : </td>
                      <td align="left" valign="top" >
					   <? echo '<a onclick="OpenNewPopUp(\'vSeller.php?edit='.$arryReview[0]['RaterID'].'\', 550, 660, \'no\' );" href="#" ><b>'. stripslashes($arryReview[0]["RatedBy"]) .'</b></a>'; 
	 ?>
					  </td>
                    </tr>
                    <tr>
                      <td width="23%" align="right" valign="top" =""  class="blackbold">   Date :</td>
                      <td width="77%" align="left" valign="top" class="blacknormal"><?=stripslashes($arryReview[0]['Date'])?></td>
                    </tr>	

			
					
							<tr >
                      <td align="right" valign="top"  class="blackbold">Status  :  </td>
                      <td align="left" valign="top" class="blacknormal">
				<? 
		 if($arryReview[0]['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
		 echo $status;
		 ?>	  
					  
					  </td>
                    </tr>		
					<tr >
                      <td align="right" valign="top"  class="blackbold"> Comments  :  </td>
                      <td align="left" valign="top" class="blacknormal"><?=nl2br(stripslashes($arryReview[0]['Message']))?></td>
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