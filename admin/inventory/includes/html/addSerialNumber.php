<script language="JavaScript1.2" type="text/javascript">
jQuery(document).ready(function(){
    jQuery('.serial-li').dblclick(function(){
      if(!jQuery(this).hasClass('disable')){
          AddtoSelectedSerial(jQuery(this));
        }
    })

    jQuery('.serial-search-input').keydown(function(e){
      if ( e.which == 13 ) {
       e.preventDefault();
       var text=jQuery(this).val();
       var inputobj=jQuery(this);
       if(!text){
        alert('Please enter serial number');
        return false;
       }
    var i=0;
       jQuery('body .serial-li').each(function(){
        if(!jQuery(this).hasClass('disable') && jQuery(this).attr('data-serial').trim().toLowerCase()==text.toLowerCase()){
           AddtoSelectedSerial(jQuery(this));
    i++;

        }

       })

       if(i!=0){
        inputobj.val('');
       }else{

        alert('Serial number not match');
       }
      }
    })

    jQuery('body').on('click','.serial-close',function(){		

		removeSelected(jQuery(this).parents('.serial-selected-li'));

    });

    jQuery('body').on('click','.clear-all',function(){
		var obj=jQuery(this);
		jQuery('.serial-selected-li').each(function(){
				var serial=jQuery(this).attr('data-serial');
				jQuery('.serialclass-'+serial).removeClass('disable');
				jQuery(this).remove();

		});

/********all selected Serial no Available for use click on clear all update by bhoodev 18jan2017 ***************/
  var Sku = "<?=$_GET['sku']?>";
	var Condition = "<?=$_GET['cond']?>";
	var allserials = jQuery('#allSelectedSerialNumber').val();
	var SendParam = 'action=clearSelSerialNo&SelSerialNo=' + escape(allserials) + '&Sku='+Sku+'&Condition='+Condition+'&r=' + Math.random();

 				$.ajax({
                type: "GET",
                async: false,
                url: '../warehouse/ajax.php',
                data: SendParam,
                dataType : "JSON",
                success: function(responseText) {
                  if(responseText){  
													var totalqty=jQuery('#totalQtyInvoced').val();
													jQuery('#allSelectedSerialNumber').val('');
													jQuery('#AvgCost').val(0);
													jQuery('.order-qty').text(totalqty);
													 window.parent.document.getElementById("price<?=$_GET['id']?>").value = '0.00';
													 window.parent.document.getElementById("serial_value<?=$_GET['id']?>").value='';
                                            
                        }else{
                              alert('Please try again');

                        }
                }

            });
/************** End ****************************/

		/*var totalqty=jQuery('#totalQtyInvoced').val();

		jQuery('#allSelectedSerialNumber').val('');
		jQuery('#AvgCost').val(0);
		jQuery('.order-qty').text(totalqty);*/
		obj.remove();
     })


/* Select all script*/
    jQuery('body').on('click','.select-all',function(){
        
 		var obj111=jQuery(this);
 		var totalqty=jQuery('#totalQtyInvoced').val();
 		var i=1;
 		 var tmpserial=jQuery('#allSelectedSerialNumber').val();
 		 var allserial=[];
 		 if(tmpserial){
 			 	var allserial= tmpserial.split(',');
 			 }
var TotalUnit =0;
 		
 	jQuery('.serial-li').not(jQuery('.serial-li.disable')).each(function(){

     		//console.log(totalqty+'--'+i);
 				if(totalqty>=i){
 		    			  var serial=jQuery(this).attr('data-serial');
 		    			  allserial.push(serial);	
							var unitcost = jQuery(this).attr('data-unitcost');
						TotalUnit +=parseFloat(unitcost) 		    			
 						i++;
 			
 					}
 							
 		});
jQuery('.serial-li').not(jQuery('.serial-li.disable')).each(function(){

     		//console.log(totalqty+'--'+i);
 				if(totalqty>=i){
 		    			  var serial=jQuery(this).attr('data-serial');
//console.log( serial);
 		    			  allserial.push(serial);	
								var unitcost = jQuery(this).attr('data-unitcost');
TotalUnit +=parseFloat(unitcost); 
//TotalUnit.push(unitcost);
		    			
 						i++;
 			
 					}
 							
 		});


 		console.log( allserial);

 		var allserialsString=allserial.join();
 		var cost=0;
 		  var Sku = "<?=$_GET['sku']?>";
 		  var condition = "<?=$_GET['cond']?>";
 		  var SendParam = 'action=checkSelSerialNo&Sku='+Sku+'&r=' + Math.random()+'&Condition='+condition;
 		
 		   for(var ii in allserial){

 			var obj=jQuery('.serialclass-'+allserial[ii]);
 			 obj.addClass('disable'); 
          var html='';
              html +='<li data-serial="'+allserial[ii]+'" class="serial-selected-li">'+obj.html()+'<span class="serial-close"></span></li>';
                   jQuery('.serial-selected ul').append(html);
 			}
 		 jQuery('#allSelectedSerialNumber').val(allserialsString);
 		   $("#AvgCost").val(TotalUnit.toFixed(2));

            jQuery('.order-qty').text(0);
            if(jQuery('.clear-all').length==0){
          		  jQuery('.clear-all-row').html('<a href="javascript:void(0);" class="clear-all">Clear All</a>');
               }              
                         
  



})


})



