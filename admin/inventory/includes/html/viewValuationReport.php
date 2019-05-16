<script language="JavaScript1.2" type="text/javascript">

function ShowDateField(){	
	 if(document.getElementById("fby").value=='Year'){
		document.getElementById("yearDiv").style.display = 'block';
		document.getElementById("monthDiv").style.display = 'none';
		//document.getElementById("fromDiv").style.display = 'none';
		document.getElementById("toDiv").style.display = 'none';	
	 }else if(document.getElementById("fby").value=='Month'){
	    document.getElementById("monthDiv").style.display = 'block';
		document.getElementById("yearDiv").style.display = 'block';
		//document.getElementById("fromDiv").style.display = 'none';
		document.getElementById("toDiv").style.display = 'none';	
	 }else{
	   document.getElementById("monthDiv").style.display = 'none';
		document.getElementById("yearDiv").style.display = 'none';
		//document.getElementById("fromDiv").style.display = 'block';
		document.getElementById("toDiv").style.display = 'block';	
	 }
}



function ValidateSearch(frm){	

	 /* if(document.getElementById("c").value == "")
	  {
		alert("Please Select Customer.");
		document.getElementById("c").focus();
		return false;
	  }*/

	if(document.getElementById("fby").value=='Year'){
		if(!ValidateForSelect(frm.y, "Year")){
			return false;	
		}
	}else if(document.getElementById("fby").value=='Month'){
		if(!ValidateForSelect(frm.m, "Month")){
			return false;	
		}
		if(!ValidateForSelect(frm.y, "Year")){
			return false;	
		}
	}else{
		if(!ValidateForSelect(frm.f, "From Date")){
			return false;	
		}
		if(!ValidateForSelect(frm.t, "To Date")){
			return false;	
		}

		if(frm.f.value>frm.t.value){
			alert("From Date should not be greater than To Date.");
			return false;	
		}

	}

	ShowHideLoader(1,'F');
	return true;	



	
}



function diplayvaluationExp(catid){


//alert(catid);
ShowHideLoader('1', 'P');
var QueryString = '<?=$QueryString?>';
var displayId = document.getElementById("displayId").value
if(displayId!=0){
document.getElementById("display" + displayId).style.display = 'none';
}
//var prev=document.getElementById("DisplayValue" + catid).innerHTML;
//var view =document.getElementById("display" + catid).style.display;
var res = QueryString.split("?")
        var SendUrl = "&action=DisplayVal&CatID="+catid+"&"+res[1]+"&r="+Math.random();
//alert(SendUrl);
        /******************/
        $.ajax({
            type: "GET",
            url: "ajax.php",
            data: SendUrl,
            dataType: "json",
            success: function (responseText) {
            //alert(responseText);
            if(catid!=displayId){
            document.getElementById("display" + catid).style.display = '';
            document.getElementById("displayId").value =catid;
            }else{
            document.getElementById("display" + catid).style.display = 'none';
            document.getElementById("displayId").value =0;
            }
                 
                 document.getElementById("DisplayValue" + catid).innerHTML = responseText;
                 
                   //prev = responseText;
 ShowHideLoader('2', 'P');
                       }

 });





}


</script>

<div class="had"><?=$ModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_Sale'])) {echo $_SESSION['mess_Sale']; unset($_SESSION['mess_Sale']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

<tr>
	  <td  valign="top">
	  
<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch(this);">
	 <table  border="0" cellpadding="3" cellspacing="0"  id="search_table" style="margin:0" >
	 
	 

		<tr>
	
	   <td>&nbsp;</td>

		<td valign="bottom">
		  Select Date :<br> 
		  <select name="fby" class="textbox" id="fby" style="width:100px;" onChange="Javascript:ShowDateField();">
					 <option value="Date" <?  if($_GET['fby']=='Date'){echo "selected";}?>>Date</option>
					 <!--<option value="Year" <?  if($_GET['fby']=='Year'){echo "selected";}?>>Year</option>
					 <option value="Month" <?  if($_GET['fby']=='Month'){echo "selected";}?>>Month</option>-->
		</select> 
		</td>
	   <td>&nbsp;</td>



		 <td valign="bottom">

		 <? if($_GET['t']>0) $ToDate = $_GET['t'];  ?>				
<script type="text/javascript">
$(function() {
	$('#t').datepicker(
		{
		showOn: "both", dateFormat: 'yy-mm-dd', 
		yearRange: '<?=date("Y")-20?>:<?=date("Y")?>', 
		maxDate: "+0D", 
		changeMonth: true,
		changeYear: true

		}
	);
});







</script>
<div id="toDiv" style="display:none">
To Date :<br> <input id="t" name="t" readonly="" class="datebox" value="<?=$ToDate?>"  type="text" placeholder="To Date">
</div>

<div id="monthDiv" style="display:none">
Month :<br>
<?=getMonths($_GET['m'],"m","textbox")?>
</div>





</td> 
  <td><div id="yearDiv" style="display:none">
