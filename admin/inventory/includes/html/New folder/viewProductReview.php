<div class="had">Manage Reviews</div>

<table width="98%"   border=0 align="center" cellpadding=0 cellspacing=0 >

    <tr>
        <td>
            <div class="message"><? if (!empty($_SESSION['mess_Review'])) {  echo stripslashes($_SESSION['mess_Review']);   unset($_SESSION['mess_Review']);} ?></div>
            <table <?= $table_bg ?>>
                <tr align="left" >
                <td width="50%" height="20"  class="head1">Review Title</td> 
                <td width="10%" height="20"  class="head1" align="center">Product Sku</td> 
                <td width="10%" height="20"  class="head1" align="center">Rating</td>
                <td width="10%" height="20"  class="head1" align="center">Reviewer</td>
                <td  width="10%" height="20"  class="head1" align="center">Status</td>
                <td width="5%"   height="20" align="right" class="head1">Action&nbsp;&nbsp;</td>
                </tr>
                <?php
                
                $pagerLink = $objPager->getPager($arryReviews, $RecordsPerPage, $_GET['curP']);
                (count($arryShipingMethod) > 0) ? ($arryReviews = $objPager->getPageRecords()) : ("");
                if (is_array($arryReviews) && $num > 0) {
                    $flag = true;
                   $reviewCount = 1;
                    foreach ($arryReviews as $key => $values) {
                        
                         if($values['Rating'] == "1"){ 
                             $width =  "12px"; 
                             
                             }
                           else if($values['Rating'] == "2"){ 
                             $width =  "24px"; 
                             
                             }
                           else if($values['Rating'] == "3"){ 
                             $width =  "36px"; 
                             
                             }
                           else if($values['Rating'] == "4"){ 
                             $width =  "48px"; 
                             
                             }
                           else if($values['Rating'] == "5"){ 
                             $width =  "60px"; 
                             
                             }
                            else{
                               $width =  "0px";   
                             }
                        ?>
               
                        <tr align="left"  bgcolor="<?= $bgcolor ?>">
                            <td height="26">
                              <?=stripslashes($values['ReviewTitle']);?> <br> <a class="readDescription" href="javascript:void();" alt="<?=$reviewCount?>">(Read Description)</a>
                              <div id="showReview_<?=$reviewCount;?>" class="showReview" style="display: none;"><?=stripslashes($values['ReviewText']);?></div>
                            </td>
                             <td height="26" align="center"><?= $values['ProductSku'];?>     </td>
                             <td height="26" align="center"><div class="gray_Star"><div class="red_Star" style="width:<?=$width;?>"></div></div>     </td>
                               <td height="26" align="center"><?= $values['email'];?>     </td>
                             <td align="center" ><?
                                            if ($values['Status'] == "Yes") {
                                                $status = 'Active';
                                            } else {
                                                $status = 'InActive';
                                            }


                                            echo '<a href="viewProductReview.php?active_id=' . $values["ReviewId"] . '&curP=' . $_GET["curP"] . '" class="'.$status.'">' . $status . '</a>';
                                            ?>
                            </td>
                            <td height="26" align="right"  valign="top">
                                    <a href="viewProductReview.php?del_id=<?php echo $values['ReviewId']; ?>&curP=<?php echo $_GET['curP']; ?>" onclick="return confDel('review')" class="Blue" ><?= $delete ?></a>              
                                &nbsp;
                            </td>
                        </tr>
                    <?php $reviewCount = $reviewCount+1;} // foreach end //?>
                <?php } else { ?>
                    <tr align="center" >
                        <td height="20" colspan="6"  class="no_record">No Review found. </td>
                    </tr>
                <?php } ?>

                <tr >  <td height="20" colspan="6" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryShipingMethod) > 0) { ?>
                            &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
                }
                ?></td>
                </tr>
            </table></td>
    </tr>


</table>
<style>
 .showReview{background: none repeat scroll 0 0 #FFFFFF;    border: 1px solid #DDDDDD;    box-shadow: 2px 1px 13px #888888;    display: block;    padding: 10px;    position: absolute;
    width: 473px;}  
 .gray_Star{background: url("../images/small_star.png") repeat-x scroll 0 0 transparent;height: 16px; text-align: left;width: 60px;}
 .red_Star{background: url("../images/small_star.png") repeat-x scroll 0 -18px transparent;height: 16px;width: 0px;}
    
</style>

 <?include("includes/html/box/read_review.php");?>

<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
   $(".readDescription").hover(function(){   

    var readDescriptionId = $(this).attr('alt');
    $("#showReview_"+readDescriptionId).slideToggle();
    

   });
  }); 
  </script>