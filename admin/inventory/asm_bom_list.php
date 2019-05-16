<?php 
$HideNavigation = 1;
require_once("../includes/settings.php");
require_once($Prefix."classes/bom.class.php");
	require_once($Prefix."classes/item.class.php");
$objBom = new bom();
$objItems = new items();

$pageUrl = $_GET['link'];

//$Config['RecordsPerPage'] =10;

$arryBOM=$objBom->ListBOMListing($_GET);
	$num=$objBom->numRows();

//$num= 15;


?>

<style>
.paging-nav {
  text-align: right;
  padding-top: 2px;
}

.paging-nav a {
  margin: auto 1px;
  text-decoration: none;
  display: inline-block;
  padding: 1px 7px;
  background: #91b9e6;
  color: white;
  border-radius: 3px;
}

.paging-nav .selected-page {
  background: #187ed5;
  font-weight: bold;
}

.paging-nav,
.tblData {
  
  margin: 0 auto;
  font-family: Arial, sans-serif;
}
</style>
  <div id="load_popup_modal_contant" class="" role="dialog">

  <div class="modal-dialog modal-md">
<?php
//$id1 = $_POST["id1"];
//$id2 = $_POST["id2"];
?>
	
    <!-- Start: Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Select Bill Number</h4>
      </div>
	    <div id="validation-error"></div>
  <div class="cl"></div>
	    <div class="modal-body">
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right" valign="bottom">
<input type="text" placeholder="<?=SEARCH_KEYWORD?>" class="textbox autocomplete" id="search"/>




		</td>
      </tr>
	<table <?=$table_bg?> class="tblData">
    <tr align="left"  >
        <td width="12%"  class="head1" >BOM No.</td>
     
     <td class="head1" >Description</td>
<td class="head1" >Bill With Option</td>
      
     
    </tr>
   
    <?php 
  if(is_array($arryBOM) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryBOM as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;
	
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
    <td>
	<a href="Javascript:void(0)" onclick="Javascript:SetbomCode('<?=$values["bomID"]?>','<?=$values["bill_option"]?>','<?=$values["Sku"]?>');"><?=$values["Sku"]?></a>
	</td>
   
     <td><?=stripslashes($values["description"])?></td> 
  <td><?=stripslashes($values["bill_option"])?></td> 
    
   
      
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="3" class="no_record">No Bill of material found</td>
    </tr>
    <?php } ?>
  <tr align="center" >
<td  colspan="3" >
<script type="text/javascript" src="js/paging.js"></script> 
<script type="text/javascript">
            $(document).ready(function() {
                $('.tblData').paging({limit:15});
            });
        </script>	
  </td>
</tr>
  </table>

 </td>
</tr>
  </table>


  


      <div class="modal-footer">

	  <!--input name="submit_popup" id="submit_popup" type="button" value="SUBMIT" class="btn btn-primary" /-->
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	 
      </div>
    </div>
  </div>
  </div>

<script>

$(document).ready(function()
{
	$('#search').keyup(function()
	{

//alert("aaaaaa");
		searchTable($(this).val());
	});
});

function searchTable(inputVal)
{
	var table = $('.tblData');

	table.find('tr:not(tr:first)').each(function(index, row)
	{
		var allCells = $(row).find('td');
		if(allCells.length > 0)
		{
			var found = false;
			allCells.each(function(index, td)
			{
				var regExp = new RegExp(inputVal, 'i');
				if(regExp.test($(td).text()))
				{
					found = true;
					return false;
				}
			});
			if(found == true)$(row).show();else $(row).hide();
		}
	});
}

function SetbomCode(bomCode,bill_option){	
	//ResetSearch();
       
        //var warehouse= window.opener.document.getElementById("warehouse").value;
        
        //alert(bill_option);

	if(bill_option == 'No'){

		location.href="<?=$pageUrl?>?bc="+bomCode;
	}else{
	
		$.fancybox.open({
                                padding : 0,
                                closeClick  : false, // prevents closing when clicking INSIDE fancybox
                                href:'OptionList.php?edit='+bomCode+'&link=<?=$pageUrl?>',
                                type: 'iframe',
                                helpers   : { 
                                                overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox 
                                            }
                            });
		//location.href ="OptionList.php?edit="+bomCode;

	}


}

</script>

