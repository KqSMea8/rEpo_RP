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
													 window.parent.document.getElementById("avgCost<?=$_GET['id']?>").value = '';
													 window.parent.document.getElementById("serial_value<?=$_GET['id']?>").value='';
                                            
                        }else{
                              alert('Please try again');

                        }
                }

            });
/************** End ****************************/

	
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
	console.log(TotalUnit);
 		console.log(allserial);

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
                         
  

 		  

  });
/* Select all script end */



})

function AddtoSelectedSerial(obj){
 var remainingorder=parseInt(jQuery('.order-qty').text());
 if(remainingorder==0){
      alert('order is empty');
      return false;

 }
var cost=0;
  var html='';
  var serial=obj.attr('data-serial');
 cost=obj.attr('data-unitcost');
var Dcost=obj.attr('data-unitcost');

//alert(cost);
  var text=obj.html();
  var Sku = "<?=$_GET['sku']?>";
		var Condition = "<?=$_GET['cond']?>";
  //allSelectedSerialNumber
  var allserials=addCommaValue(jQuery('#allSelectedSerialNumber').val(),serial);
//var cost=0;
  var SendParam = 'action=checkSelSerialNo&SelSerialNo=' + escape(allserials) + '&addSer='+serial+'&Sku='+Sku+'&Condition='+Condition+'&r=' + Math.random();
/* Add addSer ,Condition in SendParam variable Update by bhoodev 18jan2017*/

          /*$.ajax({
                type: "GET",
                async: false,
                url: '../warehouse/ajax.php',
                data: SendParam,
                dataType : "JSON",
                success: function(responseText) {*/
                  //if(responseText){  

											/*if(responseText.Used==1){
													alert("Serial number already in use.");
														return false;
											}*/
                    obj.addClass('disable');                                        
                        cost = parseFloat(cost);   
                   cost =parseFloat($("#AvgCost").val())+cost;
//alert(cost);
                        jQuery('#allSelectedSerialNumber').val(allserials);
                        var totqty = jQuery("#totalQtyInvoced").val();                     
                       //cost = cost/parseFloat(totqty);    
                       $("#AvgCost").val(cost.toFixed(2));
var avgc =  $("#AvgCost").val();
                       cost = avgc/parseFloat(totqty); 
												window.parent.document.getElementById("avgCost<?=$_GET['id']?>").value = cost.toFixed(2);
											window.parent.document.getElementById("serial_value<?=$_GET['id']?>").value=allserials;	

                        html +='<li data-serial="'+serial+'" data-unitcost = "'+Dcost+'" class="serial-selected-li">'+text+'<span class="serial-close"></span></li>';
                             jQuery('.serial-selected ul').append(html);
                              var selectedserialqty=parseInt(jQuery('.serial-selected-li').length);
                              console.log(remainingorder);console.log(selectedserialqty);
                              jQuery('.order-qty').text(totqty-selectedserialqty);
                              if(jQuery('.clear-all').length==0){
                            	  jQuery('.clear-all-row').html('<a href="javascript:void(0);" class="clear-all">Clear All</a>');
                                 }
                                            
                        //}else{
                              //alert('Please try again');

                        //}
                //}

            //});
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
 // alert(serial);
	var newvalue=removeCommaValue(serialvalue,serial,',');
    //allSelectedSerialNumber

  var cost=0;
    var SendParam = 'action=checkSelSerialNo&SelSerialNoRm=' + escape(serial) + '&delSer='+serial+'&Sku='+Sku+'&Condition='+Condition+'&r=' + Math.random();
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
//alert(cost);                     cost =  parseFloat($("#AvgCost").val())-cost;
                          //cost = cost/parseFloat(totqty); 
                        }
                          $("#AvgCost").val(cost.toFixed(2));
                          jQuery('.serialclass-'+serial).removeClass('disable');
                  		jQuery('#allSelectedSerialNumber').val(newvalue);	

											window.parent.document.getElementById("avgCost<?=$_GET['id']?>").value = $("#AvgCost").val();
											window.parent.document.getElementById("serial_value<?=$_GET['id']?>").value=newvalue;	 	
                  	    obj.remove();
                  	    var selectedserialqty=parseInt(jQuery('.serial-selected-li').length);                       
                  	    jQuery('.order-qty').text(totqty-selectedserialqty);
