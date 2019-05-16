<?php session_start();  ?>
<script language="JavaScript1.2" type="text/javascript">
function ResetSearch(){	
	ShowHideLoader('1','P');
}

var $j = jQuery;


function pdfpreview(ID,module){
        //alert(ID+module);
        //location.reload();
        $(".newpdftemp").html('<iframe src="pdfSOhtml.php?o=<?=$_GET['view']?>&module=<?=$_GET['module']?>&editpdftemp=1" style="width:100%; height:1300px;" frameborder="0"></iframe>');
        //$(".newpdftemp").html('hhhh');
//        jQuery.ajax({
//	type: "POST",
//	url: "pdfSO.php?o="+ID+"&module="+module+"&editpdftemp=1",
//        //dataType : "JSON",
//	data: {action:'pdftemp'},
//	
//	success:function(responseText)
//	 {
//          //alert(responseText);
//          //var temppdf=jQuery.parseJSON(responseText);
//          alert(responseText);
//          $(".newpdftemp").html(responseText);
//          }
//          });
    }

function companyalign(){
    
    var x = document.getElementById("CompanyFieldAlign").value;
    if(x=='left'){
        $("#InfoFieldAlign").val('right');
        
    }else if(x=='right'){$("#InfoFieldAlign").val('left');}
    else{
        
        $("#InfoFieldAlign").val('right');
    }
}

function Infoalign(){
    
    var y = document.getElementById("InfoFieldAlign").value;
    if(y=='left'){
        $("#CompanyFieldAlign").val('right');
        
    }else if(y=='right'){$("#CompanyFieldAlign").val('left');}
    else{
        
        $("#CompanyFieldAlign").val('left');
    }
}

//id="BillingID" onchange="BillingAlign()" onchange="ShippingAlign()" id="ShippingID"

function BillingAlign(){
     var B = document.getElementById("BillingID").value;
     if(B=='left'){$("#ShippingID").val('right');}
     else if(B=='right'){$("#ShippingID").val('left');}
     else{$("#ShippingID").val('left');}
    
}
function ShippingAlign(){
     var S = document.getElementById("ShippingID").value;
     if(S=='left'){$("#BillingID").val('right');}
     else if(S=='right'){$("#BillingID").val('left');}
     else{$("#BillingID").val('right');}
    
}
function BillingFontSize(){
    
    var bfs = document.getElementById("BillingFontSizeID").value;
    if(bfs!=''){$("#ShippingFontSizeID").val(bfs);}
    }
function ShippingFontSize(){
    
    var sfs = document.getElementById("ShippingFontSizeID").value;
    if(sfs!=''){$("#BillingFontSizeID").val(sfs);}
    }
    
function validateForm(frm) {
    //alert('fff');
    var TmpNameEmpty=document.getElementById("TemplateNameID").value;
    //alert(tt);
        if(TmpNameEmpty=='')
        {
            $(".temnamereq").html("Please Enter Template Name");
            return false;
            
        }
        
    }
//function changeEventFn(){
//    var CompanyFieldFontSize=$("#CompanyFieldFontSizeID").val();
//    alert(CompanyFieldFontSize);
//   // var dataString = 'name='+ name + '&username=' + username + '&password=' + password + '&gender=' + gender;
//	 var dataString = 'cmpyFieldFont='+ CompanyFieldFontSize;
//	$.ajax({
//	type: "POST",
//    url: "pdfSOhtml.php",
//    data: dataString,
//    success: function(){
//	
//    $(".newpdftemp").html('<iframe src="pdfSOhtml.php?o=<?=$_GET['view']?>&module=<?=$_GET['module']?>&editpdftemp=1&test='+CompanyFieldFontSize+'" style="width:100%; height:1300px;" frameborder="0"></iframe>');
//   }
//});
//
//}
</script>
<style>
    .temnamereq{text-align: center; color:red;font-size: 12px;}
    
