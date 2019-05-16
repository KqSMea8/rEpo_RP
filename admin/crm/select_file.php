<? session_start();
include_once("../includes/settings.php");
require_once($Prefix."classes/lead.class.php");

$objLead=new lead();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link type="text/css" rel="stylesheet" href="../../css/admin.css">
<title><?=$_GET['module']?></title>

<script>
function SelectCheckBoxes(MainID,ToSelect,Num)
{	


	var flag,i;
	if(document.getElementById(MainID).checked){
		flag = true;
	}else{
		flag = false;
	}
	
	for(i=1; i<=Num; i++){
		document.getElementById(ToSelect+i).checked=flag;
	}

}
</script>

<script>

function roundPriceValue(num,decimals){


return  Math.ceil(num * 10) / 10;

//return Math.round(num*Math.pow(10,decimals))/Math.pow(10,decimals);
}


function sendValue (name,id){

//alert(id);
//alert(name);
var selname = name;
var selid = id;
window.opener.document.getElementById('opportunityID').value = selid;
window.opener.document.getElementById('opportunityName').value = selname;


window.close();
}

function sendValueCampaign (name,id){

//alert(id);
//alert(name);
var selname = name;
var selid = id;
window.opener.document.getElementById('campaignID').value = selid;
window.opener.document.getElementById('Campaign_Source').value = selname;


window.close();
}

function set_return_inventory(product_id,product_name,unitprice,qtyInStock,curr_row,desc) {

//alert(qtyInStock);
	window.opener.document.getElementById("productName"+curr_row).value = product_name;
	window.opener.document.getElementById("hdnProductId"+curr_row).value = product_id;
	window.opener.document.getElementById("qtyInStock"+curr_row).innerHTML = qtyInStock;
	//window.opener.document.getElementById("qtyInStock"+curr_row).value = qtyInStock;
	window.opener.document.getElementById("comment"+curr_row).value = desc;

	// Apply decimal round-off to value
	if(!isNaN(parseFloat(unitprice))){
	 unitprice = roundPriceValue(unitprice,'');
	window.opener.document.getElementById("listPrice"+curr_row).value = unitprice;
	}
//alert("aaaaaaaaaa");
window.opener.document.getElementById("qty"+curr_row).value='';
	window.opener.document.getElementById("qty"+curr_row).focus();
	window.close();
}



</script>

</head>

<body style=" color: #636262; font: 12px/1.55 Lato,Arial,Helvetica,sans-serif;}">

<?php 
if($_POST){
//print_r($_POST);

}

require_once($Prefix."classes/product.class.php");
	require_once($Prefix."classes/category.class.php");
		
	
$RecordsP=15;

	
	
	?>
    
<div class="wrapper">

<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';
		/*
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  { 
			   location.href = 'viewOpportunity.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewOpportunity.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
			return false;
			*/
	}
