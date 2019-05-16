 
<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
<script language="JavaScript1.2" type="text/javascript">
    function ResetSearch() {
        ShowHideLoader('1', 'P');
    }

    var $j = jQuery;


    function pdfpreview(ID, module) {

        // alert(ID+module);
        // location.reload();

        $(".newpdftemp").html('<iframe src="pdfSOhtml.php?o=<?php echo $_GET['view'] ?>&module=<?php echo $_GET['module'] ?>&editpdftemp=1" style="width:100%; height:1300px;" frameborder="0"></iframe>');

        // $(".newpdftemp").html('hhhh');
//        jQuery.ajax({
//  type: "POST",
//  url: "pdfSO.php?o="+ID+"&module="+module+"&editpdftemp=1",
//        //dataType : "JSON",
//  data: {action:'pdftemp'},
//  
//  success:function(responseText)
//   {
//          //alert(responseText);
//          //var temppdf=jQuery.parseJSON(responseText);
//          alert(responseText);
//          $(".newpdftemp").html(responseText);
//          }
//          });

}

function companyalign() {

    var x = document.getElementById("CompanyFieldAlign").value;
    if (x == 'left') {
        $("#InfoFieldAlign").val('right');

    } else if (x == 'right') {
        $("#InfoFieldAlign").val('left');
    }
      else {

        $("#InfoFieldAlign").val('right');
    }
}

function Infoalign() {

    var y = document.getElementById("InfoFieldAlign").value;
    if (y == 'left') {
        $("#CompanyFieldAlign").val('right');

    } else if (y == 'right') {
        $("#CompanyFieldAlign").val('left');
    }
      else {

        $("#CompanyFieldAlign").val('left');
    }
}


// id="BillingID" onchange="BillingAlign()" onchange="ShippingAlign()" id="ShippingID"


function BillingAlign() {
    var B = document.getElementById("BillingID").value;
    if (B == 'left') {
        $("#ShippingID").val('right');
    }
      else if (B == 'right') {
        $("#ShippingID").val('left');
    }
      else {
        $("#ShippingID").val('left');
    }

}
function ShippingAlign() {
    var S = document.getElementById("ShippingID").value;
    if (S == 'left') {
        $("#BillingID").val('right');
    }
      else if (S == 'right') {
        $("#BillingID").val('left');
    }
      else {
        $("#BillingID").val('right');
    }

}
function BillingFontSize() {

    var bfs = document.getElementById("BillingFontSizeID").value;
    if (bfs != '') {
        $("#ShippingFontSizeID").val(bfs);
    }
}
function ShippingFontSize() {

    var sfs = document.getElementById("ShippingFontSizeID").value;
    if (sfs != '') {
        $("#BillingFontSizeID").val(sfs);
    }
}

function validateForm(frm) {

        // alert('fff');

        var TmpNameEmpty = document.getElementById("TemplateNameID").value;

        // alert(tt);

        if (TmpNameEmpty == '')
        {
            $(".temnamereq").html("Please Enter Template Name");
            return false;

        }

    }

// function changeEventFn(){
//    var CompanyFieldFontSize=$("#CompanyFieldFontSizeID").val();
//    alert(CompanyFieldFontSize);
//   // var dataString = 'name='+ name + '&username=' + username + '&password=' + password + '&gender=' + gender;
//   var dataString = 'cmpyFieldFont='+ CompanyFieldFontSize;
//  $.ajax({
//  type: "POST",
//    url: "pdfSOhtml.php",
//    data: dataString,
//    success: function(){
//  
//    $(".newpdftemp").html('<iframe src="pdfSOhtml.php?o=<?php echo $_GET['view'] ?>&module=<?php echo $_GET['module'] ?>&editpdftemp=1&test='+CompanyFieldFontSize+'" style="width:100%; height:1300px;" frameborder="0"></iframe>');
//   }
// });
//
// }


$(document).ready(function(){
    $('input[type="checkbox"]').click(function(){
        if($(this).prop("checked") == true){
            $("#setDefautTemID").val('1');

                // alert("Checkbox is checked.");

            }
              else if($(this).prop("checked") == false){
                $("#setDefautTemID").val('0');
            }
        });

        // alert($("#setDefautTemID").val());

        if($("#setDefautTemID").val()==1){$("#setDefautTemID").attr("checked","checked");}
        else{$("#setDefautTemID").removeAttr("checked");}
    });
</script>
<style>
    .temnamereq{text-align: center; color:red;font-size: 12px;}

</style>


<a href="<?php echo $AddredirectURL
?>" class="back">Back</a>






<div class="had">
    <?php echo $ModuleDepName
?>    <span>&raquo;
    <?php echo $ModuleName . ' Detail' ?>

</span>
</div>

<div class="message" align="center"><?php

if (!empty($_SESSION['mess_Sale']))
    {
    echo $_SESSION['mess_Sale'];
    unset($_SESSION['mess_Sale']);
    } ?></div>
