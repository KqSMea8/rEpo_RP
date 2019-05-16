<style>
/*update by chetan 15July */
/* popups without javascript */
/* showing popup background 
a.popup:target { display: block; }

/* showing popup
a.popup:target + div.popup { display: block; }*/

/* popup target anchor and background */
div.popupback {
	/* background is initially hidden */
	display		: none;
	position	: fixed;
	top		: 0;
	left		: 0;
	z-index		: 3; /* anything, really, but bigger than other elements on the page */
	width		: 100%;
	height		: 100%;
	background	: rgba(0, 0, 0, 0.2);
	cursor		: default;
}

/* popup window */
div.popup {
	/* popup window is initially hidden */
	display 	: none;
	border-radius	: 5px;
	background	: #fff;
	width		: 250px; /* width */
	position	: fixed;
	top		: 10%;
	left		: 0;
        right		: 0;
	margin		: auto;
	z-index		: 4; /* z-index of popup backgroung + 1 */
	padding		: 10px;
	-webkit-box-sizing : border-box;
	-moz-box-sizing	: border-box;
	-ms-box-sizing	: border-box;
	box-sizing	: border-box;
}

.popup-heading{padding:0px; }
.popup-heading h2 {
    background: #e1e1e1 none repeat scroll 0 0;
    font-size: 11px;
    font-weight: bold;
    line-height: 8px;
    margin: 0;
    padding: 10px;
    text-align: center;
}

/* links to close popup */
.close{margin:0px; padding:0px; text-align:right;}
.close a{margin:0px; padding:0px; text-align:right; font-size:12px;cursor:pointer}

/*update by ashvani/chetan on 9aug */
.head1 a.fancybox {
    display: inline-block;
    vertical-align: text-top;
}
.head1 a.fancybox span {
    display: block;
}

td.head1.sales-histry a {
    display: inline-block;
    padding: 0px 5px;
    position: relative;
    background: #106db2;
    color: #fff;
}
td.head1.sales-histry a + a:before {
    position: absolute;
    content: "";
    width: 1px;
    height: 100%;
    background: #fff;
    top: 0px;
    left: 0px;
    bottom: 0px;
    margin: auto;
}
td.head1.sales-histry a > span {
    display: block;
    border-top: 1px solid #fff;
    background: #d33f3e;
    margin: 0px -5px;
}
td.head1.sales-histry a > span:empty {
    display: none;
}




.bom1 {

background: rgb(211, 63, 62) none repeat scroll 0px 0px; color: rgb(255, 255, 255); display: inline-block; padding: 0px 5px; position: relative;  text-align:center;height: 68px;



}
.bom2 {

background: yellow none repeat scroll 0px 0px; color: rgb(255, 255, 255); display: inline-block; padding: 0px 5px; position: relative; text-align:center;height: 68px;



}
.bom3 {

background: green none repeat scroll 0px 0px; color: rgb(255, 255, 255); display: inline-block; padding: 0px 5px; position: relative; text-align:center;height: 68px;



}
.Allbom {

background: #106db2 none repeat scroll 0px 0px; color: rgb(255, 255, 255); display: inline-block; padding: 0px 5px; position: relative; color: #fff;width:49px;text-align:center;min-height: 82px;/*height: 68px; updated by chetan20Mar2017*/



}

.bom1 a{
display: inline-block;
    padding: 0px 0px;
    position: relative;
   
    color: #fff;

}
.bom2 a{
display: inline-block;
    padding: 0px 0px;
    position: relative;
    
    color: black;

}
.bom3 a{
display: inline-block;
    padding: 0px 0px;
    position: relative;
    
     color: #fff;

}
/*End*/

table td {
    position:relative;
}
.tooltip {
    width:200px;
    height:100px;
    padding:20px;
    border:1px solid red;
    box-shadow: 0 0 3px rgba(0,0,0,.3);
    -webkit-box-shadow: 0 0 3px rgba(0,0,0,.3);
    border-radius:3px;
    -webkit-border-radius:3px;
    position:absolute;
    top:5px;
    left:50px;
    display:none;
}
.bom3 i, .bom2 i, .bom1 i {
    display: block;
    text-align: center;
}


.color-box {
    float: left;
    width: 240px;
}

.boom-table {
    position: fixed;
    top: -500px;
    width: 520px;
    left: 0px;
    right: 0px;
    margin: auto;
    background: #fff;
    padding: 15px;
    box-shadow: 0px 0px 6px #000;
    border-radius: 4px;
    z-index: 99;
    transition: .5s;
    overflow:auto;
    max-height:414px;	
}
.boom-table.active {
    display:block;
    top: 20%;
}
.overlay-div {
    position: fixed;
    z-index: 99;
    background: rgba(0, 0, 0, 0.8);
    top: 0px;
    left: 0px;
    width: 100%;
    height: 100%;
    display:none;
}
.overlay-div.active {
    display:block;
}
button.boom-close {
    position: absolute;
    z-index: 99;
    right: 0px;
    top: 0px;
    font-size: 25px;
    width: 30px;
    cursor: pointer;
}

.bom1, .bom2, .bom3 {
    box-sizing: border-box;
    height: auto;
    min-height: 82px;
}


</style>
<script>
$(function(){

	$('.showpopup').click(function(){
		$('.popupback').show();
		$(this).nextAll('div:eq(1)').show();
	})
	$('.close').click(function(){
		$(this).parent('div').hide();
		$('.popupback').hide();
	})
});

$(function(){
    $('.link').hover(
        function(){
            $(this).next().show();
        },
        function(){
            $(this).next().hide();   
        }
    )   
})

