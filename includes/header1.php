<? 	 	require_once("settings.php");
	//unset($_SESSION['StoreID']);	


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE><?=$arrayConfig[0]['SiteTitle']?></TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=<?=$CharSet?>">

<?=$MetaDescription?>

<?=$MetaKeywords?>



<link href="css/stylesheet.css" rel="stylesheet" type="text/css">

<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />	
<script src="js/prototype.js" type="text/javascript"></script>
<script src="js/scriptaculous.js?load=effects" type="text/javascript"></script>
<script src="js/lightbox.js" type="text/javascript"></script> 


<script type="text/javascript" langage="javascript">

var GlobalSiteUrl = '<?=$Config['Url']?>';


function stoperror()
    {
        return true;
    }
window.onerror=stoperror;


function ChangeCurrency(){
	var SendCurrUrl = document.getElementById("CurrActionUrl").value+"curr_id="+document.getElementById("top_currency_id").value;

	location.href = SendCurrUrl;

}


function TopProductSearch(frm){
	
	Trim(frm.tky);

	if(frm.tky.value == 'Search Term'){
		frm.tky.value = '';
	}


	if(frm.tky.value==''){
		alert("Please enter a search term.");
		frm.tky.focus();
		return false;
	}

	if(CheckSpecialCharactersForSearch(frm.tky,SPECIAL_CHAR_SEARCH)){
		return false;
	}

}

</script>

<script language="javascript" src="includes/global_new.js"></script>
<script language="javascript" src="includes/ajax_new.js"></script>
<!--
<script language="javascript" src="includes/tooltip.js"></script>
-->
<script language="JavaScript" src="<?=$LanguageDirectory?>/jscript.js"></script>
<script language="JavaScript" src="<?=$LanguageDirectory?>/jscript_other.js"></script>



</HEAD>
<body>

<input type="hidden" name="SelfPage" id="SelfPage" value="<?=$SelfPageUrl?>">
<input type="hidden" name="QueryString" id="QueryString" value="<?=$QueryString?>">
<input type="hidden" name="CurrActionUrl" id="CurrActionUrl" value="<?=$CurrActionUrl?>">


<table border="0" cellspacing="0" cellpadding="0" class="maintable">
  <tr>
    <td height="117" valign="middle"><table width="990" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="431" align="left" valign="middle"><a href="index.php"><img src="images/logo.gif" alt="Oriental Merchant" border="0" /></a></td>
        <td width="303" align="left" valign="bottom"><table width="95%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="63%" height="25" align="right" valign="top" class="generaltxt">
			<?	
								
			$SrchKeyTop = $_GET['topkey'];
		   if(empty($SrchKeyTop)) {$SrchKeyTop='Search Term'; }
				?>
			 <form name="TopProductSearchForm" action="search.php"  method="get" onSubmit="return TopProductSearch(this);" enctype="multipart/form-data">
			<input type="submit" name="tp" id="tp" value="Search" class="searchbutton"/>
			<input name="tky" id="tky" type="text" class="search-txtfield" value="<?=$SrchKeyTop?>" maxlength="45" onFocus="Javascript : ClearTextBox('tky')"/>
			  
			</form>  
			  
			  </td>
          </tr>
          <tr>
            <td align="right"><span class="generaltxt">Currencies:</span><br />
			

           <select name="top_currency_id" class="currency" id="top_currency_id" onchange="Javascript:ChangeCurrency();"  >
             <? for($i=0;$i<sizeof($arryTopCurrency);$i++) {?>
               <option value="<?=$arryTopCurrency[$i]['currency_id']?>" <?  if($arryTopCurrency[$i]['currency_id']==$_SESSION['currency_id']){echo "selected";}?>><?=$arryTopCurrency[$i]['name']?></option>
             <? } ?>
         </select>				
			
			
          </td>
          </tr>
        </table></td>
        <td width="256" class="cartbox"><table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
          <tr>
            <td width="58%"><ul><li><a href="member-area.php">My Account</a></li>
<li><a href="track_order.php">Track Order</a></li>
<li><a href="products.php">Quick Order</a></li>
<li><a href="help.php">Help</a></li>
<li>
<? if(empty($_SESSION['UserName'])){?><a href="login.php"  class="footertxt_link">Sign In / Register</a><? }else{ ?><a href="logout.php" class="footertxt_link">Log Out</a><? } ?>
</li></ul>

</td>
            <td ><strong>0844 822 8000</strong><br />
              <br />
                <a href="cart.php"><strong>Your Basket</strong></a><br />