function AddtoSelectedSerial(obj){
 var remainingorder=parseInt(jQuery('.order-qty').text());
 if(remainingorder==0){
      alert('order is empty');
      return false;

 }
  var html='';
  var serial=obj.attr('data-serial');
  var text=obj.html();
  var Sku = "<?=$_GET['sku']?>";
var Condition = "<?=$_GET['cond']?>"; //add by bhoodev 18jan2017
  //allSelectedSerialNumber
  var allserials=addCommaValue(jQuery('#allSelectedSerialNumber').val(),serial);
var cost=0;
  //var SendParam = 'action=checkSelSerialNo&SelSerialNo=' + escape(allserials) + '&Sku='+Sku+'&r=' + Math.random();
 var SendParam = 'action=checkSelSerialNo&SelSerialNo=' + escape(allserials) + '&addSer='+serial+'&Sku='+Sku+'&Condition='+Condition+'&r=' + Math.random();
/* Add addSer ,Condition in SendParam variable Update by bhoodev 18jan2017*/

          $.ajax({
                type: "GET",
                async: false,
                url: '../warehouse/ajax.php',
                data: SendParam,
                dataType : "JSON",
                success: function(responseText) {
                  if(responseText){  
                   obj.addClass('disable');                                        
                        cost = parseFloat(responseText.UnitCost);    
                   alert(responseText);
                        jQuery('#allSelectedSerialNumber').val(allserials);
                        var totqty = jQuery("#totalQtyInvoced").val();                     
                       //cost = cost/parseFloat(totqty);    
                       $("#AvgCost").val(cost.toFixed(2));
												window.parent.document.getElementById("price<?=$_GET['id']?>").value = $("#AvgCost").val();
											  window.parent.document.getElementById("serial_value<?=$_GET['id']?>").value=allserials;	
                        html +='<li data-serial="'+serial+'" class="serial-selected-li">'+text+'<span class="serial-close"></span></li>';
                             jQuery('.serial-selected ul').append(html);
                              var selectedserialqty=parseInt(jQuery('.serial-selected-li').length);                            
                              jQuery('.order-qty').text(totqty-selectedserialqty);
                              if(jQuery('.clear-all').length==0){
                            	  jQuery('.clear-all-row').html('<a href="javascript:void(0);" class="clear-all">Clear All</a>');
                                 }
                                            
                        }else{
                              alert('Please try again');

                        }
                }

            });
}

function addCommaValue(list,value){
if(list){   var allvalue=list.split(',');
  }else{var allvalue=[]; }
      allvalue.push(value);
      console.log(allvalue);
    return allvalue.join(',');
}
function validJson(string){
  try {
        JSON.parse(string);
    } catch (e) {
        return false;
    }
    return true;
      
}

