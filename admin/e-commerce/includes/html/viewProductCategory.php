<script language="javascript1.2">
function submitThisForm(frm){	
	document.topForm.submit();
}

function ShowHideMenu(id){
	 var totalMenus = document.getElementById("Line").value;
	
	 for(var i=1;i<=totalMenus;i++){
	 
	  if(i==id){
	   if(document.getElementById("sub"+id).style.display == 'inline' ){
		document.getElementById("sub"+id).style.display = 'none';
	   }else{
		document.getElementById("sub"+id).style.display = 'inline';
	   }
	  }else{
		document.getElementById("sub"+i).style.display = 'none';
	  }
	  
	  
	 }
 
}	



function ShowHideSubMenu(id){
	 var totalMenus = document.getElementById("SubLine").value;
	
	 for(var i=1;i<=totalMenus;i++){
	 
	  if(i==id){
	   if(document.getElementById("subsub"+id).style.display == 'inline' ){
		document.getElementById("subsub"+id).style.display = 'none';
	   }else{
		document.getElementById("subsub"+id).style.display = 'inline';
	   }
	  }else{
		document.getElementById("subsub"+i).style.display = 'none';
	  }
	  
	  
	 }
 
}



function ShowHideSubLastMenu(id){
	 var totalMenus = document.getElementById("SubLastLine").value;
	
	 for(var i=1;i<=totalMenus;i++){
	 
	  if(i==id){
	   if(document.getElementById("subsublast"+id).style.display == 'inline' ){
		document.getElementById("subsublast"+id).style.display = 'none';
	   }else{
		document.getElementById("subsublast"+id).style.display = 'inline';
	   }
	  }else{
		document.getElementById("subsublast"+i).style.display = 'none';
	  }
	  
	  
	 }
 
}


function ShowHideSubSubLastMenu(id){
	 var totalMenus = document.getElementById("SubSubLastLine").value;
	
	 for(var i=1;i<=totalMenus;i++){
	 
	  if(i==id){
	   if(document.getElementById("subsubsublast"+id).style.display == 'inline' ){
		document.getElementById("subsubsublast"+id).style.display = 'none';
	   }else{
		document.getElementById("subsubsublast"+id).style.display = 'inline';
	   }
	  }else{
		document.getElementById("subsubsublast"+i).style.display = 'none';
	  }
	  
	  
	 }
 
}


