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
	  <? foreach($arryBrand as $key=>$values){ 
	  		$PrdLink   = 'products.php?brand='.$values['brandID'].'&cat='.$_GET['cat'].$StoreSuffix;
			echo '<li><a href="'.$PrdLink.'">'.stripslashes($values['heading']).'</a></li>';

	  } ?>
    </ul></td>
  </tr>
  <? } ?>
  
   <? if(sizeof($arryProductStyles)>0){ ?>
  <tr>
    <td align="left" valign="top" class="leftnav"><ul>
      <li>
        <h1>Style</h1>
      </li>
      <? foreach($arryProductStyles as $key=>$values){ 
	  		$PrdLink   = 'products.php?cat='.$_GET['cat'].'&style='.stripslashes($values['ProductStyle']).$StoreSuffix;
			echo '<li><a href="'.$PrdLink.'">'.stripslashes($values['ProductStyle']).'</a></li>';

	  } ?>
    </ul></td>
  </tr>
   <? } ?>
   
     <? if(sizeof($SizeArray)>0){ ?>
  <tr>
    <td align="left" valign="top" class="leftnav"><ul>
      <li>
        <h1>Size</h1>
      </li>
      <? 
	  foreach($SizeArray as $temp_size){ 
	  		$PrdLink   = 'products.php?cat='.$_GET['cat'].'&size='.stripslashes($temp_size).$StoreSuffix;
			echo '<li><a href="'.$PrdLink.'">'.stripslashes($temp_size).'</a></li>';
	  }
	  ?>
    </ul></td>
  </tr>
     <? } ?>
	 
  <tr>
    <td align="left" valign="top" class="leftnav"><ul>
      <li>
        <h1>Price <?=$arryCurrency[0]['symbol_left']?> <?=$arryCurrency[0]['symbol_right']?></h1>
      </li>
      <?
	  
	  
	  
	  
	  
	  
	  
		$PrdLink   = 'products.php?cat='.$_GET['cat'].$StoreSuffix.'&price=';
		echo '<li><a href="'.$PrdLink.'10-20">10-20</a></li>';
		echo '<li><a href="'.$PrdLink.'20-30">20-30</a></li>';
		echo '<li><a href="'.$PrdLink.'30-50">30-50</a></li>';
		echo '<li><a href="'.$PrdLink.'50-75">50-75</a></li>';
		echo '<li><a href="'.$PrdLink.'75-100">75-100</a></li>';
		echo '<li><a href="'.$PrdLink.'100-150">100-150</a></li>';
		echo '<li><a href="'.$PrdLink.'150-200">150-200</a></li>';
		echo '<li><a href="'.$PrdLink.'200-500">200-500</a></li>';
		echo '<li><a href="'.$PrdLink.'500">500+</a></li>';
	  ?>
    </ul></td>
  </tr>
  <? if($_GET['StoreID']>0){ ?>
  <!--
  <tr>
    <td height="90" align="center" valign="bottom"><a href="category.php?StoreID=<?=$_GET['StoreID']?>"><img src="images/shopotherthing.jpg" alt="Shop other" border="0" /></a></td>
  </tr>-->
  <? } ?>
</table>
