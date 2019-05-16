
<script>
var inputstr;   
var addVariant;

	$(document).ready(function () {
	var counter = 2;
	var reqcounter = 1;      
	var TaxRateOption = $("#TaxRateOption").val();
	$("#addrow").on("click", function () { 	
		counter = parseInt($("#NumLine").val()) + 1;
		var newRow = $("<tr class='itembg'>");
		var cols = "";

	

	
        cols += '<td><img src="../images/delete.png" id="ibtnDel" title="Delete">&nbsp;<input data-sku="y" type="text" name="sku' + counter + '" id="sku' + counter + '" class="textbox" size="20" maxlength="20" style="width: 83px;"  onclick="Javascript:SetAutoComplete(this);" onblur="SearchQUOTEComponent(this.value,'+counter+')" />&nbsp;<a href="#" onclick="javascript:selectItem(\''+counter+ '\',1);return false;"><img src="../images/view.gif" border="0" title="Search"></a>&nbsp;&nbsp;<a class="fancybox reqbox fancybox.iframe" id="req_link' + counter + '" href="reqItem.php?id=' + counter + '" style="display:none"><img src="../images/tab-new.png" style="display:none;" border="0" title="Additional Items" ></a><input type="hidden" name="item_id' + counter + '" id="item_id' + counter + '" readonly maxlength="20"  /><input type="hidden" name="req_item' + counter + '" id="req_item' + counter + '" readonly /><input type="hidden" name="old_req_item' + counter + '" id="old_req_item' + counter + '" readonly /><input type="hidden" name="add_req_flag' + counter + '" id="add_req_flag' + counter + '" readonly /><input data-parent="y" type="hidden" name="parent_ItemID' + counter + '" id="parent_ItemID' + counter + '" value="" readonly=""/><input data-ReqItem="y" type="hidden" name="Req_ItemID' + counter + '" id="Req_ItemID' + counter + '" value="" readonly=""/><input data-OrgQty="y" type="hidden" name="Org_Qty' + counter + '" id="Org_Qty' + counter + '" value="" readonly=""/></td><td><textarea name="description' + counter + '" id="description' + counter + '"  class="textbox" style="width:500px; height: 16px;"></textarea> </td> <td><div><select name="Condition' + counter + '" id="Condition' + counter + '" class="textbox"   style="width:80px;"><option value="">Select</option><?=$ConditionSelectedDrop?></select></div></td><td><input data-qty="y" type="text" name="qty' + counter + '"  id="qty' + counter + '"   class="textbox" size="2" maxlength="10" onkeypress="return isNumberKey(event);" /></td>';



		newRow.append(cols);
		$("table.order-list").append(newRow);
		$("#NumLine").val(counter);
		counter++;


	});









	$("table.order-list").on("focus",'input[name^="sku"]', function (event) {
			
			var add_req_flag = $(this).closest("tr").find('input[name^="add_req_flag"]').val();
			if(add_req_flag == 0){
			  addRequiredItem($(this).closest("tr"));
			}			
			
		});



	$("table.order-list").on("click", "#ibtnDel", function (event) {

		/********Edited by pk **********/
		var row = $(this).closest("tr");
		var id = row.find('input[name^="id"]').val(); 
		if(id>0){
			var DelItemVal = $("#DelItem").val();
			if(DelItemVal!='') DelItemVal = DelItemVal+',';
			$("#DelItem").val(DelItemVal+id);
		}
		/*****************************/
		
		if((row.find('input[name^="parent_ItemID"]').val() == "") && (row.find('input[name^="item_id"]').val()!='') )
		{
			
			if(row.hasClass('parent')){
				var delChildval = new Array();
				row.nextUntil('tr.parent').addBack().each(function(){
					delChildval.push($(this).find('input[name^="id"]').val()) ;
				});
				olddel = $("#DelItem").val().split(',');
				newArr = $.merge( olddel, delChildval);
				delChildval = $.unique(newArr);
				$("#DelItem").val(delChildval.join(','));	
				
				row.nextUntil('tr.parent').addBack().remove();
			}else{
				$(this).closest("tr").remove();
			}
		}else{
			$(this).closest("tr").remove();
		}
		
		

	});



	

	});


     function addRequiredItem(row) { 
			
			//inputstr = row.find('input[name^="sku"]').val().toLowerCase();           //By chetan 3Sep//
			var req_item = row.find('input[name^="req_item"]').val();
			if(req_item != ''){
				var req_itm_sp = req_item.split("#");	
				var req_item_length = req_itm_sp.length;

			}	
	
			

		<!--FOR ITEM ADD CODE -->
 		 
if(req_item_length > 0){
for(var r = 1; r<=req_item_length; r++){
$("#addrow").click();
}

var NumLine =  parseInt($("#NumLine").val());


for(var s = 0; s < req_item_length; s++){
var reqItem = req_itm_sp[s];
var req_itm_sp_pipe = reqItem.split("|");


for(var m = 1; m<=NumLine; m++){
if(document.getElementById("sku"+m) != null){
if(document.getElementById("sku"+m).value == "")
	{
		$("#sku"+m).closest('tr').css("background-color", "#d33f3e").addClass('child'); 
		document.getElementById("item_id"+m).value = req_itm_sp_pipe[0];
		document.getElementById("sku"+m).value = req_itm_sp_pipe[1];
		document.getElementById("description"+m).value = req_itm_sp_pipe[2];
		document.getElementById("qty"+m).value = (req_itm_sp_pipe[3]) ? req_itm_sp_pipe[3] : 1;   
		
		/****************************************************************/
	document.getElementById("sku"+m).setAttribute("class", "disabled");
	document.getElementById("sku"+m).setAttribute("readonly", "readonly");
		document.getElementById("qty"+m).setAttribute("class", "disabled");
		document.getElementById("qty"+m).setAttribute("readonly", "readonly");
		document.getElementById("parent_ItemID"+m).value = row.find('input[name^="item_id"]').val(); 
		document.getElementById("Org_Qty"+m).value = (req_itm_sp_pipe[3]) ? req_itm_sp_pipe[3] : 1;  
                       $("#sku"+m).next('a').attr('onclick','return false;');              
			
		break;	
}		

}	
}		
}
//By Chetan 12Jan//		
		//showTotalPrice();
}	
			
		<!--END ITEM ADD CODE-->
		        
		row.find('input[name^="add_req_flag"]').val('1');		

			
		}