//Added 6feb by chetan/updated 17feb//
jQuery(document).ready(function() {
	jQuery(".boom-active").click(function(){
		$id = $(this).attr('id');
		jQuery("#boom-overlay"+$id+", #boom"+$id+"").addClass("active");
	});
	jQuery("button.cross-close").click(function(){
		$id = $(this).attr('id');
		jQuery("#boom-overlay"+$id+", #boom"+$id+"").removeClass("active");
	});
	jQuery(".fprice-active").click(function(){
		jQuery(this).closest('td').find(".fpricediv,.fprice").addClass("active");
	});
	jQuery("button.fprice-close").click(function(){
		jQuery(this).closest('td').find(".fpricediv,.fprice").removeClass("active");
	});
});

//added by chetan on 12Apr//
function SetAutoComplete(elm){		
	$(elm).autocomplete({
		source: "../jsonSku.php",
		minLength: 1
	});

}
</script>

<?php 
if(isset($postdata)){
	$csearch->savecurrencyExchange($postdata['currency'],true);
}
?>
<?php if(isset($_GET['menu'])!=1){?>
<div class="back"><a class="back"  href="<?=$RedirectURL?>">Back</a></div>
<?php }?>
<div class="had">
<?php echo $Viewdata['search_name'] ?> Search   &raquo; <span>
</span>
</div>
<?php  //echo "<pre/>";print_r($resArray); ?>
<form name="c_searchform" id="c_searchform"  action="" method="post">
<table width="100%" border="0" cellpadding="5" cellspacing="0">
 <tbody>

<tr>
	  <td  valign="top">
         
<table  border="0" cellpadding="3" cellspacing="0"  id="search_table" style="margin:0" >
  <tbody>
<tr>
        <!--updated 20Mar2017-->
      <?php $fldvar = '';$fvar=''; //25July2018//
	if($_SESSION['searchdata'] || $searchdata){
	$inputdata = (isset($searchdata)) ? $searchdata : $_SESSION['searchdata'];
	foreach($inputdata as $value){ ?>
   	
                <?php 
		if($value['type'] == 'select'){ 
	        	$fldvar.= '<td valign="bottom"><select style="width:120px;" name="'.$value['fieldname'].'" class="inputbox" id="'.$value['fieldname'].'"><option value="">--- '.$value['fieldlabel'].' ---</option>';
                   
			if($value['fieldname'] == 'CategoryID') { 

			$PostDataCategoryID = (isset($_SESSION['PostData']['CategoryID']))?($_SESSION['PostData']['CategoryID']):('');

			$fldvar.= $objCategory->getCategoriesforCustomSearch(0, 0,$PostDataCategoryID);

			}else{
			
			$PostDatafieldname = (isset($_SESSION['PostData'][$value['fieldname']]))?($_SESSION['PostData'][$value['fieldname']]):('');

			$fldvar.= $csearch->selectOptions($value['fieldname'], $Viewdata['moduleID'], $PostDatafieldname);    
                        
                 	}
                  
			$fldvar.= '</select></td>';
      		 } 
               
		if($value['type'] == 'text'){ 

			

			//25July2018//
			if($value['fieldname'] == 'Sku'  || $value['fieldname'] == 'description'){		
		
            	$fvar.='<td valign="bottom"><input '.(($value['fieldname'] == 'description') ? 'style="width:300px"' : 'onclick="Javascript:SetAutoComplete(this);"' ).' id="'.$value['fieldname'].'" name="'.$value['fieldname'].'" size="15"  class="textbox" value="'.((isset($_POST[$value['fieldname']])) ? $_POST[$value['fieldname']] : '').'"  type="text" placeholder="'.$value['fieldlabel'].' Search"></td>'; 	
			 }else{ 

			$fldvar.= '<td valign="bottom"><input id="'.$value['fieldname'].'" name="'.$value['fieldname'].'" size="15"  class="textbox" value="'.((isset($_POST[$value['fieldname']])) ? $_POST[$value['fieldname']] : '').'"  type="text" placeholder="'.$value['fieldlabel'].' Search"></td>';

                	} 
		} 
	 } 

?>	
	<td colspan="6">
		<table style="margin-left:0px;">
			<tr>
				<?php echo $fvar; ?>
				<?
				if($fldvar == ""){
				?>
					<td align="right" valign="bottom"> <input name="go" type="submit" class="search_button" value="Go"  /></td>
				<? }else{ 
					$fldvar.= '<td align="right" valign="bottom"> <input name="go" type="submit" class="search_button" value="Go"/></td>';
				 }?>
			</tr>
		</table>
	</td>	

	 <? } ?>
</tr>

<?php if($fldvar != ""){
	
	echo "<tr style='display:block;'>".$fldvar."</tr>";
} ?>
    <!--End-->
    
   </tbody>  
    </table>
   
    
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
        $count = count($clms) + 2 + $numCheck;
        $tdwidth = round(100/$count,2);
        foreach ($clms as $key => $value) {     
            echo '<td align="center" width="'.$tdwidth.'%"  class="head1" >'.$value['fieldlabel'].'</td>';
        }
    }
?>
    </tr>
   
    <?php 
