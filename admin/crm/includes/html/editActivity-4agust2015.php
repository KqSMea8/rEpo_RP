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




<a class="back" href="<?=$RedirectURL?>">Back</a>

<? if($_GET['edit']>0){ ?>
<a href="outlookEvent.php?activityID=<?=$_GET['edit']?>" class="download" style="float:right;margin-left:5px;">Save to outlook</a>
<?} ?>

<div class="had">
Manage Event   &raquo; <span>
	<? if($_GET["tab"]=="Summary"){?>
<? 	echo (!empty($_GET['edit']))?(" ".ucfirst($_GET["tab"])." Details") :("Add ".$ModuleName); ?>
<?} else{?>

	<? 	echo (!empty($_GET['edit']))?("Edit ".ucfirst($ModuleName)." Details") :("Add ".$ModuleName); ?>
	<? }?>
		
		
		</span>
</div>

<div class="message" align="center"><?php
    if (!empty($_SESSION['mess_activity'])) {
        echo $_SESSION['mess_activity'];
        unset($_SESSION['mess_activity']);
    }
    if (!empty($_SESSION['EventLastInsertId'])) { //echo "<pre>"; print_r($OutlookFileData[0]);
	
	$OutlookFileData = $objActivity->GetActivity($_SESSION['EventLastInsertId'],'');

        $startDate = $OutlookFileData[0]["startDate"];
        $startDateStr = date_format(date_create($startDate), 'd M');
        $closeDate = $OutlookFileData[0]['closeDate'];
        $closeDateStr = date_format(date_create($closeDate), 'd M');
        $startTime = $OutlookFileData[0]['startTime'];
        $closeTime = $OutlookFileData[0]['closeTime'];
        $location = $OutlookFileData[0]['location'];
        
        $subject = $OutlookFileData[0]['subject']." - ".$OutlookFileData[0]['activityType']." [".$startDateStr."-".$closeDateStr."]";   
        $description = strip_tags($OutlookFileData[0]['description']);        
        echo "<br/><a id='msg' href='outlook.php?startDate=$startDate&closeDate=$closeDate&startTime=$startTime&closeTime=$closeTime&location=$location&subject=$subject&description=$description'>Save event to outlook</a>";
        unset($_SESSION['EventLastInsertId']);
    }else{ echo "<span id='msg' style='display:none;' ></span>"; }
    ?></div>




	<? 
	if (!empty($_GET['edit'])) {
		include("includes/html/box/activity_edit.php");
	}else{
		include("includes/html/box/activity_form.php");
	}
	
	
	?>

 
