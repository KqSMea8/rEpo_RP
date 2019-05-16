<script language="JavaScript1.2" type="text/javascript">

function SelectAllRecord()
{	
	
	for(i=1; i<=document.form1.numModule.value; i++)
		{
		document.getElementById("IconID"+i).checked=true;
	}

}s

function SelectNoneRecords()
{
	for(i=1; i<=document.form1.numModule.value; i++){
		document.getElementById("IconID"+i).checked=false;
	}
}




function validateForm(frm)
{
	ShowHideLoader('1','S');	
	return true;
}
</script>

<div class="had">Inventory Setting</div>

<div class="message">
<? if(!empty($_SESSION['mess_dash'])) {echo $_SESSION['mess_dash']; unset($_SESSION['mess_dash']); }?>
</div>

<table width="100%"   border="0" cellpadding="0" cellspacing="0" >
<form name="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">
	<tr>
	  <td align="center" >
	  
	  <table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">


<tr>
        <td colspan="2" class="head" >

		Main Menu
		
		</td>
  </tr>
			
<tr>
       
        <td   align="left" >			 

<table width="100%"  border="0" cellspacing=3 cellpadding=5 >
<tr>
   <? 
  	$flag=true;
	$Line=0;

  	foreach($arryDashboardIcon as $key=>$values)
  	{
	$flag=!$flag;
	#$bgcolor=($flag)?("#FDFBFB"):("");
	
	

	$Line++;
	
//$checked=($values['Status']==1)?("checked"):("");
	$checked=($values['Status']==1)?("checked"):("");




  ?>
     <td valign="top" width="33%"><label><input type="checkbox" name="IconID[]" id="<?=$Line?>" value="<?=$values['ModuleID']?>" <?=$checked?>/>&nbsp;
	
	 <?=stripslashes($values['Module'])?></a><label>
   
<input type="hidden" name="Status[]" id="Status" value="<?=$values['Status']?>" /> 
	 </td>

    <?php 
	if($Line%3==0) echo '</tr><tr>';

} // foreach end //?>
  

	
  </table>

    



	</td>
  </tr>




	   
	  </table></td>
	
	
	</tr>


<tr><td>

<table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
	

<tr>
        <td colspan="2" class="head" >

		Sub Sections
		
		</td>
  </tr>
			
<tr>
     
        <td   align="left" >			 

<table width="100%"  border="0" cellspacing=3 cellpadding=5 ><tr>
   <? 
  	$flag=true;
	$Line=0;

	//$arryrightmenuitems=array("basic","binlocation","Alias","Price","Quantity","Supplier","Dimensions","alterimages","Transaction","Required");
	
  	foreach($arrySubmenu as $key=>$values1)
  	{
	$flag=!$flag;
	#$bgcolor=($flag)?("#FDFBFB"):("");
	
		

	$Line++;
	
	$checked=($values1['Status']==1)?("checked"):("");
	//$checked=($values1['Status']==0)?("checked"):("");




  ?>
     <td valign="top" width="33%"><label><input type="checkbox" name="IconID[]" id="<?=$Line?>" value="<?=$values1['id']?>" <?=$checked?>/>&nbsp;
	
	 <?=ucfirst(stripslashes($values1['Heading']))?></a></label>
   
<input type="hidden" name="Status[]" id="Status" value="<?=$values['Status']?>" /> 
   

	 </td>

    <?php 
if($Line%3==0) echo '</tr><tr>';

} // foreach end //?>
  

	
  </table>

    



	</td>
  </tr>




	   
	  </table></td>
	
	
	</tr>

<tr><td>

<table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
	

<tr>
        <td colspan="2" class="head" >

		Inventory
		
		</td>
  </tr>
			
<tr>
     
        <td   align="left" >			 

<table width="100%"  border="0" cellspacing=3 cellpadding=5 ><tr>
  
     <td valign="top" > Click here to Refresh Inventory 	 <input name="Refresh"  type="button" id="Refresh" class="button" value="Refresh" /><div id="Msgred"></div></td>

  

	
  </table>

    



	</td>
  </tr>




	   
	  </table></td>
	
	
	</tr>

</td></tr>

	<tr>
	  <td align="center"  height="50">

	    <input name="Submit" type="submit" id="SubmitButton" class="button" value="Submit" />
		<input type="hidden" name="numModule" id="numModule" value="<?=$numModule?>" />  
					   
			  </td>
		</tr>		

	</form>
</table>

	<script type="text/javascript">
		
		 $(document).ready(function() {

 			$("#Refresh").click(function() {

ShowHideLoader(1,'P');
             var SendParam = 'action=RefreshQty&r=' + Math.random();
           // document.getElementById('Msgred').innerHTML='<img src="../images/loading.gif">';
            $.ajax({
                type: "GET",
                async: false,
                url: '../admin/serial_update.php',
                data: SendParam,
                success: function(responseText) {
                    if (responseText != "")
                    {
                      document.getElementById('Msgred').innerHTML='Done';  
                      ShowHideLoader(0,'P');
                    } else {
                    	document.getElementById('Msgred').innerHTML='Done';  
ShowHideLoader(0,'P');
return false;
                    }

                }

            });


             });


		});

        

 

	</script> 