function SearchQUOTEComponent(key,count){
	key = $.trim(key); 
	
	if($('#sku'+count).closest('tr').next().length == 1)
	{
		if($('#sku'+count).closest('tr').find('input[name^="item_id"]').val() == $('#sku'+count).closest('tr').next().find('input[name^="parent_ItemID"]').val())
 		{
			return false;
		}
	}
	
	if($.trim(key)==''){return false;}
	key = key.toLowerCase();
	if(inputstr == key){ 
	return false;
	}
	inputstr = key;
    


     var NumLine = document.getElementById("NumLine").value;   
   
    /******************/
    var SkuExist = 0;
	if(document.getElementById("sku"+count).value == ''){
		return false;
	}
  
	
    ShowHideLoader('1', 'P');
    $('.itembg td:first-child input[data-sku="y"]').each(function(){$(this).attr('disabled',true);})
 
    /******************/
    if(SkuExist == 1){
   	
         alert('Item Sku [ '+key+' ] has been already selected.');
	 document.getElementById("sku"+count).value = '';
         
         ShowHideLoader('2', 'P');
         $('.itembg td:first-child input[data-sku="y"]').each(function(){$(this).attr('disabled',false);})
        
 
    }else{
        
        document.getElementById("sku"+count).value = '';
        var SelID = count;
      
        var SendUrl = "&action=SearchBomCode&key="+escape(key)+"&SelID="+SelID+"&r="+Math.random();

        /******************/
        $.ajax({
            type: "GET",
            url: "../sales/ajax.php",
            data: SendUrl,
            dataType : "JSON",
            success: function (responseText) {
           
                   if(responseText["Sku"] == undefined){

                              $.fancybox.open({
                                padding : 0,
                                closeClick  : false, // prevents closing when clicking INSIDE fancybox
                                href:'../sales/addItem.php?Sku='+key+'&selectid='+SelID,
                                type: 'iframe',
                                helpers   : { 
                                                overlay : {closeClick: false} 
                                            }
                            });
                        //alert('Item Sku [ '+key+' ] is not exists.');
//AlertMsg(document.getElementById("sku"+SelID),'Item Sku [ '+key+' ] is not exists, click here to <a href="../inventory/editItem.php" target="_blank">Add Item</a>.');
//DisplayConMsg(document.getElementById("sku"+SelID),'Alert','Item SKU does not exists.');
			document.getElementById("sku"+SelID).value='';
			document.getElementById("sku"+SelID).value='';
			document.getElementById("item_id"+SelID).value='';
			
			document.getElementById("description"+SelID).value='';
			document.getElementById("qty"+SelID).value='';
			
			
			ShowHideLoader('2', 'P');
                       

                      

                   }else{

			 //document.getElementById("req_item" + SelID).value = responseText["RequiredItem"];       //By Chetan2Sep//hide by chetan on 21Mar2017//
                        //By Chetan 2Sep for display component//                       
                        if(responseText["itemType"] == 'Non Kit' && typeof responseText["KitItemsCount"] != 'undefined' && responseText["KitItemsCount"] > 0 && typeof responseText["showPopUp"] == 'undefined')
                        {
                            //if(confirm("Display Component Item!")) {
																	$reqitem = (responseText["RequiredItem"]) ? responseText["RequiredItem"]+'#' : '';  
																	document.getElementById("req_item" + SelID).value = $reqitem + responseText["KitItems"];
																	if(document.getElementById("req_item" + SelID).value) $("#sku"+SelID).closest('tr').addClass('parent').css("background-color", "#106db2"); else  $("#sku"+SelID).closest('tr').addClass('parent'); 
                           // }else{
				                        
			                     // }	 
                        }else{
			   var showreq = 1;	//added on 11Apr2017 by chetan//
$("#sku"+SelID).closest('tr').addClass('parent'); 
			}    
                        
            
                        //to show alias and option code popup//
                        if(typeof responseText["showPopUp"] != 'undefined' && responseText["showPopUp"] == 'y')        //By Chetan 18Sep//  
                        {
                            $.fancybox.open({
                                padding : 0,
                                closeClick  : false, // prevents closing when clicking INSIDE fancybox
                                href:'../sales/getOptionCode.php?ItemID='+responseText["ItemID"]+'&key='+responseText["Sku"]+'&proc=Sale&id='+SelID+'&back=No',
                                type: 'iframe',
                                helpers   : { 
                                                overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox 
                                            }
                            });
                            
			    showreq = '';	//added on 11Apr2017 by chetan//
                            ShowHideLoader('2', 'P');           //By Chetan 9Sep// 
                            return false;
                        }
                       //End//
				
				if(showreq == 1){
				document.getElementById("req_item" + SelID).value = responseText["RequiredItem"];
				}
				
				$("#sku"+SelID).closest('tr').addClass('parent');   
				document.getElementById("sku"+SelID).value=responseText["Sku"];
				document.getElementById("item_id"+SelID).value=responseText["ItemID"];
				document.getElementById("description"+SelID).value=responseText["description"];
				document.getElementById("qty"+SelID).value='';
				document.getElementById("Req_ItemID" + SelID).value = responseText["ReqItemIDs"];   //By Chetan 31Aug//
			

			   
                       
                    if (document.getElementById("req_link" + SelID) != null) {
                        var ReqDisplay = 'none';
                        if (responseText["NumRequiredItem"] > 0) {
                            ReqDisplay = 'inline';
                            var link_req = document.getElementById("req_link" + SelID);
                            link_req.setAttribute("href", 'reqItem.php?item=' + responseText["ItemID"]);

                        }
        document.getElementById("req_link" + SelID).style.display = ReqDisplay;
		  	if (document.getElementById("old_req_item" + SelID) != null) {
			  document.getElementById("old_req_item" + SelID).value = document.getElementById("req_item" + SelID).value;
			  document.getElementById("add_req_flag" + SelID).value = 0;
			}


                    }
                   

		 $('.itembg td:first-child input[data-sku="y"]').each(function(){$(this).attr('disabled',false);});           //By Chetan 9Sep// 
		//document.getElementById("price" + SelID).focus();
		document.getElementById("sku" + SelID).focus();         //By chetan 31Aug//


                   
		ShowHideLoader('2', 'P');           

                        
                        
                      }

            }
        });
        /******************/
    }
}




