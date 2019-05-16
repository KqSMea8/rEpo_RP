<?php 
//Updated By chetan 16Dec//
if($NumHeader>0){
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
	if( ValidateMandExcel(frm.excel_file,"Please upload sheet in excel format."))
          {
		
		ShowHideLoader('1','P');
		return true;	
	}else{
		return false;	
	}
	
}



function ValidateColumn(frm)
{
    var mand = 0;
    
    $('select').each(function(){
        
        if($(this).val() != '')
        {
            mand++;
        }
       
    });
    
    if(!ValidateForSelect(document.getElementById("Sku"), "Sku"))
    {
	return false;
    }	
	
     if(mand < 2)
    {
        alert('Two fields are mandatory');
        return false;
    }    
        
}
</SCRIPT>
<a class="back" href="<?=$RedirectURL?>">Back</a>
<a href="../down.php?file=inventory/upload/Excel/ItemTemplate.xls" class="download" style="float:right">Download Template</a> 
<div class="had"><?=$MainModuleName?> &raquo; <span>
Import Item
</span>
</div>


<div align="center" id="ErrorMsg" class="redmsg"><br><?=$ErrorMsg?></div>


<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Loading..............</div>
<div id="preview_div" >	
<? 
(empty($_POST['Submit']))?($_POST['Submit']=""):("");   
(empty($_POST['saveTemplateSubmit']))?($_POST['saveTemplateSubmit']=""):("");   


if($_POST['Submit']=='Submit' || $_POST['saveTemplateSubmit']=='Save Template & Submit' || isset($_SESSION['process'])){?>

<script LANGUAGE=JAVASCRIPT>
$(function() {
	getCurrentStatus();
});

function getCurrentStatus(){  
  var sendParam='';
  sendParam = 'BackgroundExec=Item&pid='+<?=$_SESSION['pid']?>+'&totalCount='+<?=$_SESSION['EXCEL_TOTAL']?>+'&randomval='+Math.random();
$.ajax({
    type: "POST",
    async:false,
    url: 'ajax.php',
    data: sendParam,
    success: function (responseText) { 
		var data = jQuery.parseJSON(responseText);
		if(data.per>=0){ 
			$("#cper").text(data.per+'%');
			$("#cper1").css("width",data.per+'%');
		}
     		
     		var mess_item = '';
     		if(parseInt(data.per)<=100 && data.status=='1'){ 
			setTimeout(function(){getCurrentStatus();}, 6000);
		}else if(parseInt(data.per)>0 && data.status=='0'){ 
     			var tCount = <?=$_SESSION['EXCEL_TOTAL']?>;
     			mess_item = "Total item to import from excel sheet : "+tCount;
    			mess_item += "<br>Total item imported into database : "+data.count;
    			mess_item += "<br>Item already exist in database : "+ (tCount-data.count);
         		$("#itemComplete").show();
         		$("#ErrorMsg").html(mess_item);
         	}else if(parseInt(data.count)=='0' && parseInt(data.per)=='0' && data.status=='0'){ 
          		var tCount = <?=$_SESSION['EXCEL_TOTAL']?>;
    			mess_item += "<br>Item already exist in database : "+ (tCount-data.count);
			mess_item += "<br>Please try another excel!";
         		$("#ErrorMsg").html(mess_lead);
			$("#itemImportProcess").remove();
         	}else { 
     			mess_lead = "Failed! Please try again.";
         		$("#ErrorMsg").text(mess_lead);
			$("#itemImportProcess").remove();
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

              <form name="form1" action id="itemImport" method="post" onSubmit="" enctype="multipart/form-data">
<table width="100%"  border="0" cellpadding="0" cellspacing="0" id="itemImportProcess">
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
	 <input name="Complete" type="submit" style="display:none" id="itemComplete" onClick="unhook()" class="button" value="Complete" />&nbsp;&nbsp;&nbsp;
	 <input name="Cancel" type="submit" id="itemCancel" onClick="unhook()" class="button" value="Cancel" />&nbsp;&nbsp;&nbsp;
				  </td></tr> 
				
          </table>
              </form>
<? }  



if($NumHeader>0){?>
<form name="form1" method="post" onSubmit="return ValidateColumn(this);" enctype="multipart/form-data">

<table width="100%"  border="0" cellpadding="0" cellspacing="0" >
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
      		<?php 
		$Count=0;
		foreach($DbColumnArray as $Key => $Heading){ 
		$Line = $Count+1;
		?>
                    
                    <td  class="blackbold" valign="top" height="40"  align="right"> <?=$Heading?> : <?=$mand?></td>
                    <td  align="center"   class="blacknormal" valign="top">

<?php
$DropDown = str_replace("HeaderIndex",$Key,$DropDownHTML);
echo $DropDown = str_replace("HeaderID",$Key,$DropDown);
?>
	                 </td>
			
		<?php 
			if($Line%2==0) echo '</tr><tr>';

			
			$Count++;
		} ?>
		</tr>
             </table>


</td>
                </tr>
				 <tr><td align="center">
<input name="Submit" type="submit" class="button" value="Submit" />
<input name="FileDestination" id="FileDestination" type="hidden"  value="<?=$FileDestination?>" />
<input name="FileName" id="FileName" type="hidden"  value="<?=$fileName?>" />
<input name="NumMandatory" id="NumMandatory" type="hidden"  value="<?=$NumMandatory?>" />
<input name="DbColumn" id="DbColumn" type="hidden"  value="<?=$DbColumn?>" />
				  </td></tr> 
				
              
          </table>
</form>
<?php }else{ ?>


<table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action method="post" onSubmit="return ValidateForm(this);" enctype="multipart/form-data">
              
                <tr>
                  <td align="center"  >

				  <table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
                  

                    <tr>
                    <td  class="blackbold" valign="top" width="45%"  align="right"> Import Item Sheet :<span class="red">*</span></td>
                    <td  align="left"   class="blacknormal" valign="top" height="80"><input name="excel_file" type="file" class="inputbox"  id="excel_file"  onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false" />
					<br>
					<?=IMPORT_SHEET_FORMAT_MSG?>
	                 </td>
					</tr>	
             </table></td>
                </tr>
				 <tr><td align="center">
	 <input name="Submit" type="submit" class="button" value="Upload" />
				  
				  </td></tr> 
				
              </form>
          </table>
<?php } ?>
</div>
		

	   


