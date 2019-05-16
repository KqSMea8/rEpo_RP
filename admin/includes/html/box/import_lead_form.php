<?
if(isset($NumHeader) && $NumHeader>0){
	//Ready for selection
	$DropDownHTML = '<select name="HeaderIndex" id="HeaderID" class="inputbox"><option value="">--- Select Excel Header ---</option>';
	for ($i=0;$i<$NumHeader;$i++){
		$DropDownHTML .= '<option value="'.$i.'">'.$arrayHeader[$i].'</option>';
	}
	$DropDownHTML .= '</select>';
	
}

?>



<SCRIPT LANGUAGE=JAVASCRIPT>

function ValidateForm(frm)
{
	if( ValidateMandExcelCSV(frm.excel_file,"Please upload excel file."))
          {
		
		ShowHideLoader('1','P');
		return true;	
	}else{
		return false;	
	}
	
}


function ValidateColumn(frm)
{
	var NumLine = parseInt($("#DbColumn").val());
	var NumMandatory = $("#NumMandatory").val();

	for(var i=1;i<=NumLine;i++){
		if(document.getElementById("Mand"+i).value == 1){
			if(!ValidateForSelect(document.getElementById("Field"+i), "All Mandatory Fields")){
				return false;
			}		

		}
	}

	var Duplicate = 0; DupIndex=0;
	for(var i=1;i<=NumLine;i++){
		for(var j=1;j<=NumLine;j++){
			if(i!=j && document.getElementById("Field"+i).value!=''){
				if(document.getElementById("Field"+i).value == document.getElementById("Field"+j).value){
					Duplicate=1; DupIndex=j;
					break;
				}
			}
		}

		if(Duplicate==1){
			break;	
		}

	}



	if(Duplicate==1){
		alert("Duplicate Header has been selected.");
		document.getElementById("Field"+DupIndex).focus();
		return false;
	}

	ShowHideLoader('1','P');
	return true;		
}


</SCRIPT>
<a class="back" href="<?=$RedirectURL?>">Back</a>


 

<div class="had"><?=$MainModuleName?> &raquo; <span>
Import <?=ucfirst($module)?>
</span>
</div>


<div align="center" id="ErrorMsg" class="redmsg"><br><?=$ErrorMsg?></div>