function SetAutoComplete(elm){		
	$(elm).autocomplete({
		source: "../jsonSku.php",
		minLength: 1
	});

}

//By Chetan 18sep//
$(function(){
    
    //For removing required item if main item sku changed//
    $(document).on('keypress','.itembg td:first-child input[data-sku="y"]',function(e){
       //updated by chetan May19 //
            var keyCode = e.keyCode || e.which;
          if(keyCode=='9'){return false; }
        //End//
        textstr = $.trim($(this).val());
       
    })
    
    $(document).on('keyup','.itembg td:first-child input[data-sku="y"]',function(e){
        //updated by chetan May19 //
            var keyCode = e.keyCode || e.which;
          if(keyCode=='9'){return false; }
        //End//
        //IndexRow = (parseInt($(this).attr('id').replace(/[^0-9\.]/g, ''))); 
       // if(e.keyCode === 8){
                if($.trim($(this).val()) !== textstr){
                removeChild($(this));
           }
        //}
        
    });    
    
   
   //For changing qty of all required item on main item qty change//
   $(document).on('input','.itembg td input[data-qty="y"]',function(){
   
        QtyVAl = $(this).val().replace(/[^0-9\.]/g, '');
        ReqArr = [];
        IndexRow = (parseInt($(this).attr('id').replace(/[^0-9\.]/g, ''))); 
        //if($('#Req_ItemID'+IndexRow+'').val()!='')
        //{
            selItemId = $('#item_id'+IndexRow+'').val();
            ReqArr = $('#Req_ItemID'+IndexRow+'').val().split('#');
            $(this).closest('tr').nextAll().find('td input[data-qty="y"]').each(function(i){

                    Indexing = parseInt($(this).attr('id').replace(/[^0-9\.]/g, ''));  
                    if($('#parent_ItemID'+Indexing+'').val() == selItemId || jQuery.inArray($('#item_id'+Indexing+'').val(),ReqArr) !='-1')
                    {    
                       	$res = QtyVAl * ($('#Org_Qty'+Indexing+'').val().replace(/[^0-9\.]/g,''));
                        $(this).val($res);
                        $(this).addClass('disabled');
                        $(this).attr('readonly', 'readonly');
                    }
            });
        //}
     
   })
   
    //End//   

	 //By chetan 9sep//
   //to remove disable attr and to call again same item name typed before//
   $(document).on('click','.fancybox-close', function(){
       inputstr = '';
       $('.itembg td:first-child input[data-sku="y"]').each(function(){$(this).attr('disabled',false);});
   });
   
    //End//   
	

	 //Pop up css script//
    var appendthis =  ("<div class='modal-overlay js-modal-close'></div>");

	$('a[data-modal-id]').click(function(e) {
		e.preventDefault();
	    $("body").append(appendthis);
	    $(".modal-overlay").fadeTo(500, 0.7);
			var modalBox = $(this).attr('data-modal-id');
			$('#'+modalBox).fadeIn($(this).data());
		});  
  
  
$(".js-modal-close, .modal-overlay").click(function() {
    $(".modal-box, .modal-overlay").fadeOut(1000, function() {
        $(".modal-overlay").remove();
    });
 
});
 
$(window).resize(function() {
    $(".modal-box").css({
        top: ($(window).height() + $(".modal-box").outerHeight()),
        left: ($(window).width() - $(".modal-box").outerWidth()) / 2,
        posititon:'fixed'
    });
});

	
//pop up search on keyup21Sep//
$(document).on('click', '#go', function(){  searchTable($('#search').val()); });


//To disable condition select if sku have children 1feb//

$('.itembg td:first-child input[data-parent="y"][value=""]').each(function(){

	if($(this).closest('tr').next().length > 0)
	{
		if($(this).closest('tr').next().find('input[name^="parent_ItemID"]').val() == $(this).closest('tr').find('input[name^="item_id"]').val() && $(this).closest('tr').find('input[name^="NotitemAlias"]').length > 0)
		{
			$(this).closest('tr').find('select[name^="Condition"]').addClass('disabled').prop('disabled',true);
		}
	}

})

    
})