//var remQty = totqty-selectedserialqty;
//cost = cost/remQty;

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
     
        $("#AddSerialNumber").click(function(){

            var allSelectedSerialNumber = document.getElementById("allSelectedSerialNumber").value;
            allSelectedSerialNumber = allSelectedSerialNumber.replace(/,$/,"");
            
             var lineNumber = $("#lineNumber").val();
             var resSerialNo = allSelectedSerialNumber.split(",");
           //  var seriallength = resSerialNo.length;
          	var seriallength =jQuery('.serial-selected-li').length;
             var totalQtyInvoced = $("#totalQtyInvoced").val();
             var AvgCost = $("#AvgCost").val();
//$("#AvgCost").val(cost.toFixed(2));
                if(allSelectedSerialNumber == ""){

                     alert("Please select serial number.");
                      return false;
                }   
                console.log(seriallength+'---'+totalQtyInvoced);
              if(seriallength != totalQtyInvoced)   
                     {
                         alert("Please select "+totalQtyInvoced+" serial number only.");
                         return false;
                     }else{
                         
                          window.parent.document.getElementById("serial_value"+lineNumber).value = allSelectedSerialNumber;
                          if(AvgCost>0){
														if(totalQtyInvoced>1){
															AvgCost = AvgCost/totalQtyInvoced;
                              AvgCost  = (parseFloat(AvgCost).toFixed(2));
															}
                        	  window.parent.document.getElementById("avgCost"+lineNumber).value = AvgCost;
                        	  //window.parent.document.getElementById("avgCost" + lineNumber).focus();
                        	  }
                          parent.$.fancybox.close();
                     }
                     
                });
            });  
            
            

function seeList(form) { 
    var result = ""; 
    for (var i = 0; i < form.allSerialNo.length; i++) { 
        if (form.allSerialNo.options[i].selected) { 
            result += "\n " + form.allSerialNo.options[i].text+","; 
        } 
    } 
    
     //window.parent.document.getElementById("serial_value"+lineNumber).value = resSerialNo;
     document.getElementById("allSelectedSerialNumber").value = result;
    
   // alert("You have selected:" + result); 
} 


 $(document).ready(function(){
if(window.parent.document.getElementById("serial_value<?=$_GET['id']?>").value!=''){
	 var avgcost=window.parent.document.getElementById("avgCost<?=$_GET['id']?>").value*window.parent.document.getElementById("qty<?=$_GET['id']?>").value;
//alert(avgcost);
	 jQuery('#AvgCost').val(avgcost);
}else{
jQuery('#AvgCost').val('0.00');
}
var Allselected = window.parent.document.getElementById("serial_value<?=$_GET['id']?>").value;

if(Allselected!=''){
	var selected = Allselected.split(",");
	//var selected=[101,103];
	var obj=$('#allSerialNo');
	var k=0;
var totc=0;
	  for (var i in selected) {
//alert(selected[i]);
	      if(jQuery('.serial-li.serialclass-'+selected[i]).length!=0){
	          jQuery('.serial-li.serialclass-'+selected[i]).addClass('disable');
var c = jQuery('.serial-li.serialclass-'+selected[i]).attr('data-unitcost');
//alert(c);
totc = parseFloat(totc)+parseFloat(c);
//alert(totc)
	          var serial=selected[i];
	          var text= jQuery('.serial-li.serialclass-'+selected[i]).html();
	         var  html='';
	           html +='<li data-serial="'+serial+'" data-unitcost="'+c+'" class="serial-selected-li">'+text+'<span class="serial-close"></span></li>';
	        jQuery('.serial-selected ul').append(html);
	        k++;
totc++;
	      }
	  }

//alert(totc);
//totc =totc-1;
	    jQuery('#allSelectedSerialNumber').val(Allselected);
//jQuery('#AvgCost').val(totc);
	    var total=parseInt(jQuery('#totalQtyInvoced').val());
	    jQuery('.order-qty').text(total-k);
	    jQuery('.clear-all-row').html('<a href="javascript:void(0);" class="clear-all">Clear All</a>');
	}
});