Year :<br>
<?=getYears($_GET['y'],"y","textbox")?>
</div></td>

	  <td align="right" valign="bottom">   <input name="search" type="submit" class="search_button" value="Go"  />	  
	  <script>
	  ShowDateField();
	  </script>
	  
	  </td> 
 </tr>


</table>
 	</form>



	
	</td>
      </tr>	
	<tr>
        <td align="right" valign="top">
		
	 <? if(!empty($_GET['search'])){?>
	      <input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/>
	       <input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='exportValuationReport.php?<?=$QueryString?>';" />
         

	    <? } ?>


		</td>
      </tr>
	 
<?php if(!empty($_GET['fby'])){?>	  
	<tr>
	  <td  valign="top">
	

		<form action="" method="post" name="form1">
		<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
		<div id="preview_div">

		<table <?=$table_bg?>>
		<tr align="left"  >
		
			<td    class="head1" >Category</td>
		<!--td class="head1" width="15%">Qty on Hand</td-->
		<!--td class="head1" align="center" width="10%">Cost</td-->
		
		<td align="right" class="head1">Total Amount</td>
		
		</tr>

		<?php 

		//$newarray = array();
		

		
		   foreach($arrySale as $key=>$values){
		        $checkProduct=$objItem->checkItemSku($values['Sku']);

			if(!empty($checkProduct[0]['CategoryID'])){
		     		$arryCat =$objItem->GetMainCategory($checkProduct[0]['CategoryID']);
			}

              //if($Cat['Name']==$arryCat[0]['Name']){
               
              
              $Unitcost = ($values['srQt']>0)?($values['conAmt']/$values['srQt']):(0) ;
              $qtyonhand = $values['srQt'];
             $totalamount = $Unitcost * $qtyonhand; 
                if(!empty($arryCat[0]['Name'])){
                $newarray2[] = array('CatID'=>$arryCat[0]['CategoryID'],'Name' => $arryCat[0]['Name'],  'qtyonhand' => $qtyonhand, 'totalamount' => $totalamount);
                }
                //echo $totalamount."=Cat-".$Cat['Name']."=Sku-".$values['Sku']."=Qty-".$qtyonhand;
                //echo "<br>";
               
                
              
              //}
            }
         
             
			
		   	
		 
		$result =array();
if(!empty($newarray2)){
foreach($newarray2 as $key=>$val){
	if(array_key_exists($val['CatID'], $result)){
		$result[$val['CatID']]['qtyonhand'] += $val['qtyonhand'];
		$result[$val['CatID']]['totalamount'] += $val['totalamount'];
	}else{
		$result[$val['CatID']]=$val;
	}
}
	
}	
	
	
		
	

		$num = sizeof($result);
		if(is_array($result) && $num>0){
		$flag=true;
		$Line=0;
		$Unitcost=0.00;
		$qtyonhand =0;
		$totalCost =0.00;
		foreach($result as $key=>$values){
		$flag=!$flag;
		$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
		$Line++;
		
		

$Unitcost = ($values['qtyonhand']>0)?($values['totalamount']/$values['qtyonhand']):(0) ;
$qtyonhand = $values['qtyonhand'];
						

$totalamount = $Unitcost * $qtyonhand;

$totalCost +=$totalamount;
		
		?>
		<tr align="left"  bgcolor="<?=$bgcolor?>">
		
		
		
	<!--<td ><a class="fancybox fancybox.iframe" href="viewValuationExplor.php?<?=$QueryString?>&CatID=<?=$values['CatID']?>">	<?=$values['Name']?></a></td>-->
		<td ><a id="displayValuation" style="cursor:pointer;color:inherit;text-decoration: inherit;" onclick=" diplayvaluationExp('<?=$values['CatID']?>');" ><strong>	<?=$values['Name']?></strong></a></td>
		<!--td><?=stripslashes($qtyonhand)?></td--> 
		<!--td align="center"><?=number_format($Unitcost,2)?></td-->
		
	
		<td align="right"><strong><?=number_format(($totalamount),2)?></a></td>
		</tr>
		<tr id="display<?=$values['CatID']?>" align="left" style="display:none"  bgcolor="<?=$bgcolor?>" >
		<td colspan="2">
		
		<div  id="DisplayValue<?=$values['CatID']?>"></div>
		
		</td>
		
		</tr>
		
		
		
		
		
		
		<?php  } // foreach end //?>
		
		<tr align="right" bgcolor="#FFF">
		<td  colspan="3"><b>Total Amount In <?=$Config['Currency']?> : <?=number_format($totalCost,2);?> </b></td>
		</tr>

		<?php }else{?>
		<tr align="center" >
		<td  colspan="3" class="no_record"><?=NO_RECORD?> </td>
		</tr>
		<?php } ?>

		<tr>  <td  colspan="3"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>     
		</td>
		</tr>
		</table>
		</div> 
	
		<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
		<input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
		<input type="hidden" name="displayId" id="displayId" value="0">
		</form>
</td>
</tr>
<?php } else {?>
<!--<tr><td style=" border-top: 1px solid #DDDDDD;font-weight: bold; padding-left: 123px;text-align: left;" class="no_record">Please Select Customer.</td></tr>-->
<?php }?>
</table>

