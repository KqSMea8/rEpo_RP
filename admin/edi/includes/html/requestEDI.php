<div class="had">
<?=$MainModuleName?>   
</div>

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <div class="message"><? if (!empty($_SESSION['mess_Page'])) {
    echo stripslashes($_SESSION['mess_Page']); 
    unset($_SESSION['mess_Page']);
} ?></div>
        	<form action="" method="post">
        	<table>
        	<tr>
        	<td>Search by Company Name: <input type="text" name="search_str" class="inputbox" value="<?php  if(isset($_POST['search_str']) && $_POST["search_str"] != '') { echo $_POST['search_str']; }?>" ></td>
        	 	<td>Company ID: <input type="text" name="CmpID" class="inputbox" value="<?php  if(isset($_POST['CmpID']) && $_POST["CmpID"] != '') { echo $_POST['CmpID']; }?>" ></td>
        	<td><input type="submit" name="Search" value="Search" class="button" ></td>
        	</tr>
        	</table>
        	</form>
			 <form action="" method="post" name="form1" id="form1">
            <table <?= $table_bg ?>>
                <tr align="left" >
                    <td width="20%" height="20"  class="head1">Company </td> 
                    <td width="15%" height="20"  class="head1">Email </td> 
                    <td width="15%" height="20"  class="head1">Contact Person </td> 
                    <td width="10%" height="20"  class="head1">Mobile </td> 
                    <td width="10%" height="20"  class="head1">Landline </td> 
                    <td width="10%" height="20"  class="head1">EDI Type </td> 
                    <td    height="20" align="right" class="head1">Action&nbsp;&nbsp;</td>
                </tr>
                <?php
                $pagerLink = $objPager->getPager($arryCompanies, $RecordsPerPage, $_GET['curP']);
                (count($arryCompanies) > 0) ? ($arryCompanies = $objPager->getPageRecords()) : ("");
                if (is_array($arryCompanies) && $num > 0) {
                    $flag = true;
					
                    foreach ($arryCompanies as $key => $values) {
                    								 	
                        ?>
                        <tr align="left"  bgcolor="<?= $bgcolor ?>">
                            <td height="26"><?php echo $values['CompanyName']; ?></td>
							<td height="26"><?php echo $values['Email']; ?></td>
                            <td height="26"><?php echo $values['ContactPerson']; ?></td>
                            <td height="26"><?php  echo $values['Mobile']; ?></td>
                             <td height="26"><?php if(!empty($values['LandlineNumber '])) echo $values['LandlineNumber ']; ?></td>
                             <td height="26"><?php 
                             if($values['RequestedCompID']!=$_SESSION['CmpID']){
                             	
                             	if(strtolower($values['EDIType'])=='both') echo 'Customer and Vendor';
                             	else echo $values['EDIType'];
                             }
                    		elseif($values['RequestedCompID']==$_SESSION['CmpID']){
                             	if(strtolower($values['EDIType'])=='both') echo 'Customer and Vendor';
                             	elseif(strtolower($values['EDIType'])=='vendor') echo 'Customer';
                             	else echo 'Vendor';
                             }
                           
                             ?></td>
                            <td height="26" align="right"  valign="top"> 
                            <?php 
                            
                            if(!empty($_GET['module']) ){
#echo $values['RequestedCompID'] ."=>".$_SESSION['CmpID'];
								if( $values['RequestedCompID']!=$_SESSION['CmpID'] && $_GET['module']=='Reqest'  ){
                            	?>
                            <!--	<a href="requestEDI.php?ID=<?php echo $values['RequestedCompID']; ?>&mod=Accept&type=<?php echo $_GET['module']; ?>&ComName=<?=$values['DisplayName']?>" class="Blue" >accept</a>-->
                            	 <a class="fancybox fancybox.iframe" class="button" href="sendEdiRequest.php?request_CmpID=<?php echo $values['RequestedCompID']; ?>&mod=Accept&type=<?php echo $_GET['module']; ?>&name=<?=$values['DisplayName']?>&EdiType=<?=$values['EDIType']?>"><?=$Accept?></a>
                            	
                              
                             	 <a href="requestEDI.php?ID=<?php echo $values['RequestedCompID']; ?>&mod=Reject&type=<?php echo $_GET['module']; ?>&ComName=<?=$values['DisplayName']?>" class="Blue" ><?=$Reject?></a>
                            
                            <?php } if( $_GET['module']=='Accept'  ){
                            	?>
                               	 <a href="requestEDI.php?ID=<?php echo $values['RequestedCompID']; ?>&mod=Reject&type=<?php echo $_GET['module']; ?>&ComName=<?=$values['DisplayName']?>" class="Blue" ><?= $Reject ?></a>
                            
                            <?php }
                            } elseif(empty($_GET['module'])) {?>
                            
                            <a class="fancybox fancybox.iframe" class="button" href="sendEdiRequest.php?request_CmpID=<?php echo $values['CmpID']; ?>&name=<?php echo $values['DisplayName']; ?>&curP=<?php echo $_GET['curP']; ?>&mod=Request">Send</a>
                            
								
					                             
                                <!--<a href="requestEDI.php?request_CmpID=<?php echo $values['CmpID']; ?>&name=<?php echo $values['DisplayName']; ?>&curP=<?php echo $_GET['curP']; ?>" class="Blue" ><?= $request ?></a>              
                               --><?php }?>
                                &nbsp;
                            </td>
                        </tr>
                    <?php } // foreach end //?>
<?php } else { ?>
                    <tr align="center" >
                        <td height="20" colspan="7"  class="no_record">No Pages found. </td>
                    </tr>
<?php } ?>

                <tr>  
                    <td height="20" colspan="7" >Total Record(s) : &nbsp;<?php echo $num; ?>    
<?php if (count($arryCompanies) > 0) { ?>&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
} ?>       
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</form>