</style>


	<a href="<?=$AddredirectURL?>" class="back">Back</a>
	
        <!--
	<input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/>
	<a href="<?=$EditUrl?>" class="edit">Edit</a>
	<a href="<?=$DownloadUrl?>" target="_blank" class="download" style="float:right;margin-left:5px;">Download</a>
        <a href="" target="_blank" class="edit" style="float:right;margin-left:5px;">Edit PDF</a>-->





	<div class="had">
	<?=$MainModuleName?>    <span>&raquo;
		<?=$ModuleName.' Detail'?>
			
	</span>
	</div>
        
        <div class="message" align="center"><?php  if (!empty($_SESSION['mess_Sale'])) {  echo $_SESSION['mess_Sale'];   unset($_SESSION['mess_Sale']);  } ?></div>
	<div style="float: left; display: inline-block;  width: 22%;">
            <div class="temnamereq"><?php if(!empty($_SESSION['mess_dynamicpdf'])){echo $_SESSION['mess_dynamicpdf'];} unset($_SESSION['mess_dynamicpdf']);?></div>
            <form enctype="multipart/form-data" onsubmit="return validateForm(this);" method="post" action="" id="form1" name="form1">
            <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" class="borderall">
                <!--Add Template -->
                
                <tr><td class="head" colspan="<?=$col?>">Add Template</td></tr>
                <tr><td colspan="<?=$col?>"> Name : <span class="red">* </span><input class="inputbox"  type="text" id="TemplateNameID" maxlength="50" name="TemplateName" value="<?php echo stripslashes($GetPFdTempalteVal[0]['TemplateName']);?>" /></td></tr>
                
                <!-- Add Template-->
                
                <!-- section A -->
                <tr><td class="head" colspan="<?=$col?>">Company Info</td></tr>
                <tr>
                    <td align="right" class="blackbold"><?=$FieldFontSize?></td>
                    <td align="left"> 
                        <select class="textbox" onchange="changeEventFn()" id="CompanyFieldFontSizeID"  name="Company<?=$FieldFontSizeName?>">
                            <option value="">Select</option>
                         <?php foreach($FieldSizeArry as $val) { ?>
                        <option value="<?=$val?>" <?php if($GetPFdTempalteVal[0]['CompanyFieldFontSize']==$val){ echo 'selected';}?>><?=$val?></option>
                         <?php } ?>
                        </select> 
                    </td>
                    
                    <td align="right" class="blackbold"><?=$FieldAlign?></td>
                    <td align="left"> 
                        <select id="CompanyFieldAlign" class="textbox" onchange="companyalign()"  name="Company<?=$FieldAlignName?>">
                         <option value="">Select</option>
                        <?php foreach($AlignArryTitle as $key=>$val) { ?>
                        <option value="<?=$val?>" <?php if($GetPFdTempalteVal[0]['CompanyFieldAlign']==$val){ echo 'selected';}?>><?=$key?></option>
                         <?php } ?>
                         
                        </select> 
                    </td>
                    </tr>
                    <tr>
                    <td align="right" class="blackbold">Logo Size</td>
                    <td align="left"> 
                        <select class="textbox"  name="LogoSize">
                         <option value="">Select</option>
                        <?php foreach($logosize as $val) { ?>
                        <option value="<?=$val?>" <?php if($GetPFdTempalteVal[0]['LogoSize']==$val){ echo 'selected';}?>><?=$val?></option>
                         <?php } ?>
                         
                        </select> 
                    </td>
                   
                            <td align="right" class="blackbold">Color</td>
                            <td align="left"> 
                                <select class="textbox"  name="CompanyColor">
                                 <option value="">Select</option>
                                <?php foreach($Color as $key=>$val) { ?>
                                <option value="<?=$val?>" <?php if($GetPFdTempalteVal[0]['CompanyColor']==$val){ echo 'selected';}?>><?=$key?></option>
                                 <?php } ?>

                                </select> 
                            </td>
                    </tr>
                    <tr>
                    <td align="right" class="blackbold"><?=$TabFontSize?></td>
                    <td align="left"> 
                        <select class="textbox"  name="Company<?=$HeadingFontSizeName?>">
                          <option value="">Select</option>
                         <?php foreach($HeadingSizeArry as $value) { ?>
                        <option value="<?=$value?>" <?php if($GetPFdTempalteVal[0]['CompanyHeadingFontSize']==$value){ echo 'selected';}?>><?=$value?></option>
                         <?php } ?>
                        </select> 
                    </td>
                    <td align="right" class="blackbold">Heading Color</td>
                    <td align="left"> 
                        <select class="textbox"  name="CompanyHeadColor">
                                 <option value="">Select</option>
                                <?php foreach($Color as $key=>$val) { ?>
                                <option value="<?=$val?>" <?php if($GetPFdTempalteVal[0]['CompanyHeadColor']==$val){ echo 'selected';}?>><?=$key?></option>
                                 <?php } ?>

                        </select> 
                    </td>
                        
                    </tr>
                    
                <!-- info-->
                <tr><td class="head" colspan="<?=$col?>"><?=$module?> Information</td></tr>
                <tr>
                    <td align="right" class="blackbold"><?=$FieldFontSize?></td>
                    <td align="left"> 
                        <select class="textbox"  name="Information<?=$FieldFontSizeName?>">
                            <option value="">Select</option>
                         <?php foreach($FieldSizeArry as $val) { ?>
                        <option value="<?=$val?>" <?php if($GetPFdTempalteVal[0]['InformationFieldFontSize']==$val){ echo 'selected';}?>><?=$val?></option>
                         <?php } ?>
                        </select> 
                    </td>
                    
                    <td align="right" class="blackbold"><?=$FieldAlign?></td>
                    <td align="left"> 
                        <select class="textbox" id="InfoFieldAlign" onchange="Infoalign()"  name="Information<?=$FieldAlignName?>">
                         <option value="">Select</option>
                        <?php foreach($AlignArryTitle as $key=>$val) { ?>
                        <option value="<?=$val?>" <?php if($GetPFdTempalteVal[0]['InformationFieldAlign']==$val){ echo 'selected';}?>><?=$key?></option>
                         <?php } ?>
                         
                        </select> 
                    </td>
                    </tr>