function removeSelected(obj){
	    var serialvalue=jQuery('#allSelectedSerialNumber').val();
	    var serial=obj.attr('data-serial');
		var totqty = jQuery("#totalQtyInvoced").val();  	  
	    var Sku = "<?=$_GET['sku']?>";
var Condition = "<?=$_GET['cond']?>"; // add by bhoodev 18jan2017
		var newvalue=removeCommaValue(serialvalue,serial,',');
	    //allSelectedSerialNumber
	  
	  var cost=0;
	    //var SendParam = 'action=checkSelSerialNo&SelSerialNo=' + escape(newvalue) + '&Sku='+Sku+'&r=' + Math.random();
var SendParam = 'action=checkSelSerialNo&SelSerialNo=' + escape(newvalue) + '&delSer='+serial+'&Sku='+Sku+'&Condition='+Condition+'&r=' + Math.random();
/* Add delSer ,Condition in SendParam variable Update by bhoodev 18jan2017*/

	            $.ajax({
	                  type: "GET",
	                  async: false,
	                  url: '../warehouse/ajax.php',
	                  data: SendParam,
	                  dataType : "JSON",
	                  success: function(responseText) {
	                    if(responseText || newvalue==''){  

                            if(responseText){           
	                            cost = parseFloat(responseText.UnitCost); 	                          
	                          //cost = cost/parseFloat(totqty); 
                            }
	                          $("#AvgCost").val(cost.toFixed(2));
	                          jQuery('.serialclass-'+serial).removeClass('disable');
	                  		jQuery('#allSelectedSerialNumber').val(newvalue);
													window.parent.document.getElementById("price<?=$_GET['id']?>").value = cost;
											window.parent.document.getElementById("serial_value<?=$_GET['id']?>").value=newvalue;		 	
	                  	    obj.remove();
	                  	    var selectedserialqty=parseInt(jQuery('.serial-selected-li').length);                       
	                  	    jQuery('.order-qty').text(totqty-selectedserialqty);
	                  	  	if(newvalue==''){
									jQuery('.clear-all').remove();
		                  	  }   
	                          }else{
	                                alert('Please try again');

	                          }
	                  }

	              });
	    
}

	 function  removeCommaValue(list, value, separator) {
		  separator = separator || ",";
		  var values = list.split(separator);
		  for(var i = 0 ; i < values.length ; i++) {
		    if(values[i] == value) {
		      values.splice(i, 1);
		      return values.join(separator);
		    }
		  }
		  return list;
		}

    function ResetSearch() {
        $("#prv_msg_div").show();
        $("#frmSrch").hide();
        $("#preview_div").hide();
    }
    

    
 $(document).ready(function(){
      //var request;
                
                $("#AddSerialNumber").click(function(event){
             
                     var Sku = "<?=$_GET['sku']?>";
                     var Condition = "<?=$_GET['cond']?>";
                     var totalqty ="<?=$_GET['total']?>";
                     var lineNumber = $("#lineNumber").val();
                
                        var allSelectedSerialNumber =  $("#allSelectedSerialNumber").val();
                        
                         if(Condition == ""){
                           alert("Please select Condition.");
                            $(parent.document).find('#serial_value'+lineNumber).val('');
                            $(parent.document).find('#price'+lineNumber).val(0.00);
                           $(parent.document).find('#Condition'+lineNumber).focus();
                            parent.$.fancybox.close(); 
                           return false;
                        }  
                        
                        if(allSelectedSerialNumber == ""){
                           alert("Please select serial number.");
                           return false;
                        }   
                       
                       var postForm = { //Fetch form data
                            'action'  : 'allAsmSerialNumber',
                            'allAsmSerialNumber' : $('#allSelectedSerialNumber').val(),
                            'Sku'  : Sku,
                            'Condition'  :  Condition   //Store name fields value
                       };
                       $.ajax({ //Process the form using $.ajax()
                           type      : 'POST', //Method type
                           url       : '../warehouse/ajax.php', //Your form processing file URL
                           data      : postForm, //Forms name
                           dataType  : 'json',
                           success   : function(data) {
                           if(data.UnitCost){
                                var AvgCost = Number(data.UnitCost)/totalqty;
                                $(parent.document).find('#serial_value'+lineNumber).val(allSelectedSerialNumber);
                                if(AvgCost>0){
                                      $(parent.document).find('#price'+lineNumber).val(AvgCost.toFixed(2));
                                      $(parent.document).find('#qty'+lineNumber).focus();
                                    //window.parent.$("#price"+lineNumber).focus();
                                }
                                 parent.$.fancybox.close();   
                           }else{
                                 var AvgCost = 0.00;
                                 $(parent.document).find('#serial_value'+lineNumber).val(allSelectedSerialNumber);
                                 $(parent.document).find('#price'+lineNumber).val(AvgCost.toFixed(2));
                                 $(parent.document).find('#qty'+lineNumber).focus();
                                  parent.$.fancybox.close(); 
                           }
                           
                           }
                       });
                      event.preventDefault(); //Prevent the default submit
    
                
                });
                       
                
       });  
            
            

