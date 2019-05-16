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

<?php include('siteManagementMenu.php');?>
<div class="clear"></div>
<br>
<div class="message" align="center">
<? if(!empty($_SESSION['mess_banner'])) {echo $_SESSION['mess_banner']; unset($_SESSION['mess_banner']); }?>
</div>
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
													Title :<span class="red">*</span>
												</td>
												<td width="56%" align="left" valign="top"><input
													name="Title" id="Title"
													value="<?= stripslashes($arryPage[0]['Title']) ?>"
													type="text" class="inputbox" size="50" />
												</td>
											</tr>
											
											<tr>
												<td width="30%" align="right" valign="top" class="blackbold">
													Image Text :<span class="red">*</span>
												</td>
												<td width="56%" align="left" valign="top"><textarea
													name="Text" id="Title"
													value=""
													class="inputbox" size="50"> <?= stripslashes($arryPage[0]['Text'])?> </textarea>
												</td>
											</tr>
											
											<tr>
												<td width="30%" align="right" valign="top" class="blackbold">
													Priority :<span class="red">*</span>
												</td>
												<td width="56%" align="left" valign="top"><input
													name="Priority" id="priority"
													value="<?= stripslashes($arryPage[0]['Priority']) ?>"
													type="text" class="inputbox" size="50" /> <?php if(!empty($errors['priority'])){echo $errors['priority'];}?>
												</td>
											</tr>


											<tr>
												<td class="blackbold" valign="top" align="right">Banner
													Image:</td>
												<td height="40" align="left" valign="top"
													class="blacknormal"><input name="Image" id="Icon"
													type="file" class="inputbox"
													onkeypress="javascript: return false;"
													onkeydown="javascript: return false;"
													oncontextmenu="return false" ondragstart="return false"
													onselectstart="return false" />&nbsp;<?=$MSG[201]?> <? if($arryPage[0]['Image'] !='' && file_exists('../../images/'.$arryPage[0]['Image']) ){ ?>

													<div id="ImageDiv">
														<a class="fancybox" data-fancybox-group="gallery"
															href="../../images/<?=$arryPage[0]['Icon']?>"
															title="<?=$arryPage[0]['Image']?>"><? echo '<img src="../../resizeimage.php?w=150&h=150&img=images/'.$arryPage[0]['Image'].'" border=0 >';?>
														</a> <br /> <a href="Javascript:void(0);"
															onclick="Javascript:DeleteFile('../../images/<?=$arryPage[0]['Image']?>','ImageDiv')">Delete</a>


													</div> <?	}?>
												</td>
											</tr>

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
