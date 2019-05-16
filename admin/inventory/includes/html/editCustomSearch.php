<style>
.column-li{
float:left;padding:3px 3px 3px 3px;
}
.inputboxclass{
    width: 100% !important;
}
</style>
<script language="JavaScript1.2" type="text/javascript">
$(function(){
var err = '';
var fr;
$( "#selectedclm" ).sortable({
  update: function( event, ui ) {      resetSelectColumns();      }
});
//update 18Jan//
$('input[name^="checkboxes"]').click(function(){
   
    if($(this).is(':checked') === true )//&& ($(this).val() == '4' || $(this).val() == '5')
    {   
        if($(this).val() == '4')
        {
            $('#shselMDY').show();
        }else if($(this).val() == '5'){
            $('#phselMDY').show();
        }else if($(this).val() == '7'){
	    $('#shsoPop').show();
	}else if($(this).val() == '8'){
            $('#shpoPop').show();	
	}
    }else{
        var allVals = [];
        $('input[name^=checkboxes]:checked').each(function(){allVals.push($(this).val());})
        if($.inArray('4',allVals)== '-1'){ 
            $('#shselMDY').hide();
            $('#shselMDY select').each(function(){
                $(this).find('option:first').prop('selected',true);
            }) 
        }
        if($.inArray('5',allVals)== '-1'){ 
            $('#phselMDY').hide();
            $('#phselMDY select').each(function(){
            $(this).find('option:first').prop('selected',true);
            })
        }
	if($.inArray('7',allVals)== '-1'){ 
            $('#shsoPop').css({'display':'none','width':'95px'});
            $('#shsoPop').each(function(){
            $(this).find('option:first').prop('selected',true);
            })
        }
	if($.inArray('8',allVals)== '-1'){
            $('#shpoPop').css({'display':'none','width':'95px'});
            $('#shpoPop').each(function(){
            $(this).find('option:first').prop('selected',true);
            })
        } 
        
        
    }
    
    
})



$('#moduleID').change(function(){
	if($(this).val() != "")
	{ 
                fr = $(this).val();
		$url='action=customsearchmodulefields&moduleID='+$(this).val();
		$.ajax({
                        url: 'ajax.php',
                        type: 'GET',
                        data:$url,
                        success: function(data){
                                    $('#showcolumns').html(data);
                                    $('#showcolumns select').css('width','611px');
                                    $('#showcolumns').show();
                                    $('#selectclmserr').html('');
                                    $('#selectedclm li').remove();
                                    if(fr == '601')
                                    {
                                        $('#displayshowcolumns').html(data);
					$('#displayshowcolumns select').children(':last').remove();//added by chetan 30Mar2017//
                                        $('#displayshowcolumns select').css('width','611px');
                                        $('#displayshowcolumns').show();
                                        $('#displayselectclmserr').html('');
                                        $('#displayselectedclm li').remove();
                                    }    
                                }
                })
                
                $('#columns').val('');
                if(fr == '602' || fr == '603')
                {       
                        $url='action=customsrchmodfldsToDisplay&moduleID='+$(this).val();
                        $.ajax({

                                url: 'ajax.php',
                                type: 'GET',
                                data:$url,
                                success: function(data) {
                                            $('#displayshowcolumns').html(data);
                                            $('#displayshowcolumns select').css('width','611px');
                                            $('#displayshowcolumns').show();
                                            $('#displayselectclmserr').html('');
                                            $('#displayselectedclm li').remove();
                                        }
                        })                                  
                }
                $('#displayCol').val('');
	}else{

		$('#showcolumns').hide();
                $('#displayshowcolumns').hide();
                $('#selectedclm li').remove();
                $('#displayselectedclm li').remove();
		$('#showcolumns select').children(':not(:first)').remove();
                $('#displayshowcolumns select').children(':not(:first)').remove();
	}
});

$('#selectclms').focus(function(){
            //$('#showcolumns').show();
            if($('#moduleID').val() == '')
            {
                $('#selectclmserr').html('Select Module to select Columns');
            }
    
});
$('#displayselectclms').focus(function(){
            if($('#moduleID').val() == '')
            {
                $('#displayselectclmserr').html('Select Module to select Columns');
            }
    
});

$('#showcolumns').on('change','select',function(){
	
        if($("#selectedclm li").length < 7)
        {
            if(typeof(jQuery(this).val()) != 'undefined' &&  jQuery(this).val()!='' ){
                    $('#selectedclm').show();
                    $('#showcolumns select').css('width','100%');
                    $('#selectclms').hide();
                    var txt = $(this).find(":selected").text();
                    var opval = $(this).find(":selected").val();
                    $('#selectedclm').append('<li id="'+opval+'" class="column-li"><img onclick="RemoveAddCol(\''+opval+'\')" src="../images/delete.png"><span>'+txt+'</span></li>');
                    $(this).find(":selected").hide();
                    $('#showcolumns select').val('');
                    if($('#columns').val())
                    {
                            $('#columns').val($('#columns').val()+','+opval);
                    }else{
                            $('#columns').val(opval);
                    }

            }
        }else{
        
            $("#columnserr").html("you can not select more than 7 Columns.");
            return false;
        }
});

$('#displayshowcolumns').on('change','select',function(){
	
//    if($("#displayselectedclm li").length < 7)
//    {
        $('#displayselectedclm').show();
        $('#displayshowcolumns select').css('width','100%');
        $('#displayselectclms').hide();
        var txt = $(this).find(":selected").text();
        var opval = $(this).find(":selected").val();
        $('#displayselectedclm').append('<li id="dis'+opval+'" class="column-li"><img onclick="RemoveDisAddCol(\''+opval+'\')" src="../images/delete.png"><span>'+txt+'</span></li>');
        $(this).find(":selected").hide();
        $('#displayshowcolumns select').val('');
        if($('#displayCol').val())
        {
                $('#displayCol').val($('#displayCol').val()+','+opval);
        }else{
                $('#displayCol').val(opval);
        }

//    }else{
//
//        $("#displaycolumnserr").html("you can not select more than 7 Columns.");
//        return false;
//    }
});

//updated by chetan on 21July for sales /purchase history dates validation and display columns validation//
$("#c_searchform").submit(function(){
    var err;
    $('div.red').html('');
    var CheckedArr = Array();
	CheckedArr = $("input:checkbox:checked").map(function(){
								return $(this).val();
								}).get();
    $("#c_searchform  :input[data-mand^=\'y\']").each(function(){
        
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
            $("#columnserr").html("Header fields is mandatory field.");
            err = 1;
        }else if($("#selectedclm li").length < 2)
        {
            $("#columnserr").html("Select atleast 2 headers.");
            err = 1;
        }else if($("#selectedclm li").length > 7)
        {
            $("#columnserr").html("you can not select more than 7 headers.");
            err = 1;
        }  
	
	if($("#displayselectedclm li").length == '0' )
        {
            $("#displayColerr").html("Display fields is mandatory.");
            err = 1;
        }
    });
	if(CheckedArr.length > 0)
	{
		if($.inArray(4,CheckedArr)!= -1){
				if($('#shselMDY select option[value=""]:selected').length==3){
							$("#shselerr").html("Required Fields.");
		    					err = 1;
				}
		}
	 	if($.inArray(5,CheckedArr)!= -1){
				if($('#phselMDY select option[value=""]:selected').length==3){
							$("#phselerr").html("Required Fields.");
		    					err = 1;
				}
		}
	}


    if(err == 1){ return false; }else{ 

	    var Url = "isRecordExists.php?search_name="+escape(document.getElementById("search_name").value)+"&editID="+document.getElementById("search_ID").value+"&Type=CustomSearch";
    	SendExistRequest(Url,"search_name", "Search Name");
    	
	    return false;
	}

   });
//End//

//added by chetan on 12Jan 2017 // updated on 20Jan2017//

$('input[name="role"]').on('click',function(){

	if($("#move_div").is(':visible') == false)
	{
		$("#move_div").show();
	}

})

//added by chetan on 20Jan 2017//

$('#fromall').click(function() { 
 $('#columnFrom option').remove().appendTo('#userids');  
});  
$('#add').click(function() { 
 $('#columnFrom option:selected').remove().appendTo('#userids');  
});  
$('#remove').click(function() {  
 $('#userids option:selected').remove().appendTo('#columnFrom');  
});  
$('#removeall').click(function() { 
 $('#userids option').remove().appendTo('#columnFrom');  
});


//by chetan 1Feb for currency option slection limit//
$("input[name='currency[]']").click(function() {
    if ($("input[name='currency[]']:checked").length > 3) {
        $(this).removeAttr("checked");
        alert('You can select upto 3 options only');
    }
});
//End//


})

