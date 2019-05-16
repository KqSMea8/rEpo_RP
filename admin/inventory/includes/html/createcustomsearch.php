<div class="had">
Manage Search   &raquo; <span>

	<?php 	echo  "Generated Search" ; ?>

</span>
</div>
<?php  //echo "<pre/>";print_r($searchdata); die;?>
<form name="c_searchform"  action="" method="post">
<table width="100%" border="0" cellpadding="5" cellspacing="0">
 <tbody>
  <tr> 
        <td class="head" align="left" colspan="8"><?php if(isset($_POST['search_name'])) echo stripcslashes($_POST['search_name']);?></td>
    </tr>
<tr>
	  <td  valign="top">
     <?php if(!isset($_POST['go']) && empty($_SESSION['PostData'])){ ?>        
<table  border="0" cellpadding="3" cellspacing="0"  id="search_table" style="margin:0" >
  <tbody>

<tr>

      <?php if(!empty($searchdata)){
		foreach($searchdata as $value){?>
   
		<td valign="bottom">
                    <?php if($value['type'] == 'select'){ ?>
		<select style="width: 120px;" name="<?php echo $value['fieldname']?>" class="inputbox" id="<?php echo $value['fieldname']?>" >
		  <option value="">--- <?php echo $value['fieldlabel']?> ---</option>
                  <?php 
                    if($value['fieldname'] == 'CategoryID') { 
                        
                       echo $objCategory->getCategories(0, 0, $_GET['CatID']);
                    
                    }else{
                        
                        echo $csearch->selectOptions($value['fieldname'], $_POST['moduleID']);    
                        
                    }
                  ?>
		</select>		
      <?php } ?>   
                     <?php if($value['type'] == 'text'){ ?>
            <input id="<?php echo $value['fieldname']?>" name="<?php echo $value['fieldname']?>" size="15"  class="textbox" value="<?=$_GET['keyword']?>"  type="text" placeholder="Search by <?php echo $value['fieldlabel']?>" > 	

                     <?php }?>
                    
		</td>
   
      <?php }
	}
 ?>
                <td align="right" valign="bottom"> <input name="go" type="submit" class="search_button" value="Go"  /></td>
</tr>
    
   </tbody>  
    </table>
  <?php }?> 
   
   
    
    </td>
</tr>

