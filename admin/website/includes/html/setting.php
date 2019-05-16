<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
<script type="text/javascript">
    var ew_DHTMLEditors = [];
</script>
<div class="had"><?=$MainModuleName?> </div>

<form name="form1" action="" method="post"  enctype="multipart/form-data">
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <div class="message"><? if (!empty($_SESSION['mess_Page'])) {
    echo stripslashes($_SESSION['mess_Page']);
    unset($_SESSION['mess_Page']);
} ?></div>
          

            <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="borderall">

								
                                <tr>
                                    <td align="center" valign="top" ><table width="100%" border="0" cellpadding="5" cellspacing="1" >
											 <tr>
                                                <td align="right" valign="middle"  class="blackbold"> Menu Option  :</td>
                                                <td align="left" class="blacknormal">
                                                    <table width="375" border="0" cellpadding="0" cellspacing="0"  class="blacknormal margin-left">
                                                        <tr>
															<?php
 															foreach ($arryMenutype as $key => $values) { 
													 			echo '<td width="20" align="left" valign="middle">
																	<input name="'.$values['MenuType'].'" type="checkbox" value="1" ';
																	if($arrySetting[0][$values['MenuType']] == "Yes")	echo "checked";
																	if($values['Editable'] == "No")	echo " disabled";
																	echo ' /></td>
                                                            		<td width="63" align="left" valign="middle">'.$values['MenuType'].'</td>';
													  	
													 			}
															?>
                                                            
                                                        </tr>
                                                    </table>                      
                                                </td>
                                            </tr>
											
											 
											 
                                             <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                   Sitename : </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="Sitename" id="Sitename" type="text" class="inputbox"  value="<?php echo $arrySetting[0]['Sitename'];?>" />
													
													
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                   Domain Redirect : </td>
                                                <td width="56%"  align="left" valign="top">
                                                <textarea class="inputbox" style="width: 60%; height: 85px;"
									name="DRedirect" id="DRedirect"><?php echo $arrySetting[0]['DRedirect'];?></textarea>
                                                    <div class="formItemComment"><a href="javascript:void(0)"
									onclick="generatecode();">Generate</a> redirect code and put
								this code on your index.html file to redirect on your mained
								domain</div>
													
													
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                   Logo : (1000*150)</td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="Logo" id="Logo" type="file" class="inputbox"  size="50" />
                                                    <br>
                                                                        <?= $MSG[201] ?>	
                                                    
                                                                        <br>
                                                                        
                                                  <?php
													$MainDir = $Prefix."upload/company/logo/"; 
													//$MainDir = $_SERVER["DOCUMENT_ROOT"]."/web/upload/company/logo/"; 
													if ($arrySetting[0]['Logo'] != '' && file_exists($MainDir.$arrySetting[0]['Logo'])) { 
													 $OldImage = $MainDir . $arrySetting[0]['Logo']; 
													?>
													<span id="DeleteSpan">
													<input type="hidden" name="OldImage" value="<?=$OldImage?>">  
													
													<a data-fancybox-group="gallery" class="fancybox" href="<?=$MainDir.$arrySetting[0]['Logo']?>">
													<? echo '<img src="resizeimage.php?w=200&h=200&img=' . $MainDir. $arrySetting[0]['Logo'] . '" border=0  >'; ?>
													</a>&nbsp;
													<a href="Javascript:void(0);" onclick="Javascript:DeleteFile('<?=$MainDir.$arrySetting[0]['Logo']?>','DeleteSpan')" onmouseout="hideddrivetip();">
													<?=$delete?></a>
													
													</span>	
													                                                                           
													 <? } ?>	                    
													<?php
													/*if($arrySetting[0]['Logo']!=''){
													echo '<br><img src="'.$Prefix."upload/company/logo/".$arrySetting[0]['Logo'].'" />';
													}*/
													?>
													
                                                </td>
                                            </tr>
											
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    Copy Right : </td>
                                                <td width="56%"  align="left" valign="top">
                                                   <textarea style="width:60%; height: 85px;" class="inputbox" id="copyright" name="copyright"><?= stripslashes($arrySetting[0]['copyright']) ?></textarea>
												    
                                                </td>
                                            </tr>
                                           
											 <tr>
                                                <td align="right" valign="middle"  class="blackbold"> Social Media  :</td>
                                                <td align="left" class="blacknormal">
                                                    <table width="151" border="0" cellpadding="0" cellspacing="0"  class="blacknormal margin-left">
                                                        <tr>
															<?php
															$arraysocial=array('Facebook'=>'Facebook Link','Twitter'=>'Twitter Link',
															'LinkedIn'=>'LinkedIn Link','GooglePlus'=>'GooglePlus Link');
															
															
 															foreach ($arraysocial as $key => $values) { 
													 			echo '<td width="20" align="left" valign="middle">
																	<input name="'.$key.'"  id="'.$key.'1" type="checkbox" value="1"  ';
																	if($arrySetting[0][$key] == "Yes")	echo "checked";
																	
																	echo ' onclick="show_social_link(\''.$key.'\')"; /></td>
                                                            		<td width="63" align="left" valign="middle">'.$key.'</td>';
													  	
													 			}
															?>
                                                            
                                                        </tr>
                                                    </table>                      
                                                </td>
                                            </tr>
                                            
                                            <?php foreach ($arraysocial as $key => $values) {  
                                            	 $style='';
                                            	if($arrySetting[0][$key] != "Yes")
                                            	 $style='style="display:none;"';
                                            	 
                                            	 $fieldname=str_replace(' ', '', $values);
                                            	?>
                                            <tr id="<?php echo $key; ?>" <?php echo $style; ?> >
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    <?php echo $values; ?> : </td>
                                                <td width="56%"  align="left" valign="top">
                                                   <textarea style="width:60%; height: 55px;" class="inputbox" id="<?php echo $fieldname; ?>" name="<?php echo $fieldname;  ?>"><?= stripslashes($arrySetting[0][$fieldname]) ?></textarea>
												    
                                                </td>
                                            </tr>
											<?php } ?>
											
											<tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    Google Analytics : </td>
                                                <td width="56%"  align="left" valign="top">
                                                <Textarea name="GoogleAnalytics" id="GoogleAnalytics" class="inputbox"  ><? echo stripslashes($arrySetting[0]['GoogleAnalytics']); ?></Textarea>
                                                    <script type="text/javascript">

                                                        var editorName = 'GoogleAnalytics';

                                                        var editor = new ew_DHTMLEditor(editorName);

                                                        editor.create = function() {
                                                            var sBasePath = '../FCKeditor/';
                                                            var oFCKeditor = new FCKeditor(editorName, '410', 200, 'Basic');
                                                            oFCKeditor.BasePath = sBasePath;
                                                            oFCKeditor.ReplaceTextarea();
                                                            this.active = true;
                                                        }
                                                        ew_DHTMLEditors[ew_DHTMLEditors.length] = editor;

                                                        ew_CreateEditor(); 


                                                    </script>
                                                  
												    
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    Home Page Content : </td>
                                                <td width="56%"  align="left" valign="top">
                                                <Textarea name="HomeContent" id="HomeContent" class="inputbox"  ><? echo stripslashes($arrySetting[0]['HomeContent']); ?></Textarea>
                                                    <script type="text/javascript">

                                                        var editorName = 'HomeContent';

                                                        var editor = new ew_DHTMLEditor(editorName);

                                                        editor.create = function() {
                                                            var sBasePath = '../FCKeditor/';
                                                            var oFCKeditor = new FCKeditor(editorName, '410', 200, 'Basic');
                                                            oFCKeditor.BasePath = sBasePath;
                                                            oFCKeditor.ReplaceTextarea();
                                                            this.active = true;
                                                        }
                                                        ew_DHTMLEditors[ew_DHTMLEditors.length] = editor;

                                                        ew_CreateEditor(); 


                                                    </script>
                                                  
												    
                                                </td>
                                            </tr>
                                            
                                        </table>

                                    </td>
                                </tr>
									 <tr>
                        <td align="center" height="135" valign="top"><br>
                            <?  $ButtonTitle = 'Save'; ?>
                            <input type="hidden" name="Id" id="Id" value="<?= $arrySetting[0]['Id']; ?>" />
                            <input name="Submit" type="submit" class="button"  value=" <?= $ButtonTitle ?> " />&nbsp;
                        </td> 
                    </tr>

                            </table>
        </td>
    </tr>