function seeList(form) { 
    var result = ""; 
var resultval = "";
var Sku = "<?=$_GET['sku']?>";
var cost =0;
    for (var i = 0; i < form.allSerialNo.length; i++) { 
        if (form.allSerialNo.options[i].selected) { 


cost = Number(cost)+Number(cost);
            result +=  form.allSerialNo.options[i].value+","; 
        } 
    } 
    
var arrData = result.slice(0,-1);
//alert(cost);
     //window.parent.document.getElementById("serial_value"+lineNumber).value = resSerialNo;
//resultval = form.allSerialNo.options[i].value;
//alert(resultval);
 var SendParam = 'action=checkSelSerialNo&SelSerialNo=' + escape(arrData) + '&Sku='+Sku+'&r=' + Math.random();
//alert(SendParam);
            $.ajax({
                type: "GET",
                async: false,
                url: '../warehouse/ajax.php',
                data: SendParam,
								dataType : "JSON",
                success: function(responseText) {
                    if (responseText != "")
                    {
                        //alert("Serial Number " + responseText + " Already Exists.");
                        //$("#allSerialNo").highlight(responseText , { wordsOnly: true });
                        //return false;
                        cost = responseText["UnitCost"];


                    } else {

			
                    }

                }

            });






var totqty = document.getElementById("totalQtyInvoced").value;

 cost = cost/totqty;
     document.getElementById("allSelectedSerialNumber").value = arrData;
$("#AvgCost").val(cost.toFixed(2));
//document.getElementById("AvgCost").value = cost;
    
   // alert("You have selected:" + cost); 
} 

 $(document).ready(function(){
var qty = document.getElementById("totalQtyInvoced").value;
var avgcost=window.parent.document.getElementById("price<?=$_GET['id']?>").value;
avgcost = Number(avgcost)*Number(qty);
jQuery('#AvgCost').val(avgcost);
var Allselected = window.parent.document.getElementById("serial_value<?=$_GET['id']?>").value;

if(Allselected!=''){
var selected = Allselected.split(",");
//var selected=[101,103];
var obj=$('#allSerialNo');
var k=0;
  for (var i in selected) {
      if(jQuery('.serial-li.serialclass-'+selected[i]).length!=0){
          jQuery('.serial-li.serialclass-'+selected[i]).addClass('disable');
          var serial=selected[i];
          var text= jQuery('.serial-li.serialclass-'+selected[i]).html();
         var  html='';
           html +='<li data-serial="'+serial+'" class="serial-selected-li">'+text+'<span class="serial-close"></span></li>';
        jQuery('.serial-selected ul').append(html);
        k++;
      }
  }
    jQuery('#allSelectedSerialNumber').val(Allselected);
    var total=parseInt(jQuery('#totalQtyInvoced').val());
    jQuery('.order-qty').text(total-k);


jQuery('.clear-all-row').html('<a href="javascript:void(0);" class="clear-all">Clear All</a>');
    
}
});
</script>

<style>
    .multiSelectBox{
         /*background-color: whitesmoke;margin-bottom: 1px;*/ 
         border-bottom: 1px solid #CCCCCC; 
         height: 18px;  
         padding: 5px 0 2px 3px;
         cursor: pointer;
         
    }
    .multiSelectBox:hover {
            background-color: whitesmoke;
           } 