</script>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	 <tr>
    <td  valign="top"  >
		
	<div class="had">Manage Products</div>
		
		
		
	    </td>
  </tr>
	
	 <tr>
    <td  valign="top" >&nbsp;
		

	    </td>
  </tr>


  
	<tr>
	  <td valign="top" height="200" >
	  
 
	  
	    <table width="90%" align="center" cellpadding="0" cellspacing="0" class="borderall" border="0">
        <tr align="left" valign="middle" >
          <td width="37%" height="20" class="head1" >
             
           &nbsp;Choose Category</td>
        </tr>
		
	<?  if(sizeof($arryCategory)>0){ ?>
		 <tr>
		 <td valign="top" colspan="2" style="padding-left:20px;">
		 
		
       
  	<?
	
	$flag=true;
	
	 $Line = 0;
	 $SubLine = 0;
	 $SublastLine = 0;
	 $SubSubLastLine = 0;
  	foreach($arryCategory as $key=>$values){
		$flag=!$flag;
			//$bgcolor=($flag)?(""):("#eeeeee");
		$Line++;
		
		$arrySubCategory = $objCategory->GetSubCategoryByParent(1,$values['CategoryID']);
			
		if(sizeof($arrySubCategory)>0) {
			$CatUrl = "Javascript:ShowHideMenu('".$Line."')";
		}else{
			$CatUrl = 'viewProduct.php?CatID='.$values['CategoryID'];
		}
			  
	echo '<div class="cat_main"><a href="'.$CatUrl.'" ><b>'.stripslashes($values['Name']).'</b></a></div>'; 	  

		$displayNone = ($_GET['CatID']!=$values['CategoryID'])?('style="display:none"'):("");

		echo '<div id="sub'.$Line.'" '.$displayNone.' >';
	
		if(sizeof($arrySubCategory)>0){ 
			foreach($arrySubCategory as $key=>$values_sub){ 
			
				$SubLine++;
				$arrySubSubCategory = $objCategory->GetSubSubCategoryByParent(1,$values_sub['CategoryID']);
				
				if(sizeof($arrySubSubCategory)>0) {
					$SubCatUrl = "Javascript:ShowHideSubMenu('".$SubLine."')";
				}else{
					$SubCatUrl = 'viewProduct.php?CatID='.$values_sub['CategoryID'];
				}
			
				echo '<div class="sub_cat_main">&raquo; <a href="'.$SubCatUrl.'" ><b>'.stripslashes($values_sub['Name']).'</b></a></div>';
				
				$SubdisplayNone = ($_GET['CatID']!=$values_sub['ParentID'])?('style="display:none"'):("");

				echo '<div id="subsub'.$SubLine.'" '.$SubdisplayNone.' >';
					if(sizeof($arrySubSubCategory)>0){ 
						foreach($arrySubSubCategory as $key=>$values_sub_sub){ 
							$SublastLine++;
							$arrySubLastCategory = $objCategory->GetSubSubCategoryByParent(1,$values_sub_sub['CategoryID']);
									
							if(sizeof($arrySubLastCategory)>0) {
								$SubSubCatUrl = "Javascript:ShowHideSubLastMenu('".$SublastLine."')";
							}else{
								$SubSubCatUrl = 'viewProduct.php?CatID='.$values_sub_sub['CategoryID'];
							}

							echo '<div class="sub_cat_main" style="padding-left:40px;">&raquo; <a href="'.$SubSubCatUrl.'" ><b>'.stripslashes($values_sub_sub['Name']).'<b></a></div>';
							
							$SubLastdisplayNone = ($_GET['CatID']!=$values_sub['ParentID'])?('style="display:none"'):("");

							echo '<div id="subsublast'.$SublastLine.'" '.$SubLastdisplayNone.' >';
							if(sizeof($arrySubLastCategory)>0) {
								foreach($arrySubLastCategory as $key=>$values_sub_last){ 
									$SubSubLastLine++;
									$arrySubSubLastCategory = $objCategory->GetSubSubCategoryByParent(1,$values_sub_last['CategoryID']);
								
									if(sizeof($arrySubSubLastCategory)>0) {
										$SubLastCatUrl = "Javascript:ShowHideSubSubLastMenu('".$SubSubLastLine."')";
									}else{
										$SubLastCatUrl = 'viewProduct.php?CatID='.$values_sub_last['CategoryID'];
									}
									
									echo '<div class="sub_cat_main" style="padding-left:50px;"> - <a href="'.$SubLastCatUrl.'" ><b>'.stripslashes($values_sub_last['Name']).'</b></a></div>';
									
									$SubSubLastdisplayNone = ($_GET['CatID']!=$values_sub_last['ParentID'])?('style="display:none"'):("");								
									echo '<div id="subsubsublast'.$SubSubLastLine.'" '.$SubSubLastdisplayNone.' >';
									foreach($arrySubSubLastCategory as $key=>$values_subsub_last){ 
										$SubSubLastCatUrl = 'viewProduct.php?CatID='.$values_subsub_last['CategoryID'];
										echo '<div class="sub_cat_main" style="padding-left:80px;"> - <a href="'.$SubSubLastCatUrl.'" >'.stripslashes($values_subsub_last['Name']).'</a></div>';

									}
									echo '</div>';
									
									
	
								}
							}
							echo '</div>';
							
							
							
						}
					}
				echo '</div>';
				
				
			} 
			
			 
		} 



		echo '</div>';
?>


		
		
		
       	 <? } // foreach end //?>
		
		</td>
        </tr>
		
        <? }else{?>
        <tr align="center" >
          <td height="20" colspan="2" class="blacknormal">
            No Category Found. </td>
        </tr>
        <? } ?>
		
		
		

      </table>
	  
	  
	  
	  
	  
	  </td>
	</tr>
	
	
</table>

<input type="hidden" name="Line" id="Line" value="<?=$Line?>">
<input type="hidden" name="SubLine" id="SubLine" value="<?=$SubLine?>">
<input type="hidden" name="SubLastLine" id="SubLastLine" value="<?=$SublastLine?>">
<input type="hidden" name="SubSubLastLine" id="SubSubLastLine" value="<?=$SubSubLastLine?>">
