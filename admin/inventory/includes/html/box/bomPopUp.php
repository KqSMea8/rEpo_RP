
<?php  $_GET['Status'] =1;
	$arryBOM=$objBom->ListBOMListing($_GET);
	$num=$objBom->numRows();

	?>

<style>
html {
  font-family: "roboto", helvetica;
  position: relative;
  height: 100%;
  font-size: 100%;
  line-height: 1.5;
  color: #444;
}

h2 {
  margin: 1.75em 0 0;
  font-size: 5vw;
}
#popup1{

top: 18.5px !important;
}
h3 { font-size: 1.3em; }

.v-center {
  height: 100vh;
  width: 100%;
  display: table;
  position: relative;
  text-align: center;
}

.v-center > div {
  display: table-cell;
  vertical-align: middle;
  position: relative;
  top: -10%;
}



.btn:hover {
  background-color: #ddd;
  -webkit-transition: background-color 1s ease;
  -moz-transition: background-color 1s ease;
  transition: background-color 1s ease;
}

.btn-small {
  padding: .75em 1em;
  font-size: 0.8em;
float: right;
}

.modal-box {
  display: none;
  position: absolute;
  z-index: 1000;
  width: 98%;
  background: white;
  border-bottom: 1px solid #aaa;
  border-radius: 4px;
  box-shadow: 0 3px 9px rgba(0, 0, 0, 0.5);
  border: 1px solid rgba(0, 0, 0, 0.1);
  background-clip: padding-box;
}
@media (min-width: 32em) {

.modal-box { width: 70%; }
}

.modal-box header,
.modal-box .modal-header {
  padding: 1.25em 1.5em;
  border-bottom: 1px solid #ddd;
}

.modal-box header h3,
.modal-box header h4,
.modal-box .modal-header h3,
.modal-box .modal-header h4 { margin: 0; }

.modal-box .modal-body { padding: 2em 1.5em; }

.modal-box footer,
.modal-box .modal-footer {
  padding: 1em;
  border-top: 1px solid #ddd;
  background: rgba(0, 0, 0, 0.02);
  text-align: right;
}

.modal-overlay {
  opacity: 0;
  filter: alpha(opacity=0);
  position: absolute;
  top: 0;
  left: 0;
  z-index: 900;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.3) !important;
}

a.close {
  line-height: 1;
  font-size: 1.5em;
  position: absolute;
  top: 5%;
  right: 2%;
  text-decoration: none;
  color: #bbb;
}

a.close:hover {
  color: #222;
  -webkit-transition: color 1s ease;
  -moz-transition: color 1s ease;
  transition: color 1s ease;
}
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
</script>
<div id="popup1" class="modal-box">
  <header> <a href="#" class="btn btn-small js-modal-close">Close</a> 
    <h3>Select Bill Number</h3>
  </header>
  <div class="modal-body">

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right" valign="bottom">
<input type="text" placeholder="<?=SEARCH_KEYWORD?>" class="textbox autocomplete" id="search"/>




		</td>
      </tr>
	 
	<tr>
	  <td  valign="top" height="400">
	

<form action="" method="post" name="form1">

<div id="preview_div34">

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

  </div> 

  
</form>
</td>
	</tr>
</table>
<footer> <a href="#" class="btn btn-small js-modal-close">Close</a> </footer>
</div>

<script language="JavaScript1.2" type="text/javascript">
function ResetSearch(){	
	$("#prv_msg_div").show();
	$("#frmSrch").hide();
	$("#preview_div").hide();
}



function SetbomCode(bomCode,bill_option,bom_Sku7676){	
	ResetSearch();
       
        var bom_Sku = document.getElementById("bom_Sku").value;
        //var bom_item_id = window.parent.document.getElementById("bom_item_id").value;
        //var bom_on_hand_qty = window.parent.document.getElementById("bom_on_hand_qty").value;
        //var bom_description = window.parent.document.getElementById("bom_description").value;

    $(".modal-box, .modal-overlay").fadeOut(500, function() {
        $(".modal-overlay").remove();
    });
        
        //alert(bill_option);

	ShowHideLoader('1','P');
	location.href= "editBOM.php?bc="+bomCode+"&bom_Sku="+bom_Sku;
	


}


    $(document).ready(function(){       
        
	$(function() {

	$( ".autocomplete" ).autocomplete({
		source: "../jsonSku.php",
		minLength: 1
	});
	});
        
        
    });

</script>

<script>
$(function(){

var appendthis =  ("<div class='modal-overlay js-modal-close'></div>");

	$('a[data-modal-id]').click(function(e) {
	if($("#bom_Sku").val()!=''){
		e.preventDefault();
	    $("body").append(appendthis);
	    $(".modal-overlay").fadeTo(500, 0.7);
	    //$(".js-modalbox").fadeIn(500);
			var modalBox = $(this).attr('data-modal-id');
			$('#'+modalBox).fadeIn($(this).data());
}else{
alert("Please Enter Bill Number First.");
$("#bom_Sku").focus();
return false;
}
		});  
  
  
$(".js-modal-close, .modal-overlay").click(function() {
    $(".modal-box, .modal-overlay").fadeOut(500, function() {
        $(".modal-overlay").remove();
    });
 
});
 
$(window).resize(function() {
    $(".modal-box").css({
        top: ($(window).height() - $(".modal-box").outerHeight()) / 2,
        left: ($(window).width() - $(".modal-box").outerWidth()) / 2
    });
});
 
$(window).resize();
 
});



</script>


