<?php
//_ini_loaded_file();
$Line=$_GET['line'];
?>
<script language="JavaScript1.2" type="text/javascript">
function ResetSearch(){	
	$("#prv_msg_div").show();
	$("#frmSrch").hide();
	$("#preview_div").hide();
}
//function SetCustCode(CustCode,CustId,creditnote){
function SetDate(line){
	//ResetSearch();
        
	/*window.parent.document.getElementById("CustomerCompany").value='';
	window.parent.document.getElementById("CustomerName").value='';
 	
	window.parent.document.getElementById("ShippingFax").value=responseText["sFax"];
	window.parent.document.getElementById("ShippingEmail").value=responseText["sEmail"];*/
        var td=document.getElementById("ToDate"+line).value;
        var fd=document.getElementById("FromDate"+line).value;
        
        //if(document.getElementById("ToDate"+line)!=null && document.getElementById("FromDate"+line)!=null){
        if(document.getElementById("ToDate"+line).value != '' && document.getElementById("FromDate"+line).value != ''){  
            if(fd <td){
                //window.opener.document.getElementById("PFromDate"+line).value=td;	alert(td);
                window.parent.document.getElementById("PFromDate"+line).value=fd;
                window.parent.document.getElementById("PToDate"+line).value=td;
                window.parent.document.getElementById("PDateDiv"+line).style.display="block";
                $("#PDateDiv"+line, window.parent.document).parent('div').show();
                //window.parent.document.getElementsByClassName("FTdate").style.display="block";
                window.parent.$.fancybox.close();
                return true;
            }else{
                alert("The To date should be grater then From date.");
                return false;
            }
        }else{
            alert("Pleas enter date.");
            return false;
        }

	//parent.ProcessTotal();
	/************************************
        parent.jQuery.fancybox.close();
        ShowHideLoader('1','P');*/

}




</script>

<div class="had">Select Date</div>
<!--TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
<tr>
    <td align="right" valign="bottom">

        <!--<form name="frmSrch" id="frmSrch" action="CustomerList.php" method="get" onSubmit="return ResetSearch();">
        <input type="text" name="key" id="key" placeholder="<?=SEARCH_KEYWORD?>" class="textbox" size="20" maxlength="30" value="<?=$_GET['key']?>">&nbsp;<input type="submit" name="sbt" value="Go" class="search_button">
        <input type="hidden" name="link" id="link" value="<?=$_GET['link']?>">
        </form>
    </td>
</tr>
	 
<tr>
    <td  valign="top" height="400"-->
	
    <form action="" method="post" name="form1">

       <table  style=" margin-top:20px;" cellspacing="1" cellpadding="3" align="center" border="1" width="100%">
            <tr align="left"  >
                <td  align="right" class="blackbold">From Date:<span class="red">*</span></td>
                <td  align="left" class="blacknormal">

                    <input id="FromDate<?=$Line?>" name="FromDate<?=$Line?>" readonly="" class="datebox" value=""  type="text" required="">
                        <script type="text/javascript">
                                $(function() {
                                        $('#FromDate'+<?=$Line?>).datepicker(
                                                {
                                                showOn: "both",
                                                //yearRange: '<?=date("Y")+10?>:<?=date("Y")?>', 
                                                //maxDate: "-1D", 
                                                dateFormat: 'yy-mm-dd',
                                                changeMonth: true,
                                                changeYear: true,
                                                minDate:'0d'

                                                }
                                        );
                                        });
                        </script>
                        <div class="red" id="FromDateerr" style="margin-left:5px;"></div>
                </td>
            </tr>
            <tr>
                <td  align="right"   class="blackbold">To Date:<span class="red">*</span></td>
                <td  align="left" class="blacknormal">

                    <input id="ToDate<?=$Line?>" name="ToDate<?=$Line?>" readonly="" class="datebox" value=""  type="text" required=""> 
                        <script type="text/javascript">
                                    $(function() {
                                    $('#ToDate'+<?=$Line?>).datepicker(
                                            {
                                            showOn: "both",
                                            //yearRange: '<?=date("Y")+50?>:<?=date("Y")?>', 
                                            //maxDate: "-1D", 
                                            dateFormat: 'yy-mm-dd',
                                            changeMonth: true,
                                            changeYear: true,
                                            minDate:'0d'

                                            }
                                    );
                                    });
                        </script>
                    <div class="red" id="ToDateerr" style="margin-left:5px;"></div>
                </td>
            </tr>

            <tr align="center" >
              <!--td  colspan="2" class="no_record"><?//=NO_CUSTOMER?></td-->
                <td  colspan="2">
                <!--<a href="Javascript:void(0)" onMouseover="ddrivetip('<?//=CLICK_TO_SELECT?>', '','')"; onMouseout="hideddrivetip()" onclick="Javascript:SetCustCode('<?=$values["CustCode"]?>','<?=$values["Cid"]?>','<?=$_GET['creditnote']?>');"><?=$values["CustCode"]?></a-->
                <a href="Javascript:void(0)" onclick="Javascript:SetDate(<?=$Line?>);">OK</a></td>
            </tr>

        </table>
   
    </form>
    <!--/td>
</tr>
</table-->