<tr><td>
<?php if(isset($_POST['go']) || isset($_SESSION['PostData'])){ ?>
<div style="width: 100%;" class="double-scroll">
<table align="center" cellspacing="1" cellpadding="3" width="100%" id="list_table">
    <tbody>
    <tr align="left">
    <?php if(isset($clms)){
        $checked = explode(',',$postdata['checkboxes']);
        $numCheck = (in_array('4',$checked)) ? 1 : '';
        $numCheck = (in_array('5',$checked)) ? $numCheck +1 : $numCheck;
        $count = count($clms) + 2 + $numCheck;

        $tdwidth = round(100/$count,2);
        foreach ($clms as $key => $value) {
            echo '<td align="center" width="'.$tdwidth.'%"  class="head1" >'.$value['fieldlabel'].'</td>';
        }
        if(!empty($checked))
        {
            if(in_array('4',$checked))
            {
                echo '<td align="center" width="'.$tdwidth.'%"  class="head1" >Sales History</td>';
            }
            if(in_array('5',$checked))
            {
                echo '<td align="center" width="'.$tdwidth.'%"  class="head1" >Purchase History</td>';
            }
           
            echo '<td align="center" width="'.$tdwidth.'%"  class="head1" >Qty</td>
                 <td align="center" width="'.$tdwidth.'%"  class="head1">Avg Cost</td>'; 
            
        }   
    }
?>
    </tr>
   
    <?php 
  
    if(is_array($resArray) && count($resArray)>0){
  	$flag=true;
	$Line=0;
  	foreach($resArray as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;
        $itemType = $objItems->GetItemById($values['ItemID']);
	$values['itemType'] = (!empty($itemType)) ? $itemType[0][itemType] : '';
 ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>"> 
        <?php foreach ($clms as $key => $value) {?>
       <td align="center"><?php 
            if(!empty($values[$value['fieldname']])){
                if(!in_array($value['fieldname'], $csearch->showVal))
                { 
                    echo $values[$value['fieldname']];
                    if(strtolower($value['fieldname']) == 'sku')
                    {
                        echo $csearch->ShowIcons($checked,$values);   //To show Icons//
                    }    
                }else{ 
                    echo $csearch->selectedVal($values[$value['fieldname']],$value['fieldname']);
                }
        }else{
           echo NOT_SPECIFIED; 
        }
        ?>
       </td>
       <?php } 
       
        if(!empty($checked))
        { 
            if(in_array('4',$checked))
            {
                $time = explode(',',$postdata['saleDuration']);
    ?>            
        <td align="center" class="head1">
            <table><tr><td>
                <?php if($time[0]){ ?>
                        <a class="fancybox fancybox.iframe" href="viewSaleHistory.php?sku=<?=$values['Sku']?>&numHistory=<?php echo $time[0]?>d&pop=1"><?php echo $time[0]?>d</a>| 
                <?php }if($time[1]){ ?>
                        <a class="fancybox fancybox.iframe" href="viewSaleHistory.php?sku=<?=$values['Sku']?>&numHistory=<?php echo $time[1]?>m&pop=1"><?php echo $time[1]?>m</a>| 
                <?php }if($time[2]){ ?>        
                        <a class="fancybox fancybox.iframe" href="viewSaleHistory.php?sku=<?=$values['Sku']?>&numHistory=<?php echo $time[2]?>year&pop=1"><?php echo $time[2]?> year</a> 
                <?php } ?>   
                    </td></tr>
            </table>
        </td>
    <?php        }
            if(in_array('5',$checked))
            {
                $time = explode(',',$postdata['purDuration']);
    ?>
            <td align="center" class="head1">
            <table><tr><td>
                <?php if($time[0]){ ?>
                        <a class="fancybox fancybox.iframe" href="viewPOHistory.php?sku=<?=$values['Sku']?>&numHistory=<?php echo $time[0]?>d&pop=1"><?php echo $time[0]?>d</a>| 
                <?php }if($time[1]){ ?>
                        <a class="fancybox fancybox.iframe" href="viewPOHistory.php?sku=<?=$values['Sku']?>&numHistory=<?php echo $time[1]?>m&pop=1"><?php echo $time[1]?>m</a>| 
                <?php }if($time[2]){ ?>        
                        <a class="fancybox fancybox.iframe" href="viewPOHistory.php?sku=<?=$values['Sku']?>&numHistory=<?php echo $time[2]?>year&pop=1"><?php echo $time[2]?> year</a> 
                <?php } ?>   
                    </td></tr>
            </table>
        </td>
    <?php        
            }
                   
        }
    $Qty = '';
    $AvgCost = '';   
	$BId = $objbom->GetBomIdByItemId($values['ItemID']);
    if(($values['itemType'] == 'Kit') && ($BId!='')){ 
        
            $Arr = $objItems->GetKitItem($values['ItemID']);
            if(!empty($Arr))
            {
                    foreach($Arr as $sku)
                    {
                        $Total      =   $objItems->getAvgCostsofPurOrderbyID($sku['sku']);
                        $Qty       +=   $Total[0]['totalQty'];
                        $AvgCost   +=   $Total[0]['avgPrice'];
                    }
                
            }else{
                
                    $optionsArr = $objItems->getOptionCode($values['ItemID']);
                    if(!empty($optionsArr))
                    {
                        foreach($optionsArr as $option)
                        {
                            $ItemsArr   =   $objItems->GetOptionCodeItem($option['optionID']);
                            $Total      =   $objItems->getAvgCostsofPurOrderbyID($ItemsArr[0]['sku']);
                            $Qty       +=   $Total[0]['totalQty'];
                            $AvgCost   +=   $Total[0]['avgPrice'];
                        }
                    }    
            }    
    }
    ?>   
    <td align="center" ><?php echo ($Qty) ? $Qty : NOT_SPECIFIED; ?>  </td>
    <td align="center" ><?php echo ($AvgCost) ? $AvgCost : NOT_SPECIFIED; ?>  </td>    
       
    </tr>
        <?php }  // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="<?=$count?>" class="no_record">No Records Found</td>
    </tr>
    <?php } ?>
  
    </tbody>
    <tr>
            <td colspan="11">Total Record(s) : &nbsp;<?php echo $num; ?> <?php if (count($resArray) > 0) { ?>
            &nbsp;&nbsp;&nbsp; Page(s) :&nbsp; <?php echo $pagerLink;
            }
            ?></td>
    </tr>
  </table>
</div>
<?php }?>
        
    </td>