//function to remove item all required items//
function removeChild(obj){
    var ids = [];
    IndexRow = (parseInt(obj.attr('id').replace(/[^0-9\.]/g, ''))); 
    if($('#req_item'+IndexRow+'').val() !='')
    {
        var selItem = $('#item_id'+IndexRow+'').val();
        if(selItem!='')
        {
            $('.itembg td:first-child input[data-parent="y"]').each(function(number){

                ids.push((parseInt($(this).attr('id').replace(/[^0-9\.]/g, ''))));
            });
           
            $(ids).each(function(index, value){
              
               if($('#parent_ItemID'+value+'').val() == selItem)
                {    
                    $('#parent_ItemID'+value+'').closest('tr').remove();
                }
               
           })

        }
    } 
}




//18Sep//
function selectItem(line,pageNo)
{   
    ShowHideLoader('1', 'P');    
    SendUrl = 'action=SelectItem&proc=Sale&id='+line+'&curP='+pageNo;
    $.ajax({
            type: "GET",
            url: "../sales/ajax.php",
            data: SendUrl,
            dataType : "JSON",
            success: function(responseText){
                $('#popup1 .modal-body').html(responseText);
                $('#popup1').css('display','block');

                //convert php paging into jquery ajax//    

                $('a.pagenumber, a.edit22').each(function(){

                    arrstr = $(this).attr('href').split('?');
                    arrstr = arrstr[1].split('&');
                    $.each(arrstr, function( index, value ) {

                        if(/curP/.test(value))
                        {
                             page = parseInt(value.replace(/[^0-9\.]/g, '')); 
                        }
                    })

                    $(this).attr('href','#');
                    line = $('#NumLine').val();
                    $(this).attr('onclick','javascript:selectItem("'+line+'","'+page+'")');

                });
                //End//
                $(window).resize();
                $(window).scrollTop($(window).height() + $(".modal-box").outerHeight());
                ShowHideLoader('2', 'P');    


            }
    }); 
}    


