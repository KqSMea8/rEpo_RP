<?
	require_once("includes/settings.php"); 
	#require_once("settings.php"); 
	
	//echo $MetaTitle;die;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE><?=$MetaTitle?></TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<?=$MetaDescription?>
<?=$MetaKeywords?>
<link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'></link>
<link href="<?=$Config['Url']?>css/front-style.css" rel="stylesheet" type="text/css"></link>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<link href="../rater/rater.css" rel="stylesheet" type="text/css"></link>

<script type="text/javascript" langage="javascript">
var GlobalSiteUrl = '<?=$Config['Url']?>';
function stoperror()
    {
        return true;
    }
window.onerror=stoperror;
if (document.images) 
{
   img_icon1 = new Image();
   img_icon1.src = "images/easy_hover_03.jpg";
}
function ChangeCurrency(){
	var SendCurrUrl = document.getElementById("CurrActionUrl").value+"curr_id="+document.getElementById("top_currency_id").value;
	location.href = SendCurrUrl;

}

</script>

<link href="../treeview/jquery.treeview.css" rel="stylesheet" type="text/css" />


<script type="text/javascript" src="../fancybox/lib/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="../js/1.7.2-jquery.js"></script>
<script language="javascript" src="../includes/ecom_global.js"></script>
<script language="javascript" src="../includes/ecom_ajax.js"></script>
<script language="javascript" src="../language/english.js"></script>
<script type="text/javascript" src="../fancybox/source/jquery.fancybox.js?v=2.1.5"></script>

<link rel="stylesheet" type="text/css" href="../fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />



<script language="javascript" src="../js/jquery.jcarousel.min.js"></script>
<script language="javascript" src="../js/validation.js"></script>
<script language="javascript" src="../js/checkout.js"></script>
<script language="javascript" src="../js/tabbar.js" type="text/javascript"></script>
<script language="javascript" src="../rater/jquery.rater-custom.js"></script>

<script type="text/javascript" src="../treeview/jquery-1.5.1.min.js"></script>

<script type="text/javascript" src="../treeview/jquery.treeview.min.js"></script>
<script src="../js/jquery.cookie.js"></script>
<script src="../fancybox/jquery_calender/jquery-ui.js"></script>
<script>
 var w = $.noConflict();
</script>

</HEAD>
<body>
    
<div class="wrapper dashboard">
<div class="mid_wraper">
    <div class="top-nav clearfix">
      <ul>
        <!--<li class="cart_contents"><a href="cart.php">Cart Contents</a></li>-->
        <?php if(!empty($_SESSION['Cid'])){?>
        <li>Welcome <?=$_SESSION['Name'];?></li>
        <li class="my_account"><a href="account.php">My Account</a></li>
        <li class="logout"><a href="logout.php">Logout</a></li>
        <?php }else{?>
        <li class="login"><a href="login.php">Login</a></li>
        <li class="register"><a href="register.php">Register</a></li>
        <?php }?>
      </ul>
    </div>
  </div>    
  <div class="header-container">
    <div class="mid_wraper">
         <?
        if($arryCompany[0]['Image'] !='' && file_exists('upload/company/'.$arryCompany[0]['Image']) ){
                $SiteLogo = 'resizeimage.php?w=120&h=120&bg=f1f1f1&img=upload/company/'.$arryCompany[0]['Image'];
        }else{
                $SiteLogo = '../images/logo.png';
        }
		?>	
      <div class="logo"><a href="index.php"><img src="<?=$SiteLogo?>" alt="<?=$Config['SiteName']?>" title="<?=$Config['SiteName']?>" border="0" /></a></div>
      <div class="header-right-pen">
        <form>
          <ul>
            <!--<li class="languages"><span>Languages</span>
              <div class="sel-wrap-friont">
                <select>
                  <option>English</option>
                </select>
              </div>
             
            </li>-->
            <li class="currencies"><span>Currencies</span>
              <div class="sel-wrap-friont">
               <select name="top_currency_id" class="currency" id="top_currency_id" onchange="Javascript:ChangeCurrency();"  >
                <? for($i=0;$i<sizeof($arryTopCurrency);$i++) {?>
                  <option value="<?=$arryTopCurrency[$i]['currency_id']?>" <?  if($arryTopCurrency[$i]['currency_id']==$_SESSION['currency_id']){echo "selected";}?>><?=$arryTopCurrency[$i]['name']?></option>
                <? } ?>
            </select>	
                  <input type="hidden" name="CurrActionUrl" id="CurrActionUrl" value="<?=$CurrActionUrl;?>"></input>
              </div>
            </li>
            <li class="shoppingcart"> <span>Shopping Cart</span> <a href="cart.php"><?php if($arryNumCart[0]['NumCartItem'] >0){echo $arryNumCart[0]['NumCartItem'];}else{echo "0";}?> item</a></li>
          </ul>
        </form>
      </div>
    </div>
  </div>  
