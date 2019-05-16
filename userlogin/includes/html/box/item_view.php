

 <table width="100%" border="0" cellpadding="3" cellspacing="1"  class="borderall">
                                                 
                                            
                                                    <tr>
                                                      
                                                        <td  width="20%" align="right"   class="blackbold" >SKU : </td>
                                                        <td   align="left" width="25%">
                                                            <? echo stripslashes($arryItem[0]['Sku']); ?> </td>
                                                   
                                                        <td  align="right"   class="blackbold" width="25%">Item Name : </td>
                                                        <td   align="left">
                                                            <? echo stripslashes($arryItem[0]['description']); ?> </td>
                                                    </tr>
                                <tr>
                                                <td  align="right"   class="blackbold" >Price :   </td>
                                                <td   align="left">
                                                  
   

     <? echo $arryItem[0]['sell_price'];?>  <?=$Config['Currency']?>                           
                                                        
                                                        </td>

                                                <td  align="right"   class="blackbold" >Qty on Hand :   </td>
                                                <td   align="left">
                                                  
      

   <? echo $arryItem[0]['qty_on_hand']; ?>
			
		
                                                     
                                                        </td>
                                            </tr>
				 
                                             
                                           
<tr>
<td align="right"  valign="top"  class="blackbold"> Item Image :</td>
<td  align="left" valign="top" >

 <?   
	$PreviewArray['Folder'] = $Config['Items'];
	$PreviewArray['FileName'] = $arryItem[0]['Image'];  
	$PreviewArray['FileTitle'] = stripslashes($arryItem[0]['Sku']);
	$PreviewArray['Width'] = "120";
	$PreviewArray['Height'] = "120";
	$PreviewArray['Link'] = "1";
 
	echo '<div id="ImageDiv">'.PreviewImage($PreviewArray).'</div>'; 

?>


 
	

</td>

                                                        <td align="right"  valign="top"  class="blackbold">Status :  </td>
                                                        <td  align="left" valign="top" ><span class="blacknormal">
                                                                <?
                                                              if ($arryItem[0]['Status'] == 1) {
                                                                        $ActiveChecked = ' Active';
                                                              }
                                                            else {
                                                                $ActiveChecked="Inactive";
                                                            }
                                                                ?>
                                                                <?= $ActiveChecked ?>
                                                                </td>
                                                    </tr>
                                             
                                                
		
                             <tr>
                                                <td  align="right"   class="blackbold" valign="top">Description :   </td>
                                                <td   align="left" valign="top" colspan="3">
                                                  

<?=(!empty($arryItem[0]['long_description']))?(nl2br(stripslashes($arryItem[0]['long_description']))):(NOT_SPECIFIED)?>			
		
                                                     
                                                        </td>
                                            </tr>                     
                                                
                                                
                                                  
                                                  
    		                    </tbody>
    				</table>
                                                                </td>
                                                               </tr>



                                                  

                                                 
                                                </table>
                                           