<div style="float: left; display: inline-block;  width: 22%;">
    <div class="temnamereq"><?php

if (!empty($_SESSION['mess_dynamicpdf']))
    {
    echo $_SESSION['mess_dynamicpdf'];
    }

unset($_SESSION['mess_dynamicpdf']); ?></div>

    <?php //PR($GetPFdTempalteVal);
 ?>
    <form enctype="multipart/form-data" onsubmit="return validateForm(this);" method="post" action="" id="form1" name="form1">
        <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" class="borderall">
            <!--Add Template -->
    <?php if (@$GetPFdTempalteVal[0]['AdminID'] != $_SESSION['AdminID'] && !empty($GetPFdTempalteVal[0]['id'])) { ?> 
             <tr><td class="head" colspan="<?php echo $col
?>">Add Template</td></tr>
             <tr><td colspan="<?php echo $col
?>"> Name : <span class="red">* </span><?php
    echo stripslashes($GetPFdTempalteVal[0]['TemplateName']); ?></td></tr>
             <?php
    $setDefTemVal = (!empty($GetPFdTempalteVal[0]['setDefautTem'])) ? (stripslashes($GetPFdTempalteVal[0]['setDefautTem'])) : ('0'); ?>
             <?php
    $defvalMul = explode(',', $GetPFdTempalteVal[0]['defaultFor']);
    if (!in_array($_SESSION['AdminID'], $defvalMul))
        {
        $setDefTemVal = '0';
        $defltmultArry = array(
            $GetPFdTempalteVal[0]['defaultFor'],
            $_SESSION['AdminID']
        );
        $defltmultVal = implode(",", $defltmultArry);
        }
      else
        {
        $defltmultVal = $GetPFdTempalteVal[0]['defaultFor'];
        }

?>
      <?php if($_SESSION['AdminType']=='admin') { ?>      
            <tr><td colspan="<?php echo $col
?>"> Make as DefaultTemp : <span class="red">* </span><input style="margin-left: 15px;" class="checkbox"  type="checkbox" id="setDefautTemID" name="setDefautTem" value="<?php
    echo $setDefTemVal; ?>" /></td></tr>

            <!-- Make Template public or private-->
            <tr><td class="head" colspan="<?php echo $col ?>">Make Template Public/Private</td></tr>
            <tr>
                <td align="right" class="blackbold" colspan="2">Template Public/Private :</td>
                <td align="left" colspan="2"> 
                   <?php
    echo $shPubPvt = (($GetPFdTempalteVal[0]['PublicPvt']) == 0) ? ('Public') : ('Private');
?>
               </td>
           </tr>
           <?php } ?>
           <tr>
            <td align="right" class="blackbold" colspan="2">Created By :</td>
            <td align="left" colspan="2"> 
              <?php
    echo $createdBy; ?> 
              <input type="hidden" name="Deftformult" value="1"/>
              <input type="hidden" name="defaultFor" value="<?php
    echo $defltmultVal; ?>"/>
          </td>
      </tr>
      <?php
    }
  else
    { ?>
        <tr><td class="head" colspan="<?php echo $col
?>">Add Template</td></tr>
        <tr><td colspan="<?php echo $col
?>"> Name : <span class="red">* </span><input class="inputbox"  type="text" id="TemplateNameID" maxlength="50" name="TemplateName" value="<?php
    echo stripslashes($GetPFdTempalteVal[0]['TemplateName']); ?>" /></td></tr>
 <?php if($_SESSION['AdminType']=='admin') { ?>
        <?php
    $setDefTemVal = (!empty($GetPFdTempalteVal[0]['setDefautTem'])) ? (stripslashes($GetPFdTempalteVal[0]['setDefautTem'])) : ('0'); ?>
        <tr><td colspan="<?php echo $col
?>"> Make as DefaultTemp : <span class="red">* </span><input style="margin-left: 15px;" class="checkbox"  type="checkbox" id="setDefautTemID" name="setDefautTem" value="<?php
    echo $setDefTemVal; ?>" /></td></tr>
    <?php } ?>

        <!-- Make Template public or private-->
        <tr><td class="head" colspan="<?php echo $col ?>">Make Template Public/Private</td></tr>
        <tr>
            <td align="right" class="blackbold" colspan="2">Template Public/Private</td>
            <td align="left" colspan="2"> 
                <select class="textbox" onchange="changeEventFn()" id="CompanyFieldFontSizeID"  name="PublicPvt">
                    <option value="">Select</option>
                    <?php
    foreach($PublicPvtArry as $key => $val)
        { ?>
                        <option value="<?php echo $val
?>" <?php
        if ($GetPFdTempalteVal[0]['PublicPvt'] == $val)
            {
            echo 'selected';
            } ?>><?php echo $key ?></option>
                        <?php
        } ?>
                    </select> 
                </td>
            </tr>
            <tr>
                <td align="right" class="blackbold" colspan="2">Created By :</td>
                <td align="left" colspan="2"> 

                  <?php
(empty($createdBy))?($createdBy=""):("");

    echo $createdBy; ?> 
              </td>
          </tr>

<!-- start hide logo and address-->
<?php
    if ($_GET['ModuleDepName'] == 'WhouseBatchMgt')
        { ?>
<tr><td class="head" colspan="<?php echo $col
?>">Show Hide Logo/Address</td></tr>
<tr>

<td align="right" class="blackbold">Logo</td>
<td align="left"> 
<select class="textbox"  name="LogoDisplay">
<option value="">Select</option>
<?php
        foreach($showHideArray as $key => $val)
            { ?>
<option value="<?php echo $val
?>" <?php
            if ($GetPFdTempalteVal[0]['LogoDisplay'] == $val)
                {
                echo 'selected';
                } ?>><?php echo $key ?></option>
<?php
            } ?>
</select> 
</td>


<td align="right" class="blackbold">Address</td>
<td align="left"> 
<select class="textbox"  name="AddressDisplay">
<option value="">Select</option>
<?php
        foreach($showHideArray as $key => $val)
            { ?>
 <option value="<?php echo $val
?>" <?php
            if ($GetPFdTempalteVal[0]['AddressDisplay'] == $val)
                {
                echo 'selected';
                } ?>><?php echo $key ?></option>
 <?php
            } ?>
 </select> 
 </td>  
    </tr>
    <?php
        } ?>

<!--end hide logo and address-->
          <!-- Add Template-->

          <!-- section A -->
          <tr><td class="head" colspan="<?php echo $col ?>">Company Info</td></tr>
          
          <tr>

            <td align="right" class="blackbold"><?php echo $FieldFontSize ?></td>
            <td align="left"> 
                <select class="textbox" onchange="changeEventFn()" id="CompanyFieldFontSizeID"  name="Company<?php echo $FieldFontSizeName
?>">
                    <option value="">Select</option>
                    <?php
    foreach($FieldSizeArry as $val)
        { ?>
                        <option value="<?php echo $val
?>" <?php
        if ($GetPFdTempalteVal[0]['CompanyFieldFontSize'] == $val)
            {
            echo 'selected';
            } ?>><?php echo $val ?></option>
                        <?php
        } ?>
                    </select> 
                </td>

                <td align="right" class="blackbold"><?php echo $FieldAlign
?></td>
                <td align="left"> 
                    <select id="CompanyFieldAlign" class="textbox" onchange="companyalign()"  name="Company<?php echo $FieldAlignName
?>">
                        <option value="">Select</option>
                        <?php
    foreach($AlignArryTitle as $key => $val)
        { ?>
                            <option value="<?php echo $val
?>" <?php
        if ($GetPFdTempalteVal[0]['CompanyFieldAlign'] == $val)
            {
            echo 'selected';
            } ?>><?php echo $key ?></option>
                            <?php
        } ?>

                        </select> 
                    </td>
                </tr>
                <tr>
                    <td align="right" class="blackbold">Logo Size</td>
                    <td align="left"> 
                        <select class="textbox"  name="LogoSize">
                            <option value="">Select</option>
                            <?php
    foreach($logosize as $val)
        { ?>
                                <option value="<?php echo $val
?>" <?php
        if ($GetPFdTempalteVal[0]['LogoSize'] == $val)
            {
            echo 'selected';
            } ?>><?php echo $val ?></option>
                                <?php
        } ?>

                            </select> 
                        </td>

                        <td align="right" class="blackbold">Color</td>
                        <td align="left"> 
                            <select class="textbox"  name="CompanyColor">
                                <option value="">Select</option>
                                <?php
    foreach($Color as $key => $val)
        { ?>
                                    <option value="<?php echo $val
?>" <?php
        if ($GetPFdTempalteVal[0]['CompanyColor'] == $val)
            {
            echo 'selected';
            } ?>><?php echo $key ?></option>
                                    <?php
        } ?>

                                </select> 
                            </td>
                        </tr>
                        <tr>
                            <td align="right" class="blackbold"><?php echo $TabFontSize
?></td>
                            <td align="left"> 
                                <select class="textbox"  name="Company<?php echo $HeadingFontSizeName
?>">
                                    <option value="">Select</option>
                                    <?php
    foreach($HeadingSizeArry as $value)
        { ?>
                                        <option value="<?php echo $value
?>" <?php
        if ($GetPFdTempalteVal[0]['CompanyHeadingFontSize'] == $value)
            {
            echo 'selected';
            } ?>><?php echo $value ?></option>
                                        <?php
        } ?>
                                    </select> 
                                </td>
                                <td align="right" class="blackbold">Heading Color</td>
                                <td align="left"> 
                                    <select class="textbox"  name="CompanyHeadColor">
                                        <option value="">Select</option>
                                        <?php
    foreach($Color as $key => $val)
        { ?>
                                            <option value="<?php echo $val
?>" <?php
        if ($GetPFdTempalteVal[0]['CompanyHeadColor'] == $val)
            {
            echo 'selected';
            } ?>><?php echo $key ?></option>
                                            <?php
        } ?>

                                        </select> 
                                    </td>

                                </tr>

                                <!-- info-->
                                <tr><td class="head" colspan="<?php echo $col
?>"><?php echo $module
?> Information</td></tr>
<tr>
              <?php
    if ($_GET['ModuleDepName'] == 'Sales' || $_GET['ModuleDepName'] == 'SalesInvoice')
        { ?>
<td align="right" class="blackbold">Sales Person</td>
<td align="left"> 
<select class="textbox"  name="SalesPersonD">
<option value="">Select</option>
<?php
        foreach($showHideArray as $key => $val)
            { ?>
 <option value="<?php echo $val
?>" <?php
            if ($GetPFdTempalteVal[0]['SalesPersonD'] == $val)
                {
                echo 'selected';
                } ?>><?php echo $key ?></option>
 <?php
            } ?>
 </select> 
 </td>
 <td align="right" class="blackbold">Created By</td>
<td align="left"> 
<select class="textbox"  name="CreatedByD">
<option value="">Select</option>
<?php
        foreach($showHideArray as $key => $val)
            { ?>
 <option value="<?php echo $val
?>" <?php
            if ($GetPFdTempalteVal[0]['CreatedByD'] == $val)
                {
                echo 'selected';
                } ?>><?php echo $key ?></option>
 <?php
            } ?>
 </select> 
 </td>    
  <?php
        } ?>

          </tr>
                                <tr>
                                    <td align="right" class="blackbold"><?php echo $FieldFontSize
?></td>
                                    <td align="left"> 
                                        <select class="textbox"  name="Information<?php echo $FieldFontSizeName
?>">
                                            <option value="">Select</option>
                                            <?php
    foreach($FieldSizeArry as $val)
        { ?>
                                                <option value="<?php echo $val
?>" <?php
        if ($GetPFdTempalteVal[0]['InformationFieldFontSize'] == $val)
            {
            echo 'selected';
            } ?>><?php echo $val ?></option>
                                                <?php
        } ?>
                                            </select> 
                                        </td>

                                        <td align="right" class="blackbold"><?php echo $FieldAlign
?></td>
                                        <td align="left"> 
                                            <select class="textbox" id="InfoFieldAlign" onchange="Infoalign()"  name="Information<?php echo $FieldAlignName
?>">
                                                <option value="">Select</option>
                                                <?php
    foreach($AlignArryTitle as $key => $val)
        { ?>
                                                    <option value="<?php echo $val
?>" <?php
        if ($GetPFdTempalteVal[0]['InformationFieldAlign'] == $val)
            {
            echo 'selected';
            } ?>><?php echo $key ?></option>
                                                    <?php
        } ?>

                                                </select> 
                                            </td>
                                        </tr>
<!--                    <tr>
    <td align="right" class="blackbold"><?php echo $TabFontSize
?></td>
    <td align="left"> 
        <select class="textbox"  name="Information<?php echo $HeadingFontSizeName
?>">
          <option value="">Select</option>
          <?php
	if(empty($GetPFdTempalteVal[0]['InformationHeadingFontSize'])) $GetPFdTempalteVal[0]['InformationHeadingFontSize']='';
    foreach($HeadingSizeArry as $value)
        { ?>
            <option value="<?php echo $value
?>" <?php
	
        if ($GetPFdTempalteVal[0]['InformationHeadingFontSize'] == $value)
            {
            echo 'selected';
            } ?>><?php echo $value ?></option>
            <?php
        } ?>
        </select> 
    </td>

    <td align="right" class="blackbold"><?php echo $TabAlign
?></td>
    <td align="left"> 
        <select class="textbox"  name="Information<?php echo $HeadingAlignName
?>">
           <option value="">Select</option>
           <?php
	if(empty($GetPFdTempalteVal[0]['InformationHeadingAlign'])) $GetPFdTempalteVal[0]['InformationHeadingAlign']='';
    foreach($AlignArryTitle as $val)
        { ?>
            <option value="<?php echo $val
?>" <?php
        if ($GetPFdTempalteVal[0]['InformationHeadingAlign'] == $val)
            {
            echo 'selected';
            } ?>><?php echo $val ?></option>
            <?php
        } ?>

        </select> 
    </td>
</tr>-->
<tr>
<!--                    <td align="right" class="blackbold">Field Border</td>
            <td align="left"> 
                <select class="textbox"  name="InformationFieldBorder">
                 <option value="">Select</option>
                 <?php
	if(empty($GetPFdTempalteVal[0]['InformationFieldBorder'])) $GetPFdTempalteVal[0]['InformationFieldBorder']='';
    foreach($borderarry as $key => $val)
        { ?>
                    <option value="<?php echo $val
?>" <?php
        if ($GetPFdTempalteVal[0]['InformationFieldBorder'] == $val)
            {
            echo 'selected';
            } ?>><?php echo $key ?></option>
                    <?php
        } ?>


                </select> 
            </td>-->


            <td align="right" class="blackbold">Color</td>
            <td align="left"> 
                <select class="textbox"  name="InformationColor">
                    <option value="">Select</option>
                    <?php
    foreach($Color as $key => $val)
        { ?>
                        <option value="<?php echo $val
?>" <?php
        if ($GetPFdTempalteVal[0]['InformationColor'] == $val)
            {
            echo 'selected';
            } ?>><?php echo $key ?></option>
                        <?php
        } ?>
                    </select> 
                </td> 
                <td align="right" class="blackbold">Title Font Size</td>
                <td align="left"> 
                    <select class="textbox"  name="TitleFontSize">
                        <option value="">Select</option>
                        <?php
    foreach($HeadingSizeArry as $val)
        { ?>
                            <option value="<?php echo $val
?>" <?php
        if ($GetPFdTempalteVal[0]['TitleFontSize'] == $val)
            {
            echo 'selected';
            } ?>><?php echo $val ?></option>
                            <?php
        } ?>

                        </select> 
                    </td>
                </tr>
                <tr>
                    <td align="right" class="blackbold">Title/PDF Name</td>
                    <td align="left"> 
                        <select class="textbox"  name="Title">
                            <option value="">Select</option>
                            <?php
    foreach($HeadingArry as $key => $val)
        { ?>
                                <option value="<?php echo $val
?>" <?php
        if ($GetPFdTempalteVal[0]['Title'] == $val)
            {
            echo 'selected';
            } ?>><?php echo $key ?></option>
                                <?php
        } ?>


                            </select> 
                        </td>



                        <td align="right" class="blackbold">Title Color</td>
                        <td align="left"> 
                            <select class="textbox"  name="TitleColor">
                                <option value="">Select</option>
                                <?php
    foreach($Color as $key => $val)
        { ?>
                                    <option value="<?php echo $val
?>" <?php
        if ($GetPFdTempalteVal[0]['TitleColor'] == $val)
            {
            echo 'selected';
            } ?>><?php echo $key ?></option>
                                    <?php
        } ?>

                                </select> 
                            </td>

                        </tr>
                        <!-- section B -->
                        <tr><td class="head" colspan="<?php echo $col
?>"><?php echo $Address1
?></td></tr>
                        <tr>
                            <td align="right"  class="blackbold">Heading & <?php echo $FieldFontSize ?></td>
                            <td align="left"> 
                                <select class="textbox" onchange="BillingFontSize()" id="BillingFontSizeID"  name="BillAdd_Heading_<?php echo $FieldFontSizeName
?>">
                                    <option value="">Select</option>
                                    <?php
    foreach($FieldSizeArry as $val)
        { ?>
                                        <option value="<?php echo $val
?>" <?php
        if ($GetPFdTempalteVal[0]['BillAdd_Heading_FieldFontSize'] == $val)
            {
            echo 'selected';
            } ?>><?php echo $val ?></option>
                                        <?php
        } ?>
                                    </select> 
                                </td>

                                <td align="right" class="blackbold">Heading & <?php echo $FieldAlign ?></td>
                                <td align="left"> 
                                    <select class="textbox" id="BillingID" onchange="BillingAlign()"  name="BillAdd_Heading_<?php echo $FieldAlignName
?>">
                                        <option value="">Select</option>
                                        <?php
    foreach($AlignArryTitle as $key => $val)
        { ?>
                                            <option value="<?php echo $val
?>" <?php
        if ($GetPFdTempalteVal[0]['BillAdd_Heading_FieldAlign'] == $val)
            {
            echo 'selected';
            } ?>><?php echo $key ?></option>
                                            <?php
        } ?>

                                        </select> 
                                    </td>
                                </tr>
                                <tr>

                                    <td align="right" class="blackbold"><?php echo $Tab
?></td>
                                    <td align="left"> 
                                        <select class="textbox"  name="BillAdd<?php echo $HeadingName
?>">
                                            <option value="">Select</option>
                                            <?php
    foreach($HeadingArry as $key => $val)
        { ?>
                                                <option value="<?php echo $val
?>" <?php
        if ($GetPFdTempalteVal[0]['BillAddHeading'] == $val)
            {
            echo 'selected';
            } ?>><?php echo $key ?></option>
                                                <?php
        } ?>

                                            </select> 
                                        </td>


                                        <td align="right" class="blackbold">Color</td>
                                        <td align="left"> 
                                            <select class="textbox"  name="BillAddColor">
                                                <option value="">Select</option>
                                                <?php
    foreach($Color as $key => $val)
        { ?>
                                                    <option value="<?php echo $val
?>" <?php
        if ($GetPFdTempalteVal[0]['BillAddColor'] == $val)
            {
            echo 'selected';
            } ?>><?php echo $key ?></option>
                                                    <?php
        } ?>
                                                </select> 
                                            </td> 
                                        </tr>
                                        <tr>
                                            <td align="right" class="blackbold">Heading Color</td>
                                            <td align="left"> 
                                                <select class="textbox"  name="BillHeadColor">
                                                    <option value="">Select</option>
                                                    <?php
    foreach($Color as $key => $val)
        { ?>
                                                        <option value="<?php echo $val
?>" <?php
        if ($GetPFdTempalteVal[0]['BillHeadColor'] == $val)
            {
            echo 'selected';
            } ?>><?php echo $key ?></option>
                                                        <?php
        } ?>
                                                    </select> 
                                                </td>

                                                <td align="right" class="blackbold">Heading background Color</td>
                                                <td align="left"> 
                                                    <select class="textbox"  name="BillHeadbackgroundColor">
                                                        <option value="">Select</option>
                                                        <?php
    foreach($Color as $key => $val)
        { ?>
                                                            <option value="<?php echo $val
?>" <?php
        if ($GetPFdTempalteVal[0]['BillHeadbackgroundColor'] == $val)
            {
            echo 'selected';
            } ?>><?php echo $key ?></option>
                                                            <?php
        } ?>
                                                        </select> 
                                                    </td>  

                                                </tr>
                                                <!-- Section C-->
                                                <tr><td class="head" colspan="<?php echo $col
?>"><?php echo $Address2
?></td></tr>
                                                <tr>

                                                    <td align="right" class="blackbold">Heading & <?php echo $FieldAlign ?></td>
                                                    <td align="left"> 
                                                        <select class="textbox" onchange="ShippingAlign()" id="ShippingID"  name="ShippAdd_Heading_<?php echo $FieldAlignName
?>">
                                                            <option value="">Select</option>
                                                            <?php
    foreach($AlignArryTitle as $key => $val)
        { ?>
                                                                <option value="<?php echo $val
?>" <?php
        if ($GetPFdTempalteVal[0]['ShippAdd_Heading_FieldAlign'] == $val)
            {
            echo 'selected';
            } ?>><?php echo $key ?></option>
                                                                <?php
        } ?>
                                                            </select> 
                                                        </td>


                                                        <td align="right" class="blackbold"><?php echo $Tab
?></td>
                                                        <td align="left"> 
                                                            <select class="textbox"  name="ShippAdd<?php echo $HeadingName
?>">
                                                                <option value="">Select</option>
                                                                <?php
    foreach($HeadingArry as $key => $val)
        { ?>
                                                                    <option value="<?php echo $val
?>" <?php
        if ($GetPFdTempalteVal[0]['ShippAddHeading'] == $val)
            {
            echo 'selected';
            } ?>><?php echo $key ?></option>
                                                                    <?php
        } ?>

                                                                </select> 
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td align="right" class="blackbold">Color</td>
                                                            <td align="left"> 
                                                                <select class="textbox"  name="ShippAddColor">
                                                                    <option value="">Select</option>
                                                                    <?php
    foreach($Color as $key => $val)
        { ?>
                                                                        <option value="<?php echo $val
?>" <?php
        if ($GetPFdTempalteVal[0]['ShippAddColor'] == $val)
            {
            echo 'selected';
            } ?>><?php echo $key ?></option>
                                                                        <?php
        } ?>
 </select> 
</td> 
 <td align="right"  class="blackbold">Heading & <?php echo $FieldFontSize ?></td>
 <td align="left"> 
<select class="textbox" onchange="ShippingFontSize()" id="ShippingFontSizeID" name="ShippAdd_Heading_<?php echo $FieldFontSizeName
?>">
<option value="">Select</option>
<?php
    foreach($FieldSizeArry as $val)
        { ?>
<option value="<?php echo $val
?>" <?php
        if ($GetPFdTempalteVal[0]['ShippAdd_Heading_FieldFontSize'] == $val)
            {
            echo 'selected';
            } ?>><?php echo $val ?></option>
                                                                            <?php
        } ?>
</select> 
 </td>
 </tr>
<tr>
<td align="right" class="blackbold">Heading Color</td>
<td align="left"> 
<select class="textbox"  name="ShippHeadColor">
<option value="">Select</option>
<?php
    foreach($Color as $key => $val)
        { ?>
<option value="<?php echo $val
?>" <?php
        if ($GetPFdTempalteVal[0]['ShippHeadColor'] == $val)
            {
            echo 'selected';
            } ?>><?php echo $key ?></option>
<?php
        } ?>
</select> 
</td>
<td align="right" class="blackbold">Heading background Color</td>
<td align="left"> 
<select class="textbox"  name="ShippHeadbackgroundColor">
<option value="">Select</option>
<?php
    foreach($Color as $key => $val)
        { ?>
   <option value="<?php echo $val
?>" <?php
        if ($GetPFdTempalteVal[0]['ShippHeadbackgroundColor'] == $val)
            {
            echo 'selected';
            } ?>><?php echo $key ?></option>
  <?php
        } ?>
  </select> 
 </td>  
</tr>
 <!-- Section D-->
<tr><td class="head" colspan="<?php echo $col
?>">Line Item</td></tr>
<tr>
<td align="right" class="blackbold">Heading Color</td>
<td align="left"> 
<select class="textbox"  name="LineHeadColor">
 <option value="">Select</option>
<?php
    foreach($Color as $key => $val)
        { ?>
        <option value="<?php echo $val
?>" <?php
        if ($GetPFdTempalteVal[0]['LineHeadColor'] == $val)
            {
            echo 'selected';
            } ?>><?php echo $key ?></option>
                                   <?php
        } ?>
            </select> 
 </td>

    <td align="right" class="blackbold">Heading background Color</td>
  <td align="left"> 
   <select class="textbox"  name="LineHeadbackgroundColor">
    <option value="">Select</option>
   <?php
    foreach($Color as $key => $val)
        { ?>
                                        <option value="<?php echo $val
?>" <?php
        if ($GetPFdTempalteVal[0]['LineHeadbackgroundColor'] == $val)
            {
            echo 'selected';
            } ?>><?php echo $key ?></option>
                                                     <?php
        } ?>
                                    </select> 
                                     </td>  

                                                </tr>
                                                <tr>
         <td align="right" class="blackbold"><?php echo $Tab
?></td>
                                        <td align="left"> 
                                <select class="textbox"  name="Line<?php echo $HeadingName
?>">
        <option value="">Select</option>
                                                    <?php
    foreach($HeadingArry as $key => $val)
        { ?>
               <option value="<?php echo $val
?>" <?php
        if ($GetPFdTempalteVal[0]['LineHeading'] == $val)
            {
            echo 'selected';
            } ?>><?php echo $key ?></option>
                                                            <?php
        } ?>

                                                </select> 
                                            </td>
                    <td align="right" class="blackbold">Color</td>
                        <td align="left"> 
     <select class="textbox"  name="LineColor">
    <option value="">Select</option>
    <?php
    foreach($Color as $key => $val)
        { ?>
 <option value="<?php echo $val
?>" <?php
        if ($GetPFdTempalteVal[0]['LineColor'] == $val)
            {
            echo 'selected';
            } ?>><?php echo $key ?></option>
      <?php
        } ?>
    </select> 
</td>
</tr>
 <tr>
<td align="right" class="blackbold">Item Field & <?php echo $TabFontSize ?></td>
<td align="left"> 
<select class="textbox"  name="LineItem<?php echo $HeadingFontSizeName
?>">
<option value="">Select</option>
 <?php
    foreach($lineItemHeadFontSize as $value)
        { ?>
<option value="<?php echo $value
?>" <?php
        if ($GetPFdTempalteVal[0]['LineItemHeadingFontSize'] == $value)
            {
            echo 'selected';
            } ?>><?php echo $value ?></option>
<?php
        } ?>
</select> 
    </td>
</tr>
 <!-- Show hide Sku item-->
<tr><td class="head" colspan="<?php echo $col
?>">Show Hide Sku Item</td></tr>
<tr>
<?php
    //if ($_GET['ModuleDepName'] == 'Sales' || $_GET['ModuleDepName'] == 'Purchase' || $_GET['ModuleDepName'] == 'SalesInvoice' || $_GET['ModuleDepName'] == 'PurchaseInvoice'){
         ?>
<td align="right" class="blackbold">Condition</td>
<td align="left"> 
<select class="textbox"  name="ConditionDisplay">
<option value="">Select</option>
<?php
        foreach($showHideArray as $key => $val)
            { ?>
<option value="<?php echo $val
?>" <?php
            if ($GetPFdTempalteVal[0]['ConditionDisplay'] == $val)
                {
                echo 'selected';
                } ?>><?php echo $key ?></option>
<?php
            } ?>
</select> 
</td>
<?php
        //} ?>
<?php
    if ($_GET['ModuleDepName'] == 'Sales' || $_GET['ModuleDepName'] == 'SalesInvoice')
        { ?>
<td align="right" class="blackbold">Discount</td>
<td align="left"> 
<select class="textbox"  name="DiscountDisplay">
<option value="">Select</option>
<?php
        foreach($showHideArray as $key => $val)
            { ?>
 <option value="<?php echo $val
?>" <?php
            if ($GetPFdTempalteVal[0]['DiscountDisplay'] == $val)
                {
                echo 'selected';
                } ?>><?php echo $key ?></option>
 <?php
            } ?>
 </select> 
 </td>  
  <?php
        } ?>
  </tr>
 <!-- Special NOtes -->
 <tr><td class="head" colspan="<?php echo $col
?>">Special Notes &amp; Below Data</td></tr>
                    <tr>
    <td align="right" class="blackbold">Heading Color</td>
<td align="left"> 
<select class="textbox"  name="SpecialHeadColor">
<option value="">Select</option>
<?php
    foreach($Color as $key => $val)
        { ?>
<option value="<?php echo $val
?>" <?php
        if ($GetPFdTempalteVal[0]['SpecialHeadColor'] == $val)
            {
            echo 'selected';
            } ?>><?php echo $key ?></option>
 <?php
        } ?>
   </select> 
</td>
<td align="right" class="blackbold">Heading background Color</td>
<td align="left"> 
<select class="textbox"  name="SpecialHeadbackgroundColor">
<option value="">Select</option>
 <?php
    foreach($Color as $key => $val)
        { ?>
    <option value="<?php echo $val
?>" <?php
        if ($GetPFdTempalteVal[0]['SpecialHeadbackgroundColor'] == $val)
            {
            echo 'selected';
            } ?>><?php echo $key ?></option>
    <?php
        } ?>
    </select> 
    </td>  
 </tr>
    <tr>
  <td align="right" class="blackbold">Heading & Field & <?php echo $TabFontSize ?></td>
       <td align="left"> 
    <select class="textbox"  name="SpecialHeadingFontSize">
 <option value="">Select</option>
<?php
    foreach($lineItemHeadFontSize as $value)
        { ?>
<option value="<?php echo $value
?>" <?php
        if ($GetPFdTempalteVal[0]['SpecialHeadingFontSize'] == $value)
            {
            echo 'selected';
            } ?>><?php echo $value ?></option>
 <?php
        } ?>
</select> 
</td>
    <td align="right" class="blackbold">Field Color</td>
<td align="left"> 
  <select class="textbox"  name="SpecialFieldColor">
 <option value="">Select</option>
                     <?php
    foreach($Color as $key => $val)
        { ?>
<option value="<?php echo $val
?>" <?php
        if ($GetPFdTempalteVal[0]['SpecialFieldColor'] == $val)
            {
            echo 'selected';
            } ?>><?php echo $key ?></option>
 <?php
        } ?>
                   </select> 
</td>
    </tr>
<tr>
    <td align="right" class="blackbold"><?php echo $Tab
?></td>
    <td align="left"> 
  <select class="textbox"  name="Special<?php echo $HeadingName
?>">
<option value="">Select</option>
    <?php
    foreach($HeadingArry as $key => $val)
        { ?>
  <option value="<?php echo $val
?>" <?php
        if ($GetPFdTempalteVal[0]['SpecialHeading'] == $val)
            {
            echo 'selected';
            } ?>><?php echo $key ?></option>
                         <?php
        } ?>
   </select> 
 </td>
       </tr>
<tr><td align="right" class="blackbold">Signed :</td>
 <td align="left" colspan="3" >
<textarea name="SpecialSigned" class="textarea" type="text" style="height:60px;width: 150px;"><?php echo $GetPFdTempalteVal[0]['SpecialSigned']; ?></textarea>
    </td>
</tr>
<!--Footer Content -->
 <tr><td class="head" colspan="<?php echo $col
?>">Footer Content</td></tr>
 <tr><td align="right" class="blackbold">Content :</td>
  <td align="left" colspan="3" >
<textarea name="FooterContent" class="textarea" type="text" style="height:120px;width: 200px;"><?php echo $GetPFdTempalteVal[0]['FooterContent']; ?></textarea>
 </td>
 </tr>
 <?php
    } //session else end

