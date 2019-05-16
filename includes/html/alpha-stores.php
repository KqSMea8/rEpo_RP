<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
       
    <td align="left" width="100%" valign="top"><table cellspacing="0" cellpadding="0" id="container4">
            <tr>
              <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?> </span> <?=BROWSE_STORES?> </td>
            </tr>
            <tr>
              <td  align="left" valign="middle" class="heading"><?=BROWSE_STORES?></td>
            </tr>
            <tr>
              <td height="15"></td>
            </tr>
           <tr>
            <td   valign="top">
			
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	 <tr>
		<td height="20" ></td>
	  </tr>
 <tr>
            <td height="20" colspan="2" class="outline greentxt" align="center">
			
			<?  echo Alphabets('alpha-stores.php?ch=','',$_GET['ch']); ?>
			
		</td>
          </tr>
 
  <tr>
	<td height="20" align="right" class="skytxt" >
	&nbsp;
	<? //if($_GET['ch'] != ''){?> <!--<a href="alpha-products.php"><?=VIEW_ALL?></a>&nbsp;&nbsp;-->	<? //} ?>
	
	</td>
  </tr>
 
</table>
			 
		  </td>
        </tr>
		
		
	   <tr>
        <td valign="top"><? require_once("includes/html/box/onl-stores.php"); ?></td>
      </tr>	
		
		
		
          </table></td>
		
		 <td align="right" valign="top">
		 		 
		 <? require_once("includes/html/box/right.php"); ?>

		 
		 </td>
  </tr>
    </table></td>
  </tr>
</table>