$(window).load(function(){
	$('#columnFrom option:selected').remove().appendTo('#userids');
})
//End//




function RemoveAddCol(val)
{
	$('#'+val+'').remove();
	$('#showcolumns select').find('option[value="'+val+'"]').show();

	resetSelectColumns('selectedclm','columns');
        if($("#selectedclm li").length < 7)
        {
            $("#columnserr").html('');
        }    
}

function RemoveDisAddCol(Dval)
{
	$('#dis'+Dval+'').remove();
	$('#displayshowcolumns select').find('option[value="'+Dval+'"]').show();

	resetSelectColumns('displayselectedclm','displayCol');
}

function resetSelectColumns($sel,$input)
{
    var selVal = [];
    $('#'+$sel+' li').each(function(){   
            selVal.push($(this).attr('id').replace('dis',''));

            });

    selValStr = selVal.join(',');
    $('#'+$input).val(selValStr);
}

function editmoduleIDChange(ID)
{
    if(ID != "")
    { 
        $url='action=customsearchmodulefields&moduleID='+ID;
        $.ajax({

            url: 'ajax.php',
            type: 'GET',
            data:$url,
            success:function(data) {
                        $('#showcolumns').html(data);
                        $('#showcolumns select').css('width','611px');
                        $('#showcolumns').show();
                        $('#selectclmserr').html('');
                        if(ID == '601')
                        {
                            $('#displayshowcolumns').html(data);
			     $('#displayshowcolumns select').children(':last').remove();//added by chetan 30Mar2017//		
                            $('#displayshowcolumns select').css('width','611px');
                            $('#displayshowcolumns').show();
                            $('#displayselectclmserr').html('');
                        }
                    }
        })
        if(ID == '602' || ID == '603')
        { 
            $url='action=customsrchmodfldsToDisplay&moduleID='+ID;
            $.ajax({

                url: 'ajax.php',
                type: 'GET',
                data:$url,
                success:function(data) {
                            $('#displayshowcolumns').html(data);
                            $('#displayshowcolumns select').css('width','611px');
                            $('#displayshowcolumns').show();
                            $('#displayselectclmserr').html('');
                        }
            })
        }
        
    }    
       
}

