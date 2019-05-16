


<div class="had">
<?=$MainModuleName?>   <span>&raquo;
	<? 	echo (!empty($_GET['edit']))?("Edit ".$SubHeading) :("Add ".$ModuleName); ?>
		
		</span>
</div>
<form name="form1" action="" method="post"  enctype="multipart/form-data">
    <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" valign="top">
                <table width="100%"  border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" valign="middle">
                            <div  align="right"><a href="<?= $ListUrl ?>" class="back">Back</a>&nbsp;</div><br>
                            <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="borderall">


                                <tr>
                                    <td align="center" valign="top" ><table width="100%" border="0" cellpadding="5" cellspacing="1" >
											<tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                   Title : <span class="red">*</span></td>
                                                <td width="56%"  align="left" valign="top">
                                                	<select name="Social_media_id" id="Social_media_id" class="inputbox" onchange=geticon(this.value); >
                                                	<option value="">Select</option>
                                                	<?php foreach($arrySocialMediaList as $list){
                                                		echo '<option value="'.$list['id'].'" ';
                                                		if($arrySocial[0]['Social_media_id']==$list['id']) echo 'selected="selected"';
                                                		echo '>'.$list['name'].'</option>';
                                                	
                                                	}?>
                                                	</select>
                                                	<?php if($arrySocial[0]['icon']!=''){
                                                		$img=$arrySocial[0]['icon'];
                                                		$display='';
                                                	}else{
                                                	 $img='badoo.png';
                                                	 $display=' display:none;';
                                                	}?>
													<div id="socialicon" style="padding-left: 212px; margin-top: -24px; <?php echo $display;?>">
													<?php $OldImage = '../images/icons/'.$img;?>
													<img src="<?php echo $OldImage;?>" width="24px;" height="24px;"/>
													</div>
                                                    
                                                </td>
                                            </tr>
											
											  <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    Priority (used for sorting) :</td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="Priority" id="Priority" onkeypress="return isNumberKey(event)" value="<?= stripslashes($arrySocial[0]['Priority']) ?>" type="text" class="inputbox" />
                                                </td>
                                            </tr>
											
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    URL :<span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="URL" id="URL" value="<?= stripslashes($arrySocial[0]['URL']) ?>" type="text" class="inputbox"  size="50" />
                                                </td>
                                            </tr>
                                           
                                            
                                            <tr>
                                                <td align="right" valign="middle"  class="blackbold"> Status  :</td>
                                                <td align="left" class="blacknormal">
                                                    <table width="151" border="0" cellpadding="0" cellspacing="0"  class="blacknormal margin-left">
                                                        <tr>
                                                            <td width="20" align="left" valign="middle"><input name="Status" type="radio" value="1" <?= ($PageStatus == "Yes") ? "checked" : "" ?> /></td>
                                                            <td width="48" align="left" valign="middle">Active</td>
                                                            <td width="20" align="left" valign="middle"><input name="Status" type="radio" <?= ($PageStatus == "No") ? "checked" : "" ?> value="0" /></td>
                                                            <td width="63" align="left" valign="middle">Inactive</td>
                                                        </tr>
                                                    </table>                      
                                                </td>
                                            </tr>

                                           

                                        </table>

                                    </td>
                                </tr>


                            </table></td>
                    </tr>
                    <tr>
                        <td align="center" height="135" valign="top"><br>
                            <? if ($_GET['edit'] > 0) {
                                $ButtonTitle = 'Update';
                            } else {
                                $ButtonTitle = 'Submit';
                            } ?>
                            <input type="hidden" name="Id" id="Id" value="<?= $LinkId; ?>" />
                            <input name="Submit" type="submit" class="button" id="SubmitSocial" value=" <?= $ButtonTitle ?> " />&nbsp;
                        </td> 
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</form>
<script>
function geticon(id){
	if(id!=''){
		$.post( "ajax.php?action=socailicon", { socailiconid: id })
		  .done(function( data ) {
		   
		    var img='<?php echo $OldImage = '../../images/icons/';?>';
			$("#socialicon img").attr("src", img+data);
			$('#socialicon').show();
		  });
		
	
	}else{
		$('#socialicon').hide();
	}
	
}
</script>
