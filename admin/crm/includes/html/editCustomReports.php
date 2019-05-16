<script language="JavaScript1.2" type="text/javascript">
$(function(){

$( "#selectedclm" ).sortable({
  update: function( event, ui ) {      resetSelectColumns();      }
});

$('#moduleID').change(function(){
	if($(this).val() != "")
	{ 
		$url='action=customreportmodulefields&moduleID='+$(this).val();
		$.ajax({

                        url: 'ajax.php',
                        type: 'GET',
                        data:$url,
                        success: function(data) {
                                    $('#groupcolumns').html(data);
                                    $('#groupcolumns select').attr('name','groupby');
                                    $('#sortcol').html(data);
                                    $('#sortcol select').attr('name','sortcol');
                                    $('#showcolumns').html(data);
                                    $('#showcolumns select').css('width','611px');
                                    $('#showcolumns').show();
                                    $('#columnserr').html('');
                                    $('.filter_condi select:first-child').each(function(){
                                                                                        $(this).html(data);
                                    })
                                    $('#selectedclm li').remove();
                                    $('.filter_condi input').datepicker("destroy").val(''); 
                                    $('.filter_condi select:gt(0)').find('option').removeAttr("selected");
                                }
                })
                
        $('#selectclms').val('');
		$('.filter_condi select:gt(0)').children().show();
	}else{

		$('#showcolumns').hide();
		$('#showcolumns select').children(':not(:first)').remove();
		$('#groupcolumns').children(':not(:first)').remove();
		$('.filter_condi select:first-child').children(':not(:first)').remove();
		$('.filter_condi select:gt(0)').children().show();
		$('.filter_condi input').datepicker("destroy"); 
	}
});

$('#columns').focus(function(){
            $('#showcolumns').show();
            if($('#moduleID').val() == '')
            {
                $('#columnserr').html('Select Primary Module to select Columns');
            }
            
    
});



$('#addmore').on('click',function(){
	var Clonehtml = $('#filter_condi').clone();//console.log(Clonehtml.find('select:first option:selected').text());
	 Clonehtml.find('td:first').html('');
     Clonehtml.find(':input').val('');
	 Clonehtml.find('option[value = in]').show();
	 Clonehtml.find("#foperr").hide();
	var leng = $('.filter_condi').length;
	if(leng == 2){   $('#addmore').hide();	} 
            Clonehtml.find('#fval').attr('id','fval'+leng+'');
            Clonehtml.find('#fval'+leng+'').removeClass("hasDatepicker");
            Clonehtml.find('button').remove();
            Clonehtml.attr('id','filter'+leng+'');console.log(Clonehtml.find('span'));
            $('<img onclick="filterremove(this)" src="../images/delete.png">').insertBefore(Clonehtml.find('span'));
            Clonehtml.insertAfter($('.filter_condi:last'));
                        
            selFop = [];
            $('.filter_condi select:first-child option:selected').each(function(){
                                                             selFop.push($(this).val());
                                    })
            $('.filter_condi:last select:first option:not(":first")').each(function(){
                                                            if($.inArray($(this).val(),selFop)!=-1)
                                                            {
                                                                $(this).hide();
                                                            }
                                    })
    
                                	
  
});



$('#showcolumns').on('change','select',function(){
	var lenofli = $('#selectedclm li').length; 
	if(lenofli == 10) { alert ('You have selected maximum fields.');$('#showcolumns select option').removeAttr('selected'); return false; }
	if(typeof(jQuery(this).val()) != 'undefined' &&  jQuery(this).val()!=''  ){
                $('#selectedclm').show();
                $('#showcolumns select').css('width','100%');
                $('#columns').hide();
		var txt = $(this).find(":selected").text();
		var opval = $(this).find(":selected").val();
		$('#selectedclm').append('<li id="li'+opval+'" class="column-li"><img onclick="RemoveAddCol(\''+txt+'\',\''+opval+'\')" src="../images/delete.png"><span>'+txt+'</span></li>');
		$(this).find(":selected").hide();
		$('#showcolumns select').val('');
		if($('#selectclms').val())
		{
			$('#selectclms').val($('#selectclms').val()+','+opval);
		}else{
			$('#selectclms').val(opval);
		}
                
	}
});



$(document).on('change','.column-filter',function(){  //console.log($('option:selected',this).attr('data-type'));
	$(this).next('select').find('option:selected').removeAttr('selected');
	$(this).parent().find('input').val('');
    if($('option:selected',this).attr('data-type')=='date'){ 
             $(this).next('select').find('option[value = in]').hide();
            showCalender($(this));
    }else{
            removeCalender($(this));
	     $(this).next('select').find('option[value = in]').show();
    }
}); 

$(document).on('change','.condi-filter',function() { 
   if($('option:selected',this).val() == 'in') {
	   $(this).closest('td').find('span').show().html("For words seperation put the dot(.)"); 
	}else{
		$(this).closest('td').find('span').hide();
	}
}); 

$(document).on('change','.filter_condi select:first-child',function(){
              showhidefiltercol();
                                                             
})



$("#c_reportform").submit(function(){
    var err;
    $('div.red').html('');
    $("#c_reportform  :input[data-mand^=\'y\']").each(function(){
        
        $input = ($(this).closest('td').prev().clone().children().remove().end().text()).replace(':','');
        $fldname = $(this).attr('name');
        if($(this).attr('type') == '' || typeof($(this).attr('type')) == 'undefined' || $(this).attr('type') == 'text')
        {
          if( $.trim($(this).val()) == "")
          {
                    $("#"+$fldname+"err").html(""+$input+" is mandatory field.");
                    err = 1;
          }
        }	
        if($("#selectedclm li").length == '0' )
        {
            $("#selectclmserr").html("Select Columns is mandatory field.");
            err = 1;
        }else if($("#selectedclm li").length < 2)
        {
            $("#selectclmserr").html("Select atleast 2 Columns.");
            err = 1;
        }else if($("#selectedclm li").length > 10)
        {
            $("#selectclmserr").html("you can not select more than 10 Columns.");
            err = 1;
        }   
          
      });
    if(err == 1){ return false; }else{ 

	    var Url = "isRecordExists.php?report_name="+escape(document.getElementById("report_name").value)+"&editID="+document.getElementById("report_ID").value+"&Type=CustomReport";
    	SendExistRequest(Url,"report_name", "Report Name");
    	
	    return false;
	}

   });




})