</script>
<div class="had"><?=$_GET['module']?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_opp'])) {echo $_SESSION['mess_opp']; unset($_SESSION['mess_opp']); }?></div>
<TABLE WIDTH="98%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	
	<tr>
	  <td  valign="top">
	  
	<? if($_GET['module']=='opportunity'){?>
	<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch();">
	 <table  border="0" cellpadding="3" cellspacing="0"  id="search_table">
        <tr >
          <td>		  
	<select name="sortby" id="sortby" class="textbox">
    
		<option value=""> All </option>
		<option value="o.OpportunityName" <? if($_GET['sortby']=='o.OpportunityName') echo 'selected';?>>Opportunity Name</option>
		
		<option value="o.SalesStage" <? if($_GET['sortby']=='o.SalesStage') echo 'selected';?>>Sales Stage</option>
		
		
	</select>
	  </td>
			  
          <td><input type='text' name="key"  id="key" class="inputbox" value="<?=$_GET['key']?>" /></td>
          <td>            
              <select name="asc" id="asc" class="textbox" >
                <option value="Desc" <? if($_GET['asc']=='Desc') echo 'selected';?>>Desc</option>
                <option value="Asc" <? if($_GET['asc']=='Asc') echo 'selected';?>>Asc</option>
              </select>         
			   </td>
		 <td>
         <input name="row" type="hidden"  value="<?=$_GET['row']?>"  />
		 <input name="module" type="hidden"  value="<?=$_GET['module']?>"  />
		 <input name="search" type="submit" class="search_button" value="Go"  />
		   <? if($_GET['key']!='') {?>
		  <a href="select_file.php?module=<?=$_GET['module']?>">View All</a>
		<? }?>
		 
		 </td> 
        </tr>
      </table>
	</form>
    <? }
	
	if($_GET['module']=='Products'){ ?>
	
	<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch();">
	 <table  border="0" cellpadding="3" cellspacing="0"  id="search_table">
        <tr >
          <td>		  
	<select name="sortby" id="sortby" class="textbox">
		<option value=""> All </option>
		<option value="p1.Name" <? if($_GET['sortby']=='p1.Name') echo 'selected';?>>Product Name</option>
		<option value="p1.Price" <? if($_GET['sortby']=='p1.Price') echo 'selected';?>>Price</option>
		<option value="p1.Status" <? if($_GET['sortby']=='p1.Status') echo 'selected';?>>Status</option>
	</select>
	  </td>
			  
          <td><input type='text' name="key"  id="key" class="inputbox" value="<?=$_GET['key']?>" /></td>
          <td>            
              <select name="asc" id="asc" class="textbox" >
                <option value="Desc" <? if($_GET['asc']=='Desc') echo 'selected';?>>Desc</option>
                <option value="Asc" <? if($_GET['asc']=='Asc') echo 'selected';?>>Asc</option>
              </select>         
			   </td>
		 <td>
		 <input name="module" type="hidden"  value="<?=$_GET['module']?>"  />
         <input name="row" type="hidden"  value="<?=$_GET['row']?>"  />
		 <input name="search" type="submit" class="search_button" value="Go"  />
		  <? if($_GET['key']!='') {?>
		  <a href="select_file.php?module=<?=$_GET['module']?>">View All</a>
		<? }?>
		 
		 </td> 
        </tr>
      </table>
	</form>
	
	
	<? }
    
    if($_GET['module']=='Campaign'){ ?>
	
	<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch();">
	 <table  border="0" cellpadding="3" cellspacing="0"  id="search_table">
        <tr >
          <td>		  
	<select name="sortby" id="sortby" class="textbox">
                                <option value=""> All </option>
                                <option value="c.campaignname" <? if($_GET['sortby']=='c.campaignname') echo 'selected';?>>Campaign Name</option>
                                <option value="c.campaigntype" <? if($_GET['sortby']=='c.campaigntype') echo 'selected';?>>Campaign Type</option>
	</select>
	  </td>
			  
          <td><input type='text' name="key"  id="key" class="inputbox" value="<?=$_GET['key']?>" /></td>
          <td>            
              <select name="asc" id="asc" class="textbox" >
                <option value="Desc" <? if($_GET['asc']=='Desc') echo 'selected';?>>Desc</option>
                <option value="Asc" <? if($_GET['asc']=='Asc') echo 'selected';?>>Asc</option>
              </select>         
			   </td>
		 <td>
		 <input name="module" type="hidden"  value="<?=$_GET['module']?>"  />
         <input name="row" type="hidden"  value="<?=$_GET['row']?>"  />
		 <input name="search" type="submit" class="search_button" value="Go"  />
		  <? if($_GET['key']!='') {?>
		  <a href="select_file.php?module=<?=$_GET['module']?>">View All</a>
		<? }?>
		 
		 </td> 
        </tr>
      </table>
	</form>
	
	
	<? }?>

<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
<div id="piGal">
<table <?=$table_bg?>>



