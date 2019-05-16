
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  
  <tr>
    <td height="20"  colspan="2" style="padding-top:7px;"><? include("includes/html/box/search.php"); ?></td>
  </tr>
 
  
  <tr>
       
    <td align="left" width="100%" valign="top"><table cellspacing="0" cellpadding="0" id="container4">
             <tr>
        <td><?  require_once("includes/html/box/banner_top.php"); ?></td>
      </tr>

	  
	  <? if(!empty($_GET['topkey'])){ ?>
	   <tr>
        <td height="20"><span class="heading2"><?=YOU_SEARCH_STORE_FOR?></span> <span class="blueheader"><?=$_GET['topkey']?></span> </td>
      </tr>
	  <tr>
        <td height="20"></td>
      </tr>
	  <? } ?>
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
