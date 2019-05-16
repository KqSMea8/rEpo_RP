<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
      <tr>
        <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?> </span> <span >
          <a href="advertise-with-us.php"><?=ADVERTISE_WITH_US?></a>   <a href="postBanner.php"><?=POST_YOUR_BANNER?></a> 
         </span>
              <?=ADVERT_PAYMENT?></td>
      </tr>
      <tr>
        <td  align="left" valign="middle" class="heading"><?=ADVERT_PAYMENT?></td>
      </tr>
      <tr>
        <td height="15"></td>
      </tr>
      <tr>
        <td height="32" >
		<?
		//$BannerImage = '<a onclick="OpenNewPopUp(\'showimage.php?img='.$_SESSION['BannerTempDest'].'\', 150, 160, \'no\' );" href="#" alt="Click to View Banner" title="Click to View Banner"><img src="'.$_SESSION['BannerTempDest'].'" width="'.$_SESSION['DisplayWidth'].'" height="'.$_SESSION['DisplayHeight'].'" border=0 class="imgborder"></a>';
		
		$BannerImage = '<a href="'.$_SESSION['BannerTempDest'].'"  rel="lightbox"><img src="'.$_SESSION['BannerTempDest'].'" width="'.$_SESSION['DisplayWidth'].'" height="'.$_SESSION['DisplayHeight'].'" border=0 class="imgborder" alt="Click to View Banner" title="Click to View Banner"></a>';
		
	
	$TotalImpressions = ($_SESSION['Impression'])*1000;
	$Imp = $_SESSION['Impression'];
	$BannerAmount =  $arrayConfig[0]['Banner'.$Imp];
		
		
	echo '<table width="100%" border="0" cellspacing="4" cellpadding="4" class="generaltxt_inner outline">
  <tr>
    <td width="15%">'.BANNER_TITLE.' : </td>
    <td>'.$_SESSION['Title'].'</td>
  </tr>
  <tr>
    <td>'.WEBSITE_STORE.' : </td>
    <td>'.$_SESSION['WebsiteUrl'].'</td>
  </tr>
   <tr>
    <td>'.DISPLAY_ZONE.' : </td>
    <td>'.$_SESSION['Position'].'</td>
  </tr><tr>
    <td>'.DISPLAY_WIDTH.' : </td>
    <td>'.$_SESSION['DisplayWidth'].'</td>
  </tr>
  <tr>
    <td>'.DISPLAY_HEIGHT.' : </td>
    <td>'.$_SESSION['DisplayHeight'].'</td>
  </tr>
  <tr>
    <td valign="top">'.BANNER_IMAGE.' :</td>
    <td valign="top">'.$BannerImage.'</td>
  </tr>

</table>';		
		
		
		
		?>				</td>
      </tr>
	   <tr>
        <td height="15"></td>
      </tr>
	  
	 
	   <tr>
	     <td height="32" class="generaltxt_inner">
		 
<form action="" method="post" name="form1" id="form1">
		 
 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="generaltxt_inner" >
             <? if(sizeof($arryDuration)>0) { ?>
             <tr>
               <td class="graybox"><input type="radio" name="PackageType" id="PackageType" value="Duration"   <? if($_SESSION['PackageType']=='Duration') echo 'checked';?>  />
                 <strong><?=SELECT_DURATION?></strong></td>
             </tr>
             <tr>
               <td valign="top">
			   
				   <table width="99%" border="0" cellspacing="0" cellpadding="5" class="blacktxt" align="right">
					   
					   <tr>
						 <td>
					<select name="Duration" id="Duration" style="width:320px;" class="txt-feild">
					
					 <? foreach($arryDuration as $key=>$values){ ?>
	 
						<option value="<?=$values['PackageID']?>" <? if($_SESSION['PackageID']==$values['PackageID']) echo 'selected';?>>
						 <?=stripslashes($values['Name'])?>
							 <? echo ' <span class=greentxt>( '.$Config['Currency'].' '.$values['Price'].' for '.$values['Validity'].' days )</span>'; ?> </option>
							 
							  <? } ?> 
					</select>						 </td>
					   </tr>
				   </table>			   </td>
             </tr>
             <? } ?>
             <? if(sizeof($arryImpression)>0) { ?>
             <tr>
               <td class="graybox"><input type="radio" name="PackageType" id="PackageType" value="Impression" <? if($_SESSION['PackageType']=='Impression') echo 'checked';?>/>
                 &nbsp;<strong><?=SELECT_IMPRESSION?></strong></td>
             </tr>
             <tr>
               <td>
			   
			   
				 <table width="99%" border="0" cellspacing="0" cellpadding="5" class="blacktxt" align="right">
					  
					   <tr>
						 <td>
						 
						 <select name="Impression" id="Impression" style="width:320px;" class="txt-feild">
						  <? foreach($arryImpression as $key=>$values2){ ?>
						 
						 <option value="<?=$values2['PackageID']?>" <? if($_SESSION['PackageID']==$values2['PackageID']) echo 'selected';?>>
						 <?=stripslashes($values2['Name'])?>
							 <? echo ' <span class=greentxt>( '.$Config['Currency'].' '.$values2['Price'].' for '.$values2['Impression'].' Impressions )</span>'; ?>						</option> 
							 
							<? } ?> 
						</select>						 </td>
					   </tr>
				   </table>			   </td>
             </tr>
             <? } ?>
           </table>		 
		 
		 
 <? if(sizeof($arryDuration)>0 || sizeof($arryImpression)>0) {
	 include("includes/html/box/payment_box.php");
}else{  ?>
 <div class="redtxt" align="center"><?=NO_PACKAGE_FOUND?></div>
 <? } ?>		 
		 
 <input type="hidden" name="MemberID" id="MemberID" value="<?=$_SESSION['MemberID']?>" />
 <input value="<?=stripslashes($_SESSION['Title'])?>" name="Title" type="hidden"  id="Title"  />
		
		 <input name="webUrl" type="hidden"  id="webUrl"  value="<?=$_SESSION['WebsiteUrl']?>"/>
		
		 <input name="BannerUrl" type="hidden"  id="BannerUrl"  value="<?=$_SESSION['BannerTempDest']?>"  />
		
		 <input type="hidden"  name="DisplayWidth" id="DisplayWidth" value="<?=$_SESSION['DisplayWidth']?>"/>
		 <input type="hidden"  name="Position" id="Position" value="<?=$_SESSION['Position']?>"/>
		
		 <input type="hidden"  name="DisplayHeight" id="DisplayHeight" value="<?=$_SESSION['DisplayHeight']?>"/>
		 
		   <input type="hidden" name="ShowOn" id="ShowOn"  value="<?=$_SESSION['ShowOn']?>" />
		  	 
		 </form>		 </td>
        </tr>
	  
    </table></td>
    <td align="right" valign="top"><? require_once("includes/html/box/right.php"); ?>
    </td>
  </tr>
</table>
</td>
</tr>
</table>
