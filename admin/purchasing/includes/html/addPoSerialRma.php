<div class="custom-overlay"></div><script language="JavaScript1.2" type="text/javascript">
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
		var totalqty=jQuery('#totalQtyInvoced').val();

		jQuery('#allSelectedSerialNumber').val('');
		jQuery('#AvgCost').val(0);
		jQuery('.order-qty').text(totalqty);
		obj.remove();
     });


    jQuery('body').on('click','.select-all',function(){
        
		var obj111=jQuery(this);
		var totalqty=jQuery('#totalQtyInvoced').val();
		var i=1;
		 var tmpserial=jQuery('#allSelectedSerialNumber').val();
		 var allserial=[];
		 if(tmpserial){
			 	var allserial= tmpserial.split(',');
			 }
        i =allserial.length;
		
		jQuery('.serial-li').each(function(){

    		//console.log(totalqty+'--'+i);
        if(!jQuery(this).hasClass('disable')){
				if(totalqty>i){
		    			  var serial=jQuery(this).attr('data-serial');
		    			  allserial.push(serial);			    			
						i++;
			
					}
        }
							
		});


		console.log( allserial);

		var allserialsString=allserial.join();
		var cost=0;
		  var Sku = "<?=$_GET['sku']?>";
		  var condition = "<?=$_GET['condition']?>";
		  var SendParam = 'action=checkSelSerialNo&SelSerialNo=' + escape(allserialsString) + '&Sku='+Sku+'&r=' + Math.random()+'&Condition='+condition;
		
		  $.ajax({
                type: "GET",
                async: false,
                url: '../warehouse/ajax.php',
                data: SendParam,
                dataType : "JSON",
                success: function(responseText) {
                  if(responseText){

	                  console.log(responseText); 
	                  cost = parseFloat(responseText.UnitCost); 
	                  cost = cost/parseFloat(totalqty);
                    jQuery('.serial-selected-li').remove(); 
		for(var ii in allserial){

			var obj=jQuery('.serialclass-'+allserial[ii]);
			 obj.addClass('disable'); 
         var html='';
             html +='<li data-serial="'+allserial[ii]+'" class="serial-selected-li">'+obj.html()+'<span class="serial-close"></span></li>';
                  jQuery('.serial-selected ul').append(html);
			}
		 jQuery('#allSelectedSerialNumber').val(allserialsString);
		   $("#AvgCost").val(cost.toFixed(2));

           jQuery('.order-qty').text(0);
           if(jQuery('.clear-all').length==0){
         		  jQuery('.clear-all-row').html('<a href="javascript:void(0);" class="clear-all">Clear All</a>');
              }              
                        }else{
                              alert('Please try again');

                        }
                }

            });
		  

 });


    jQuery('body').on('click','.range-link',function(){

        var html='';
        html +='<ul><li><label>Start Serial Range</label><input type="" class="startSrialRange inputbox"></li>';
        html +='<li><label>End Serial Range</label><input type="" class="EndSrialRange inputbox"></li><li><input type="button" class="range-button button" value="Select"></li></ul>';
        jQuery('.range-popup').html(html);
        jQuery('.range-popup').dialog({
        	  open: function() {
        	jQuery('.custom-overlay').addClass('open');
        },
        close: function() {
        	jQuery('.custom-overlay').removeClass('open');
        } 
            });

      
        })


   jQuery('body').on('click','.range-button',function(){

var startrange=jQuery('.startSrialRange').val();
var EndSrialRange=jQuery('.EndSrialRange').val();

if(jQuery.isNumeric(startrange) && jQuery.isNumeric(EndSrialRange)){
var allserial=[];
var avgcost=0;
var html='';
jQuery('.serial-li').each(function(){
		if(!jQuery(this).hasClass('disable') && parseInt(jQuery(this).attr('data-serial'))>=startrange &&  parseInt(jQuery(this).attr('data-serial'))<=EndSrialRange){
				
			allserial.push(jQuery(this).attr('data-serial'));
			var obj=jQuery(this);
			 obj.addClass('disable'); 
			 avgcost = parseFloat(avgcost) + parseFloat(jQuery(this).attr('data-unitcost'));
            html +='<li data-serial="'+jQuery(this).attr('data-serial')+'" class="serial-selected-li">'+obj.html()+'<span class="serial-close"></span></li>';                
			
		}
});


if(allserial.length==0){
alert('There is no serial in this range');	
return false;
}
jQuery('.serial-selected ul').append(html);

var totalqty=jQuery('.serial-selected-li').length;
var totalQtyInvoced=parseInt(jQuery('#totalQtyInvoced').val());
var c=parseFloat(jQuery("#AvgCost").val());
cost = parseFloat(avgcost) +c; 
console.log(cost);
cost = cost/parseFloat(totalqty); 
var rr=jQuery('#allSelectedSerialNumber').val();
if(rr){
	var preserila=rr.split(',');
}else{
	var preserila=[];
}
allserial=preserila.concat(allserial);
jQuery('#allSelectedSerialNumber').val(allserial.join());
jQuery("#AvgCost").val(cost.toFixed(2));
jQuery('.order-qty').text(totalQtyInvoced-totalqty);
jQuery('.clear-all-row').html('<a href="javascript:void(0);" class="clear-all">Clear All</a>');
console.log(allserial);
jQuery('.range-popup').dialog('close');

}else{

	alert('Please enter only numeric serials');
	return false;
}
	   
   });

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
  //allSelectedSerialNumber
  var allserials=addCommaValue(jQuery('#allSelectedSerialNumber').val(),serial);
