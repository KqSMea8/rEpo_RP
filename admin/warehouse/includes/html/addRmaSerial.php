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
           
    	   jQuery('.addnewsserial').html('<div class="dialog-container">Serial number not match. do you want to add this serial number ?<div class="button-box"><input type="button" class="yesbutton button" value="Yes"><input type="button" class="nobutton button" value="No"></div> </div>')
           jQuery('.addnewsserial').dialog();

       
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
var condition='<?php echo $condition;?>';
  //allSelectedSerialNumber
  var allserials=addCommaValue(jQuery('#allSelectedSerialNumber').val(),serial);
var cost=0;
  var SendParam = 'action=checkSelSerialNo&SelSerialNo=' + escape(allserials) + '&Sku='+Sku+'&r=' + Math.random()+'&Condition='+condition;

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
                              console.log(remainingorder);console.log(selectedserialqty);
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
var condition='<?php echo $condition;?>';
	var newvalue=removeCommaValue(serialvalue,serial,',');
    //allSelectedSerialNumber
  
  var cost=0;
    var SendParam = 'action=checkSelSerialNo&SelSerialNo=' + escape(newvalue) + '&Sku='+Sku+'&r=' + Math.random()+'&Condition='+condition;

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

				jQuery('body').on('click','.nobutton',function(){				
					 jQuery('.addnewsserial').dialog('close');
				});

				jQuery('body').on('click','.yesbutton',function(){	
				var serial=jQuery('.serial-search-input').val();
				var Sku='<?php echo $sku;?>';
				var condition='<?php echo $condition;?>';
				var refserial=jQuery('li.serial-li').first().attr('data-serial');

				console.log(serial+'--'+Sku+'---'+condition+'----'+refserial);
				if(!serial){
						alert('please enter serial number.');
						return false;
					}
				   var SendParam = 'action=addSelSerialNo&SelSerialNo=' + escape(serial.trim()) + '&Sku='+Sku+'&r=' + Math.random()+'&condition='+condition+'&refserial='+refserial;

		            $.ajax({
		                  type: "GET",
		                  async: false,
		                  url: '../warehouse/ajax.php',
		                  data: SendParam,
		                  dataType : "JSON",
		                  success: function(responseText) {

		            	 if(responseText.UnitCost){ 
			            	 var html='';	                                                       
		                          cost = parseFloat(responseText.UnitCost);  
		                          var allserials=addCommaValue(jQuery('#allSelectedSerialNumber').val(),serial);                     
		                          jQuery('#allSelectedSerialNumber').val(allserials);
		                          var totqty = jQuery("#totalQtyInvoced").val();                     
		                          cost = cost/parseFloat(totqty);    
		                         $("#AvgCost").val(cost.toFixed(2));
		                        
		                        
		                         var text='<label><span>Serial Number</span> : '+responseText.serialNumber+'</label><label><span>Unit Cost</span> : '+responseText.UnitCost+'</label>';

		                         
		                          html +='<li data-serial="'+serial+'" class="serial-selected-li">'+text+'<span class="serial-close"></span></li>';
		                               jQuery('.serial-selected ul').append(html);
		                                var selectedserialqty=parseInt(jQuery('.serial-selected-li').length);		                             
		                                jQuery('.order-qty').text(totqty-selectedserialqty);
		                                jQuery('.serial-search-input').val('');
		                                if(jQuery('.clear-all').length==0){
		                              	  jQuery('.clear-all-row').html('<a href="javascript:void(0);" class="clear-all">Clear All</a>');
		                                   }
		                                jQuery('.addnewsserial').dialog('close');
		                                              
		                          }else{
		                                alert('Please try again');

		                          }

		                  
		                  }

		              });
								
					 
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
		      if(jQuery('.Selectedserialclass-'+selected[i]).length==0){
		          jQuery('.serial-li.serialclass-'+selected[i]).addClass('disable');
		          var serial=selected[i];
		          var text= jQuery('.serial-li.serialclass-'+selected[i]).html();
		       	  var  html='';
		           html +='<li data-serial="'+serial+'" class="serial-selected-li Selectedserialclass-'+serial+'">'+text+'<span class="serial-close"></span></li>';
		       		 jQuery('.serial-selected ul').append(html);
		        	
		      }
		  	k++;
	      }else{
	    	  if(jQuery('.Selectedserialclass-'+selected[i]).length==0){
		    	  var serial=selected[i];
		          var text='<label><span>Serial Number</span> : '+serial+'</label>';
		         var  html='';
		           html +='<li data-serial="'+serial+'" class="serial-selected-li Selectedserialclass-'+serial+'">'+text+'<span class="serial-close"></span></li>';
			       jQuery('.serial-selected ul').append(html);
			       
	    	  }
	    	  k++;
		      }
	  }
	   var total=parseInt(jQuery('#totalQtyInvoced').val());
	  console.log(total+'---'+k);

	var dataserial=  jQuery('#allSelectedSerialNumber').val();
	var ArraySerials=dataserial.split(',');
	var allSelArray =ArraySerials.concat(selected);

	var uniqueSeralAll = allSelArray.filter( onlyUnique );
	console.log(uniqueSeralAll);
	    jQuery('#allSelectedSerialNumber').val(uniqueSeralAll.join());
	 var nn=jQuery('.serial-selected-li').length;
	    jQuery('.order-qty').text(total-nn);


	jQuery('.clear-all-row').html('<a href="javascript:void(0);" class="clear-all">Clear All</a>');
	    
	}
	});

