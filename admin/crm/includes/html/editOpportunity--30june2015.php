<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>
<link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
<link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />
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
    
    
    


</script>


<div class="back"><a class="back"  href="<?=$RedirectURL?>">Back</a></div>


<div class="had">
Manage Opportunity   <span> &raquo; 

<? 
	if($_GET["tab"]=="Summary"){

	      echo (!empty($_GET['edit']))?(" ".ucfirst($_GET["tab"])." Details") :("Add ".$ModuleName); 

	} else{ 
	
              echo (!empty($_GET['edit']))?("Edit ".ucfirst($ModuleName)." Details") :("Add ".$ModuleName); 
	}
?>
		
	</span>	
</div>

	
  <? if (!empty($errMsg)) {?>
    <div align="center"  class="red" ><?php echo $errMsg;?></div>
  <? } ?>
  
	
	<? 
	if (!empty($_GET['edit'])) {
		include("includes/html/box/opportunity_edit.php");
	}else{
		include("includes/html/box/opportunity_form.php");
	}
	
	
	?>

	
	
 