.serial-search-row > label {
    font-weight: bold;
    margin-right: 3%;
}
.serial-detail-row > label {
    font-weight: bold;
    margin-right: 3%;
}

.serial-list, .serial-selected {
    float: left;
    width: 49%;
}
.serial-list > h4 , .serial-selected > h4 {
    padding: 0;
    text-align: center;
}


.serial-selection-row {
    border: 1px solid;
    display: block;
    float: left;
    margin: 0 3% 10px;
    padding: 1%;
    width: 92%;
}
.serial-search-row {
    margin: 17px 20px;
}

.serial-search-input.inputbox {
    height: 20px;
    width: 60%;
}

.serial-li,.serial-selected-li {
    border: 1px solid #e5e5e5;
    margin-bottom: 2px;
    padding: 2px;     
}
.serial-li{
cursor: pointer;
}
.serial-li > label{
 cursor: pointer;
}

.serial-li > label, .serial-selected-li > label {
   
    word-wrap: break-word;
     -webkit-user-select: none; /* webkit (safari, chrome) browsers */
    -moz-user-select: none; /* mozilla browsers */
    -khtml-user-select: none; /* webkit (konqueror) browsers */
    -ms-user-select: none;
    display: block;
}
.serial-li > label > span, .serial-selected-li > label > span {
  font-weight: bold;  }
.serial-li.disable > label,.serial-li.disable {
    cursor: not-allowed;
    opacity: 0.6;
}
.serial-selected-li {
    background: #00c75b none repeat scroll 0 0;
    border-radius: 5px;
    color: #fff;
}

.serial-info li {
    display: inline-block;
    width: 47%;
     vertical-align: top;
}

.quantity > label {
    font-weight: bold;
}
.quantity {
    text-align: right;
}
.serial-selected-li {
    float: right;
    width: 90%;
       position: relative;
}
/* select All Css*/
.select-all-row {
    display: inline-block;
     margin-left: 27px;
}
/* End Select All Css*/
.serial-close {
    background: rgba(0, 0, 0, 0) url("../images/close-black.png") repeat scroll 0 0 / 15px 15px;
    height: 15px;
    position: absolute;
    right: 0;
    top: 0;
    width: 15px;
      cursor: pointer;
}

.save-button-row {
    margin-bottom: 10px;
    text-align: center;
}

.clear-all-row {
    margin-right: 3%;
    text-align: right;
}
</style>