function SetItemCode(ItemID, Sku, SelID,proc) {
	var NumLine = document.getElementById("NumLine").value;
//var SelID = $("#id").val();

	/******************/
	var SkuExist = 0;

	/*for (var i = 1; i <= NumLine; i++) {
	    if (document.getElementById("sku" + i) != null) {
		if (document.getElementById("sku" + i).value == Sku) {
		    SkuExist = 1;
		    break;
		}
	    }
	}*/
	/******************/
        if (SkuExist == 1) {
            $("#msg_div").html('Item Sku [ ' + Sku + ' ] has been already selectitsale.');
        } else {
                ShowHideLoader('1', 'P');
	
		var showComponent = ($('#yes').is(':checked'))? '1' :''; 
		var SendUrl = "&action=ItemInfo&ItemID=" + escape(ItemID) + "&proc=" + escape(proc) +"&showcompo="+ showComponent + "&SelID="+SelID+"&r=" + Math.random();


            /******************/
            $.ajax({
                type: "GET",
                url: "../sales/ajax.php",
                data: SendUrl,
                dataType: "JSON",
                success: function(responseText) {

			document.getElementById("sku" + SelID).value = responseText["Sku"];
			document.getElementById("item_id" + SelID).value = responseText["ItemID"];
			document.getElementById("description" + SelID).value = responseText["description"];
			document.getElementById("qty" + SelID).value = '1';
			document.getElementById("Req_ItemID" + SelID).value = responseText["ReqItemIDs"];    




		

                }
            });
            /******************/
        }

    }

function searchTable(inputVal)
{
	 ShowHideLoader('1', 'P');
    line = $('#id').val();
    SendUrl = 'action=SelectItem&str='+inputVal+'&proc=Sale&id='+line+'&curP=1';
    $.ajax({
            type: "GET",
            url: "../sales/ajax.php",
            data: SendUrl,
            dataType : "JSON",
            success: function(responseText){
                
                        $('#popup1 .modal-body').html(responseText);
                        $('#popup1').css('display','block');

                        //convert php paging into jquery ajax//    

                        $('a.pagenumber, a.edit22').each(function(){

                            arrstr = $(this).attr('href').split('?');
                            arrstr = arrstr[1].split('&');
                            $.each(arrstr, function( index, value ) {

                                if(/curP/.test(value))
                                {
                                     page = parseInt(value.replace(/[^0-9\.]/g, '')); 
                                }
                            })

                            $(this).attr('href','#');
                            line = $('#NumLine').val();
                            $(this).attr('onclick','javascript:selectItem("'+line+'","'+page+'")');

                        });
                        //End//
                        $(window).resize();
                        $(window).scrollTop($(window).height() + $(".modal-box").outerHeight());
                        ShowHideLoader('2', 'P');    


                    }
    }); 
}






