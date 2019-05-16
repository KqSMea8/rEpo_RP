<script language="JavaScript1.2" type="text/javascript">
function validateForm(frm){


	if( ValidateForSimpleBlank(frm.AuthorName, "Author Name")
		&& ValidateForTextareaMand(frm.Description,"Description",10,500)
		&& ValidateOptionalUpload(frm.Image, "Image")
		
		)
                {    
			return true;		
		}
      else{
					return false;	
			}	
}

</script>

<?php include('siteManagementMenu.php');?>
<div class="clear"></div>
<div class="had">Testimonial Management  <span> &raquo;
<? 
$MemberTitle = (!empty($_GET['edit']))?(" Edit ") :(" Add  ");
echo $MemberTitle.$ModuleName;
?>
</span>
</div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_testimonial'])) {echo $_SESSION['mess_testimonial']; unset($_SESSION['mess_testimonial']); }?>
</div>

<form name="form1" action="" method="post" enctype="multipart/form-data" onsubmit="return validateForm(this);">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
     <tr>
	<td align="center" valign="top">
	    <table width="100%" border="0" cellpadding="0" cellspacing="0">
	      <tr>
		<td align="center" valign="middle">
		   <div align="right"><a href="<?= $ListUrl ?>" class="back">Back</a>&nbsp;
			</div>
			  <br>
		   <table width="100%" border="0" cellpadding="0" cellspacing="0" class="borderall">			
		     <tr>
		       <td align="center" valign="top">
			<table width="100%" border="0" cellpadding="5" cellspacing="1">
			     <tr>                              
                   <td  width="45%" align="right"   class="blackbold"> Author Name   :<span class="red">*</span> </td>                         	
		 <td width="56%" align="left" valign="top"><input name="AuthorName" id="AuthorName" type="text" class="inputbox" size="50" maxlength="50"
								value="<?= stripslashes($arryeditTestimonial[0]['AuthorName']) ?>"/> 									 
			     </td>
			  </tr>

                                                              
          
                          <tr>
                            <td  width="45%" align="right"   valign="top" class="blackbold">  Description   :<span class="red">*</span> </td> 
                             <td  align="left" >
                               <textarea name="Description" class="bigbox" id="Description" maxlength="500"><?=stripslashes($arryeditTestimonial[0]['Description'])?></textarea></td>
                          </tr>

                                  
                
                            <tr>
				<td class="blackbold" valign="top" align="right">Image:</td>
                            <td height="40" align="left" valign="top" class="blacknormal">

<input name="Image" id="Image" type="file" class="inputbox" onkeypress="javascript: return false;" onkeydown="javascript: return false;"
   oncontextmenu="return false" ondragstart="return false" onselectstart="return false" />   &nbsp;


<?/* if($arryeditTestimonial[0]['Image'] !='' && file_exists('../images/'.$arryeditTestimonial[0]['Image']) ){ ?>

<div id="ImageDiv">

 <a class="fancybox" data-fancybox-group="gallery"
															href="../images/<?=$arryeditTestimonial[0]['Image']?>"
															title="<?=$arryeditTestimonial[0]['Image']?>"><? echo '<img src="../resizeimage.php?w=150&h=150&img=images/'.$arryeditTestimonial[0]['Image'].'" border=0 >';?>
		</a> <br />

 <?}*/?>
<?
if(IsFileExist($Config['TestimonialDir'],$arryeditTestimonial[0]['Image'])){ 
	$OldImage =  $arryeditTestimonial[0]['Image'];

	$PreviewArray['Folder'] = $Config['TestimonialDir'];
	$PreviewArray['FileName'] = $arryeditTestimonial[0]['Image']; 
	$PreviewArray['FileTitle'] = stripslashes($arryeditTestimonial[0]['AuthorName']);
	$PreviewArray['Width'] = "150";
	$PreviewArray['Height'] = "150";
	$PreviewArray['Link'] = "1";

	echo '<br><br><div id="ImageDiv">'.PreviewImage($PreviewArray).'
	&nbsp;<a href="Javascript:void(0);" onclick="Javascript:RemoveFile(\''.$Config['TestimonialDir'].'\',\''.$arryeditTestimonial[0]['Image'].'\',\'ImageDiv\')">'.$delete.'</a><input type="hidden" name="OldImage" value="'.$OldImage.'"></div>';

}
?>

   
			</td></tr>										
							
			<tr>
			   <td align="right" valign="middle" class="blackbold">Status :</td>
								<td align="left" class="blacknormal">
								<table width="151" border="0" cellpadding="0" cellspacing="0"
									class="blacknormal margin-left">
									<tr>
		<td width="20" align="left" valign="middle"><input name="Status" type="radio" value="1" <?= ($TestimonialStatus == "1") ? "checked" : "" ?> /></td>								
		<td width="48" align="left" valign="middle">Active</td>
	        <td width="20" align="left" valign="middle"><input name="Status" type="radio" <?= ($TestimonialStatus == "0") ? "checked" : "" ?> value="0" /></td>
	        <td width="63" align="left" valign="middle">Inactive</td>
		  </tr>
								</table>
								</td>
							</tr>
							
						</table>
						</td>
					</tr>


				</table>
				</td>
			</tr>
			<tr>
				<td align="center" height="135" valign="top"><br>
				<? if ($_GET['edit'] > 0) {
					$ButtonTitle = 'Update';
				} else {
					$ButtonTitle = 'Submit';
				} ?> 

<input type="hidden" name="TestimonialID" id="TestimonialID" value="<?= $TestimonialID; ?>" /> 

<input name="Submit" type="submit" class="button" id="SubmitPage" value=" <?= $ButtonTitle ?> " />


</td>
			</tr>

		</table>
		</td>
	</tr>
</table>
</form>