function editHideAddCol($input,$sel)
{
    $colsID = $('#'+$input+'').val().split(',');console.log($colsID);
    $('#'+$sel+' select option').each(function(){
        
        if($.inArray($(this).val(),$colsID)!=-1)
        {
            $(this).hide();
        }
        
    });
}

$('input:checkbox').click(function(){

      fldname = $(this).attr('name');
      if($('input:checkbox:checked').length < 0)
      { 
            $('<input>').attr({
                    type: 'hidden',
                    id: fldname,
                    name: fldname,
                    value:''
            }).appendTo('#c_searchform');
      }else{
            $('input[name="'+fldname+'"][type="hidden"]').remove();
      }

    });
          

</script>

<div class="back"><a class="back"  href="<?=$RedirectURL?>">Back</a></div>
<div class="had">
Manage Search   &raquo; <span>

	<?php 	echo (!empty($_GET['edit']))?("Edit  <b>".$editData['search_name']."</b> ") :("Add Search"); ?>

</span>
</div>

<form name="c_searchform" id="c_searchform"  action="createcustomsearch.php" method="post">
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<?php if (!empty($_SESSION['mesg_search'])) { ?>
                <tr>
                    <td  align="center"  class="message"  >
                        <?php if (!empty($_SESSION['mesg_search'])) {
                            echo $_SESSION['mesg_search'];
                            unset($_SESSION['mesg_search']);
                        } ?>	
                    </td>
                </tr>
<?php } ?>
   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
    <td colspan="4" align="left" class="head"><b>Search Details</b></td>