</tr>



   <tr>
    <td  align="center">
	
<?
(!isset($postdata['saleduration']))?($postdata['saleduration']=""):("");
(!isset($postdata['purduration']))?($postdata['purduration']=""):("");
(!isset($postdata['search_name']))?($postdata['search_name']=""):(""); 
(!isset($postdata['moduleID']))?($postdata['moduleID']=""):(""); 
(!isset($postdata['columns']))?($postdata['columns']=""):(""); 
(!isset($postdata['displayCol']))?($postdata['displayCol']=""):(""); 
(!isset($postdata['userids']))?($postdata['userids']=""):(""); 
(!isset($postdata['role']))?($postdata['role']=""):(""); 
(!isset($postdata['shsopopop']))?($postdata['shsopopop']=""):(""); 
(!isset($postdata['currency']))?($postdata['currency']=""):(""); 
(!isset($postdata['checkboxes']))?($postdata['checkboxes']=""):(""); 
(!isset($postdata['search_ID']))?($postdata['search_ID']=""):("");    
?>
	<input type="hidden" name="saleDuration" value="<?php echo $postdata['saleduration']?>" />
        <input type="hidden" name="purDuration" value="<?php echo $postdata['purduration']?>" />
        <input name="search_name" type="hidden" class="inputbox" id="searchname " value="<?php echo $postdata['search_name']; ?>" />
	<input name="moduleID"    type="hidden" class="inputbox" id="moduleID "   value="<?php echo $postdata['moduleID']; ?>" />
	<input name="columns"  type="hidden" class="inputbox" id="columns"  value="<?php echo $postdata['columns']; ?>" />
	<input name="displayCol"  type="hidden" class="inputbox" id="displayCol"  value="<?php echo $postdata['displayCol']; ?>" />
	<input name="userids" type="hidden" class="inputbox" id="userids" value="<?php echo $postdata['userids'];?>" />
	<input name="role" type="hidden" class="inputbox" id="role" value="<?php echo $postdata['role'];?>" />
	<input name="showsopopop" type="hidden" class="inputbox" id="showsopopop" value="<?php echo $postdata['shsopopop'];?>" />
	<input name="currency" type="hidden" class="inputbox" id="currency" value="<?php echo $postdata['currency'];?>" /><!--Add by CHETAN ON 1feb-->
        <input type="hidden" name="checkboxes" value="<?php echo $postdata['checkboxes']?>" />
        <input name="Save" type="submit" class="button" id="SubmitButton" value="Save" />
        <input name="Cancel" type="button" class="button" onclick="window.location.href='viewCustomSearch.php?curP=1'" value="Cancel"  />
        <input type="hidden" name="search_ID" id="report_ID" value="<?php echo $postdata['search_ID']?>" />
        

</td>

   </tr>
   
</tbody>
</table>
   
   
</form>

