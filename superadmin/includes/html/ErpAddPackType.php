<script type="text/javascript" src="../admin/FCKeditor/fckeditor.js"></script>
<script
	type="text/javascript" src="../admin/js/ewp50.js"></script>

<script type="text/javascript">
    var ew_DHTMLEditors = [];
</script>

<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';
		/*
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  { 
			   location.href = 'viewLicense.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewLicense.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
			return false;
			*/
	}
</script>

<div class="message" align="center">
<? if(!empty($_SESSION['mess_license'])) {echo $_SESSION['mess_license']; unset($_SESSION['mess_license']); }?>
</div>
<ul class="site-cl">

	<li><a href="pageList.php">Page Management</a></li>

	<li><a href="menuManagement.php">Menu Management</a>

		<ul>

			<li><a href="headerMenu.php">Header Menu</a></li>
			<li><a href="footerSocialLinksList.php">Footer Social Link</a></li>


		</ul>
	</li>
		  	<li><a href="packegeManagement.php">Package Management</a>
		<ul>

			<li><a href="managePackFeature.php">Manage Package Feature</a></li>
			<li><a href="managePackType.php">Manage Package Type</a></li>
			<li><a href="managePackages.php">Packages</a></li>


		</ul>
	</li>
	<li><a href="bannerManagement.php">Banner Management</a></li>




</ul>
<div class="clear"></div>
<form name="form1" action="" method="post" enctype="multipart/form-data">
	<table width="100%" border="0" align="center" cellpadding="0"
		cellspacing="0">
		<tr>
			<td align="center" valign="top">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td align="center" valign="middle">
							<div align="right">
								<a href="<?= $ListUrl ?>" class="back">Back</a>&nbsp;
							</div> <br>
							<table width="100%" border="0" cellpadding="0" cellspacing="0"
								class="borderall">


								<tr>
									<td align="center" valign="top"><table width="100%" border="0"
											cellpadding="5" cellspacing="1">
											
											<tr>
												<td width="30%" align="right" valign="top" class="blackbold">
													Name<span class="red">*</span>
												</td>
												<td width="56%" align="left" valign="top"><input
													name="name" id="name"
													value="<?= !empty($arryPage[0]['name'])?stripslashes($arryPage[0]['name']):''; ?>"
													type="text" class="inputbox" size="50" /> <?php if(!empty($errors['name'])){echo $errors['name'];}?>
												</td>
											</tr>
											
											
											<?php 
											foreach($packTpData as $ptkey=>$ptvalues){ //echo "<pre>";print_r($ptvalues); ?>
													<tr>
												<td width="50%" align="right" valign="top" class="blackbold">
													<?php echo $ptvalues['feature'];?>
												</td>

												<td width="56%" align="left" valign="top"><input
													name="value[]" id="feature"
													value="<?php echo $ptvalues['ModuleID'];?>"
													type="checkbox" class="inputbox" size="50" <?php if(in_array($ptvalues['ModuleID'],$arr)){echo 'checked="checked"';}?>/>
												</td>
											</tr>
										
											<?php } ?>

										</table>
									</td>
								</tr>


							</table></td>
					</tr>
					<tr>
						<td align="center" height="135" valign="top"><br> <? if ($_GET['edit'] > 0) {
							$ButtonTitle = 'Update';
						} else {
							$ButtonTitle = 'Submit';
						} ?> <input type="hidden" name="id" id="id" value="<?= $id; ?>" />
							<input name="Submit" type="submit" class="button" id="SubmitPage"
							value=" <?= $ButtonTitle ?> " />&nbsp;</td>
					</tr>

				</table>
			</td>
		</tr>
	</table>
</form>
