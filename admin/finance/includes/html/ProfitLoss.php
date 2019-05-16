<script language="JavaScript1.2" type="text/javascript">
    function ValidateSearch() {
	ShowHideLoader('1','L');
       }


    function SetDate(str){
        if(str == "Specific Date") {
            	$(".specificdaterange").show();
	     	$(".monthlyyearly").hide();
        }else if(str == "Monthly") {
		$(".specificdaterange").hide()
		$(".monthlyyearly").show();
	}else{
            	$(".specificdaterange").hide();
	    	$(".monthlyyearly").hide();
        }
    }




</script>



<input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/>

 
<input type="button" onclick="Javascript:window.location = 'export_profit_loss.php?<?=$QueryString?>';" value="Export To Excel" name="exp" class="export_button">
 

<?php if (!empty($num7777)) { ?>
    <a href="<?= $EmailUrl ?>" target="_blank" class="fancybox fancybox.iframe email_button" style="float:right;margin-left:5px;">Email</a>

    <a href="<?= $DownloadUrl ?>" target="_blank" class="download" style="float:right;margin-left:5px;">Download</a>
    
<?php } ?>
<div class="had"><?= $MainModuleName ?> Report</div>

<div class="message" align="center">

    <? if(!empty($_SESSION['mess_report_email'])) {echo $_SESSION['mess_report_email']; unset($_SESSION['mess_report_email']); }?>
</div>


<table width="100%" border=0 align="center" cellpadding=0 cellspacing=0>
    <?php if ($num > 0) { ?>
        <tr>
            <td align="left" valign="top" >
                <form onsubmit="return ValidateSearch();" name="form3" method="get" action="">
                    <table cellspacing="0" cellpadding="0" border="0" style="margin:0" id="search_table" >
                        <tbody>
                            <tr>
                                <!--td align="left">Transaction Date:</td>
                                <td align="left">
<select onchange="Javascript: SetDate(this.value);" id="TransactionDate" class="textbox" name="TransactionDate">
	<option value="All" <?php if ($_GET['TransactionDate'] == "All") {
	echo "selected";
	} ?>>All</option>
	<option value="Today" <?php if ($_GET['TransactionDate'] == "Today") {
	echo "selected";
	} ?>>Today</option>
	<option value="Last Week" <?php if ($_GET['TransactionDate'] == "Last Week") {
	echo "selected";
	} ?>>Last Week</option>
	<option value="Last Month" <?php if ($_GET['TransactionDate'] == "Last Month") {
	echo "selected";
	} ?>>Last Month</option>
	<option value="Last Three Month" <?php if ($_GET['TransactionDate'] == "Last Three Month") {
	echo "selected";
	} ?>>Last Three Month</option>
	<option value="Specific Date" <?php if ($_GET['TransactionDate'] == "Specific Date") {
	echo "selected";
	} ?>>Specific Date</option>
	<option value="Monthly" <?php if ($_GET['TransactionDate'] == "Monthly") {
	echo "selected";
	} ?>>Monthly</option>
</select>
                                </td-->

                                <td>

                                    <!--table cellspacing="0" cellpadding="0" border="0" class="specificdaterange">
                                        <tr>
                                            <td align="left">From:</td>
                                            <td align="left">
    <?php
    if (!empty($_GET['FromDate']) && $SpecificDate == 1) {
        $FromDate = $_GET['FromDate'];
    }
    ?>
                                                <script type="text/javascript">
                                                    $(function () {
                                                        $('#FromDate').datepicker(
                                                                {
                                                                    showOn: "both", dateFormat: 'yy-mm-dd',
                                                                    yearRange: '<?= date("Y") - 30 ?>:<?= date("Y") + 30 ?>',
                                                                                        changeMonth: true,
                                                                                        changeYear: true

                                                                                    }
                                                                            );
                                                                            $("#FromDate").on("click", function () {
                                                                                $(this).val("");
                                                                            }
                                                                            );
                                                                        });
                                                </script>
                                                <input id="FromDate" name="FromDate" readonly="" value="<?= $FromDate ?>" class="inputbox" style="width: 120px;" type="text" maxlength="10" > 
                                            </td>


                                            <td align="left">To:</td>
    <?php
    if (!empty($_GET['ToDate']) && $SpecificDate == 1) {
        $ToDate = $_GET['ToDate'];
    }
    ?>
                                            <td> <script type="text/javascript">
                                                $(function () {
                                                    $('#ToDate').datepicker(
                                                            {
                                                                showOn: "both", dateFormat: 'yy-mm-dd',
                                                                yearRange: '<?= date("Y") - 30 ?>:<?= date("Y") + 30 ?>',
                                                                                    changeMonth: true,
                                                                                    changeYear: true

                                                                                }
                                                                        );
                                                                        $("#ToDate").on("click", function () {
                                                                            $(this).val("");
                                                                        }
                                                                        );

                                                                    });
                                                </script>
                                                <input id="ToDate" name="ToDate" readonly="" value="<?= $ToDate ?>" class="inputbox" style="width: 120px;" type="text" maxlength="10" > 
                                            </td>

                                        </tr>

                                    </table-->

				 



				<table cellspacing="0" cellpadding="0" border="0" class="monthlyyearly">
                                        <tr>
                                            <td align="left"><?=getMonths($_GET['m'],"m","textbox")?></td>
                                            <td align="left"><?=getYears($_GET['y'],"y","textbox")?></td>
					    <td  align="left"  style="display:none4"> 
				<select name="InvStatus" id="InvStatus" class="textbox">
				<option value="" > All </option>
				<option value="1" <?=($_GET['InvStatus']=='1')?('selected'):('')?>> Cash Only </option>
				</select>
				</td>
                                       </tr>
                                </table>


				<script language="JavaScript1.2" type="text/javascript">
				//SetDate('<?=$_GET["TransactionDate"]?>');
				</script>




                                </td>


                                <td>
                                    <input type="submit" value="Go" class="search_button" name="s">


                                </td>


                            </tr>


                        </tbody>
                    </table>
                </form>

            </td>
        </tr>
<?php } ?>
    <tr>
        <td  valign="top">&nbsp;</td>
    </tr>
    <tr>
        <td  valign="top">	
            <div id="prv_msg_div" style="display:none"><img src="<?= $MainPrefix ?>images/loading.gif">&nbsp;Searching..............</div>
            <div id="preview_div">
                <? include_once("includes/html/box/profit_loss_data.php"); ?>
            </div> 

        </td>
    </tr>
</table>