</script>


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

top: 18.5px;
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

//.modal-box .modal-body { padding: 2em 1.5em; }

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

</style>




<?php 
 $TaxRateOption = "<option value='0'>None</option>";
if(!empty($arrySaleTax)){
	 for($i=0;$i<sizeof($arrySaleTax);$i++) {
		$TaxRateOption .= "<option value='".$arrySaleTax[$i]['RateId'].":".$arrySaleTax[$i]['TaxRate']."'>
		".$arrySaleTax[$i]['RateDescription']." : ".$arrySaleTax[$i]['TaxRate']."</option>";
	 } 
}

#print_r($arryCompany[0]['TrackInventory']);


?>	
<input type="hidden" name="TaxRateOption" id="TaxRateOption" value="<?=$TaxRateOption?>" readonly />


<!--script language="javascript" src="js/editSalesQuoteOrder.php.js"></script-->



 <table width="100%" id="myTable" class="order-list"  cellpadding="0" cellspacing="1">
<thead>
    <tr align="left" >
					<td width="20%" class="heading">&nbsp;&nbsp;SKU</td>
					<td class="heading">Description</td>
<td width="20%"class="heading">Condition</td>
					<td width="10%" class="heading">Qty</td>
					
    </tr>
</thead>
<tbody>
	<? 
	$subtotal=0;
	
	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	
	
	$ReqDisplay = !empty($arrySaleItem[$Count]['req_item'])?(''):('style="display:none"');
 
$ConditionSelectedDropValue  =$objCondition-> GetConditionDropValue($arrySaleItem[$Count]["Condition"]);
        
        if(!empty($arrySaleItem[$Count]['parent_ItemID'])){
                $disable = 'class = "disabled" readonly="readonly"';
		$color = "style='background-color:#d33f3e'";
		$class = 'child';
        }else{
		if($arrySaleItem[$Count]['req_item']){
            		$color = (!empty($_GET['edit'])) ? "style='background-color:#106db2'" : '';
		 }else{
			$color = '';
		 }
		$class = 'parent';
                $disable = "";
        }//End//?>

     <tr class='itembg <?=$class?>'   <?=$color?>>
		<td>

<?/*=($Line>1)?('<img src="../images/delete.png" id="ibtnDel" title="Delete">'):("&nbsp;&nbsp;&nbsp;")*/?>
<? echo '<img src="../images/delete.png" id="ibtnDel" title="Delete">';?>

		<!--<input data-sku='y' type="text" name="sku<?=$Line?>" style="width:83px;"  id="sku<?=$Line?>" class="textbox"  size="50" maxlength="50"  value="<?=stripslashes($arrySaleItem[$Count]['sku'])?>" onblur="SearchQUOTEComponent(this.value,<?=$Line?>)" onclick="Javascript:SetAutoComplete(this);"/>&nbsp;<a href="#" onclick="javascript:selectItem('<?=$Line?>','1');return false;" ><img src="../images/view.gif" border="0" title="Search"></a>&nbsp;&nbsp;<a class="fancybox reqbox  fancybox.iframe" href="reqItem.php?id=<?=$Line?>&oid=<?=$arrySaleItem[$Count]['id']?>" id="req_link<?=$Line?>" <?=$ReqDisplay?>><img src="../images/tab-new.png" style="display:none;" border="0" title="Additional Items"></a>-->

<!--By chetan 6Jan--->
		<input data-sku='y' type="text" name="sku<?=$Line?>" style="width:83px;"  id="sku<?=$Line?>"   size="50" maxlength="50"  value="<?=stripslashes($arrySaleItem[$Count]['sku'])?>"  <?php if($disable){ echo 'readonly class="disabled textbox"';}else{?> onblur="SearchQUOTEComponent(this.value,<?=$Line?>)" onclick="Javascript:SetAutoComplete(this);" class="textbox" <?php } ?>/>&nbsp; 

