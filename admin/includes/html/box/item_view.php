

 <table width="100%" border="0" cellpadding="3" cellspacing="1"  class="borderall">
                                                 
                                            
                              
<?php      
 //By Chetan 26Aug//
$head=1;
$arrayVal= $arryItem[0];
for($h=0;$h<sizeof($arryHead);$h++){?>
        <tr>
            <td colspan="8" align="left" class="head"><?=$arryHead[$h]['head_value']?></td>
        </tr>

<?php 

$arryField = $objField->getFormField('',$arryHead[$h]['head_id'],'1'); 
include("includes/html/box/viewCustomFieldsNew.php");
}
 //End//
?>			 
                                             
                                           

                                             
                                                
		
                                             
                                                
                                                
                                                  
                                                  

    				
                                                </table>
                                           