<!--                    <tr>
                    <td align="right" class="blackbold"><?=$TabFontSize?></td>
                    <td align="left"> 
                        <select class="textbox"  name="Information<?=$HeadingFontSizeName?>">
                          <option value="">Select</option>
                         <?php foreach($HeadingSizeArry as $value) { ?>
                        <option value="<?=$value?>" <?php if($GetPFdTempalteVal[0]['InformationHeadingFontSize']==$value){ echo 'selected';}?>><?=$value?></option>
                         <?php } ?>
                        </select> 
                    </td>
                    
                    <td align="right" class="blackbold"><?=$TabAlign?></td>
                    <td align="left"> 
                        <select class="textbox"  name="Information<?=$HeadingAlignName?>">
                         <option value="">Select</option>
                         <?php foreach($AlignArryTitle as $val) { ?>
                        <option value="<?=$val?>" <?php if($GetPFdTempalteVal[0]['InformationHeadingAlign']==$val){ echo 'selected';}?>><?=$val?></option>
                         <?php } ?>
                         
                        </select> 
                    </td>
                    </tr>-->
                    <tr>
<!--                    <td align="right" class="blackbold">Field Border</td>
                    <td align="left"> 
                        <select class="textbox"  name="InformationFieldBorder">
                         <option value="">Select</option>
                        <?php foreach($borderarry as $key=>$val) { ?>
                        <option value="<?=$val?>" <?php if($GetPFdTempalteVal[0]['InformationFieldBorder']==$val){ echo 'selected';}?>><?=$key?></option>
                         <?php } ?>
                        
                         
                        </select> 
                    </td>-->
                
                    
                    <td align="right" class="blackbold">Color</td>
                    <td align="left"> 
                        <select class="textbox"  name="InformationColor">
                         <option value="">Select</option>
                        <?php foreach($Color as $key=>$val) { ?>
                         <option value="<?=$val?>" <?php if($GetPFdTempalteVal[0]['InformationColor']==$val){ echo 'selected';}?>><?=$key?></option>
                        <?php } ?>
                        </select> 
                    </td> 
                    <td align="right" class="blackbold">Title Font Size</td>
                    <td align="left"> 
                        <select class="textbox"  name="TitleFontSize">
                         <option value="">Select</option>
                        <?php foreach($HeadingSizeArry as $val) { ?>
                        <option value="<?=$val?>" <?php if($GetPFdTempalteVal[0]['TitleFontSize']==$val){ echo 'selected';}?>><?=$val?></option>
                         <?php } ?>
                         
                        </select> 
                    </td>
                    </tr>
                    <tr>
                    <td align="right" class="blackbold">Title/PDF Name</td>
                    <td align="left"> 
                        <select class="textbox"  name="Title">
                         <option value="">Select</option>
                        <?php foreach($HeadingArry as $key=>$val) { ?>
                        <option value="<?=$val?>" <?php if($GetPFdTempalteVal[0]['Title']==$val){ echo 'selected';}?>><?=$key?></option>
                         <?php } ?>
                        
                         
                        </select> 
                    </td>
                
                
                    
                            <td align="right" class="blackbold">Title Color</td>
                            <td align="left"> 
                                <select class="textbox"  name="TitleColor">
                                 <option value="">Select</option>
                                <?php foreach($Color as $key=>$val) { ?>
                                <option value="<?=$val?>" <?php if($GetPFdTempalteVal[0]['TitleColor']==$val){ echo 'selected';}?>><?=$key?></option>
                                 <?php } ?>

                                </select> 
                            </td>
                    
                    </tr>
                <!-- section B -->
                <tr><td class="head" colspan="<?=$col?>">Billing Address</td></tr>
                <tr>
                    <td align="right"  class="blackbold">Heading & <?=$FieldFontSize?></td>
                    <td align="left"> 
                        <select class="textbox" onchange="BillingFontSize()" id="BillingFontSizeID"  name="BillAdd_Heading_<?=$FieldFontSizeName?>">
                            <option value="">Select</option>
                         <?php foreach($FieldSizeArry as $val) { ?>
                        <option value="<?=$val?>" <?php if($GetPFdTempalteVal[0]['BillAdd_Heading_FieldFontSize']==$val){ echo 'selected';}?>><?=$val?></option>
                         <?php } ?>
                        </select> 
                    </td>
                    
                    <td align="right" class="blackbold">Heading & <?=$FieldAlign?></td>
                    <td align="left"> 
                        <select class="textbox" id="BillingID" onchange="BillingAlign()"  name="BillAdd_Heading_<?=$FieldAlignName?>">
                         <option value="">Select</option>
                        <?php foreach($AlignArryTitle as $key=>$val) { ?>
                        <option value="<?=$val?>" <?php if($GetPFdTempalteVal[0]['BillAdd_Heading_FieldAlign']==$val){ echo 'selected';}?>><?=$key?></option>
                         <?php } ?>
                         
                        </select> 
                    </td>
                </tr>
                <tr>
                    
                    <td align="right" class="blackbold"><?=$Tab?></td>
                    <td align="left"> 
                        <select class="textbox"  name="BillAdd<?=$HeadingName?>">
                         <option value="">Select</option>
                        <?php foreach($HeadingArry as $key=>$val) { ?>
                        <option value="<?=$val?>" <?php if($GetPFdTempalteVal[0]['BillAddHeading']==$val){ echo 'selected';}?>><?=$key?></option>
                         <?php } ?>
                         
                        </select> 
                    </td>
                
                
                    <td align="right" class="blackbold">Color</td>
                    <td align="left"> 
                        <select class="textbox"  name="BillAddColor">
                         <option value="">Select</option>
                        <?php foreach($Color as $key=>$val) { ?>
                         <option value="<?=$val?>" <?php if($GetPFdTempalteVal[0]['BillAddColor']==$val){ echo 'selected';}?>><?=$key?></option>
                        <?php } ?>
                        </select> 
                    </td> 
                    </tr>
                    <tr>
                      <td align="right" class="blackbold">Heading Color</td>
                    <td align="left"> 
                        <select class="textbox"  name="BillHeadColor">
                         <option value="">Select</option>
                        <?php foreach($Color as $key=>$val) { ?>
                         <option value="<?=$val?>" <?php if($GetPFdTempalteVal[0]['BillHeadColor']==$val){ echo 'selected';}?>><?=$key?></option>
                        <?php } ?>
                        </select> 
                    </td>
                    
                    <td align="right" class="blackbold">Heading background Color</td>
                    <td align="left"> 
                        <select class="textbox"  name="BillHeadbackgroundColor">
                         <option value="">Select</option>
                        <?php foreach($Color as $key=>$val) { ?>
                         <option value="<?=$val?>" <?php if($GetPFdTempalteVal[0]['BillHeadbackgroundColor']==$val){ echo 'selected';}?>><?=$key?></option>
                        <?php } ?>
                        </select> 
                    </td>  
                        
                    </tr>
                <!-- Section C-->
                <tr><td class="head" colspan="<?=$col?>">Shipping Address</td></tr>
                <tr>

                    <td align="right" class="blackbold">Heading & <?=$FieldAlign?></td>
                    <td align="left"> 
                        <select class="textbox" onchange="ShippingAlign()" id="ShippingID"  name="ShippAdd_Heading_<?=$FieldAlignName?>">
                         <option value="">Select</option>
                        <?php foreach($AlignArryTitle as $key=>$val) { ?>
                        <option value="<?=$val?>" <?php if($GetPFdTempalteVal[0]['ShippAdd_Heading_FieldAlign']==$val){ echo 'selected';}?>><?=$key?></option>
                         <?php } ?>
                        </select> 
                    </td>
                    
                    
                    <td align="right" class="blackbold"><?=$Tab?></td>
                    <td align="left"> 
                        <select class="textbox"  name="ShippAdd<?=$HeadingName?>">
                         <option value="">Select</option>
                        <?php foreach($HeadingArry as $key=>$val) { ?>
                        <option value="<?=$val?>" <?php if($GetPFdTempalteVal[0]['ShippAddHeading']==$val){ echo 'selected';}?>><?=$key?></option>
                         <?php } ?>
                         
                        </select> 
                    </td>
                
                </tr>
                <tr>
                    <td align="right" class="blackbold">Color</td>
                    <td align="left"> 
                        <select class="textbox"  name="ShippAddColor">
                         <option value="">Select</option>
                        <?php foreach($Color as $key=>$val) { ?>
                         <option value="<?=$val?>" <?php if($GetPFdTempalteVal[0]['ShippAddColor']==$val){ echo 'selected';}?>><?=$key?></option>
                        <?php } ?>
                        </select> 
                    </td> 
                    <td align="right"  class="blackbold">Heading & <?=$FieldFontSize?></td>
                    <td align="left"> 
                        <select class="textbox" onchange="ShippingFontSize()" id="ShippingFontSizeID" name="ShippAdd_Heading_<?=$FieldFontSizeName?>">
                            <option value="">Select</option>
                         <?php foreach($FieldSizeArry as $val) { ?>
                        <option value="<?=$val?>" <?php if($GetPFdTempalteVal[0]['ShippAdd_Heading_FieldFontSize']==$val){ echo 'selected';}?>><?=$val?></option>
                         <?php } ?>
                        </select> 
                    </td>
                    </tr>
                    <tr>
                      <td align="right" class="blackbold">Heading Color</td>
                    <td align="left"> 
                        <select class="textbox"  name="ShippHeadColor">
                         <option value="">Select</option>
                        <?php foreach($Color as $key=>$val) { ?>
                         <option value="<?=$val?>" <?php if($GetPFdTempalteVal[0]['ShippHeadColor']==$val){ echo 'selected';}?>><?=$key?></option>
                        <?php } ?>
                        </select> 
                    </td>
                    
                    <td align="right" class="blackbold">Heading background Color</td>
                    <td align="left"> 
                        <select class="textbox"  name="ShippHeadbackgroundColor">
                         <option value="">Select</option>
                        <?php foreach($Color as $key=>$val) { ?>
                         <option value="<?=$val?>" <?php if($GetPFdTempalteVal[0]['ShippHeadbackgroundColor']==$val){ echo 'selected';}?>><?=$key?></option>
                        <?php } ?>
                        </select> 
                    </td>  
                        
                    </tr>
                <!-- Section D-->
                <tr><td class="head" colspan="<?=$col?>">Line Item</td></tr>
                
                    <tr>
                    <td align="right" class="blackbold">Heading Color</td>
                    <td align="left"> 
                        <select class="textbox"  name="LineHeadColor">
                         <option value="">Select</option>
                        <?php foreach($Color as $key=>$val) { ?>
                         <option value="<?=$val?>" <?php if($GetPFdTempalteVal[0]['LineHeadColor']==$val){ echo 'selected';}?>><?=$key?></option>
                        <?php } ?>
                        </select> 
                    </td>
                    
                    <td align="right" class="blackbold">Heading background Color</td>
                    <td align="left"> 
                        <select class="textbox"  name="LineHeadbackgroundColor">
                         <option value="">Select</option>
                        <?php foreach($Color as $key=>$val) { ?>
                         <option value="<?=$val?>" <?php if($GetPFdTempalteVal[0]['LineHeadbackgroundColor']==$val){ echo 'selected';}?>><?=$key?></option>
                        <?php } ?>
                        </select> 
                    </td>  
                        
                    </tr>
                    <tr>
                    <td align="right" class="blackbold"><?=$Tab?></td>
                    <td align="left"> 
                        <select class="textbox"  name="Line<?=$HeadingName?>">
                         <option value="">Select</option>
                        <?php foreach($HeadingArry as $key=>$val) { ?>
                        <option value="<?=$val?>" <?php if($GetPFdTempalteVal[0]['LineHeading']==$val){ echo 'selected';}?>><?=$key?></option>
                         <?php } ?>
                         
                        </select> 
                    </td>
                
                
                    <td align="right" class="blackbold">Color</td>
                    <td align="left"> 
                        <select class="textbox"  name="LineColor">
                         <option value="">Select</option>
                        <?php foreach($Color as $key=>$val) { ?>
                         <option value="<?=$val?>" <?php if($GetPFdTempalteVal[0]['LineColor']==$val){ echo 'selected';}?>><?=$key?></option>
                        <?php } ?>
                        </select> 
                    </td>
                   
                    </tr>
                    <tr>
                 <td align="right" class="blackbold">Item Field & <?=$TabFontSize?></td>
                    <td align="left"> 
                        <select class="textbox"  name="LineItem<?=$HeadingFontSizeName?>">
                          <option value="">Select</option>
                         <?php foreach($lineItemHeadFontSize as $value) { ?>
                        <option value="<?=$value?>" <?php if($GetPFdTempalteVal[0]['LineItemHeadingFontSize']==$value){ echo 'selected';}?>><?=$value?></option>
                         <?php } ?>
                        </select> 
                    </td>
                    </tr>
                     <!-- Special NOtes -->
                    <tr><td class="head" colspan="<?=$col?>">Special Notes &amp; Below Data</td></tr>
                    <tr>
                    <td align="right" class="blackbold">Heading Color</td>
                    <td align="left"> 
                        <select class="textbox"  name="SpecialHeadColor">
                         <option value="">Select</option>
                        <?php foreach($Color as $key=>$val) { ?>
                         <option value="<?=$val?>" <?php if($GetPFdTempalteVal[0]['SpecialHeadColor']==$val){ echo 'selected';}?>><?=$key?></option>
                        <?php } ?>
                        </select> 
                    </td>
                    
                    <td align="right" class="blackbold">Heading background Color</td>
                    <td align="left"> 
                        <select class="textbox"  name="SpecialHeadbackgroundColor">
                         <option value="">Select</option>
                        <?php foreach($Color as $key=>$val) { ?>
                         <option value="<?=$val?>" <?php if($GetPFdTempalteVal[0]['SpecialHeadbackgroundColor']==$val){ echo 'selected';}?>><?=$key?></option>
                        <?php } ?>
                        </select> 
                    </td>  
                        
                    </tr>
                    <tr>
                        
                    <td align="right" class="blackbold">Heading & Field & <?=$TabFontSize?></td>
                    <td align="left"> 
                        <select class="textbox"  name="SpecialHeadingFontSize">
                          <option value="">Select</option>
                         <?php foreach($lineItemHeadFontSize as $value) { ?>
                        <option value="<?=$value?>" <?php if($GetPFdTempalteVal[0]['SpecialHeadingFontSize']==$value){ echo 'selected';}?>><?=$value?></option>
                         <?php } ?>
                        </select> 
                    </td>
                    <td align="right" class="blackbold">Field Color</td>
                    <td align="left"> 
                        <select class="textbox"  name="SpecialFieldColor">
                         <option value="">Select</option>
                        <?php foreach($Color as $key=>$val) { ?>
                         <option value="<?=$val?>" <?php if($GetPFdTempalteVal[0]['SpecialFieldColor']==$val){ echo 'selected';}?>><?=$key?></option>
                        <?php } ?>
                        </select> 
                    </td>
                    </tr>
                    <tr>
                    <td align="right" class="blackbold"><?=$Tab?></td>
                    <td align="left"> 
                        <select class="textbox"  name="Special<?=$HeadingName?>">
                         <option value="">Select</option>
                        <?php foreach($HeadingArry as $key=>$val) { ?>
                        <option value="<?=$val?>" <?php if($GetPFdTempalteVal[0]['SpecialHeading']==$val){ echo 'selected';}?>><?=$key?></option>
                         <?php } ?>
                         
                        </select> 
                    </td>
                    </tr>
                    
                    
                    
                <tr>
                <td colspan="<?=$col?>">
                    <div style="text-align: center;">
                            <input type="hidden" name="Module" value="Sales<?=$module?>"/>
                            <input type="hidden" name="ModuleId" value="<?=$_GET['view']?>"/>
                            <input type="hidden" name="id" value="<?=$GetPFdTempalteVal[0]['id']?>"/>
