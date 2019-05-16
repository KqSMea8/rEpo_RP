<? if($_GET['pop']!=1){ ?>
    <a href="<?= $RedirectURL ?>" class="back">Back</a>
    <div class="had">
        <?= $MainModuleName ?>  <span>&raquo; <?= $ModuleName ?></span>
        <!--code start  by sachin-->

<?
/*********************/
$ModuleDepName = "SalesRMA";
$module = "RMA"; 
$PdfFolder = $Config['S_Rma'];
 
/********************/
$PdfResArray = GetPdfLinks(array('Module' => $module,  'ModuleID' => $arrySale[0]["ReturnID"], 'ModuleDepName' => $ModuleDepName, 'OrderID' => $arrySale[0]['OrderID'], 'PdfFolder' => $PdfFolder, 'PdfFile' => $arrySale[0]['PdfFile']));
/********************/
 

if(!empty($GetDefPFdTempNameArray)){
	$PdfTmpArray = GetPdfLinks(array('Module' => $module,  'ModuleID' => $arrySale[0]["ReturnID"], 'ModuleDepName' => $ModuleDepName, 'OrderID' => $arrySale[0]['OrderID'], 'PdfFolder' => $PdfFolder, 'TemplateID'=> $GetDefPFdTempNameArray[0]['id'], 'PdfFile' => $GetDefPFdTempNameArray[0]['PdfFile'] ));		 
	$DefaultDwnUrl = $PdfTmpArray['DownloadUrl'];
//End//
}else{

	$DefaultDwnUrl = $PdfResArray['DownloadUrl'];
}  

/*********************/

?>



        <ul class="editpdf_menu">
            <li>
                <a href="<?= $DefaultDwnUrl ?>" target="_blank" class="download" style="float:right;margin-left:5px;">Download</a>
                <ul>
                    <?php
                    echo '<li><a class="editpdf download" href="' . $DefaultDwnUrl . '">Default</a></li>';
                    if (sizeof($GetPFdTempalteNameArray) > 0) {
                        foreach ($GetPFdTempalteNameArray as $tempnmval) {
							/*to download template files16Apr2018*/
						/*$TempPdfFile = $ModuleDepName.'-'.$arrySale[0]['ReturnID'].'-temp'.$tempnmval['id'].'.pdf';
						$tempfileexist = file_exists($PdfDir.$TempPdfFile);
						$TempDwnUrl = $DownloadUrl.'&tempid='.$tempnmval['id'];
						if($tempfileexist == 1){
							$TempDwnUrl = 'dwn.php?file='.$PdfFolder.$TempPdfFile.'&dtype=p';
						}*/
					$PdfTmpsArray = GetPdfLinks(array('Module' => $module,  'ModuleID' => $arrySale[0]["ReturnID"], 'ModuleDepName' => $ModuleDepName, 'OrderID' => $arrySale[0]['OrderID'], 'PdfFolder' => $PdfFolder, 'TemplateID'=> $tempnmval['id'] , 'PdfFile' => $tempnmval['PdfFile']));
					$TempDwnUrl = $PdfTmpsArray['DownloadUrl'];

                            echo '<li><a class="editpdf download" href="' . $TempDwnUrl . '">' . $tempnmval['TemplateName'] . '</a></li>';
                        }
                    }
                    ?>

                </ul>
            </li>
        </ul>
        <!--code end by sachin -->
        
        <!--<input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/>-->
        <!--<a href="<?= $DownloadUrl ?>" target="_blank" class="download" style="float:right;margin-left:5px;">Download</a>-->
        <!--code for dynamic pdf by sachin-->
        <ul class="editpdf_menu">
           <li><a class="edit" href="javascript:void(0)">Edit PDF</a>
              <ul>
                  <?php 

                  echo '<li><a class="add" href="../editcustompdf.php?curP='.$_GET['curP'].'&view='.$_GET["view"].'&ModuleDepName='.$ModuleDepName.'&rtn='.$_GET["rtn"].'&Module='.$Module.'">Add PDF Template</a></li>';
                  if(sizeof($GetPFdTempalteNameArray)>0) { 
                      foreach($GetPFdTempalteNameArray as $tempnmval){
                         echo '<li>';
         if($tempnmval['AdminID']==$_SESSION['AdminID']){
                          echo '<a class="delete" href="../editcustompdf.php?curP='.$_GET['curP'].'&view='.$_GET["view"].'&Deltempid='.$tempnmval['id'].'&ModuleDepName='.$ModuleDepName.'&rtn='.$_GET["rtn"].'"></a>';
                          }

                          echo '<a class="edit editpdf" href="../editcustompdf.php?curP='.$_GET['curP'].'&view='.$_GET["view"].'&tempid='.$tempnmval['id'].'&ModuleDepName='.$ModuleDepName.'">'.$tempnmval['TemplateName'].'</a></li>';
                      }
                  }
                  ?>

              </ul>
          </li>                               
      </ul>

      <ul class="editpdf_menu">
       <?php 
 
       echo '<li><a target="_blank" class="edit" href="'.$PdfResArray['PrintUrl'].'">Print</a>
   </li>';
 
   ?>
</ul>
<!--code for dynamic pdf sachin-->
</div>
<? } ?>
<? if (!empty($errMsg)) {?>
    <div align="center"  class="red"><?= $errMsg ?></div>
    <? } ?>
    <div class="message" align="center"><?  if (!empty($_SESSION['mess_Sale'])) {  echo $_SESSION['mess_Sale'];   unset($_SESSION['mess_Sale']);  } ?></div>
    <?
    if(!empty($ErrorMSG)){
        echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
    }else{

        ?>


        <form name="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">

            <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="left">

                        <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
                            <tr>
                                <td colspan="4" align="left" class="head">RMA Information</td>
                            </tr>
                            <tr>
                                <td  align="right"   class="blackbold" width="20%"> RMA No# : </td>
                                <td align="left" width="30%"> <?= $arrySale[0]['ReturnID']; ?></td>

                                <td  align="right"   class="blackbold" width="20%">Item RMA Date  :</td>
                                <td   align="left" >
                                    <?= ($arrySale[0]['ReturnDate'] > 0) ? (date($Config['DateFormat'], strtotime($arrySale[0]['ReturnDate']))) : (NOT_SPECIFIED) ?>




                                </td>
                            </tr>

                            <tr>
                        <!--td  align="right"   class="blackbold" valign="top"> Return Amount Paid  : </td>
                        <td   align="left" valign="top">
                            <?php
                            if ($arrySale[0]['ReturnPaid'] == "Yes") {
                                echo "Yes";
                            } else {
                                echo "No";
                            }
                            ?>
                        </td-->

                        <td  align="right" class="blackbold" valign="top"> Comments  : </td>
                        <td align="left" valign="top">
                            <?php echo stripslashes($arrySale[0]['ReturnComment']); ?>
                        </td>

                        <td  align="right"   class="blackbold"  >RMA Expiry Date:</td>
                        <td   align="left" >
                            <?= ($arrySale[0]['ExpiryDate'] > 0) ? (date($Config['DateFormat'], strtotime($arrySale[0]['ExpiryDate']))) : (NOT_SPECIFIED) ?>




                        </td>
                    </tr>

                    <tr>


                        <td  align="right" class="blackbold"> Re-Stocking : </td>
                        <td align="left">
                            <? if($arrySale[0]['ReSt']==1){echo "Yes";}else{echo "No";};?>

                        </td>


                    </tr>


                </table>

            </td>
        </tr>
        <tr>
            <td align="left"><? include("includes/html/box/rma_order_view.php");?></td>
        </tr>
<tr>
	<td align="left">
	<?
	$arryShipStand['ModuleType'] = 'SalesRMA';
	$arryShipStand['RefID'] = $OrderID; 
	include("../includes/html/box/shipping_info_standalone.php");
	?>
	</td>
</tr>

        <tr>
            <td>

                <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >
                    <tr>
                        <td align="left" valign="top" width="50%" class="borderpo"><? include("includes/html/box/sale_order_billto_view.php");?></td>
                        <td width="1%"></td>
                        <td align="left" valign="top" class="borderpo"><? include("includes/html/box/sale_order_shipto_view.php");?></td>
                    </tr>
                </table>

            </td>
        </tr>


        <tr>
            <td align="right">
                <?php
                $Currency = (!empty($arrySale[0]['CustomerCurrency'])) ? ($arrySale[0]['CustomerCurrency']) : ($Config['Currency']);

                echo $CurrencyInfo = str_replace("[Currency]", $Currency, CURRENCY_INFO);
                ?>	 
            </td>
        </tr>


        <tr>
            <td  align="center" valign="top" >


                <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">



                    <tr>
                        <td  align="left" class="head" >Line Item

                            <script language="JavaScript1.2" type="text/javascript">

                                $(document).ready(function () {
                                    $(".fancybox").fancybox({
                                        'width': 900
                                    });

                                });

                            </script>



                        </td>
                    </tr>

                    <tr>
                        <td align="left" >
                            <?php include("includes/html/box/so_item_rma_view_list.php"); ?>
                        </td>
                    </tr>

                </table>	


            </td>
        </tr>



        <tr>
            <td  align="center">

                <? if($HideSubmit!=1){ ?>	
                    <input name="Submit" type="submit" class="button" id="SubmitButton" value="Process"  />
                    <? } ?>
                    <?php if (empty($_GET['rtn'])) { ?>
                        <input type="hidden" name="ReturnOrderID" id="ReturnOrderID" value="<?= $_GET['edit'] ?>" readonly />
                        <?php } ?>
                        <input type="hidden" name="OrderID" id="OrderID" value="<?= $_GET['edit'] ?>" readonly />


                    </td>
                </tr>

            </table>

        </form>

        <? } ?>