function RemoveAddCol(txt,val)
{
	$('#li'+val+'').remove();
	$('#showcolumns select').find('option[value="'+val+'"]').show();

	resetSelectColumns();
}

function resetSelectColumns()
{
    var selVal = [];
    $('#selectedclm li').each(function(){   
            selVal.push($(this).attr('id').replace(/[^0-9cs_\.]/g, ''));

            });

    selValStr = selVal.join(',');
    $('#selectclms').val(selValStr);
}


function showCalender(obj)
{
        getObj(obj,'').datepicker({
                showOn: "both",
                yearRange: '<?= date("Y") ?>:<?= date("Y") + 20 ?>',
                dateFormat: 'yy-mm-dd',
                maxDate: "",
                minDate:"",
                changeMonth: true,
                changeYear: true

            });
}
    
function removeCalender(obj)
{    
    getObj(obj,'Y').datepicker("destroy");  
}     

function getObj(obj,remove)
{
    $Index =  obj.closest('tr').attr('id').replace(/[^0-9\.]/g, '');
    if($Index === '')
    {
        $newObj = (remove == 'Y')? $('#fval') : obj.closest('td').children('input:last');
    }else{
        $newObj = $('#fval'+$Index+'');
    }
    return $newObj;
}


function editmoduleIDChange(ID)
{
    $url='action=customreportmodulefields&moduleID='+ID;
    $.ajax({

            url: 'ajax.php',
            type: 'GET',
            data:$url,
            success: function(data) {
                        $('#groupcolumns').html(data);
                        $('#groupcolumns select').attr('name','groupby');
                        $('#sortcol').html(data);
                        $('#sortcol select').attr('name','sortcol');
                        $('#showcolumns').html(data);
                        $('#showcolumns select').css('width','611px');
                        $('#showcolumns').show();
                        $('#columnserr').html('');
                        $('.filter_condi select:first-child').each(function(){
                                                                            $(this).html(data);
                        });
                    }
    })
}

function editHideAddCol(cols)
{
    $colsID = $('#selectclms').val().split(',');
    $('#showcolumns select option').each(function(){
        
        if($.inArray($(this).val(),$colsID)!=-1)
        {
            $(this).hide();
        }
        
    });
}

function selectOptionforEditData(val,ElmID)
{
    $("#"+ElmID+"").find("option[value='"+val+"']").attr('selected',true);
}

