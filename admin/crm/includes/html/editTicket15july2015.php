<script type="text/javascript">
	function selModule() {
		
		var option = document.getElementById("RelatedType").value;
	
		document.getElementById("Opportunity").style.display = "none";
		document.getElementById("Lead").style.display = "none";
		document.getElementById("Campaign").style.display = "none";
		document.getElementById("Quote").style.display = "none";
		//alert();

		//alert(option);return false;
		if(option == "Opportunity"){
			document.getElementById("Opportunity").style.display = "block";
		}else if (option == "Lead"){
			document.getElementById("Lead").style.display = "block";
		}else if (option == "Campaign"){
			document.getElementById("Campaign").style.display = "block";
		}else if (option == "Quote"){
			document.getElementById("Quote").style.display = "block";
		}
	}
	
	</script>
<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>

    <link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
    <link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />
 <script>
$(document).ready(function() {
        $('#assign1').click(function() {
                $('#group').hide();
                $('#user').show();

        });
       $('#assign2').click(function() {
                 $('#user').hide();
                $('#group').show();
                
        });
    });
       

    </script>

<div class="back"><a class="back" href="<?=$RedirectURL?>">Back</a></div>


<div class="had">
Manage <?=$_GET['parent_type']?> Ticket   <span> &raquo; 
	<? 	echo (!empty($_GET['edit']))?("Edit ".ucfirst($_GET["tab"])." Details") :("Add ".$_GET['parent_type']." ".$ModuleName); ?>
	</span>	
		
</div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<? if (!empty($errMsg)) {?>
  <tr>
    <td height="2" align="center"  class="red" ><?php echo $errMsg;?></td>
    </tr>
  <? } ?>
  
	<tr>
	<td align="left" valign="top">

	<? 
	if (!empty($_GET['edit'])) {
		include("includes/html/box/ticket_edit.php");
	}else{
		include("includes/html/box/ticket_form.php");
	}
	
	
	?>

	
	</td>
    </tr>
 
</table>