?>

<tr>
    <td colspan="<?php echo $col
?>">
        <div style="text-align: center;">
            <input type="hidden" name="Module" value="<?php echo $ModuleDepName . $module ?>"/>
            <input type="hidden" name="ModuleId" value="<?php echo $_GET['view'] ?>"/>
            <input type="hidden" name="id" value="<?php echo $GetPFdTempalteVal[0]['id'] ?>"/>
            <!--                            <button type="button" value="Preview" onclick="pdfpreview('<?php echo $_GET['view'] ?>','<?php echo $_GET['module'] ?>')" class="button" name="Preview">Preview</button>-->
            <?php

if ($GetPFdTempalteVal[0]['id'] > 0 && $GetPFdTempalteVal[0]['AdminID']== $_SESSION['AdminID'])
    { ?>
        
                <button type="submit" value="Update" class="button" name="Update">Preview & Save</button>
                <?php 
    }
  else
    { ?>
                    <button type="submit" value="Save" class="button" name="Save">Preview & Save</button>
                    <?php
    } ?>
                </div>
            </td> 
        </tr>



    </table> 
</form>
</div>

<?php 
$newval='';
(empty($_GET['Wstatus']))?($_GET['Wstatus']=""):("");

if($_GET['Wstatus']=='Packed'){
    $newval='&Wstatus=Packed';
}

?>
<div style="display: inline-block; float: right; width: 78%;" class="newpdftemp">
    <iframe src="<?php echo $PdfUrl
?>?o=<?php echo $_GET['view'] ?>&module=<?php echo $_GET['module'] ?>&editpdftemp=1&tempid=<?php echo $_GET['tempid'].$newval ?>&ModuleDepName=<?php echo $ModuleDepName ?>" style="width:100%; height:1300px;" frameborder="0"></iframe>

</div>

