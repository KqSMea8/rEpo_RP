<div class="had"><?=$MainModuleName?> </div>

<form name="form1" id="form1" action="" method="post"  enctype="multipart/form-data">
    <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" valign="top">
			
            <div class="message"><? if (!empty($_SESSION['mess_Page'])) {
				echo stripslashes($_SESSION['mess_Page']);
				unset($_SESSION['mess_Page']);
			} ?></div>
                <table width="100%"  border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" valign="middle">
                            
							<?php
							
							$numCols = 3;
							
							echo "<table width=\"100%\"  border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"borderall\">\n";
							echo "\t<tr>\n";
							
							foreach( $arryTemplates as $i => $values )
							{
								if ( $i != 0 && $i++ % $numCols == 0 )
								{
									echo "\t</tr>\n\t<tr>\n";
								}
								echo "\t\t<td class=\"blackbold\"><img width=\"205px;\" height=\"150px;\" src=\"".$Prefix."template/".$values['themeUploadedName']."/".$values['thumb_image']."\" ><br><br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type=\"button\"  onclick=\"submitform('".$values['id']."')\" name=\"activate\" ";  
								if($arrySetting[0]['TemplateId']==$values['id']) 
								echo "value=\"Active\" class=\"activate\">";
								else echo "value=\"Apply\" class=\"apply\">";
								
								 
								echo "<input type=\"button\"  onclick=\"openedit('".$values['id']."')\" name=\"activate\" value=\"Edit\" class=\"apply\"></td>\n";
								/*echo "<input type=\"radio\" name=\"TemplateId\" value=\"".$values['TemplateId']."\" ";
								if($arrySetting[0]['TemplateId']==$values['TemplateId']) echo "checked";
								echo ">&nbsp;&nbsp;".$values['TemplateDisplayName']."</td>\n";*/
							}
							
							echo "\t</tr>\n";
							echo '</table>';
							?>
							
							
							
							</td>
                    </tr>
                    <tr>
                        <td align="center" height="135" valign="top"><br>
                            <? if ($_GET['edit'] > 0) {
                                $ButtonTitle = 'Update';
                            } else {
                                $ButtonTitle = 'Submit';
                            } ?>
                            <input type="hidden" name="Id" id="Id" value="<?= $arrySetting[0]['Id']; ?>" />
                            <input type="hidden" name="TemplateId" id="TemplateId" value="" />
                        </td> 
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</form>
<script type="text/javascript">
function submitform(templateId){
	
	$('#TemplateId').val(templateId);
	$( "#form1" ).submit();
}
function openedit(templateId){	
	window.location.href = 'editTheme.php?edit='+templateId+'&curP=1';
}
</script>