</tr>


    <tr>
             <td  align="left" width="15%" class="blackbold"> Search Name  :<span class="red">*</span> </td>
             <td   align="left" width="75%"><input data-mand="y" name="search_name" type="text" class="inputbox" id="search_name" value="<?php echo stripslashes($editData['search_name']); ?>"  maxlength="40" />
             <div class="red" id="search_nameerr" style="margin-left:5px;"></div>
             </td>


     </tr>
      
    <tr>
             <td align="left" width="15%" class="blackbold">Select Module :<span class="red">*</span> </td>
             <td align="left" width="75%" >
             <select data-mand="y" class="inputbox" id="moduleID" name="moduleID" style="width:200px;">
             <option value="">--Select Module--</option>
                <?php 
                $count = count($arrayHeaderMenus);
                for($i=0;$i<3;$i++) {?>
                        <option value="<?=$arrayHeaderMenus[$i]['ModuleID']?>" <?php  if($arrayHeaderMenus[$i]['ModuleID'] == $editData['moduleID']){echo "selected";}?>>
                        <?=stripslashes($arrayHeaderMenus[$i]['Module']);?> 
                        </option>
                <?php } ?>
            </select> 
            <div class="red" id="moduleIDerr" style="margin-left:5px;"></div>
            </td>
      </tr>
   
      
      <!--Add by CHETAN ON 1Feb-->
      <tr>
         <td align="left" width="15%" class="blackbold" valign="top">Currencies : </td>
         <td align="left" width="75%" >
         <?  if(strstr($editData['currency'],',') && $editData['currency'] != '')
	        {
	            $currencyArr = explode(',',$editData['currency']);
	            
	        }else{
	            $currencyArr[] = $editData['currency'];
	        }
        ?>
	<div id="PermissionValue" style="width:600px; height:300px; overflow:auto">
	<? 
	
	for($i=0;$i<sizeof($arryCurrency);$i++) {?>
	<div style="float:left;width:180px;"><label><input type="checkbox" name="currency[]" id="currency" value="<?=$arryCurrency[$i]['code']?>" <?=in_array($arryCurrency[$i]['code'],$currencyArr)?("checked"):("")?>  /> <?=$arryCurrency[$i]['name']?> </label></div>
	<? } ?>
 </div>

        <div class="red" id="moduleIDerr" style="margin-left:5px;"></div>
        </td>
        </tr>	   	