<?php if(empty($disable)){?><a href="#" onclick="javascript:selectItem('<?=$Line?>','1');return false;" ><img src="../images/view.gif" border="0" title="Search"></a>&nbsp;&nbsp;<a class="fancybox reqbox  fancybox.iframe" href="reqItem.php?id=<?=$Line?>&oid=<?=$arrySaleItem[$Count]['id']?>" id="req_link<?=$Line?>" <?=$ReqDisplay?>><img src="../images/tab-new.png" style="display:none;" border="0" title="Additional Items"></a><?php }?>
<!--End--->
		<input type="hidden" name="item_id<?=$Line?>" id="item_id<?=$Line?>" value="<?=stripslashes($arrySaleItem[$Count]['item_id'])?>" readonly maxlength="20"  />
		<input type="hidden" name="id<?=$Line?>" id="id<?=$Line?>" value="<?=$arrySaleItem[$Count]['id']?>" readonly maxlength="20" class="formactive" />
		
		<input type="hidden" name="req_item<?=$Line?>" id="req_item<?=$Line?>" value="<?=stripslashes($arrySaleItem[$Count]['req_item'])?>" readonly />
                

                 <input type="hidden" name="old_req_item<?=$Line?>" id="old_req_item<?=$Line?>" value="<?=stripslashes($arrySaleItem[$Count]['old_req_item'])?>" readonly />
               
                 <input type="hidden" name="add_req_flag<?=$Line?>" id="add_req_flag<?=$Line?>" value="<?=($arrySaleItem[$Count]['sku']) ? 1 : '';?>" readonly />
		
               <input data-parent='y' type="hidden" name="parent_ItemID<?=$Line?>" id="parent_ItemID<?=$Line?>" value="<?=(!empty($arrySaleItem[$Count]['parent_item_id'])) ? $arrySaleItem[$Count]['parent_ItemID'] : '';?>" readonly=""/>
                <input data-ReqItem='y' type="hidden" name="Req_ItemID<?=$Line?>" id="Req_ItemID<?=$Line?>" value="<?=$arrySaleItem[$Count]['Req_ItemID']?>" readonly=""/>
		<input data-OrgQty="y" type="hidden" name="Org_Qty<?=$Line?>" id="Org_Qty<?=$Line?>"  value="<?=(!empty($arrySaleItem[$Count]['Org_Qty'])) ? $arrySaleItem[$Count]['Org_Qty'] : '';?>" readonly=""/>
               
	
		</td>
   
<td>

<textarea name="description<?=$Line?>" id="description<?=$Line?>"  <?php if(empty($disable)){?> class="textbox" <?php }else{ echo $disable; }?> style="width:500px; height: 16px;"><?=stripslashes($arrySaleItem[$Count]["description"])?></textarea>

</td>
       
	   <td><div>


<select name="Condition<?=$Line?>" id="Condition<?=$Line?>" class="textbox"  <?php if($_GET['edit']>0){ ?>onchange="getItemCondionQty('<?=stripslashes($arrySaleItem[$Count]['sku'])?>','<?=$Line?>',this.value)" <?php }?> style="width:80px;"><option value="" <?=$selectCond?>>Select</option><?=$ConditionSelectedDropValue?></select>

 </div></td>    
        
        <td><input <?=$disable?> data-qty="y" type="text" name="qty<?=$Line?>"  id="qty<?=$Line?>" class="textbox" size="2" maxlength="6" onkeypress="return isNumberKey(event);" value="<?=stripslashes($arrySaleItem[$Count]["qty"])?>"/></td>

  <!--By chetan 11Jan--->
       
       
    </tr>
	<? 
		if(!empty($arrySaleItem[$Count]["amount"]))$subtotal += $arrySaleItem[$Count]["amount"];
	} ?>
</tbody>
<tfoot>

    <tr class='itembg'>
        <td colspan="13" align="right">

		 <a href="Javascript:void(0);"  id="addrow" class="add_row" style="float:left">Add Row</a>
		 
       		 <input type="hidden" name="NumLine" id="NumLine"  class="formactive" value="<?=$NumLine?>" readonly maxlength="20"  />
        	 <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />



	
        </td>
    </tr>
</tfoot>
</table>


<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
		$(".reqbox").fancybox({
			'width'         : 500
		 });

  $(".slnoclass").fancybox({
			'width'         : 50%
		 });
                 
    $(".controle").fancybox({
        'width':300,
        'height':500,
        'autoSize' : false,
        'afterClose':function(){
            
        }, 
    });	  


});




//-----------------------------------------End---------------------------------------->


</script>

<? #echo '<script>SetInnerWidth();</script>'; ?>