<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Loading..............</div>
<div id="preview_div" >	
<? if( ((isset($_POST['Submit']) && $_POST['Submit']=='Submit') || (isset($_POST['saveTemplateSubmit']) && $_POST['saveTemplateSubmit']=='Save Template & Submit')) || isset($_SESSION['process']) ){?>

<script LANGUAGE=JAVASCRIPT>
/*var hook = true;

window.onbeforeunload = function () {
	  if(hook) {
	  return "Data will be lost if you leave the page, are you sure?";
	  }
};
function unhook() {
    hook=false;
  }
*/
$(function() {
	getCurrentStatus();
});

function getCurrentStatus(){  
	  var  sendParam='';
  sendParam='BackgroundExec=Lead&pid='+<?=$_SESSION['pid']?>+'&totalCount='+<?=$_SESSION['EXCEL_TOTAL']?>+'&randomval='+Math.random();
	$.ajax({
    type: "POST",
    async:false,
    url: 'ajax.php',
    data: sendParam,
    success: function (responseText) { //console.log(responseText);
		var data = jQuery.parseJSON(responseText);
			if(data.per>=0){ 
					$("#cper").text(data.per+'%');
					$("#cper1").css("width",data.per+'%');
				}
     		var mess_lead = '';
     		if(parseInt(data.per)<=100 && data.status=='1'){ 
		setTimeout(function(){getCurrentStatus();}, 6000);
		}else if(parseInt(data.per)>0 && data.status=='0'){ 
     			var tCount = <?=$_SESSION['EXCEL_TOTAL']?>;
     			mess_lead = "Total lead to import from excel sheet : "+tCount;
    			mess_lead += "<br>Total lead imported into database : "+data.count;
    			mess_lead += "<br>Lead already exist in database : "+ (tCount-data.count);
         		$("#leadComplete").show();
         		$("#ErrorMsg").html(mess_lead);
         	}else if(parseInt(data.count)=='0' && parseInt(data.per)=='0' && data.status=='0'){ 
          		var tCount = <?=$_SESSION['EXCEL_TOTAL']?>;
    			mess_lead += "<br>Lead already exist in database : "+ (tCount-data.count);
				mess_lead += "<br>Please try another excel!";
         		$("#ErrorMsg").html(mess_lead);
				$("#leadImportProcess").remove();
         	}else { 
     			mess_lead = "Failed! Please try again.";
         		$("#ErrorMsg").text(mess_lead);
						$("#leadImportProcess").remove();
         	} 
    }
	});
}
</script>

<style>

		
	#loading {
		position: absolute;
		top: 5px;
		
		right: 5px;
		}

	#calendar {
		width: 100%;
		margin: 0 auto;
		}
		.fc-event-title{
		 color:#FFFFFF;
		}
		
		.fc-event-inner .fc-event-time{ color:#FFFFFF;}
                
                a.Send{background: #81bd82;border: medium none;border-radius: 2px 2px 2px 2px;color: #FFFFFF;cursor: pointer; font-size: 12px;line-height: normal;padding: 1px 9px 2px 9px;}
    a.Unsend{background: #d40503;border: medium none;border-radius: 2px 2px 2px 2px;color: #FFFFFF;cursor: pointer; font-size: 12px;line-height: normal;padding: 1px 3px 2px 3px;}

    
*, *::before, *::after {
    box-sizing: border-box;
}
*, *::before, *::after {
    box-sizing: border-box;
}
    .sub-section::after {
    clear: both;
}
.sub-section::before, .sub-section::after {
    content: " ";
    display: table;
}
.sub-section {
    margin-bottom: 30px;
}
    
    .unit {

        background-clip: padding-box !important;
        float: left;
        overflow: hidden;
        width: 100%;
    }

    .meter-data {
        vertical-align: bottom;
    }
    .full-width {
        max-width: 100% !important;
        width: 100%;
    }
    .alignr {
        text-align: right;
    }
    .nomargin {
        margin: 0 !important;
    }
    .meter {
        background: none repeat scroll 0 0 #e0e0e0;
        border-radius: 2px;
        height: 13px;
        margin: 7px 0 30px;
        overflow: hidden;
        position: relative;

    }

    .meter > span {
        -moz-border-bottom-colors: none;
        -moz-border-left-colors: none;
        -moz-border-right-colors: none;
        -moz-border-top-colors: none;
        border-color: -moz-use-text-color -moz-use-text-color #95d1c4;
        border-image: none;
        border-style: none none solid;
        border-width: medium medium 13px;
        display: block;
        height: 100%;
        overflow: hidden;
        position: relative;
        border-color: #95d1c4;
    }

    .lastUnit, .lastGroup {
        float: right;
        width: 48%;
    }

    .p.fwb.float-left.nomargin {
        float: left;
    }
    .stat-block:first-child {
        border-left: 1px solid #d9d9d9;
        border-radius: 6px 0 0 6px;
    }
    .stat-block {
        -moz-border-bottom-colors: none;
        -moz-border-left-colors: none;
        -moz-border-right-colors: none;
        -moz-border-top-colors: none;
        border-color: #d9d9d9 #d9d9d9 #d9d9d9 -moz-use-text-color;
        border-image: none;
        border-style: solid solid solid none;
        border-width: 1px 1px 1px 0;
        padding-bottom: 1.8125em;
        padding-top: 1.8125em;
    }
    .size1of4 {
        width: 25%;
    }
   .stat-block:last-child {
    border-radius: 0 6px 6px 0;
}
.unit {
    padding-left: 15px;
    padding-right: 15px;
}
.size1of1 {
    width: 100%;
}

.fwb {
    float: right;
}
.leaders li {
background: url("images/mass_bg_leaders.png") repeat-x scroll 0 17px transparent;
line-height: 1.6em;
    margin-bottom: 0.8em;
}
.leaders li > span {
    background-color: #fff;
    font-size: 16px;
}
.leaders li > span:first-child {
    padding-right: 12px;
}

.fwb > a {
    font-size: 16px;
    color:#000;
}
#cper1{height: auto;}

</style>

              <form name="form1" action id="leadImport" method="post" onSubmit="" enctype="multipart/form-data">
<table width="100%"  border="0" cellpadding="0" cellspacing="0" id="leadImportProcess">
         <tr>
                  <td align="left"  >
		</td>
		</tr>    
         
                <tr>
                  <td align="center"  >

	


</td>
                </tr>
                
				 <tr>
				 <td >
                <div class="unit size1of2 maintain-width"> 
                            <div class="meter-data full-width selfclear nomargin alignr"> 
                                <span class="p fwb float-left nomargin">Data processing</span> <span class="h3 fsn nomargin">
                                    <a title="View" id="cper" href="#">10%</a>
                                </span> 
                            </div> 
                            <div class="meter"> 
                                <span style="width: 10%;" id="cper1">
                                </span> 
                            </div> 
                            <!--<ul class="leaders">
                                <li> <span>List average</span> <span class="fwb">35.7%</span> </li> 
                                <li> <span>Industry average (<a href="/account/details">Software and Web App</a>)</span> <span class="fwb">15.4%</span> </li> 
                            </ul> -->
                        </div>
                </td>
				 <td align="1center">
	 <input name="AssignTo" type="hidden" value="<?=$_POST['AssignTo']?>" />
	 <input name="FolderID" type="hidden" value="<?=$_POST['FolderID']?>" />
	 <input name="Complete" type="submit" style="display:none" id="leadComplete" onClick="unhook()" class="button" value="Complete" />&nbsp;&nbsp;&nbsp;
	 <input name="Cancel" type="submit" id="leadCancel" onClick="unhook()" class="button" value="Cancel" />&nbsp;&nbsp;&nbsp;
				  </td></tr> 
				
          </table>
              </form>
<? }  if(isset($NumHeader) && $NumHeader>0){?>
<table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action method="post" onSubmit="return ValidateColumn(this);" enctype="multipart/form-data">
         <tr>
                  <td align="left"  >
<?=EXCEL_MAP_MSG?> 

		</td>
		</tr>    
         
                <tr>
                  <td align="center"  >

	 <table width="100%" border="0" cellpadding="10" cellspacing="1"  class="borderall">
         <tr>
		<td   class="head" width="20%"  align="right">Database Column  </td>
		<td   class="head" width="25%" align="center"  >
		Imported Excel Sheet Header
		</td>
		<td   class="head"   align="right">Database Column  </td>
		<td   class="head" width="25%" align="center"  >
		Imported Excel Sheet Header
		</td>
		</tr>    
		<tr>
      		<? 
		$Count=0;
		foreach($DbColumnArray as $Key => $Heading){ 
		$Line = $Count+1;
		#$mand = ($Count<$NumMandatory)?('<span class="red">*</span>'):('');
		if((substr_count($_SESSION['DuplicayColumn'],$Key)==1)){
			$mand = '<span class="red">*</span>';
			$mand_val = 1;
		}else{
			$mand = '';
			$mand_val = 0;
		}

		?>
                    
                    <td  class="blackbold" valign="top" height="40"  align="right"> <?=$Heading?> : <?=$mand?></td>
                    <td  align="center"   class="blacknormal" valign="top">


<?
$DropDownHTML = '<select name="'.$Key.'" id="Field'.$Line.'" class="inputbox"><option value="">--- Select Excel Header ---</option>';
for ($i=0;$i<$NumHeader;$i++)
{
	$sel=(isset($ArryLeadImport[0][$Key]) && $ArryLeadImport[0][$Key]!='' && $ArryLeadImport[0][$Key]==$i)?("selected"):("");
	$DropDownHTML .= '<option value="'.$i.'" '.$sel.'>'.$arrayHeader[$i].'</option>';
}
$DropDownHTML .= '</select>';

echo $DropDownHTML;
?>

<? /*$DropDown = str_replace("HeaderIndex",$Key,$DropDownHTML);
echo $DropDown = str_replace("HeaderID","Field".$Line,$DropDown);*/
?>

<input type="hidden" name="Mand<?=$Line?>" id="Mand<?=$Line?>" value="<?=$mand_val?>">

	                 </td>
			
		<? 
			if($Line%2==0) echo '</tr><tr>';

			
			$Count++;
		} ?>
		</tr>
             </table>


</td>
                </tr>
				 <tr><td align="center">
	 <input name="Submit" type="submit" class="button" value="Submit" />&nbsp;&nbsp;&nbsp;

	 <input name="saveTemplateSubmit" id="saveTemplateSubmit" type="Submit" class="button" value="Save Template & Submit"/>


<input name="FileDestination" id="FileDestination" type="hidden"  value="<?=$FileDestination?>" />

<input name="NumMandatory" id="NumMandatory" type="hidden"  value="<?=$NumMandatory?>" />				  

<input name="DbColumn" id="DbColumn" type="hidden"  value="<?=$DbColumn?>" />
 <input name="AssignTo" type="hidden" value="<?=$_POST['AssignTo']?>" />	
<input name="FolderID" type="hidden" value="<?=$_POST['FolderID']?>" />
				  </td></tr> 
				
              </form>
          </table>

<? }else{ ?>
<table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action method="post" onSubmit="return ValidateForm(this);" enctype="multipart/form-data">
              
                <tr>
                  <td align="center"  >

<table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">                 

               <tr>
                    <td  class="blackbold" valign="top" width="45%"  align="right"> Import Excel Sheet :<span class="red">*</span></td>
                    <td  align="left"   class="blacknormal" valign="top" height="60"><input name="excel_file" type="file" class="inputbox"  id="excel_file"  onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false" />
					<br>
					<?=IMPORT_EXCEL_CSV_FORMAT_MSG?>
	                 </td>
		</tr>	

 <tr>
                    <td  class="blackbold" valign="top" align="right"> Duplicacy Column :<span class="red">*</span></td>
                    <td  align="left"   class="blacknormal" valign="top">
<?php
echo '<select name="DuplicayColumn" id="DuplicayColumn" class="inputbox">';
if(!empty($DbUniqueArray)){
foreach($DbUniqueArray as $Key => $Heading){ 
	$sel = (isset($_SESSION['DuplicayColumn']) && $_SESSION['DuplicayColumn']==$Key)?('selected'):('');
	echo '<option value="'.$Key.'" '.$sel.'>'.$Heading.'</option>';
}}
echo '</select>';
?>
	                 </td>
		</tr>	


	<? // if($_SESSION['AdminType'] == "admin"){ ?>
	<tr>
              <td  align="right"   class="blackbold"> Assigned To  : </td>
              <td   align="left" >
                <select name="AssignTo" class="inputbox" id="AssignTo" >
                  <option value="">--- Select ---</option>
                  <? for($i=0;$i<sizeof($arryEmployee);$i++) {?>
                  <option value="<?=$arryEmployee[$i]['EmpID']?>" <?  if($arryEmployee[$i]['EmpID']==$AssignTo){echo "selected";}?>>
                  <?=stripslashes($arryEmployee[$i]['UserName']);?>
                 </option>
                 <? } ?>
                </select>
              
              </td>
            </tr>
	<? // } ?>
	
	<!-- added by sanjiv -->
 	<tr>
        <td  class="blackbold" valign="top" align="right"> Folder Name :</td>
        <td  align="left"   class="blacknormal" valign="top">
		<?
		echo '<select name="FolderID" id="FolderName" class="inputbox">';
		echo '<option value="">--- Select ---</option>';
		foreach($folderList as $FKey => $FValue){ 
			$sel = (($_POST) && $_POST['FolderID']==$FValue['FolderId'])?('selected'):('');
			echo '<option value="'.$FValue['FolderId'].'" '.$sel.'>'.$FValue['FolderName'].'</option>';
		}
		echo '</select>';
		?>
       </td>
	</tr>
	

 </table></td>
                </tr>
				 <tr><td align="center">
	 <input name="Submit" type="submit" class="button" value="Upload" />
			  



				  </td></tr> 
				
              </form>
          </table>
<? } ?>


</div>
		
<? echo '<script>SetInnerWidth();</script>'; ?>
	   