<!--End--> 


	
      <tr>
             <td align="left" width="15%" class="blackbold">Roles/Permission : </td>
             <td align="left" width="75%" >
		
             <input type="radio" name="role" id="role" value="public" <? if($editData['role'] == 'public'){ echo "checked";}?>>Public
             <input type="radio" name="role" id="role" value="private" <? if($editData['role'] == 'private'){ echo "checked";}?>>Private
            <div class="red" id="moduleIDerr" style="margin-left:5px;"></div>
            </td>
      </tr>	 

	<tr>
		<td align="left" width="15%" class="blackbold"></td>
		<td align="left" width="" >
		<? if($_SESSION['AdminType'] == 'admin'){?>
	    <!-- <select <? if($editData['role']=='' || $_GET['edit']==''){?>style="display:none" <? }?> class="inputbox" id="userids" name="userids[]" size="12" multiple  style="width:200px;">
             <option value="">--Select Users--</option>
                <?php 
                $count = count($employeeList);
		$userIdArr = array();
                if(strstr($editData['userids'],',') && $editData['userids'] != '')
                {
                    $userIdArr = explode(',',$editData['userids']);
                    
                }else{
                    $userIdArr[] = $editData['userids'];
                }
                for($i=0;$i<$count;$i++) {
		if($employeeList[$i]['EmpID']!=$_SESSION['AdminID']){			
		?>
                        <option value="<?=$employeeList[$i]['EmpID']?>" <?php if(in_array($employeeList[$i]['EmpID'],$userIdArr)){ echo "selected";}?>>
                        <?=stripslashes($employeeList[$i]['UserName']);?> 
                        </option>
                <?php } }?>
            </select>-->
		
		<div id="move_div" <? if($editData['role']=='' || $_GET['edit']==''){?>style="float:left;display:none;" <? }else{?> style="float:left;" <? }?>>
		<table width="50%" border="0" cellpadding="5" cellspacing="0" class="borderall"> 
		<tr>
		       <td align="center" class="head" width="40%">Available Users </td>
		       <td class="head"></td>
		       <td align="center" class="head" width="40%">Allowed Users </td>
		</tr>
		<tr>
		       <td align="center" >
   
		<select name="columnFrom[]" id="columnFrom"  class="inputbox" style="width:250px;height:300px;" multiple>';
		 <?php
			$count = count($employeeList);
			$userIdArr = array();
		        if(strstr($editData['userids'],',') && $editData['userids'] != '')
		        {
		            $userIdArr = explode(',',$editData['userids']);
		            
		        }else{
		            $userIdArr[] = $editData['userids'];
		        }
			for ($i = 0; $i < $count; $i++) {		 
				    
			    if($employeeList[$i]['EmpID']!=$_SESSION['AdminID']){
			?>
			     	<option value="<?=$employeeList[$i]['EmpID']?>" <?php if(in_array($employeeList[$i]['EmpID'],$userIdArr)){ echo "selected";}?>>
                        	<?=stripslashes($employeeList[$i]['UserName']);?> 
                        	</option>
		 <? } }?>
		
		</select>   
		    
		    
		       </td>
		       <td align="center" valign="top">
			   <br><br> <br> <br> 
			    <input type="button" value=" &raquo; &raquo; " name="fromall" id="fromall" class="grey_bt" style="padding:5px;width:40px;" onMouseover="ddrivetip('<center>Move All</center>', 100,'')"; onMouseout="hideddrivetip()"> <br><br> 
			   <input type="button" value=" &raquo;  " name="frombt" id="add" class="grey_bt" style="padding:5px;width:40px;"  onMouseover="ddrivetip('<center>Move Selected</center>', 100,'')"; onMouseout="hideddrivetip()">  <br> <br>
			   <input type="button" value=" &laquo;  " name="tobt" id="remove" class="grey_bt" style="padding:5px;width:40px;" onMouseover="ddrivetip('<center>Remove Selected</center>', 100,'')"; onMouseout="hideddrivetip()"> <br><br> 		   
			   <input type="button" value=" &laquo; &laquo; " name="tobt" id="removeall" class="grey_bt" style="padding:5px;width:40px;" onMouseover="ddrivetip('<center>Remove All</center>', 100,'')"; onMouseout="hideddrivetip()"> 
		       </td>
		       <td align="center">		      
			<select name="userids[]" id="userids"  class="inputbox" style="width:250px;height:300px;" multiple></select>	   
		       </td>
		</tr>

		</table>	
		</div>






	    <? }?>		
		
		
		</td>
	</tr>


<tr>
	 <td colspan="4" align="left" class="head"><b>Choose Column</b></td>
</tr>
     <tr>
             <td align="left"  width="15%" class="blackbold">Search Fields :<span class="red">*</span> </td>
             <td align="left" width="200%" >
                 <div style="height:auto; width: 100%">
                 <ul id="selectedclm" style="border: 1px solid rgb(218, 225, 232); display: none; overflow: hidden;