function selectOptforEditFltrData(fop,fval,fcol)
{console.log('gh');
    if(fop.length >=1 )
    {   
        $(".filter_condi:first").find("select:first option[value='"+fcol[0]+"']").attr('selected',true);
        $(".filter_condi:first").find("select:last option[value='"+fop[0]+"']").attr('selected',true);
        $(".filter_condi:first").find("input").val(fval[0]);
        
        if(fop.length >1)
        {
            for(i=1;i<fop.length;i++)
            {   
                $('#addmore').trigger('click');
                $(".filter_condi:last").each(function(){
                    
                    $(this).find("select:first option[value='"+fcol[i]+"']").attr('selected',true);
                    $(this).find("select:last option[value='"+fop[i]+"']").attr('selected',true);
                    $(this).find("input").val(fval[i]);
                    
                })
            }
        } 
	
	$('.filter_condi select:first-child option:selected').each(function(){
		if($(this).attr('data-type') == 'date')
		{
			$(this).closest('td').find('select:last option[value="in"]').hide();
			showCalender($(this));
		}
            })  
   
        showhidefiltercol();
        
    }
    
}

function filterremove(obj) {
	obj.closest('tr').remove();
	$('#addmore').show();
	showhidefiltercol();
}

function showhidefiltercol()
{
	OtherselId = [];
    $('.filter_condi select:first-child option:selected').each(function(){
    								OtherselId.push($(this).val());
                            })
    $('.filter_condi select:first-child option:not(":first"):not(":selected")').each(function(){
            if($.inArray($(this).val(),OtherselId) !=-1 )
            {
                $(this).hide();
            }else{
                $(this).show();
            }
    })
}


</script>
<style>
.column-li{
float:left;padding:3px 3px 3px 3px;
}
.inputboxclass{
    width: 100% !important;
}
</style>
<div class="back"><a class="back"  href="<?=$RedirectURL?>">Back</a></div>
<div class="had">
Manage Report   &raquo; <span>

	<?php 	echo (!empty($_GET['edit']))?("Edit  <b>".stripcslashes($editData['report_name'])."</b> ") :("Add Report"); ?>

</span>
</div>

<form name="c_reportform" id="c_reportform"  action="createcustomreport.php" method="post">
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<?php if (!empty($_SESSION['mesg_report'])) { ?>
                <tr>
                    <td  align="center"  class="message"  >
                        <?php if (!empty($_SESSION['mesg_report'])) {
                            echo $_SESSION['mesg_report'];
                            unset($_SESSION['mesg_report']);
                        } ?>	
                    </td>
                </tr>
<?php } ?>
   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
    <td colspan="4" align="left" class="head"><b>Report Details</b></td>
</tr>


    <tr>
             <td  align="left" width="15%"   class="blackbold"> Report Name  :<span class="red">*</span> </td>
             <td   align="left" width="75%"><input data-mand="y" name="report_name" type="text" class="inputbox" id="report_name" value="<?php echo (isset($editData['report_name'])) ? stripcslashes($editData['report_name']) : ''; ?>"  maxlength="40" />
             <div class="red" id="report_nameerr" style="margin-left:5px;"></div>
             </td>


     </tr>
      <tr>
             <td align="left"  width="15%" class="blackbold"> Description :<span class="red">*</span> </td>
             <td align="left" width="75%" ><input data-mand="y" name="report_desc" type="text" class="inputbox" id="report_desc" value="<?php echo (isset($editData['report_desc'])) ? stripcslashes($editData['report_desc']) : ''; ?>"  maxlength="400" />
             <div class="red" id="report_descerr" style="margin-left:5px;"></div>
             </td>
      </tr>
      <tr>
             <td align="left" width="15%" class="blackbold">Select Primary Module :<span class="red">*</span> </td>
             <td align="left" width="75%" >
             <select data-mand="y" class="inputbox" id="moduleID" name="moduleID" style="width:200px;">
             <option value="">--Select Module--</option>
                <?php  for($i=0;$i<9;$i++) {?>
                        <option value="<?=$arrayHeaderMenus[$i]['ModuleID']?>" <?php  if( isset($editData['moduleID']) && $arrayHeaderMenus[$i]['ModuleID'] == $editData['moduleID']){echo "selected";}?>>
                        <?=stripslashes($arrayHeaderMenus[$i]['Module']);?> 
                        </option>
                <?php } ?>
     
            <option value="2003" <?php  if(isset($editData['moduleID']) && $editData['moduleID']==2003){echo "selected";}?>>Item Master </option>
             
            </select> 
            <div class="red" id="moduleIDerr" style="margin-left:5px;"></div>
            </td>
      </tr>
   
   
<tr>
	 <td colspan="4" align="left" class="head"><b>Choose Column</b></td>
</tr>
     <tr>
             <td align="left"  width="15%" class="blackbold">Selected Fields :<span class="red">*</span> </td>
             <td align="left" width="200%" >
                 <div style="height:auto; width: 100%">
                 <ul id="selectedclm" style="border: 1px solid rgb(218, 225, 232); display: none; overflow: hidden;