var cost=0;
  var SendParam = 'action=checkSelSerialNo&SelSerialNo=' + escape(allserials) + '&Sku='+Sku+'&r=' + Math.random();

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
                        jQuery('#allSelectedSerialNumber').val(allserials);
                        var totqty = jQuery("#totalQtyInvoced").val();                     
                        cost = cost/parseFloat(totqty);    
                       $("#AvgCost").val(cost.toFixed(2));
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
		var newvalue=removeCommaValue(serialvalue,serial,',');
	    //allSelectedSerialNumber
	  
	  var cost=0;
	    var SendParam = 'action=checkSelSerialNo&SelSerialNo=' + escape(newvalue) + '&Sku='+Sku+'&r=' + Math.random();

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
	                          cost = cost/parseFloat(totqty); 
                            }
	                          $("#AvgCost").val(cost.toFixed(2));
	                          jQuery('.serialclass-'+serial).removeClass('disable');
	                  		jQuery('#allSelectedSerialNumber').val(newvalue);		 	
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
     
        $("#AddSerialNumber").click(function(){
            var allSelectedSerialNumber = document.getElementById("allSelectedSerialNumber").value;
            allSelectedSerialNumber = allSelectedSerialNumber.replace(/,$/,"");
            
             var lineNumber = $("#lineNumber").val();
             var resSerialNo = allSelectedSerialNumber.split(",");
             var seriallength = resSerialNo.length;
             var totalQtyInvoced = $("#totalQtyInvoced").val();
            
                if(allSelectedSerialNumber == ""){
                     alert("Please select serial number.");
                      return false;
                }   
                
              if(seriallength > totalQtyInvoced || seriallength < totalQtyInvoced)   
                     {
                         alert("Please select "+totalQtyInvoced+" serial number only.");
                         return false;
                     }else{
                         
                          window.parent.document.getElementById("serial_value"+lineNumber).value = allSelectedSerialNumber;
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
	var avgcost=window.parent.document.getElementById("price<?=$_GET['id']?>").value;
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
           
    .fancybox-opened {
    width: auto !important;
   }
   
   .fancybox-skin {
    width: auto !important;
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
.select-all-row {
    display: inline-block;
     margin-left: 27px;
}
.rage-box {
    display: inline-block;
    margin-left: 30px;
}

.custom-overlay.open {
    background: #000 none repeat scroll 0 0;
    height: 100%;
    opacity: 0.6;
    position: fixed;
    width: 100%;
    z-index: 100;
}
   
</style>
<?php if(empty($_GET['sku'])){?>
<table width="100%"  class="serialnumbers" border=0 align="center" cellpadding="0" cellspacing="0">
 <tr>
                   
<td align="left" class="red" align="center" style=" font-size: 14px;font-weight: bold;padding: 30px;">
Enter return Qty.
</td>
</tr>
</table>
<?php } else {
  
?>

 <div class="serial-search-container">
<ul class="serial-info">
<li ><label class="had"> SKU</label> : <?=$_GET['sku']?> </li>
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
<?php 
if(!empty($serialValue)){?>

 <div class="serial-search-row"> 
     <label>Search Serial</label><input type="text" class="serial-search-input inputbox">
     </div>
     <div class="select-button-box">
      <div class="select-all-row"><a href="javascript:void(0)" class="select-all">Select All</a></div>   
      <!--<div class="rage-box"><a href="javascript:void(0)" class="range-link">Select Range</a></div> -->    
      <div class="clear-all-row"></div>
      </div>
     <div class="serial-selection-row"> 
        <div class="serial-list">
        <h4>Serial List</h4>     
          <ul>
            <?php
			
            foreach($serialValue as $value){             
                $class="";
                if(in_array($value['serialNumber'],$serial_value_sel)){
                  $class="disable";
                  $selectedSerial[] =$value;
                }
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


<?php } else{?>
<span class="red"><? echo "NO SERIAL AVAILABLE";?></span>
 <?php }?>
  <input type="hidden" name="lineNumber" id="lineNumber" value="<?=$_GET['id']?>">
                           <input type="hidden" name="allSelectedSerialNumber" id="allSelectedSerialNumber" value="<?=trim($_GET['SerialValue']);?>">
                           <input type="hidden" name="totalQtyInvoced" id="totalQtyInvoced" value="<?=$_GET['total']?>">
                           <input type="hidden" name="AvgCost" id="AvgCost" value="">
  <?php if(!empty($arrySerialNumber)){              
                    if($_GET['view']!=1){
              ?>      
            <tr>
            <td align="center" colspan="2">
                    <input type="button" name="submit" id="AddSerialNumber" value="Select Serial Number"  class="button"/>
            </td>
            </tr>
                    <?php }
                    }?>
                    <?php /*?>
<form name="addItemSerailNumber" id="addItemSerailNumber"  action=""  method="post" onSubmit="return validateI(this);"  enctype="multipart/form-data">
<table width="100%"   border=0 align="center" cellpadding="0" cellspacing="0">
     
          <tr>
              <td align="left" valign="top" width="250px">
                          <?php if(!empty($arrySerialNumber)){?>
                          <b>Qty to Invoice: <?=$_GET['total']?></b><br>
                          
                          <?php  
                          
                        
                          
                          //print_r($serialValue);
                          
                          
                          $serial_value_sel = explode(",",$_GET['serial_value_sel']);
                                $serial_value_sel=array_map('trim',$serial_value_sel);
                          ?>
                          
                           <select multiple="multiple" name="allSerialNo" id="allSerialNo"  class="borderall" onclick="seeList(this.form)" style="height: 250px; width: 280px;">
                          <?php for($i=0; $i< sizeof($serialValue); $i++){?>     
                               <option value="<?=$serialValue[$i]?>" class="multiSelectBox" <?php if (in_array($serialValue[$i], $serial_value_sel)){echo "selected";}?>><?=$serialValue[$i]?></option>
                          <?php }?>
                           </select> 
                          <?php } else {?>
                            <span class="red"><? echo "NO SERIAL AVAILABLE";?></span>
                          <?php }?>
                          <input type="hidden" name="lineNumber" id="lineNumber" value="<?=$_GET['id']?>">
                           <input type="hidden" name="allSelectedSerialNumber" id="allSelectedSerialNumber" value="<?=$serialValue[$i]?>">
                           <input type="hidden" name="totalQtyInvoced" id="totalQtyInvoced" value="<?=$_GET['total']?>">
                    </td>
                    <td align="left" valign="top"></td>
                </tr>
          <?php if(!empty($arrySerialNumber)){
              
                    if($_GET['view']!=1){
              ?>      
            <tr>
            <td align="center" colspan="2">
                    <input type="button" name="submit" id="AddSerialNumber" value="Select Serial Number"  class="button"/>
            </td>
            </tr>
                    <?php }
                    }?>
   
</table>
 </form>
 <?*/?>
 </div>
<?php }?>
<div class="range-popup" style="display:none;"></div>