height: auto !important; min-height: 26px; width: 100%; margin-bottom: 3px;display: none;">
                     
                <?php     
                if($editData['columns'])
                {
                    $colSel = explode(',',$editData['columns']);   
                    foreach($colSel as $val)
                    {
                        $col =  $csearch->GetFieldLabel($val,$editData['moduleID'],'1');
                ?>
                        <li id="<?php echo $col['fieldname']?>" class="column-li">
                            <img onclick="RemoveAddCol('<?php echo $col['fieldname']?>')" src="../images/delete.png"><span> <?php echo $col['fieldlabel']?></span>
                        </li>
                <?php
                    }
                }
                ?>
                     
                     
                 </ul>
                 
                 <input name="selectclms" id="selectclms" type="text" readonly="readonly" style="width:600px;" placeholder="" class="inputbox" id="SelectColumns" value="" />
                 <span id="selectclmserr" class="red"></span>
                 </div>
                 <div id ="showcolumns" class="inputboxclass" style="display:none;">
              <select class="inputbox" style="width:611px">
              <option>--Select Column--</option>
              </select>
            
              </div>
                <input name="columns" id="columns" type="hidden" style="width:600px;"  class="inputbox" value="<?php echo $editData['columns']; ?>" />
             <div class="red" id="columnserr" style="margin-left:5px;"></div> 
             </td>
      </tr>
	<tr>
             <td align="left"  width="15%" class="blackbold">Display :<span class="red">*</span> </td>
             <td align="left" width="200%" >
                 <div style="height:auto; width: 100%">
                 <ul id="displayselectedclm" style="border: 1px solid rgb(218, 225, 232); display: none; overflow: hidden;