$(document).ready(function(){
$("#AddSerialNumber").click(function(){
var allSelectedSerialNumber = $("#allSelectedSerialNumber").val();
var totalQtyInvoced = $("#totalQtyInvoced").val();
 var Sku = "<?=$_GET['sku']?>";
	var Condition = "<?=$_GET['cond']?>";
var seriallength =jQuery('.serial-selected-li').length;
 if(allSelectedSerialNumber == ""){

                     alert("Please select serial number.");
                      return false;
                }   
else if(seriallength != totalQtyInvoced)   
                     {
                         alert("Please select "+totalQtyInvoced+" serial number only.");
                         return false;
                     }
else{
$.post("serial_post.php", //Required URL of the page on server
{ // Data Sending With Request To Server
SerialNumber:allSelectedSerialNumber,
Condition:Condition,
Sku:Sku
},
function(response,status){ // Required Callback Function
alert("*----Received Data----*\n\nResponse : " + response+"\n\nStatus : " + status);//"response" receives - whatever written in echo of above PHP script.
$("#form")[0].reset();
});
}
});
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
/* select All Css*/
.select-all-row {
    display: inline-block;
     margin-left: 27px;
}
/* End Select All Css*/
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

<?php if(empty($_GET['sku']) || empty($_GET['total'])){?>
<table width="100%"   border=0 align="center" cellpadding="0" cellspacing="0">
 <tr>
                   
<td align="left" class="red" align="center" style=" font-size: 14px;font-weight: bold;padding: 30px;">
<?=ENTER_QTY_INVOICE?>
</td>
</tr>
</table>

<?php } else {?>
<div class="serial-search-container">
<ul class="serial-info">
<li ><label class="had"> <?php echo SKU;/*SERIAL_NO_FPR_SKU*/ ;?></label> : <?=$_GET['sku']?> </li>
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
      <div class="clear-all-row"></div>     
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
              <li data-serial="<?php echo $value['serialNumber'];?>" data-unitcost="<?php echo $value['UnitCost'];?>" class="serial-selected-li"><label ><?php echo $value['serialNumber'];?>
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
                    <input type="hidden" name="allSelectedSerialNumber" id="allSelectedSerialNumber" value="<?=trim($_GET['serial_value_sel']);?>">
                    <input type="hidden" name="totalQtyInvoced" id="totalQtyInvoced" value="<?=$_GET['total']?>">
                    <input type="hidden" name="AvgCost" id="AvgCost" value="0.00">



     <?php /*?>
          <tr>
              <form name="addItemSerailNumber" id="addItemSerailNumber"  action=""  method="post" onSubmit="return validateI(this);"  enctype="multipart/form-data">     
                     <td align="left" valign="top" width="250px">
                          <?php if(sizeof($arrySerialNumber) > 0){?>
                          <b>Qty to Invoice: <?=$_GET['total']?></b><br>
                          
                          <?php  
                          
				$serialValue = $arrySerialNumber;                      
				//$serial_value_sel = explode(",",$_GET['SerialValue']);
                        	//$serial_value_sel=array_map('trim',$serial_value_sel);
                          ?>
                          
                           <select multiple="multiple" name="allSerialNo" id="allSerialNo"  class="borderall" onclick="seeList(this.form)" style="height: 250px; width: 280px;">
                          <?php foreach ($arrySerialNumber as $serial){

?>     
                               <option value="<?=$serial['serialNumber']?>" class="multiSelectBox" <?php //if (in_array($serial['serialNumber'], $serial_value_sel)){echo "selected";}?>><?=$serial['serialNumber']?></option>
                          <?php }?>
                           </select> 
                          <?php } else {?>
                            <span class="red"><?=NO_SERIAL_AVAILABLE;?></span>
                          <?php }?>
                        
                    </td>
                    <td align="left" valign="top"></td>
                </tr>
                <?php */?>
          <?php if(sizeof($arrySerialNumber) > 0){?>      
            <tr>
            <td align="center" colspan="2">
                    <input type="button" name="submit" id="AddSerialNumber" value="Add Serial Number"  class="button"/>
            </td>
            </form>
            </tr>
          <?php }?>
   

 </div>

<?php }?>
