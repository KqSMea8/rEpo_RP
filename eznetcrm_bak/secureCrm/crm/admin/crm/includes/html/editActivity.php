<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
<script type="text/javascript">
	var ew_DHTMLEditors = [];
</script>
<script language="JavaScript1.2" type="text/javascript">
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




function selModule() {
        var option = document.getElementById("RelatedType").value;

	document.getElementById("Opportunity").style.display = "none";
	document.getElementById("Lead").style.display = "none";
	document.getElementById("Campaign").style.display = "none";
	document.getElementById("Ticket").style.display = "none";
	 document.getElementById("Quote").style.display = "none";

        if(option == "Opportunity"){
            document.getElementById("Opportunity").style.display = "block";
        }else if (option == "Lead"){
            document.getElementById("Lead").style.display = "block";
 	}else if (option == "Campaign"){
            document.getElementById("Campaign").style.display = "block";
	}else if (option == "Ticket"){
            document.getElementById("Ticket").style.display = "block";
	}else if (option == "Quote"){
            document.getElementById("Quote").style.display = "block";
        }



    }
</script>




<div class="back"><a class="back" href="<?=$RedirectURL?>">Back</a></div>


<div class="had">
Manage Event   &raquo; <span>
	<? if($_GET["tab"]=="Summary"){?>
<? 	echo (!empty($_GET['edit']))?(" ".ucfirst($_GET["tab"])." Details") :("Add ".$ModuleName); ?>
<?} else{?>

	<? 	echo (!empty($_GET['edit']))?("Edit ".ucfirst($ModuleName)." Details") :("Add ".$ModuleName); ?>
	<? }?>
		
		
		</span>
</div>


	<? 
	if (!empty($_GET['edit'])) {
		include("includes/html/box/activity_edit.php");
	}else{
		include("includes/html/box/activity_form.php");
	}
	
	
	?>

 
