

<div class="had"><?=$MainModuleName?> <span>&raquo;
	<? 	echo (!empty($_GET['edit']))?("".$SubHeading) :("".$ModuleName); ?>
		
		</span></div>
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
                                                   Form : </td>
                                                <td width="56%"  align="left" valign="top">
													<select name="CustId" id="CustId" class="inputbox">
													
													<?php
												
													 foreach ($CustomersArray as $key => $values) {
													 	echo '<option value="'.$values['Cid'].'" ';
														
														echo ' >'.$values['FullName'].'</option>';
													  	
													 }
													?>
													</select>
                                                    
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
                                $ButtonTitle = 'Assign Website';
                            } ?>
                           
                            <input name="Submit" type="submit" class="button" id="AssignWebsite" value=" <?= $ButtonTitle ?> " />&nbsp;
                        </td> 
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</form>
