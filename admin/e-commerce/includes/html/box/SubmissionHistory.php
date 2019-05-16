<div class="had">Submission History</span></div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <td id="ProductsListing">
            <form action="" method="post" name="form1">
                <table <?= $table_bg ?>>
                    <tr align="left">
                       <td width="10%" class="head1" align="left">Added/Updated Date/Time</td>
                        <td width="10%"  class="head1" >Product Name</td>
                        <td width="10%"  class="head1" align="left">Product SKU</td>
                        <td class="head1" class="head1" align="left">Status</td>
						<td class="head1" class="head1" align="left">Modification Type</td>
						<td width="30%" class="head1" class="head1" align="left">Status Message</td>
                       
                    </tr>

                    <?php
                    if (is_array($arryEbay) && $num > 0) {
                        $flag = true;
                        $Line = 0;
                        foreach ($arryEbay as $key => $values) {
                            $flag = !$flag;
                            //$bgcolor=($flag)?(""):("#F3F3F3");
                            $Line++;
                            $data = '';
                            $status = 0;
							if($values['Status']!=1 && $values['amazonAccountID']>0 && !empty($values['FeedSubmissionId'])){
								$status++;
								$fetchType = empty($values['ProductSku']) ? 'Batch' : 'SubmitHistory';
								$Amazonservice = $objProduct->AmazonSettings($Prefix,true,$values['amazonAccountID']);
								if($Amazonservice)
								$data = $objProduct->getFeedSubmissionHistory($Amazonservice, $values['FeedSubmissionId'], $fetchType);
								
							}
                            //if($values['Status']<=0){ $bgcolor="#000000"; }
                            ?>
                            <tr align="left" valign="middle" bgcolor="<?= $bgcolor ?>">
                                <td align="left"><?= date($Config['DateFormat'].' '.$Config['TimeFormat'],strtotime($values['CreatedDate'])); ?></td>
                                <td align="left"><?=stripslashes($values['Name']); ?></td>
                                <td align="left"><?= stripslashes($values['ProductSku']);?></td>
                               <td align="left"><?= (!empty($data)) ? (is_numeric($data['status'])) ? '<span style="color: red;">Failed</span>': $data['status'] : stripslashes($values['FeedProcessingStatus']); ?></td>
                               <td align="left"><?=($values['ProductSku'])?'New Listing':'Item(s)';?></td>
                                <td align="left"><?= (!empty($data['feedmsg']))? stripslashes($data['feedmsg']) : stripslashes($values['FeedProcessingSMsg']);?></td>
							</tr>
                        <?php } // foreach end // 
                            if($status>0) header('Location: '.$_SERVER['REQUEST_URI']);
                            ?>

                    <?php } else { ?>
                        <tr >
                            <td  colspan="9" class="no_record">No products found.</td>
                        </tr>

                    <?php } ?>



                    <tr >  
                    <td  colspan="9" >Total Product(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryEbay) > 0) { ?>
                                &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;  } ?>
                    </td>
                    </tr>
                </table>

                

                <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
            </form>
 
        </td>
    </tr>
</table>
