<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>
    <link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
    <link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />
<script type="text/javascript">
	var ew_DHTMLEditors = [];
</script>


<? if($_GET['pop']!=1){ ?>
<a class="back" href="<?=$RedirectURL?>">Back</a>

<a class="download" style="float:right;" target="_blank" href="pdfDocumentView.php?documentID=<?=$_GET['view']?>">Download Pdf</a>

<div class="had">
Manage <?=((isset($_GET["parent_type"])) ? $_GET["parent_type"] : '')?> Document   <span> &raquo; 
	<? 	echo (!empty($_GET['view']))?("View ".((isset($_GET["parent_type"])) ? ucfirst($_GET["parent_type"]) : '')." Details") :("Add ".((isset($_GET["parent_type"])) ? $_GET["parent_type"] : '')." ".$ModuleName); ?></span>
		
		
</div>
<? } ?>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	
  
	<tr>
	<td align="left" valign="top">
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
<form name="form1" action="<?=$ActionUrl?>"  method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
 
  
   <tr>
    <td  align="center" valign="top" >


<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

<?php   
//By Chetan26Aug// 
$head =1;
$arrayVal= $arryDocument[0];
for($h=0;$h<sizeof($arryHead);$h++){?>
        <tr>
            <td colspan="8" align="left" class="head"><?=$arryHead[$h]['head_value']?></td>
        </tr>

<?php 

$arryField = $objField->getFormField('',$arryHead[$h]['head_id'],'1'); 
include("includes/html/box/viewCustomFieldsNew.php");  
 
}
//End//
?> 	
	
</table>	
  
  
	
	</td>
   </tr>

   <tr>
       		 <td colspan="8" align="left"   ><?php if($_GET['pop']!=1){ include("includes/html/box/comment.php"); }?></td>
        </tr>

  
   </form>
</table>

	
	</td>
    </tr>
 
</table>
<? echo '<script>SetInnerWidth();</script>'; ?>