height: auto !important; min-height: 26px; width: 100%; margin-bottom: 3px;display: none;">
                     
                <?php     
                if(!empty($colSel))
                {
                    foreach($colSel as $col)
                    {
                ?>
                        <li id="li<?php echo $col['ID']?>" class="column-li">
                            <img onclick="RemoveAddCol('<?php echo $col['name']?> ','<?php echo $col['ID']?>')" src="../images/delete.png"><span> <?php echo $col['name']?></span>
                        </li>
                <?php
                    }
                }
                ?>
                     
                     
                 </ul>
                 
                 <input name="columns" id="columns" type="text" readonly="readonly" style="width:600px;" placeholder="" class="inputbox" id="SelectColumns" value="" />
                 <span id="columnserr" class="red"></span>
                 </div>
                 <div id ="showcolumns" class="inputboxclass" style="display:none;">
              <select class="inputbox" style="width:611px">
              <option>--Select Column--</option>
              </select>
            
              </div>
                <input name="selectclms" id="selectclms" type="hidden" style="width:600px;"  class="inputbox" value="<?php echo (isset($editData['columns'])) ? $editData['columns'] : ''; ?>" />
             <div class="red" id="selectclmserr" style="margin-left:5px;"></div> 
             </td>
      </tr>
     <tr>
             <td align="left"  width="15%" class="blackbold">Group By : </td>
             <td align="left"  width="75%" >
              
              <select name="groupby" class="inputbox" id ="groupcolumns">
              <option>--Select Column--</option>
              </select>
             
              </td>
     </tr>
     <tr>
             <td align="left"  width="15%" class="blackbold">Sort By : </td>
             <td align="left"  width="75%" > 
              <select name="sortcol" class="inputbox" id ="sortcol">
              <option>--Select Column--</option>
              </select> &nbsp;&nbsp;
             <select name="order" class="inputbox" style="width:100px;">
                  <option value="ASC" <?php  if(isset($order) && $order == "ASC"){echo "selected";}?>> Ascending </option>
                  <option value="DESC" <?php  if(isset($order) && $order == "DESC"){echo "selected";}?>> Descending </option>
             </select> 
              </td>
     </tr>
     
<tr>
	 <td colspan="4" align="left" class="head"><b>Choose Filter</b></td>
</tr>
	   <tr id="filter_condi" class="filter_condi">
             <td align="left"  width="15%" class="blackbold"> All Conditions : </td>
             <td align="left" width="15%" >
             <select name="fcol[]" class="inputbox column-filter" style="width:200px;">
             <option value="">Select</option>
            
             </select> 
            <?php echo "&nbsp"; ?>  
              
                 <select name="fop[]" class="inputbox condi-filter" id="fop" style="width:200px;">
                <option value="">None</option>
                <option value="e" >equal to</option>
                <option value="n" >Not equal to</option>
                <option value="l" >Less than</option>
                <option value="g" >Greater than</option>
                <option value="in" >In (..)</option>
                                                           
             </select>
            <?php echo "&nbsp"; ?>  
            <input name="fval[]" id="fval" size="30" maxlength="80" value="" class="inputbox" type="text"> 
            <span id="foperr" class="red"></span>
              </td>
      </tr>
      <tr>
      <td></td>
      <td align="left"  width="75%" ><a id="addmore" class="add_row" href="javascript:;" >Add More Condition</a></td>
      </tr>
      <tr><td>&nbsp;</td></tr>
</table>	
  

	</td>
   </tr>



   <tr>
    <td  align="center">
	
	<div id="SubmitDiv">
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
        <input name="Submit" type="submit" class="button" id="SubmitButton" value="Generate Report"  />
        <input type="hidden" name="report_ID" id="report_ID" value="<?=$_GET['edit']?>" />


</div>

</td>

   </tr>
   
   
   
</table>
    <br/>
</form>
<?php 
if(isset($editData['moduleID']) && $editData['moduleID']){ //print_r($editData);die('rajanaaaaaa');
?>    
<script>
$(function(){
    editmoduleIDChange(<?php echo $editData['moduleID'];?>)
});

$(window).load(function(){
   
    $('#selectedclm').show();
    $('#showcolumns select').css('width','100%');
    $('#columns').hide();
    setTimeout(function(){ 
        
        editHideAddCol();
        <?php if($editData['groupby']){?>selectOptionforEditData(<?php echo $editData['groupby'];?>,'groupcolumns'); <?php } ?>
        <?php if($sortcol){?>selectOptionforEditData(<?php echo $sortcol?>,'sortcol'); <?php } ?>
        <?php if($fcol){?>selectOptforEditFltrData(<?php echo $fop;?>,<?php echo stripcslashes($fval);?>,<?php echo $fcol?>); <?php } ?>
    
    
    },500);
    
});



</script>
<?php    
}
?>
