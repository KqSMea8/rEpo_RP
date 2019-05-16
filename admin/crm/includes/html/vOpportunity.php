<?if($_GET['pop']!=1){?>

<?
	/*********************/
	/*********************/
   	$NextID = $objCommon->NextPrevOpp($_GET['view'],1);
	$PrevID = $objCommon->NextPrevOpp($_GET['view'],2);
	$NextPrevUrl = "vOpportunity.php?module=".$_GET["module"]."&curP=".$_GET["curP"];
	include("includes/html/box/next_prev.php");
	/*********************/
	/*********************/
?>



<script language="JavaScript1.2" type="text/javascript">
    //By chetan 4 Dec//
           var ConvertConfirm =  function(){

                $( "#dialog-confirm" ).dialog({
                    resizable: false,
                    height:150,
                    modal: true,
                    buttons: {
                      "Yes": function() {
                       window.location = "vOpportunity.php?view=<?=$_GET['view']?>&module=Opportunity&curP=1&convert=y&in=customer";
                      },
                      Cancel: function() {
                        $( this ).dialog( "close" );
                      }
                    }
                });
         }
  //End//
</script>


<a class="back" href="<?=$RedirectURL?>">Back</a> <a href="<?=$EditUrl?>" class="edit">Edit</a> 

<a class="download" style="float:right;" target="_blank" href="pdfOpportunityView.php?OpportunityID=<?=$_GET['view']?>">Download</a>

<div class="had">Manage Opportunity   <span> &raquo;
	View <? 	echo ucfirst($_GET["tab"])." Details"; ?>
		</span>
</div>
<? } ?>
  
<? if($_GET['tab']!="Opportunity"){?>
<h2><font color="darkred"> Opportunity [<?=$arryOpportunity[0]['OpportunityID']?>] : <?=stripslashes($arryOpportunity[0]['OpportunityName'])?></font></h2>         
<? } ?>
<? 
if (!empty($_GET['view'])) {
	include("includes/html/box/opportunity_view.php");
}

?>

<!--By chetan 4Dec--->
<div id="dialog-confirm" title="Convert To Customer?" style="display: none">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Are you sure to convert Opportunity to Customer?</p>
</div>
<!--End-->