function onlyUnique(value, index, self) { 
    return self.indexOf(value) === index;
}
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

.serial-li,.serial-selected-li,.rmaserial-disable {
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

.serial-li > label, .serial-selected-li > label , .rmaserial-disable > label {
   
    word-wrap: break-word;
     -webkit-user-select: none; /* webkit (safari, chrome) browsers */
    -moz-user-select: none; /* mozilla browsers */
    -khtml-user-select: none; /* webkit (konqueror) browsers */
    -ms-user-select: none;
    display: block;
}
.serial-li > label > span, .serial-selected-li > label > span , .rmaserial-disable > label > span  {
  font-weight: bold;  }
.serial-li.disable > label,.serial-li.disable,.rmaserial-disable {
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
.yesbutton {
    margin: 8px;
}
.button-box {
    text-align: center;
}
.rmaserial-disable {
    background: #d40503 none repeat scroll 0 0;
    color: #fff;
    opacity: 0.5 !important;
}
</style>

<?php if(empty($_GET['sku'])){?>
<table width="100%"   border=0 align="center" cellpadding="0" cellspacing="0">
 <tr>
                   
<td align="left" class="red" align="center" style=" font-size: 14px;font-weight: bold;padding: 30px;">
Enter  Qty.
</td>
</tr>
</table>

<?php } else {


?>
<div class="serial-search-container">
<ul class="serial-info">
<li ><label class="had"> <?php echo SKU;/*SERIAL_NO_FPR_SKU*/ ;?></label> : <?=$_GET['sku']?> </li>
<li class="quantity"> 
    <div><label>Total Qty</label>: <span class="total-order-qty"><?php echo !empty($_GET['total'])?$_GET['total']:0;?> </span>
   </div>
   <div><label>Qty to Order</label>: <span class="order-qty"><?php echo !empty($_GET['total'])?$_GET['total']-count($serial_value_sel):0;?> </span>
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

<?php if(!empty($serialValue)){ ?>
    
     <div class="serial-search-row"> 
     <label>Search Serial</label><input type="text" class="serial-search-input inputbox">
     </div>
      <div class="clear-all-row"><?php echo !empty($serial_value_sel)?'<a class="clear-all" href="javascript:void(0);">Clear All</a>':'';?></div>     
     <div class="serial-selection-row"> 
        <div class="serial-list">
        <h4>Serial List</h4>
        <?php            
           // $serial_value_sel = explode(",",$_GET['SerialValue']);           
          //  $serial_value_sel=array_map('trim',$serial_value_sel);
            $selectedSerial=array();
          ?>
          <ul>
            <?php foreach($serialValue as $value){             
                $class="";
                if(in_array($value['serialNumber'],$serial_value_sel)){
                  $class="disable";
                  $selectedSerial[$value['serialNumber']] =$value;
                }
                $allclass='';
                 if(!in_array($value['serialNumber'],$creditserial)){
                $allclass ='serialclass-'.$value['serialNumber'].' serial-li '.$class;
                $title="";
                 }else{
                  $allclass ='rmaserial-disable';
                    $title="Already RMA";
                 }
              ?>
              <li title="<?php echo $title;?>" data-unitcost="<?php echo $value['UnitCost'];?>" data-serial="<?php echo $value['serialNumber'];?>" class="<?php echo $allclass;?>">
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
            <?php 
            $allselecteddata=array();
            if(!empty($selectedSerial )){foreach($selectedSerial as $value){
            $allselecteddata['UnitCost'] +=$value['UnitCost'];
            $allselecteddata['serialNumber'][] =$value['serialNumber'];
            ?>
             <li data-unitcost="<?php echo $value['UnitCost'];?>" data-serial="<?php echo $value['serialNumber'];?>" class="Selectedserialclass-<?php echo $value['serialNumber']; ?> serial-selected-li">
              <label><span>Serial Number</span> : <?php echo $value['serialNumber'];?></label>
               <?php if(!empty($value['UnitCost'])){?>
               <label><span>Unit Cost</span> : <?php echo $value['UnitCost'];?></label>
               <?php }?>
                <?php if(!empty($value['description'])){?>
                   <label><span>Description</span> : <?php echo $value['description'];?></label>
                   <?php }?>
                   <span class="serial-close"></span>
             </li>
            
            
             
             <?php }}?>

          </ul>
        </div>

     </div>

 <?php }else{?>
<span class="red"><? echo "NO SERIAL AVAILABLE";?></span>
 <?php }
 
 //print_r($allselecteddata);
 $avgcost=$allselecteddata['UnitCost']/count($allselecteddata['serialNumber']);
 ?> 
                    <input type="hidden" name="lineNumber" id="lineNumber" value="<?=$_GET['id']?>">
                    <input type="hidden" name="allSelectedSerialNumber" id="allSelectedSerialNumber" value="<?=trim(implode(',',$allselecteddata['serialNumber']));?>">
                    <input type="hidden" name="totalQtyInvoced" id="totalQtyInvoced" value="<?=$_GET['total']?>">
                    <input type="hidden" name="AvgCost" id="AvgCost" value="<?php echo $avgcost;?>">
 
  <?php if(sizeof($serialValue) > 0){?> 
                    <input type="button" name="submit" id="AddSerialNumber" value="Add Serial Number"  class="button"/>
          
          <?php }?>
</div>
<?php }?>

<div class="addnewsserial" style="display:none;"></div>