</table>
</form>

<script>
function generatecode(){
	<?php 
		$Domain='';
                    if((isset($_REQUEST['CustomerID']) && $_REQUEST['CustomerID']!='') && $arrySetting[0]['Sitename']!=''){
                    $Domain='http://'.$_SERVER['SERVER_NAME'].'/web/'.$_SESSION['DisplayName'].'/'.$arrySetting[0]['Sitename'].'/';
                    
                    }elseif($arrySetting[0]['Sitename']!=''){
                    	 $Domain='http://'.$_SERVER['SERVER_NAME'].'/web/'.$_SESSION['DisplayName'].'/';
                    }
                   
	?>
	<?php if((isset($_REQUEST['CustomerID']) && $_REQUEST['CustomerID']) && $arrySetting[0]['Sitename']=''){ 
		$Domain='http://'.$_SERVER['SERVER_NAME'].'/web/'.$_SESSION['DisplayName'].'/';
		?>
	var Sitename=$('#Sitename').val();
	var domain='<?php echo $Domain;?>+Sitename+'/';
	<?php }?>
	
	var domain='<?php echo $Domain;?>';
	if(domain!=''){
	var content='<!DOCTYPE html><html><head><meta http-equiv="refresh"  content="0; url='+domain+'"></head></html>';
	$('#DRedirect').val(content);
	}else{
		alert('domain name not avilable.');
	}
}
function show_social_link(Id){

	if($("#"+Id+"1").is(':checked')){
		$("#"+Id).show();
		}
	else{
		$("#"+Id).hide();
	}

}
</script>