<? if($_GET['module']=='opportunity'){
	
	$arryOpportunity=$objLead->ListOpportunity('',$_GET['key'],$_GET['sortby'],$_GET['asc']);
	$num=$objLead->numRows();

	$pagerLink=$objPager->getPager($arryOpportunity,$RecordsP,$_GET['curP']);
	(count($arryOpportunity)>0)?($arryOpportunity=$objPager->getPageRecords()):("");
	
	
	
	?>
  

<form action="" method="post" name="form1">
<TABLE WIDTH="620"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right">
        
      
        
         <input type="hidden" value="<?=$_GET['parent_type']?>" id="parent_type"  name="parent_type">
          <input type="hidden" value="<?=$_GET['parentID']?> " id="parentID"  name="parentID">
		  <input type="hidden" value="<?=$_GET['module']?> " id="mode_type"  name="mode_type">
        
          
      
        
        </td>
      </tr>
      
      
      
	<tr>
	  <td  valign="top">
      
   
   <table id="list_table" width="100%" cellspacing="1" cellpadding="3" align="center">
   
    <tr align="left"  >
   

      <td width="22%"  class="head1" >Opportunity Name</td>
	  <td width="15%" class="head1"> Sales Stage  </td>
      <td width="15%" class="head1"> Expected Close Date  </td>
	 
    </tr>
   
    <?php 
  if(is_array($arryOpportunity) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryOpportunity as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?("#FDFBFB"):("");
	$Line++;
	
	//if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
     
      <td ><a href="javascript:;" onClick="sendValue('<?=$values["OpportunityName"]?>','<?=$values['OpportunityID']?>');"><?=stripslashes($values["OpportunityName"]);?></a></td>
   
	  
		   <td><?=stripslashes($values["SalesStage"])?></td>
            <td><?=date($Config['DateFormat'],strtotime($values["CloseDate"]))?></td>
      
     
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="9" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  

 <tr>  
 <td  colspan="9" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryOpportunity)>0){?>&nbsp;&nbsp;&nbsp; Page(s) :&nbsp; <?php echo $pagerLink; }?></td>
  </tr>
  </table> 
  
  </td>
  </tr>  
 </TABLE>
 </form>
 
 <? }?>
 <? if($_GET['module']=='Products'){
	  
	$objProduct=new product();
	$objCategory=new category();

	


	$arryProduct=$objProduct->GetProductsView('',$_GET['CatID'],$_GET['key'],$_GET['sortby'],$_GET['asc'],'');
	
	/*echo"<pre>";
	print_r($arryProduct);
	exit;*/	
	$num=$objProduct->numRows();


	$pagerLink=$objPager->getPager($arryProduct,$RecordsP,$_GET['curP']);
	(count($arryProduct)>0)?($arryProduct=$objPager->getPageRecords()):("");   
	  
	  
	  ?>
 <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">


    <tr>
        <td id="ProductsListing">

            <form action="" method="post" name="form1">
                <table <?= $table_bg ?>>


                    <tr align="left">
                       <!-- <td width="1%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','ProductID','<?= sizeof($arryProduct) ?>');" /></td>-->
                       
                        <td width="35%"  class="head1" >Product Name</td>
                        <td class="head1">qty In Stock</td>
                        <td class="head1">Price</td>
                        <td width="16%" class="head1" >Added Date </td>
                         <td width="11%" class="head1" align="center">Featured</td>
                          <td width="8%"  class="head1"align="center">Status</td>
                       
                    </tr>

                    <?php
                    if (is_array($arryProduct) && $num > 0) {
                        $flag = true;
                        $Line = 0;
                        foreach ($arryProduct as $key => $values) {
                            $flag = !$flag;
                            //$bgcolor=($flag)?(""):("#F3F3F3");
                            $Line++;

                            //if($values['Status']<=0){ $bgcolor="#000000"; }
                            ?>
                            <tr align="left" valign="middle" bgcolor="<?= $bgcolor ?>">
                               <!-- <td><input type="checkbox" name="ProductID[]" id="ProductID<?= $Line ?>" value="<?= $values['ProductID']; ?>"></td>-->
                              
                                <td>
                               
                                 <a href="javascript:;" onclick="set_return_inventory('<?=$values['ProductID']?>','<?=$values['Name']?>','<?=$values['Price']?>','<?=$values['Quantity']?>',<?=$_GET['row']?>,'')">   <?
                                    echo stripslashes($values['Name']);
                                    if (!empty($values['ProductNumber'])) {
                                        echo ' <span class="txt">(' . stripslashes($values['ProductNumber']) . ')</span>';
                                    }
                                    ?></a>	</td>



                                <td><?=$values['Quantity']?></td>

                              
                                <td><?= number_format($values['Price'],2);?></td>
                                <td><?
                                    if ($values['AddedDate'] > 0) {
                                        //echo '<SPAN >'.  date("jS F  y", strtotime($values['AddedDate'])) .'</SPAN>'; 
                                        echo '<SPAN>' . $values['AddedDate'] . '</SPAN>';
                                    }
                                    ?></td>
                                 <td align="center">
                                    <?
                                    if($values['Featured'] == "Yes")
                                    {$featured = "Yes"; $status = 'Active';}else{$featured = "No"; $status = 'InActive';}
                                    echo $featured;
                                    ?>


                                </td>
                                  <td align="center"><?
                                    if ($values['Status'] == 1) {
                                        $status = 'Active';
                                    } else {
                                        $status = 'InActive';
                                    }

                               

                                    echo  $status ;
                                    ?></td>
                             
                        <?php } // foreach end // ?>



                    <?php } else { ?>
                        <tr >
                            <td  colspan="8" class="no_record">No product found.</td>
                        </tr>

                    <?php } ?>



                    <tr >  <td  colspan="8" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryProduct) > 0) { ?>
                                &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
                    }
                    ?></td>
                    </tr>
                </table>

            

                <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">


            </form>
        </td>
    </tr>