height: auto !important; min-height: 26px; width: 100%; margin-bottom: 3px;display: none;">
                     
                <?php     
                if($editData['displayCol'])
                {
                    $colSel = explode(',',$editData['displayCol']);   
                    foreach($colSel as $val)
                    {
                        $fr = ($editData['moduleID'] != '601') ? '3' : '1';
                        $col =  $csearch->GetFieldLabel($val,$editData['moduleID'],$fr);
                ?>
                        <li id="dis<?php echo $col['fieldname']?>" class="column-li">
                            <img onclick="RemoveDisAddCol('<?php echo $col['fieldname']?>')" src="../images/delete.png"><span> <?php echo $col['fieldlabel']?></span>
                        </li>
                <?php
                    }
                }
                ?>
                     
                     
                 </ul>
                 
                 <input name="displayselectclms" id="displayselectclms" type="text" readonly="readonly" style="width:600px;" placeholder="" class="inputbox" id="SelectColumns" value="" />
                 <span id="displayselectclmserr" class="red"></span>
                 </div>
                 <div id ="displayshowcolumns" class="inputboxclass" style="display:none;">
              <select class="inputbox" style="width:611px">
              <option>--Select Column--</option>
              </select>
            
              </div>
                <input name="displayCol" id="displayCol" type="hidden" style="width:600px;"  class="inputbox" value="<?php echo $editData['displayCol']; ?>" />
             <div class="red" id="displayColerr" style="margin-left:5px;"></div> 
             </td>
      </tr>
    <tr>
	 <td colspan="4" align="left" class="head"><b>View</b></td>
    </tr>
        <tr>
                <td align="left" width="15%" class="blackbold">To Show : </td>
                <td align="left" width="75%" >
                    <?php
                        $checked = array();
                        if(strstr($editData['checkboxes'],',') && $editData['checkboxes'] != '')
                        {
                            $checked = explode(',',$editData['checkboxes']);
                            
                        }else{
                            $checked[] = $editData['checkboxes'];
                        }   
                    ?>    
                    <input <?php if(in_array('1',$checked)){ echo "checked";}?> type="checkbox" name="checkboxes[]" id="checkboxes" value="1"> BOM
                    <input <?php if(in_array('2',$checked)){ echo "checked";}?> type="checkbox" name="checkboxes[]" id="checkboxes" value="2"> Alias
                    <input <?php if(in_array('3',$checked)){ echo "checked";}?> type="checkbox" name="checkboxes[]" id="checkboxes" value="3"> Serial Number
                    <input <?php if(in_array('4',$checked)){ echo "checked";}?> type="checkbox" name="checkboxes[]" id="checkboxes" value="4"> Sales History
                    <input <?php if(in_array('5',$checked)){ echo "checked";}?> type="checkbox" name="checkboxes[]" id="checkboxes" value="5"> Purchase History
		    <input <?php if(in_array('6',$checked)){ echo "checked";}?> type="checkbox" name="checkboxes[]" id="checkboxes" value="6"> Condition qty                
		     <input <?php if(in_array('7',$checked)){ echo "checked";}?> type="checkbox" name="checkboxes[]" id="checkboxes" value="7"> On So 
                     <?php 
                    $showsopo = explode(',',$editData['showsopopop']);
			$showsopo0= (isset($showsopo[0])) ? ($showsopo[0]) :(''); 
			$showsopo1= (isset($showsopo[1])) ? ($showsopo[1]) :(''); 
		 ?>	
		    <select <?php if(!in_array('7',$checked)){?> style="display:none;width=95px;" <?php }else{?> style="width:95px;" <? }?>  class="inputbox" id="shsoPop" name="shsoPop" >
                    <option value="">Show PopUp</option>                   
                    <option value="Yes" <?php if($showsopo0 == 'Yes' ){echo "selected";}?>>Yes</option>
		    <option value="No" <?php if($showsopo0 == 'No' ){echo "selected";}?>>No</option>	
                    </select> 	
                    <input <?php if(in_array('8',$checked)){ echo "checked";}?> type="checkbox" name="checkboxes[]" id="checkboxes" value="8"> On Po
		    <select <? if(!in_array('8',$checked)){?> style="display:none;width=95px;" <?php }else{?> style="width:95px;" <? }?> class="inputbox" id="shpoPop" name="shpoPop" style="width:95px;">
                    <option value="">Show PopUp</option>                   
                    <option value="Yes" <?php if($showsopo1 == 'Yes' ){echo "selected";}?>>Yes</option>
		    <option value="No" <?php if($showsopo1 == 'No' ){echo "selected";}?>>No</option>	
                    </select> 

