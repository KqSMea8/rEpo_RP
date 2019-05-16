<?
	$arryPriceRange=$objProduct->GetPriceRange();
?>
<form name="left_form" action="products.php" method="get">
<input type="hidden" name="cat" value="<?=$_GET['cat']?>" />
<input type="hidden" name="StoreID" value="<?=$_GET['StoreID']?>" />
<input type="hidden" name="curP" value="<?=$_GET['curP']?>" />

<table width="197" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="leftnavheader">Refine by</td>
  </tr>
  <? if($numBrand>0){ ?>
  <tr>
    <td align="left" valign="top" class="leftnav"><ul>
      <li>
        <h1>Brand</h1>
      </li>
	  <? 
	  $Line=0;
	  foreach($arryBrand as $key=>$values){ 
	  $Line++;
	  		/*$PrdLink   = 'products.php?brand='.$values['brandID'].'&cat='.$_GET['cat'].$StoreSuffix;
			echo '<li><a href="'.$PrdLink.'">'.stripslashes($values['heading']).'</a></li>';*/
			
			
			$sel = ($_GET['br'.$Line]==$values['brandID'])?(" checked"):("");

			echo '<li><input type="checkbox" name="br'.$Line.'" value="'.$values['brandID'].'" '.$sel.'>'.stripslashes($values['heading']).'</li>';

	  } ?>
    </ul>
	<input type="hidden" name="nbr" value="<?=$Line?>" />
	
	</td>
  </tr>
  <? } ?>
  
   <? if(sizeof($arryProductStyles)>0){ ?>
  <tr>
    <td align="left" valign="top" class="leftnav"><ul>
      <li>
        <h1>Style</h1>
      </li>
      <? 
	  $Line=0;
	  foreach($arryProductStyles as $key=>$values){ 
	  $Line++;
	  		/*$PrdLink   = 'products.php?cat='.$_GET['cat'].'&style='.stripslashes($values['ProductStyle']).$StoreSuffix;
			echo '<li><a href="'.$PrdLink.'">'.stripslashes($values['ProductStyle']).'</a></li>';*/
			
			$sel = ($_GET['st'.$Line]==stripslashes($values['ProductStyle']))?(" checked"):("");

			echo '<li><input type="checkbox" name="st'.$Line.'" value="'.stripslashes($values['ProductStyle']).'" '.$sel.'>'.stripslashes($values['ProductStyle']).'</li>';

	  } ?>
    </ul>
	<input type="hidden" name="nst" value="<?=$Line?>" />
	
	</td>
  </tr>
   <? } ?>
   
     <? if(sizeof($SizeArray)>0){ ?>
  <tr>
    <td align="left" valign="top" class="leftnav"><ul>
      <li>
        <h1>Size</h1>
      </li>
      <? 
	  $Line=0;
	  foreach($SizeArray as $temp_size){ 
	  $Line++;
	  		/*$PrdLink   = 'products.php?cat='.$_GET['cat'].'&size='.stripslashes($temp_size).$StoreSuffix;
			echo '<li><a href="'.$PrdLink.'">'.stripslashes($temp_size).'</a></li>';*/
			
			$sel = ($_GET['sz'.$Line]==stripslashes($temp_size))?(" checked"):("");
			
			echo '<li><input type="checkbox" name="sz'.$Line.'" value="'.stripslashes($temp_size).'" '.$sel.'>'.stripslashes($temp_size).'</li>';
			
	  }
	  ?>
    </ul>
	<input type="hidden" name="nsz" value="<?=$Line?>" />
	</td>
  </tr>
     <? } ?>
	 
  <tr>
    <td align="left" valign="top" class="leftnav"><ul>
      <li>
        <h1>Price <?=$arryCurrency[0]['symbol_left']?> <?=$arryCurrency[0]['symbol_right']?></h1>
      </li>
      <?
		/*$PrdLink   = 'products.php?cat='.$_GET['cat'].$StoreSuffix.'&price=';
		
		echo '<li><a href="'.$PrdLink.'10-20">10-20</a></li>';
		echo '<li><a href="'.$PrdLink.'20-30">20-30</a></li>';
		echo '<li><a href="'.$PrdLink.'30-50">30-50</a></li>';
		echo '<li><a href="'.$PrdLink.'50-75">50-75</a></li>';
		echo '<li><a href="'.$PrdLink.'75-100">75-100</a></li>';
		echo '<li><a href="'.$PrdLink.'100-150">100-150</a></li>';
		echo '<li><a href="'.$PrdLink.'150-200">150-200</a></li>';
		echo '<li><a href="'.$PrdLink.'200-500">200-500</a></li>';
		echo '<li><a href="'.$PrdLink.'500">500+</a></li>';
		*/
		 
	  $Line=0;
	  foreach($arryPriceRange as $key=>$values){ 
	  $Line++;
		   /*$PrdLink   = 'products.php?cat='.$_GET['cat'].$StoreSuffix.'&price='.$values['value'];
			echo '<li><a href="'.$PrdLink.'">'.$values['value'].'</a></li>';*/
			
			
			$sel = ($_GET['pr'.$Line]==$values['value'])?(" checked"):("");

			echo '<li><input type="checkbox" name="pr'.$Line.'" value="'.$values['value'].'" '.$sel.'>'.$values['range'].'</li>';

	  } ?>
    </ul>
	<input type="hidden" name="npr" value="<?=$Line?>" />
	
	</td>
  </tr>
  <tr>
    <td class="leftnav" height="60">
	
	<input type="submit" name="rf" id="rf" value="Search" class="searchbutton" style="margin-right:20px;"/>
	</td>
  </tr>

</table>
</form>