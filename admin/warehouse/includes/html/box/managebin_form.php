

	<script language="JavaScript1.2" type="text/javascript">




function validateWarehouse(frm){

if(ValidateForSelect(frm.warehouse_name, "Warehouse Name") && ValidateForSimpleBlank(frm.binlocation,"Bin Location"))         
{


var Url = "isRecordExists.php?warehouse_id=" + escape(document.getElementById("warehouse_name").value) +"&binlocation_name="+escape(document.getElementById("binlocation").value)+"&binid=" +escape(document.getElementById("binid").value)+"&Type=Warehouse";

//alert(Url)
               SendExistRequest(Url, 'warehouse_name', "Bin");
			
//var Url = "isRecordExists.php?warehouse_id="+escape(document.getElementById("warehouse_name").value)+"&binlocation_name="+escape(document.getElementById("binlocation").value)+"&binid="+escape(document.getElementById("binid").value)+"&Type=Warehouse";
	//alert(Url);		 

	//SendEventExistRequest(Url);			  	
	return false;				
}
	    else{
		      return false;	
		}	

	
}


function ltype(){

 
 var opt = document.getElementById('type').value;

if(opt=="Company"){
    document.getElementById('com').style.display = 'block';
	}else{
	document.getElementById('com').style.display = 'none';
	document.getElementById('company').value = '';
  
 }
    
    
}



</script>

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" action=""  method="post" onSubmit="return validateWarehouse(this);" enctype="multipart/form-data">


   <tr>
    <td  align="center" valign="top" >
	

		<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
			<tr>
				 <td colspan="2" align="left" class="head">Manage Bin Details</td>
			</tr>


			<tr>
				<td width="43%"  align="right"   class="blackbold"> Warehouse Name  :<span class="red">*</span> </td>
				<td   align="left" >
				
				
<select name="warehouse_name" class="inputbox" id="warehouse_name">

				<option value="">Select Warehouse</option>
				<?php foreach($warehouse_listted as $warehouse_data): ?>
			
				<option value="<?php echo $warehouse_data['WID']; ?>" <? if($warehouse_data['WID'] == $arryBin[0]['warehouse_id']){ echo "selected"; } ?>><?php echo $warehouse_data['warehouse_name']; ?></option>
						<?php         endforeach; ?>
				
				</select>
				</td>
			</tr>

			<tr>
				<td  align="right"   class="blackbold"> Bin Location  :<span class="red">*</span> </td>
				<td   align="left" >
				<input name="binlocation" type="text" class="inputbox" id="binlocation" value="<?php echo stripslashes($arryBin[0]['binlocation_name']); ?>"  maxlength="50" />            </td>
		       </tr>     
		       <tr>
				<td  align="right"   class="blackbold" 
				>Status  : </td>
				<td   align="left"  >
				<? 
				$ActiveChecked = ' checked';
				if($_GET['edit'] > 0){
				if($arryBin[0]['status'] == 1) {$ActiveChecked = ' checked'; $InActiveChecked ='';}
				if($arryBin[0]['status'] == 0) {$ActiveChecked = ''; $InActiveChecked = ' checked';}
				}
				?>
				<input type="radio" name="Status" id="Status" value="1" <?=$ActiveChecked?> />
				Active&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" name="Status" id="Status" value="0" <?=$InActiveChecked?> />
				InActive </td>
		      </tr>
			  


			<tr>
			 	<td colspan="2" align="left"   class="head">Description</td>
			</tr>

			 <tr>
		  		<td align="right"   class="blackbold" valign="top">Description :</td>
		  		<td  align="left" >
		    			<Textarea name="description" id="description" class="inputbox"  ><?=stripslashes($arryBin[0]['description'])?></Textarea>

					<script type="text/javascript">

					var editorName = 'description';

					var editor = new ew_DHTMLEditor(editorName);

					editor.create = function() {
						var sBasePath = '../FCKeditor/';
						var oFCKeditor = new FCKeditor(editorName, '410', 200, 'Basic');
						oFCKeditor.BasePath = sBasePath;
						oFCKeditor.ReplaceTextarea();
						this.active = true;
					}
					ew_DHTMLEditors[ew_DHTMLEditors.length] = editor;

					ew_CreateEditor(); 


					</script>			          
				</td>
			</tr>
		</table>  
	</td>
   </tr>

   <tr>
	<td align="left" valign="top">&nbsp;</td>
   </tr>
   <tr>
    	<td  align="center">
	
		<div id="SubmitDiv" style="display:none1">
	
			<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
			<input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />	
			<input type="hidden" name="binid" id="binid" value="<?=$_GET['edit']?>" />

		</div>

	</td>
   </tr>
   </form>
</table>

<SCRIPT LANGUAGE=JAVASCRIPT>
	StateListSend();
	//ShowPermission();
</SCRIPT>