</td>
        </tr>
        
        <tr id="shselMDY" <?php if(!in_array('4',$checked)){?> style="display:none" <?php }?>>
            <td align="left" width="15%" class="blackbold">Select(M/D/Y) for Sales History : </td>
                <td align="left" width="75%" >
                    <select class="inputbox" id="shselMon" name="saleMon" style="width:80px;">
                    <option value="">--Month--</option>
                    <?php 
                    $select = explode(',',$editData['saleduration']);
		    $select0= (isset($select[0])) ? ($select[0]) :('');
		    $select1= (isset($select[1])) ? ($select[1]) :('');
                    $select2= (isset($select[2])) ? ($select[2]) :('');
                    $select3= (isset($select[3])) ? ($select[3]) :(''); 

                    for($i=1;$i<=12;$i++) {?>
                            <option value="<?=$i?>" <?php if($select0 == $i){echo "selected";}?>>
                            <?=$i;?> 
                            </option>
                    <?php } ?>
                    </select>
                    <select class="inputbox" id="shselDay" name="saleDay" style="width:80px;">
                    <option value="">--Days--</option>
                    <?php 
                    for($j=1;$j<=31;$j++) {?>
                            <option value="<?=$j?>" <?php if($select1 == $j){echo "selected";}?>>
                            <?=$j;?> 
                            </option>
                    <?php } ?>
                    </select>
                    <select class="inputbox" id="shselYr" name="saleYr" style="width:80px;">
                    <option value="">--Year--</option>
                    <?php 
                    for($k=1;$k<=10;$k++) {?>
                            <option value="<?=$k?>" <?php if($select2 == $k ){echo "selected";}?>>
                            <?=$k;?> 
                            </option>
                    <?php } ?>
                    </select>
		    <select class="inputbox" id="shselPop" name="shselPop" style="width:100px;">
                    <option value="">Show PopUp</option>                   
                    <option value="Yes" <?php if($select3 == 'Yes' ){echo "selected";}?>>Yes</option>
		    <option value="No" <?php if($select3 == 'No' ){echo "selected";}?>>No</option>	
                    </select>  
		<div class="red" id="shselerr" style="margin-left:5px;"></div> 
                   
                </td>
        </tr>
        <tr id="phselMDY" <?php if(!in_array('5',$checked)){?> style="display:none" <?php }?>>
            <td align="left" width="15%" class="blackbold">Select(M/D/Y) for Purchase History : </td>
                <td align="left" width="75%" >
                    <select class="inputbox" id="phselMon" name="purMon" style="width:80px;">
                    <option value="">--Month--</option>
                    <?php 
                    $select = explode(',',$editData['purduration']);
		    $select0= (isset($select[0])) ? ($select[0]) :('');
		    $select1= (isset($select[1])) ? ($select[1]) :('');
                    $select2= (isset($select[2])) ? ($select[2]) :('');
                    $select3= (isset($select[3])) ? ($select[3]) :(''); 
                    for($i=1;$i<=12;$i++) {?>
                            <option value="<?=$i?>" <?php if($select0 == $i){echo "selected";}?>>
                            <?=$i;?> 
                            </option>
                    <?php } ?>
                    </select>
                    <select class="inputbox" id="phselDay" name="purDay" style="width:80px;">
                    <option value="">--Days--</option>
                    <?php 
                    for($j=1;$j<=31;$j++) {?>
                            <option value="<?=$j?>" <?php if($select1 == $j){echo "selected";}?>>
                            <?=$j;?> 
                            </option>
                    <?php } ?>
                    </select>
                    <select class="inputbox" id="phselYr" name="purYr" style="width:80px;">
                    <option value="">--Year--</option>
                    <?php 
                    for($k=1;$k<=10;$k++) {?>
                            <option value="<?=$k?>" <?php if($select2 == $k){echo "selected";}?>>
                            <?=$k;?> 
                            </option>
                    <?php } ?>
                    </select>
		    <select class="inputbox" id="phselPop" name="phselPop" style="width:100px;">
                    <option value="">Show PopUp</option>                   
                    <option value="Yes" <?php if($select3 == 'Yes' ){echo "selected";}?>>Yes</option>
		    <option value="No" <?php if($select3 == 'No' ){echo "selected";}?>>No</option>	
                    </select>	 
                   <div class="red" id="phselerr" style="margin-left:5px;"></div> 
                </td>
        </tr>
      <tr><td>&nbsp;</td></tr>
</table>	
  
	</td>
   </tr>

   <tr>
    <td  align="center">
	
	<div id="SubmitDiv">
        <input name="Submit" type="submit" class="button" id="SubmitButton" value="Generate Search"  />
        <input type="hidden" name="search_ID" id="search" value="<?=$_GET['edit']?>" />
        </div>
</td>

   </tr>
   
</table>
    <br/>
</form>

<?php 
if($editData['moduleID']){
?>    
<script>
    
$(function(){
    editmoduleIDChange(<?php echo $editData['moduleID'];?>)
    
});    
    
    
$(window).load(function(){
   
    $('#selectedclm').show();
    $('#displayselectedclm').show();
    $('#showcolumns select').css('width','100%');
    $('#displayshowcolumns select').css('width','100%');
    $('#selectclms').hide();
    $('#displayselectclms').hide();
    setTimeout(function(){ 
        
	editHideAddCol('displayCol','displayshowcolumns');
    },300);
	setTimeout(function(){ 
		editHideAddCol('columns','showcolumns');
	},500);
    
});



</script>
<?php    
}
?>