<?=$arryNumCart[0]['NumCartItem']?> items: <?=display_price($TotalCartPrice,'','',$arryCurrency[0]['symbol_left'],$arryCurrency[0]['symbol_right'])?> </td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr><td><ul id="MenuBar1" class="MenuBarHorizontal">
   <li><a href="index.php" <?=($PageID==1)?('style="background:#000000;"'):("")?>>Home</a></li>
   
   <?
	foreach($arryTopCategory as $key=>$values){
			$cat_active = ($TopCatID==$values['CategoryID'])?('style="background:#000000;"'):("");
			
			$CatUrl = 'category.php?cat='.$values['CategoryID'].$StoreSuffix;
   
	  echo '<li><a href="'.$CatUrl.'" '.$cat_active.' >'.stripslashes($values['Name']).'</a>';
		
	  $arrySubCategory = $objCategory->GetSubCategoryByParent(1,$values['CategoryID']);
	
	  if(sizeof($arrySubCategory)>0){
		  echo '<ul ><li>';
				
				
		echo '<table  border="0" cellspacing="0" cellpadding="5" class="menu_table" width="100%"><tr>';
		
		for($i=0;$i<sizeof($arrySubCategory);$i++) {
			if($i==4) break;
			$SubCatUrl = 'category.php?cat='.$arrySubCategory[$i]['CategoryID'].$StoreSuffix;
			$SubCategoryName= str_replace(" ","&nbsp;",stripslashes($arrySubCategory[$i]['Name']));
			
			echo '<td valign="top" class="menu_table_td" width="25%"><a href="'.$SubCatUrl.'" style="font-weight:bold;">'.$SubCategoryName.'</a>';
			
			$arrySubSubCategory = $objCategory->GetSubCategoryByParent(1,$arrySubCategory[$i]['CategoryID']);
			
			foreach($arrySubSubCategory as $key=>$SubSubValues){
				$SubSubCatUrl = 'category.php?cat='.$SubSubValues['CategoryID'].$StoreSuffix;

				echo '<div><a href="'.$SubSubCatUrl.'">'.stripslashes($SubSubValues['Name']).'</a></div>';
			}
			
			echo '</td>';
		}
		  
		echo '</tr></table>';
		
		echo '</li></ul>';
		
	  }
			
	echo '</li>';
	
	}
   
   ?>
    
   
     <li ><a href="special_offers.php"   <?=($LatestOffers==1)?('style="background:#000000;border-right:none;"'):('style="border-right:none;"')?>>Special&nbsp;offers</a></li>
  </ul>
  
  <script type="text/javascript">
<!--

var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
//-->
</script>
  </td>
  </tr>
<!--
  <tr>
    <td class="topnavbg">

	<ul>
    <li class="first"><a href="index.php" <?=($PageID==1)?('class="active"'):("")?>>Home</a></li>
	<?	/*
		foreach($arryTopCategory as $key=>$values){
			$cat_active = ($TopCatID==$values['CategoryID'])?('class="active"'):("");
			
			$CatUrl = 'category.php?cat='.$values['CategoryID'].$StoreSuffix;
			

			echo '<li class="first"><a href="'.$CatUrl.'" '.$cat_active.'>'.stripslashes($values['Name']).'</a></li>';
		}*/
	?>
    <li><a href="special_offers.php" <?=($LatestOffers==1)?('class="active"'):("")?>>Special&nbsp;offers</a></li>
    </ul>

</td>
</tr>
-->

  
 
  <tr>
    <td height="44" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="26%" align="left" valign="middle"><a href="whyus.php"><img src="images/why-us-icon.gif" alt="Why Us" border="0" /></a></td>
        <td width="28%" align="left" valign="middle"><a href="howtoorder.php"><img src="images/order-icon.gif" alt="How to Order" border="0" /></a></td>
        <td width="29%" align="left" valign="middle"><a href="specialrequest.php"><img src="images/special-request-icon.gif" alt="Special request" border="0" /></a></td>
        <td width="17%" align="left" valign="middle"><a href="wholesale.php"><img src="images/wholesale-icon.gif" alt="Wholesale" border="0" /></a></td>
      </tr>
    </table></td>
  </tr>
 </table> 


<table border="0" cellspacing="0" cellpadding="0" class="maintable">
<TR>
	  <TD  align="center" height="250" valign="top" <? if($PageID!=1){ echo 'class="midarea"';}?>>
	  