<?php if(empty($_GET['sku'])){?>
<table width="100%"   border=0 align="center" cellpadding="0" cellspacing="0">
 <tr>
                   
<td align="left" class="red" align="center" style=" font-size: 14px;font-weight: bold;padding: 30px;">
Enter return Qty.
</td>
</tr>
</table>

<?php } else {?>
<div class="serial-search-container">
<ul class="serial-info">
<li ><label class="had"> <?php echo 'SKU';/*SERIAL_NO_FPR_SKU*/ ;?></label> : <?=$_GET['sku']?> </li>
<li class="quantity"> 
    <div><label>Total Qty</label>: <span class="total-order-qty"><?php echo !empty($_GET['total'])?$_GET['total']:0;?> </span>
   </div>
   <div><label>Qty to Order</label>: <span class="order-qty"><?php echo !empty($_GET['total'])?$_GET['total']:0;?> </span>
   </div>

   </li>
</ul>
<?php if (!empty($_SESSION['mess_Serial'])) { ?>
    <div class="redmsg" align="center"> <? echo $_SESSION['mess_Serial'];
    $dis = 1;
    ?></div>
    <? unset($_SESSION['mess_Serial']);
}
?>
<?php if(!empty($arrySerialNumber)){ ?>
    
     <div class="serial-search-row"> 
     <label>Search Serial</label><input type="text" class="serial-search-input inputbox">
     </div>
<div class="select-all-row"><a href="javascript:void(0)" class="select-all">Select All</a></div> 
     <div class="clear-all-row"> 
  
     </div>
     <div class="serial-selection-row"> 
        <div class="serial-list">
        <h4>Serial List</h4>
        <?php            
            $serial_value_sel = explode(",",$_GET['SerialValue']);           
            $serial_value_sel=array_map('trim',$serial_value_sel);
            $selectedSerial=array();
          ?>
          <ul>
            <?php foreach($arrySerialNumber as $value){             
                $class="";
                if(in_array($value['serialNumber'],$serial_value_sel)){
                  $class="disable";
                  $selectedSerial[] =$value;
                }
if($value['UsedSerial']==1) $class="disable"; //Update by bhoodev 18jan2017 for disable use serial
              ?>
              <li data-unitcost="<?php echo $value['UnitCost'];?>" data-serial="<?php echo $value['serialNumber'];?>" class="serialclass-<?php echo $value['serialNumber']; ?> serial-li<?php echo ' '.$class; ?>">
              <label><span>Serial Number</span> : <?php echo $value['serialNumber'];?></label>
               <?php if(!empty($value['UnitCost'])){?>
               <label><span>Unit Cost</span> : <?php echo $value['UnitCost'];?></label>
               <?php }?>
                <?php if(!empty($value['description'])){?>
                   <label><span>Description</span> : <?php echo $value['description'];?></label>
                   <?php }?>
             </li>
             <?php }?>

          </ul>
        </div>
        <div class="serial-selected">
          <h4>Serial Selected</h4>
           <ul>
            <?php if(!empty($selectedSerial )){foreach($selectedSerial as $value){?>
              <li data-serial="<?php echo $value['serialNumber'];?>" class="serial-selected-li"><label ><?php echo $value['serialNumber'];?>
                <?php echo !empty($value['description'])?'('.$value['description'].')':'';?>
              </label></li>
             <?php }}?>

          </ul>
        </div>

     </div>

 <?php }else{?>
<span class="red"><? echo "NO SERIAL AVAILABLE";?></span>
 <?php }?> 
                         <input type="hidden" name="lineNumber" id="lineNumber" value="<?=$_GET['id']?>">
                           <input type="hidden" name="allSelectedSerialNumber" id="allSelectedSerialNumber" value="<?=trim($_GET['SerialValue']);?>">
                           <input type="hidden" name="totalQtyInvoced" id="totalQtyInvoced" value="<?=$_GET['total']?>">
                           <input type="hidden" name="AvgCost" id="AvgCost" value="">
     
        <?php /*?>  <tr>
          <form name="addItemSerailNumber" id="addItemSerailNumber"  action=""  method="post" onSubmit="return validateI(this);"  enctype="multipart/form-data">
              <td align="left" valign="top" width="250px">
                          <?php if(!empty($arrySerialNumber)){?>
                          <b>Qty to Order: <?=$_GET['total']?></b><br>
                          
                          <?php  
                          
                          $serialValue = $arrySerialNumber;
                          
                          
                          
                          $serial_value_sel = explode(",",$_GET['SerialValue']);
                                $serial_value_sel=array_map('trim',$serial_value_sel);
                          ?>
                          
                           <select multiple="multiple" name="allSerialNo" id="allSerialNo"  class="borderall" onblur="seeList(this.form)" onchange="seeList(this.form)" onclick="seeList(this.form)" style="height: 250px; width: 280px;">
<optgroup label="Serial No &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp    |   &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp description">

                          <?php for($i=0; $i< sizeof($serialValue); $i++){?>     
                               <option value="<?=$serialValue[$i]['serialNumber']?>" class="multiSelectBox" <?php if (in_array($serialValue[$i]['serialNumber'], $serial_value_sel)){echo "selected";}?>><?=$serialValue[$i]['serialNumber']?> &nbsp&nbsp&nbsp&nbsp |&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <?=$serialValue[$i]['description']?></option>
                          <?php }?>
</optgroup>
                           </select> 
                          <?php } else {?>
                            <span class="red"><? echo "NO SERIAL AVAILABLE";?></span>
                          <?php }?>
                         
                    </td>
                    <td align="left" valign="top"></td>
                </tr>
                <?php */?>
          <?php if(!empty($arrySerialNumber)){
              
                    if($_GET['view']!=1){
              ?>      
          <div class="save-button-row">
                    <input type="button" name="submit" id="AddSerialNumber" value="Select Serial Number"  class="button"/>
          </div>
            
                    <?php }
                    }?>
   
</div>

<?php }?>