<!--                            <button type="button" value="Preview" onclick="pdfpreview('<?=$_GET['view']?>','<?=$_GET['module']?>')" class="button" name="Preview">Preview</button>-->
                            <?php if($GetPFdTempalteVal[0]['id'] > 0) { ?>
                            <button type="submit" value="Update" class="button" name="Update">Preview & Save</button>
                            <?php } else { ?>
                            <button type="submit" value="Save" class="button" name="Save">Preview & Save</button>
                            <?php  } ?>
                    </div>
                </td> 
                </tr>
                
            </table> 
            </form>
        </div>
        <div style="display: inline-block; float: right; width: 78%;" class="newpdftemp">
            <iframe src="pdfSOhtml.php?o=<?=$_GET['view']?>&module=<?=$_GET['module']?>&editpdftemp=1&tempid=<?=$_GET['tempid']?>" style="width:100%; height:1300px;" frameborder="0"></iframe>
<!--            <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" class="borderall">
                <tr><td class="head" colspan="<?=$col?>">PDF Preview</td></tr>
                <tr>
                    <td colspan="<?=$col?>">
                    <?php //require_once("includes/html/box/pdf_sales_template.php");?>
                        
                    </td>
                </tr>
                <tr>
                    <td>
                       <div id="scroller">
                        
                        </div> 
                    </td>
                </tr>
            </table>-->
        </div>
        
            



