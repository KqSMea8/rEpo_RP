<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
      <tr>
        <td height="32" align="left" valign="middle" class="pagenav">
		<span ><?=$Nav_Home?> </span> <span > <a href="Javascript:window.history.go(-1)"><?=SEARCH_PRODUCTS?></a> </span> <?=GALLERY?></td>
      </tr>
      <tr>
        <td  align="left" valign="middle" class="heading">
		<?=GALLERY?>
			</td>
      </tr>
      <tr>
        <td height="15"></td>
      </tr>
      <tr>
        <td height="32">
		<Div id="LoadingDiv" align=center class=blacktxt><?=LOADING?></Div>
		<Div id="GalleryDiv" style="display:none">
		<? require_once("includes/html/box/gallery.php"); ?>
		</Div>
		</td>
      </tr>
    </table></td>
    <td align="right" valign="top"><? require_once("includes/html/box/right.php"); ?>
    </td>
  </tr>
</table>
</td>
</tr>
</table>

<script language="javascript1.2">
ShowGalleryAfterLoading();
function ShowGalleryAfterLoading(){
	document.getElementById("LoadingDiv").style.display = 'none';
	document.getElementById("GalleryDiv").style.display = 'inline';
}
</script>