</table>
<? }?>


<? if($_GET['module']=='Campaign'){
	
	$arryCampaign=$objLead->ListCampaign('',$_GET['key'],$_GET['sortby'],'',$_GET['asc']);
	$num=$objLead->numRows();

	$pagerLink=$objPager->getPager($arryCampaign,$RecordsP,$_GET['curP']);
	(count($arryCampaign)>0)?($arryCampaign=$objPager->getPageRecords()):("");
	
	
	
	?>
  

<form action="" method="post" name="form1">
<TABLE WIDTH="620"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right">
        
      
        
         <input type="hidden" value="<?=$_GET['parent_type']?>" id="parent_type"  name="parent_type">
          <input type="hidden" value="<?=$_GET['parentID']?> " id="parentID"  name="parentID">
		  <input type="hidden" value="<?=$_GET['module']?> " id="mode_type"  name="mode_type">
        
          
      
        
        </td>
      </tr>
      
      
      
	<tr>
	  <td  valign="top">
      
   
   <table id="list_table" width="100%" cellspacing="1" cellpadding="3" align="center">
   
    <tr align="left"  >
   

      <td width="22%"  class="head1" >Campaign Name</td>
	  <td width="15%" class="head1"> Campaign Type   </td>
     
	 
    </tr>
   
    <?php 
  if(is_array($arryCampaign) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryCampaign as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?("#FDFBFB"):("");
	$Line++;
	
	//if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
     
      <td ><a href="javascript:;" onClick="sendValueCampaign('<?=$values["campaignname"]?>','<?=$values['campaignID']?>');"><?=stripslashes($values["campaignname"]);?></a></td>
   
	  
		   <td><?=stripslashes($values["campaigntype"])?></td>
           
      
     
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="9" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  

 <tr>  
 <td  colspan="9" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryCampaign)>0){?>&nbsp;&nbsp;&nbsp; Page(s) :&nbsp; <?php echo $pagerLink; }?></td>
  </tr>
  </table> 
  
  </td>
  </tr>  
 </TABLE>
 </form>
 
 <? }?>
</table>
</div>
  </div>
  
</body>
</html>