<?php 
      $RowColor = array
        (        
        array("col_name" => "None", "col_value" => "None" ),
        array("col_name" => "Red", "col_value" => "#FFB0AA"),
	array("col_name" => "Green", "col_value" => "#CAFFCA"),
	array("col_name" => "Blue", "col_value" => "#CCCCFF"),
	array("col_name" => "Yellow", "col_value" => "#FFFF99"),
	array("col_name" => "Grey", "col_value" => "#CCCCCC"),
	array("col_name" => "Pink", "col_value" => "#FFE3EB") 
   
    );

$RowColorDropDown = '<select name="RowColor" id="RowColor" class="textbox" onchange="Javascript:SetRowColor(\''.$ToSelect.'\');"><option value="">--- Highlight Row ---</option>';
for ($i = 0; $i < sizeof($RowColor); $i++) {  
    $RowColorDropDown .=  '<option value="' .$RowColor[$i]["col_value"] . '" >' . $RowColor[$i]["col_name"] . '</option>';
}
$RowColorDropDown .=  '</select>';  

?>
<script language="JavaScript1.2" type="text/javascript">

function SetRowColor(ToSelect){             
		var checkedFlag = 0;
		var ids = '';
		var TotalRecords = document.getElementById("NumField").value;
		var RowColor = document.getElementById("RowColor").value;
          
		if(TotalRecords > 0 && RowColor!=''){
				for(var i=1;i<=TotalRecords;i++){
					if(document.getElementById(ToSelect+i).checked==true){
						if(checkedFlag == 0){
							checkedFlag = 1;
						}						
					}
				}
                                                

				if(checkedFlag == 0){
					alert("You must select atleast one record.");  
					document.getElementById("RowColor").value=''; 
	                                   
				}else{				
					ShowHideLoader(1,'P');
					document.form1.submit();  
					return true;			

				}
		}
			
}
</script>