#print_r($resArray);
    if(is_array($resArray) && count($resArray)>0){
  	$flag=true;
	$Line=0;
  	foreach($resArray as $key=>$values){
	if(isset($values['sku'])) $values['Sku'] = $values['sku']; //26July2018//
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;
        $itemType = $objItems->GetItemById($values['ItemID']);
	$values['itemType'] = (!empty($itemType)) ? $itemType[0]['itemType'] : ''; 
 ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>"> 
    <?php foreach ($clms as $key => $value) {?>
    <td align="center"><?php 
        if(!empty($values[$value['fieldname']])  || $values[$value['fieldname']] == '0'){
            if(!in_array($value['fieldname'], $csearch->showVal))
            { 
                echo $values[$value['fieldname']];
                if(strtolower($value['fieldname']) == 'sku')
                {
                     echo $csearch->ShowIcons($checked,$values,$Line);   //To show Icons//
                }  
            }else{
                $res = $csearch->selectedVal($values[$value['fieldname']],$value['fieldname'], $values['ItemID']);
		echo ($res) ? $res : NOT_SPECIFIED;
            }
    }else{
       echo NOT_SPECIFIED; 
    }
    ?></td>
    <?php } 
       
        
    ?>
    
    </tr>
<!----Add by chetan on 11Jan----->
    <tr>
	<td colspan="8">
	<table align="center" cellspacing="1" cellpadding="3" width="100%" id="list_table">	
		<?//added by chetan on 13jan//
		
		$numCheck2 = 0;
		$numCheck2 = (in_array('4',$checked)) ? $numCheck2 +1 : $numCheck2;
		$numCheck2 = (in_array('5',$checked)) ? $numCheck2 +1 : $numCheck2;
		$numCheck2 = (in_array('6',$checked)) ? $numCheck2 +5 : $numCheck2;
		$numCheck2 = (in_array('7',$checked)) ? $numCheck2 +1 : $numCheck2;
		$numCheck2 = (in_array('8',$checked)) ? $numCheck2 +1 : $numCheck2;
		$count2 = $numCheck2;
		$td2width =0;
		if($count2 > 0){
			$td2width = round(100/$count2,2);
		}
		//End//
		$heads = ''; 
		if(in_array('6',$checked))
		{
			$heads .='<td align="center" width="'.($td2width-2).'%"class="head1">Condition</td>
				<td align="center"  width="'.($td2width+8).'%"class="head1">Stock</td>';
		}
		if(in_array('7',$checked))
		{
			$Stime = explode(',',$postdata['saleDuration']);
			$heads .='<td align="center" width="'.($td2width-7).'%"  class="head1" >On SO</td>';
		}
					if(in_array('6',$checked))
		{
			$heads .='<td align="center" width="'.($td2width-3).'%"class="head1">Available</td>
         			<td align="center" width="'.($td2width+8).'%"class="head1">Avg Cost['.$Config['Currency'].']</td>
				<td align="center" width="'.($td2width-2).'%"class="head1">Sell Price</td>';
		}
		
		if(in_array('8',$checked))
		{
			$Ptime = explode(',',$postdata['purDuration']);	
			$heads .='<td align="center" width="'.($td2width-4).'%"  class="head1" >On PO</td>';
		} 
		if(in_array('4',$checked))
		{
			$Stime = explode(',',$postdata['saleDuration']);
			$heads .='<td align="center" width="'.($td2width+5).'%"  class="head1" >Sales History</td>';
		}
		if(in_array('5',$checked))
		{
			$Ptime = explode(',',$postdata['purDuration']);	
			$heads .='<td align="center" width="'.($td2width+5).'%"  class="head1" >Purchase History</td>';
		}		
		?>
	</tr>
	<?
	if(in_array('3',$checked)) $serialNo =  '&serial=1'; else $serialNo =  '';
	$ItemDtl   =   $objItems->GetItemById($values['ItemID']);
	$arryKit = $objItems->GetKitItem($values['ItemID']);
	$_POST['warehouse'] = (isset($_POST['warehouse']))  ? $_POST['warehouse'] : '';    //25July2018//
	if(($values['itemType'] == 'Kit' || $values['itemType'] == 'Non Kit') && !empty($arryKit)){  
		$arr = array();
		$PrimaryKit = $objItems->GetKitItem($values['ItemID']);

		$PrimaryArry = array();
		foreach($PrimaryKit as $key=>$Comval){
		if($Comval['Primary']==1){
			$PrimaryArry[0]['Primary'] = $Comval['Primary'];
			$PrimaryArry[0]['ItemID']= $Comval['item_id'];
		}
		}

		if(!isset($_POST['warehouse'])) $_POST['warehouse']='';
 

		$allKitItemidArr = array_column($arryKit, 'item_id'); //print_r($allKitItemidArr);
		$allKitItemid = implode("','",$allKitItemidArr);
		$allcondition = $objItems->getAllConditionofItems($allKitItemid,$_POST['warehouse']); //by chetan on 6Apr2017//
		$allconditionMain = $objItems->getAllConditionofItems($values['ItemID'],$_POST['warehouse']); //by chetan on 6Apr2017//
 		$salecondition = $csearch->getAllConditionofSOPO($allKitItemidArr,'sale',$_POST['warehouse']); //by chetan on 6Apr2017//
		$purcondition = $csearch->getAllConditionofSOPO($allKitItemidArr,'purchase',$_POST['warehouse']); //by chetan on 6Apr2017//
	
		$allcondition = array_merge($allcondition,$salecondition,$purcondition,$allconditionMain);
 		$finallyArray = array(); 

		foreach($allcondition as $valarray){
				      foreach($valarray as $val){
								if($val!=''){
								   $finallyArray[] = $val; 
								}
				       }
				}
		$allcondition = array_unique($finallyArray);
		$numcond = count($allcondition);

		if ( !empty($allcondition) && $numcond > 0) 
		{	
			//added 20Mar2017//
			if(in_array('3',$checked) && !empty($arryKit)){ 
				$heads .='<td align="center" width="'.$td2width.'%"  class="head1" >Serials</td>';
			} 
			echo '<tr align="left">'.$heads.'</tr>';
			//End//
			foreach($allcondition as $condi)
			{
				//$condi['condition'] = $condi;   //27July2018//
					//if((in_array('3',$checked))  && !empty($arryKit)){

if(in_array('3',$checked) && !empty($arryKit)){
$condQtyCostup = $objItems->getTotQtBySerial($values['Sku'],$condi,$_POST['warehouse']); 
$objItems->UpdateTotQtBySerial($values['Sku'],$condi,$_POST['warehouse'],$condQtyCostup[0]['condition_qty']);
}


					//}else{
						$condQtyCostNonKit = $objItems->getTotQtByItemIdsOnCond($values['ItemID'],$condi,$_POST['warehouse']); //updated by chetan on 30Mar2017//
					//}
				//$condAvgCostNonKit = $csearch->GetCSAvgTransPrice($values['ItemID'],$condi);
			        //$condQtyCostKit    = $objItems->getTotQtByItemIdsOnCond($values['ItemID'],$condi);
				//$condAvgCostKit    = $csearch->GetCSAvgTransPrice($values['ItemID'],$condi);
				//$SoQty             = $csearch->getSaleQTY('sale',$ItemDtl[0]['ItemID'],$condi);
				$PairQty  = $csearch->pairQuantNo($ItemDtl[0],$condi,'',$_POST['warehouse']);//updated by chetan on 31Mar2017//
				$countSo = $csearch->getQtyOrderfr('sale',$ItemDtl[0]['ItemID'],$condi,'',$_POST['warehouse']);//updated by chetan on 5Apr2017//
			  $countDropSo = $csearch->getQtyOrderfr('sale',$ItemDtl[0]['ItemID'],$condi,'',$_POST['warehouse'],1);
        $countSo = $countSo-$countDropSo;
			if(!empty($PrimaryArry) && $PrimaryArry[0]['Primary']==1){
				$NonPairQty = $objItems->getTotQtByItemIdsOnCond($PrimaryArry[0]['ItemID'],$condi,$_POST['warehouse']); //updated by chetan on 31Mar2017//
				$NonPairQty = $NonPairQty[0]['condition_qty'];
			}else{
				$NonPairQty = $csearch->NoNpairQuantNo($ItemDtl[0],$condi,'',$_POST['warehouse']); //updated by chetan on 31Mar2017//
			}

			$NonPairQty = $NonPairQty-$PairQty;
			 $FullKitss = $csearch->pairQuantNo($ItemDtl[0],$condi,'',$_POST['warehouse']);
			$pairTotCost = $csearch->fullKitscost($ItemDtl[0],$condi, $_POST['warehouse']);//added by chetan on 19Sep2017//
if($FullKitss==0){

$pairTotCost = '0.00';
}
			//$pairTotCost = $csearch->pairQuantNo($ItemDtl[0],$condi,'totalcost', $_POST['warehouse']);//updated by chetan on 31Mar2017//
			$pairTotCostNon = $csearch->NoNpairQuantNo($ItemDtl[0],$condi,'totalcost', $_POST['warehouse']);//updated by chetan on 31Mar2017//)
			$NonPairCost = (!empty($NonPairQty))?($pairTotCostNon/$NonPairQty):(0);
			$avgPrice = $csearch->compItemTableHtml($condi,$ItemDtl[0],$arr, $_POST['warehouse']);//updated by chetan on 31Mar2017//
			$InvQty = $objItems->CountInvQty($values['ItemID'],$condi, $_POST['warehouse']);//updated by chetan on 30Mar2017//
			$OnQty =$condQtyCostNonKit[0]['condition_qty']+$InvQty[0]['InvQty'];
			//$onSo = $csearch->showOnSO($condi,$ItemDtl[0]['ItemID'],$checked,$postdata);
			//$onHand = $OnQty-$countSo;
			$onHand = $OnQty+$PairQty-$countSo;



		

			?>
				<tr align="left"><td ><?=($condi)?></td>
				<td style="text-align: center;"> 
	<span class="bom3" >	<b>On hand</b><br><a  href="#" title="On hand">

		<span >  <b><?php if($OnQty>0){?><?=($OnQty)?><? }else{ echo '0';}?></b></span>
		</a>
</span>
				<span class="bom2" ><b style="color:#000">Full Kits</b><br><? echo '<a class="fancybox fancybox.iframe"  href="csviewcondqty.php?sku='.$values['Sku'].'&condition='.$condi.$serialNo.'&WID='.$_POST['warehouse'].'" title="view"> <span title="Full Kits"> <b> '.$csearch->pairQuantNo($ItemDtl[0],$condi,'',$_POST['warehouse']).'</b></span></a>'; //updated 30Mar2017 by chetan//
				?></span>
<span class="bom1" ><b>Partials</b><br><? echo '<a class="fancybox fancybox.iframe"  href="csviewcondqty.php?sku='.$values['Sku'].'&condition='.$condi.$serialNo.'&WID='.$_POST['warehouse'].'" title="view"> <span title="Partials"><b>'.(($NonPairQty>0)?$NonPairQty:0).'</b></span></a>';//updated 30Mar2017 by chetan//
				?></span>
				</td>
      <? echo $csearch->showOnSO($condi,$ItemDtl[0]['ItemID'],$checked,$postdata); ?>
        <td align="center"><?=($onHand)?></td>
				<!--td align="center"><? //echo $totCost." ".$Config['Currency'];?></td-->

				<td style="text-align: center;" class="color-box">

	<span class="bom3"><b>On hand</b><br><?php if($postdata['currency']!=''){ echo $csearch->getCurrencyConverted($avgPrice[0]['price'], $Config['Currency']);}else if(!empty($avgPrice[0]['price'])){ echo '<b>'.number_format($avgPrice[0]['price'],2).'</b>';}?>
<? if($postdata['currency']!=''){ echo $csearch->getCurrencyConverted($avgPrice[0]['price'], $postdata['currency']); }//by chetan 2Feb//?>

</span>
				<span class="bom2" style="color:black;"><b>Full Kits</b><br><? if($postdata['currency']!=''){?><?=$csearch->getCurrencyConverted($pairTotCost,$Config['Currency'])?> <? }else{ echo '<b>'.number_format($pairTotCost,2).'</b>'; }?>
				
<? if($postdata['currency']!=''){ echo $csearch->getCurrencyConverted($pairTotCost, $postdata['currency']); }//by chetan 2Feb//?>

</span>
				<span class="bom1" ><b>Partials</b><br><?php if($postdata['currency']!=''){ echo $csearch->getCurrencyConverted($NonPairCost, $Config['Currency']);}else{ echo '<b>'.number_format($NonPairCost,2).'</b>';} 
			
 if($postdata['currency']!=''){ echo $csearch->getCurrencyConverted($NonPairCost, $postdata['currency']); }//by chetan 2Feb//?>

</span>

				</td>
				<td align="center"><span class="bom3" style="width: 70px;">	<b>Price</b> <?php echo $csearch->getfpriceDetail($condi,$ItemDtl[0]);?><br><?  $SP = $csearch->getSalePrice($condi,$ItemDtl[0]);
					if($postdata['currency']!=''){echo $csearch->getCurrencyConverted($SP, $Config['Currency']);}else{ echo '<b>'.number_format($SP,2).'</b>';}
					if($postdata['currency']!=''){echo $csearch->getCurrencyConverted($SP, $postdata['currency']);}//by chetan 2Feb//
					
				?></span>
				</td>
				<? echo $csearch->showOnPO($condi,$ItemDtl[0]['ItemID'],$checked,$postdata);?>
				<? if(in_array('4',$checked)){
				//updated by chetan on 3Apr2017//				
				?>
			 	<td class="head1 sales-histry" style="background:none;" align="center"><?php if($values['itemType'] == 'Non Kit'){?><?=$csearch->showSalesPurchase('sale', $Stime,$ItemDtl[0], $condi, $values['ItemID'], $_POST['warehouse'] )?><? }else{?><?=$csearch->showSalesPurchase('sale', $Stime,$ItemDtl[0], $condi, $allKitItemidArr, $_POST['warehouse'] )?><?}?></td>
				<? } if(in_array('5',$checked)){?>
				<td class="head1 sales-histry" style="background:none;" align="center"><?php if($values['itemType'] == 'Non Kit'){?><?=$csearch->showSalesPurchase('purchase', $Ptime, $ItemDtl[0], $condi,$values['ItemID'], $_POST['warehouse'])?><? }else{?><?=$csearch->showSalesPurchase('purchase', $Ptime, $ItemDtl[0], $condi,$values['ItemID'], $_POST['warehouse'])?><? }?></td>
				<? } if((in_array('3',$checked))  && !empty($arryKit) && ($OnQty !='' && $OnQty != 0)){?>
				<td  width="20%" align="center"><a class="fancybox fancybox.iframe" href="csItemSerial.php?Sku=<?=$values['Sku']?>&pop=1&Condition=<?=$condi?>&WID=<?=$_POST['warehouse']?>"><img border="0" title="Serial Numbers" src="../images/serial.png"></a></td>
				<?//END//	 
				}else{ echo  '<td  width="20%" align="center">N/A</td>';}?>
			</tr>
			<?
			}

		}else{
			if(in_array('3',$checked)){
			$heads .='<td align="center" width="'.$td2width.'%"  class="head1" >Serials</td>';
			}
			echo '<tr align="left">'.$heads.'</tr>';
			$arryCondQty=$objItems->getItemCondion($ItemDtl[0]['Sku'],'', $_POST['warehouse']); //updated by chetan on 6Apr2017//
			$numQty =count($arryCondQty);    
			if (is_array($arryCondQty) && $numQty > 0) 
			{	
				foreach ($arryCondQty as $key => $CondQty) {
					$avgPrice = $csearch->compItemTableHtml($CondQty,$ItemDtl[0],$arr, $_POST['warehouse']);//updated by chetan on 7Apr2017//
					//$SoQty = $csearch->getQtyOrderfr('sale',$ItemDtl[0]['ItemID'],$CondQty);
					$SoQty = $csearch->getSaleQTY('sale',$values['ItemID'],$condi);
					$PairQty = $csearch->pairQuantNo($ItemDtl[0],$condi);
					$onHand = $PairQty;
			?>
				 	<tr align="left">
					<td align="center"><?=($CondQty['condition']) ? Stripslashes($CondQty['condition'])   :  NOT_SPECIFIED?></td>
					<td align="center"> 
					<?	echo '<a class="fancybox fancybox.iframe" style="display:block;" href="csviewcondqty.php?sku='.$values['Sku'].'&condition='.$condi['condition'].$serialNo.'" title="view"> '.$csearch->pairQuantNo($ItemDtl[0],$condi).'</a>';
					?>
					</td>
					<? echo $csearch->showOnSO($CondQty,$ItemDtl[0]['ItemID'],$checked,$postdata); ?>
					<td align="center"><span class="bom3"><b>On hand</b><br> <?=($onHand)?> 
				</td>
					<td align="center">
<span class="bom3"><b>On hand</b><br><?php if($postdata['currency']!=''){ echo $csearch->getCurrencyConverted($avgPrice[0]['price'], $Config['Currency']);}else{ echo '<b>'.number_format($avgPrice[0]['price'],2).'</b>'; } ?>
<? if($postdata['currency']!=''){ echo '<br><b>'.$csearch->getCurrencyConverted($avgPrice[0]['price'], $postdata['currency']).'</b><br>';}//by chetan 2Feb//?>
</span>

</td>
					<td align="center">
					<? $SP = $csearch->getSalePrice($CondQty,$ItemDtl[0]); if($postdata['currency']!=''){echo $csearch->getCurrencyConverted($SP, $Config['Currency']);}else{ echo  '<b>'.number_format($SP,2).'</b>'; } ?>
					<? if($postdata['currency']!=''){ echo '<br/>'.$csearch->getCurrencyConverted($SP, $postdata['currency']);}//by chetan 2Feb//
					echo $csearch->getfpriceDetail($condi,$ItemDtl[0]);
				?>
					</td>
					<? echo $csearch->showOnPO($CondQty,$ItemDtl[0]['ItemID'],$checked,$postdata); ?>
					<? if(in_array('4',$checked)){?>			 	
					<td class="head1 sales-histry" style="background:none;" align="center"><?=$csearch->showSalesPurchase('sale', $Stime, $ItemDtl[0], $CondQty['condition'])?></td>
					<? } if(in_array('5',$checked)){?>
					<td class="head1 sales-histry" style="background:none;" align="center"><?=$csearch->showSalesPurchase('purchase', $Ptime, $ItemDtl[0], $CondQty['condition'])?></td>
					<? } if(in_array('3',$checked)){?>
					<td  width="20%" align="center"><a class="fancybox fancybox.iframe" href="csItemSerial.php?Sku=<?=$values['Sku']?>&pop=1&Condition=<?=$CondQty['condition']?>"><img border="0" title="Serial Numbers" src="../images/serial.png"></a></td>
					<? }?>
					</tr>
				<? }
			}else{
				echo '<tr><td  colspan="9" class="no_record">No Record found.</td></tr>';
			} 
	     }                
	}else{
	if(in_array('3',$checked)){
		$heads .='<td align="center" width="'.$td2width.'"  class="head1" >Serials</td>';
	}
	$bomArr = $objItems->KitItemsOfComponent($values['ItemID']);   

	if(!empty($bomArr))
	{
		if(!isset($_POST['warehouse'])) $_POST['warehouse']='';

		$allBomItemidArr = array_column($bomArr, 'ItemID'); 
		$arryBOMID = implode("','",$allBomItemidArr);
		array_push($allBomItemidArr,$values['ItemID']);
		$allBomItemid = implode("','",$allBomItemidArr);
		$allcondition = $objItems->getAllConditionofItems($allBomItemid,$_POST['warehouse']); //by chetan on 6Apr2017//  
		$salecondition = $csearch->getAllConditionofSOPO($allBomItemidArr,'sale',$_POST['warehouse']); //by chetan on 6Apr2017//
		$purcondition = $csearch->getAllConditionofSOPO($allBomItemidArr,'purchase',$_POST['warehouse']); //by chetan on 6Apr2017//  
		$allcondition = array_merge($allcondition,$salecondition,$purcondition);//comment by bhoodev 18jan2017
           	$finallyArray = array(); 
           	//$allcondition = array_unique($allcondition);//comment by bhoodev 18jan2017
           	
  if($_GET['CON']==1){ pr($allcondition);}
           	
     foreach($allcondition as $valarray){
       foreach($valarray as $val){
        if($val!='' && in_array($val, $valarray)){
           $finallyArray[] = $val; 
        }
       }
     }


		$allcondition = array_unique($finallyArray);//comment by bhoodev 18jan2017
		//$allcondition = array_flip($allcondition);
		//$allcondition = array_flip($allcondition);
		if($_GET['CON']==1){ 
		
		//$allcondition =  $objCondition->ListAllCondition();
		
		pr($allcondition);}

		$numcond = count($allcondition);    	
		$arr = array();
		echo '<tr align="left">'.$heads.'</tr>';
		if ( !empty($allcondition) && $numcond > 0) 
		{
			foreach($allcondition as $condi)
			{        
     if(!empty($_POST['warehouse'])){
         $Config['warehouse'] = $_POST['warehouse'];
     }
				$TocondQtyCost = $objItems->getTotQtByItemIdsOnCond($arryBOMID,$condi,$_POST['warehouse']); //updated by chetan on 3Apr2017//
     if(in_array('3',$checked) && !empty($arryKit)){
         $condQtyCostup = $objItems->getTotQtBySerial($values['Sku'],$condi,$_POST['warehouse']); 
         $objItems->UpdateTotQtBySerial($values['Sku'],$condi,$_POST['warehouse'],$condQtyCostup[0]['condition_qty']);
     }



				$condQtyCost = $objItems->getTotQtByItemIdsOnCond($values['ItemID'],$condi,$_POST['warehouse']); //updated by chetan on 
    $totcondAvgCost = $csearch->GetInKitAvgTransPrice($values['ItemID'],$condi,$_POST['warehouse']); //updated by chetan on 4Apr2017//
    $TotCondQtyCost = $objItems->getTotQtByItemIdsOnCond($arryBOMID,$condi,$_POST['warehouse']); //updated by chetan on 3Apr2017//
    $avgPrice = $csearch->compItemTableHtml($condi,$ItemDtl[0],$arr,$_POST['warehouse']); //updated by chetan on 3Apr2017//
    $SoQty  = $csearch->getQtyOrderfr('sale',$values['ItemID'],$condi,'',$_POST['warehouse']);
    $countDropSo = $csearch->getQtyOrderfr('sale',$values['ItemID'],$condi,'',$_POST['warehouse'],1);
    $InvQty = $objItems->CountInvQty($values['ItemID'],$condi,$_POST['warehouse']); //updated by chetan on 3Apr2017//
    $OnQty  = $condQtyCost[0]['condition_qty']+$InvQty[0]['InvQty'];
    $onHand = $OnQty-($SoQty-$countDropSo);
				if(!isset($avgPrice[0]['price'])) $avgPrice[0]['price']='';
			?>
				<tr align="left"><td align="center"><?=($condi)?></td>
				<td style="text-align: center;"> 
<?php //if($condQtyCost[0]['condition_qty'] != 0){ echo $condQtyCost[0]['condition_qty'];}else{ echo '0';}//jan242017//?>	 


<span class="bom3" title="On hand" style="cursor: pointer;"><b>On hand</b><br><?=($OnQty)?> 
				</span>
				<span class="Allbom" title="In Kits" style="cursor: pointer;" ><b>In Kits</b><br>

<?	echo '<a class="fancybox fancybox.iframe" style="display:block;color: #fff;" href="csviewWhereUsed.php?sku='.$values['Sku'].'&condition='.$condi.$serialNo.'&WID='.$_POST['warehouse'].'" title="view"> '.(($TocondQtyCost[0]['condition_qty'])?$TocondQtyCost[0]['condition_qty']:0).'</a>'; //updated by chetan on 5Apr2017//
					?>


</span>


<!--table  id="list_table">
    <tr>
        <td>                                  
            <a href="#" class="link">Show</a>
            <div class="tooltip"><table width="200">
    <tr>
    <td class="head1">AvgCost </td> 
    <td class="head1">Total Qty </td>
    </tr>
     <tr>
<td><? //echo $avgPrice[0]['price']; ?></td>
    <td><? //echo $TocondQtyCost[0]['condition_qty']; ?> </td> 
    
    </tr></table></div>
        </td>
    </tr>
</table-->
<!--<a class="fancybox fancybox.iframe" style="display:block;" href="csviewcondqty.php?sku=<?=$ItemDtl[0]['Sku'].$serialNo?>&comp=yes" title="view"></a>-->				</td>	

				<? //echo $csearch->showOnSO($condi,$values['ItemID'],$checked,$postdata); 
echo $csearch->showOnSO($condi,$values['ItemID'],$checked,$postdata);
?>	
				<td align="center"><?php  echo $onHand;?></td>
				<!--td align="center"><? //echo $avgPrice[0]['price']." ".$Config['Currency']; ?></td-->
<td align="center"><span class="bom3" style="width: 70px;"><b>On hand</b><br><?if($postdata['currency']!=''){?><?=$csearch->getCurrencyConverted($avgPrice[0]['price'], $Config['Currency'])?> <?}else if(!empty($avgPrice[0]['price'])){ echo $avgPrice[0]['price']; }?>
				


<?if($postdata['currency']!=''){ echo $csearch->getCurrencyConverted($avgPrice[0]['price'], $postdata['currency']); }//by chetan 2Feb//?>
</span>
				<span class="Allbom" style="width: 70px;" ><b>In Kits</b><br> 

<?	
if($postdata['currency']!=''){
$kitsPrice = $csearch->getCurrencyConverted($totcondAvgCost,$Config['Currency']);
}else{
$kitsPrice =  '<b>'.number_format($totcondAvgCost,2).'</b>';

}
echo '<a class="fancybox fancybox.iframe" style="display:block;color: #fff;" href="csviewWhereUsed.php?sku='.$values['Sku'].'&condition='.$condi.$serialNo.'&WID='.$_POST['warehouse'].'" title="view"> 
'.$kitsPrice.'
</a>';//updated by chetan on 5Apr2017//
					?>


<? if($postdata['currency']!=''){echo $csearch->getCurrencyConverted($totcondAvgCost, $postdata['currency']);}//by chetan 2Feb//?></span></td>
				<td align="center">
			<span class="bom3" style="width: 70px;" >	<b>Price</b><br><?  $SP = $csearch->getSalePrice($condi,$ItemDtl[0]); if($postdata['currency']!=''){ echo $csearch->getCurrencyConverted($SP, $Config['Currency']);}else{ echo $SP;} ?>
				<? if($postdata['currency']!=''){ echo $csearch->getCurrencyConverted($SP, $postdata['currency']);}//by chetan 2Feb//
				echo $csearch->getfpriceDetail($condi,$ItemDtl[0]);
				?>
	</span>	
				</td>
				<? echo $csearch->showOnPO($condi,$allBomItemidArr,$checked,$postdata); ?>	
				<? 
				 //updated by chetan on 4Apr2017//
				if(in_array('4',$checked)){?>
			 	<td class="head1 sales-histry" style="background:none;" align="center"><?=$csearch->showSalesPurchase('sale', $Stime,$ItemDtl[0], $condi, $allBomItemidArr, $_POST['warehouse'] )?></td>
				<? } if(in_array('5',$checked)){?>
				<td class="head1 sales-histry" style="background:none;" align="center"><?=$csearch->showSalesPurchase('purchase', $Ptime, $ItemDtl[0], $condi,$allBomItemidArr, $_POST['warehouse'])?></td>
				<? } if(in_array('3',$checked)){?>
				<td  width="20%" align="center"><a class="fancybox fancybox.iframe" href="csItemSerial.php?Sku=<?=$values['Sku']?>&pop=1&Condition=<?=$condi?>&WID=<?=$_POST['warehouse']?>"><img border="0" title="Serial Numbers" src="../images/serial.png"></a></td>
				<? //END//
				}?>
				</tr>
			<?	
			}
		}else{
			echo '<tr><td  colspan="9" class="no_record">No Record found.</td></tr>';
		}
		
	}else{
		$arr = array();
		echo '<tr align="left">'.$heads.'</tr>';
		$arr = array();//print_r($values['ItemID']);
		$allcondition = $objItems->getAllConditionofItems($values['ItemID'],$_POST['warehouse']); //by chetan on 6Apr2017//
		$salecondition = $csearch->getAllConditionofSOPO($values['ItemID'],'sale',$_POST['warehouse']); //by chetan on 6Apr2017//
		$purcondition = $csearch->getAllConditionofSOPO($values['ItemID'],'purchase',$_POST['warehouse']); //by chetan on 6Apr2017//
		$allcondition = array_merge($allcondition,$salecondition,$purcondition);
 		$finallyArray = array(); 
		foreach($allcondition as $valarray){
		      foreach($valarray as $val){
						if($val!=''){
						   $finallyArray[] = $val; 
						}
		       }
		}
		$allcondition = array_unique($finallyArray);
		$numcond = count($allcondition);	
		if (is_array($allcondition) && $numcond > 0) 
		{
			foreach ($allcondition as $key => $condi) {
				$avgPrice = $csearch->compItemTableHtml($condi,$ItemDtl[0],$arr,$_POST['warehouse']); //updated by chetan on 4Apr2017//
					if(in_array('3',$checked)){
					  $condQtyCost = $objItems->getTotQtBySerial($values['Sku'],$condi,$_POST['warehouse']); 
					}else{
						$condQtyCost = $objItems->getTotQtByItemIdsOnCond($values['ItemID'],$condi,$_POST['warehouse']); //updated by chetan on 4Apr2017//
					}
				
			 $SoQty = $csearch->getQtyOrderfr('sale',$ItemDtl[0]['ItemID'],$condi,$_POST['warehouse']); //updated by chetan on 4Apr2017//	
 $countDropSo = $csearch->getQtyOrderfr('sale',$ItemDtl[0]['ItemID'],$condi,'',$_POST['warehouse'],1);
//print_r($countDropSo);
//echo $_POST['warehouse'];
				//$SoQty = $csearch->getSaleQTY('sale',$values['ItemID'],$condi);
				$InvQty = $objItems->CountInvQty($values['ItemID'],$condi,$_POST['warehouse']); //updated by chetan on 4Apr2017//
				$OnQty =$condQtyCost[0]['condition_qty']+$InvQty[0]['InvQty'];
if(is_array($SoQty)){

$SoQty =0;

}
				 $onHand = intval($OnQty)-intval($SoQty-$countDropSo);
//if($onHand>0)
			//	$onHand = $onHand-$countDropSo;


	if(!isset($avgPrice[0]['price'])) $avgPrice[0]['price']='';
				?>
			 	<tr align="left"><td align="center"><?=($condi) ? Stripslashes($condi)   :  NOT_SPECIFIED?></td>
				<td align="center"><span class="bom3" style="width: 70px;"><b>On hand</b><br><?php if($OnQty>0){echo $OnQty;}else{ echo '0';}?></span>
</td>
				<? echo $csearch->showOnSO($condi,$ItemDtl[0]['ItemID'],$checked,$postdata); ?>	
				<td align="center">	<?php  echo $onHand;?></td>
				<td align="center">
<span class="bom3" style="width: 70px;"><b>On hand</b><br>
<?php if($postdata['currency']!='' && $postdata['currency']!=$Config['Currency'] ){  
echo $csearch->getCurrencyConverted($avgPrice[0]['price'], $Config['Currency']); 
}else{ 
echo '<b>'.$avgPrice[0]['price'].'</b>';
} ?>
<? if($postdata['currency']!=''){ echo $csearch->getCurrencyConverted($avgPrice[0]['price'], $postdata['currency']);}//by chetan 2Feb//?></span>

</td>
				<td align="center"><span class="bom3" style="width: 70px;" >	<b>Price</b><br><? $SP = $csearch->getSalePrice($condi,$ItemDtl[0]); 
if($postdata['currency']!=''){ echo $csearch->getCurrencyConverted($SP, $Config['Currency']); }else{ echo '<b>'.number_format($SP,2).'</b>'; }?>
				<? if($postdata['currency']!=''){echo $csearch->getCurrencyConverted($SP, $postdata['currency']);}//by chetan 2Feb//
echo $csearch->getfpriceDetail($condi,$ItemDtl[0]);
				?>	
</span></td>
				<? echo $csearch->showOnPO($condi,$ItemDtl[0]['ItemID'],$checked,$postdata); ?>			 	
				<? //updated by chetan on 4Apr2017//
				if(in_array('4',$checked)){?>			 	
				<td class="head1 sales-histry" style="background:none;" align="center"><?=$csearch->showSalesPurchase('sale', $Stime, $ItemDtl[0], $condi,'',$_POST['warehouse'])?></td>
				<? } if(in_array('5',$checked)){?>
				<td class="head1 sales-histry" style="background:none;" align="center"><?=$csearch->showSalesPurchase('purchase', $Ptime, $ItemDtl[0], $condi,'',$_POST['warehouse'])?></td>
				<? } if(in_array('3',$checked)){?>
				<td  width="20%" align="center"><a class="fancybox fancybox.iframe" href="csItemSerial.php?Sku=<?=$values['Sku']?>&pop=1&Condition=<?=$condi?>&WID=<?=$_POST['warehouse']?>"><img border="0" title="Serial Numbers" src="../images/serial.png"></a></td>
				<? //End//
				}?>
			</tr>
			<? }
		}else{	
	
 if($_SESSION['SelectOneItem'] == 1){ ?>
	<tr align="left">
				<? echo $csearch->showOnSO('',$ItemDtl[0]['ItemID'],$checked,$postdata); ?>	
				<? echo $csearch->showOnPO('',$ItemDtl[0]['ItemID'],$checked,$postdata); ?>			 	
				<? if(in_array('4',$checked)){?>			 	
				<td class="head1 sales-histry" style="background:none;" align="center"><?=$csearch->showSalesPurchase('sale', $Stime, $ItemDtl[0], $condi)?></td>
				<? } if(in_array('5',$checked)){?>
				<td class="head1 sales-histry" style="background:none;" align="center"><?=$csearch->showSalesPurchase('purchase', $Ptime, $ItemDtl[0], $condi)?></td>
				<? } ?>
			</tr>
<?}else{
		  echo '<tr><td  colspan="9" class="no_record">No Record found.</td></tr>';
}
	       }  
	
	}

	}





	?>


	<tr>&nbsp;</tr>
	</table>
	</td>
</tr>
<!---End--->
        <?php /*End*/ } // foreach end */?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="<?=(isset($count)) ? $count : '';//27July2018//?>" class="no_record">No Records Found</td>
    </tr>
    <?php } ?>
  
    </tbody>
    <tr>
            <td colspan="15">Total Record(s) : &nbsp;<?php echo $num; ?> <?php if (count($resArray) > 0) { ?>
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
	<input name="moduleID"    type="hidden" class="inputbox" id="moduleID "   value="<?php echo $Viewdata['moduleID']; ?>" />
        <input name="columns"  type="hidden" class="inputbox" id="columns"  value="<?php echo $Viewdata['columns']; ?>" />
        <input name="displayCol"  type="hidden" class="inputbox" id="displayCol"  value="<?php echo $Viewdata['displayCol']; ?>" />
        <input type="hidden" name="checkboxes" value="<?php echo $Viewdata['checkboxes']?>" />
        <input type="hidden" name="saleDuration" value="<?php echo $Viewdata['saleduration']?>" />
        <input type="hidden" name="purDuration" value="<?php echo $Viewdata['purduration']?>" />
	<input type="hidden" name="showsopopop" value="<?php echo $Viewdata['showsopopop']?>" />
	<input type="hidden" name="currency" value="<?php echo $Viewdata['currency']?>" />
	<input type="hidden" name="search_ID" value="<?php echo $_GET['view']?>" />
    </td>

   </tr>
</tbody>
</table>
   
   
</form>



