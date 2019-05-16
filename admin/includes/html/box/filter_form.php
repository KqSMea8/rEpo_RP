<script language="JavaScript1.2" type="text/javascript">
    function validateFilter(frm) {

        var NotNUll = 0;


        if (ValidateForSimpleBlank(frm.viewName, "View Name")) {

            /*
             for(var j =1; j <= 5; j++){   //change here
             if(document.getElementById("column"+J).value != ''){
             NotNUll++;
             break;
             }
             
             }
             
             if(NotNUll == 0){
             alert('Please Select at least one Column');
             return false;
             }
             */
            if (document.getElementById("column1").value == '' && document.getElementById("column2").value == '' && document.getElementById("column3").value == '' && document.getElementById("column4").value == '' && document.getElementById("column5").value == '') {
                alert('Please Select at least one Column');
                return false;
            }

            for (var i = 1; i <= 5; i++) {

                if (document.getElementById("fcol" + i).value != '' || document.getElementById("fop" + i).value != '' || document.getElementById("fval" + i).value != '') {
                    if (document.getElementById("fcol" + i).value == '') {
                        alert("Please select Column.");
                        document.getElementById("fcol" + i).focus();
                        return false;
                    }
                    if (document.getElementById("fop" + i).value == '') {
                        alert("Please select Condition.");
                        document.getElementById("fop" + i).focus();
                        return false;
                    }


                    if (document.getElementById("fval" + i).value == '') {
                        alert("Please Enter value.");
                        document.getElementById("fval" + i).focus();
                        return false;
                    }
                }

            }




//var Url = "isRecordExists.php?FilterName="+escape(document.getElementById("viewName").value)+"&editID="+document.getElementById("cvid").value+"&Type=Ticket";
            //SendExistRequest(Url,"viewName", "View Name");




            ShowHideLoader('1', 'S');
            return true;

        } else {
            return false;
        }


    }

    function checkDuplicate()
    {

        var cvselect_array = new Array('column1', 'column2', 'column3', 'column4', 'column5','column6');     //change here

        var duplicate = 0;
        for (var i = 0; i < cvselect_array.length; i++) {
            for (var r = 0; r < cvselect_array.length; r++) {
                if (i != r) {
                    if (document.getElementById(cvselect_array[i]).value == document.getElementById(cvselect_array[r]).value && document.getElementById(cvselect_array[i]).value != '') {
                        document.getElementById(cvselect_array[r]).value = '';
                        duplicate = 1;
                        break;
                    }
                }
            }

            if (duplicate == 1)
                break;
        }



        if (duplicate == 1) {
            alert("Column Contain Duplicate value.Please select another column");
            return false;
            //hidden
        }


    }

 //By Chetan4Aug//
   
    $(function() {
        
        $('select[name="fcol[]"]').change(function(){
            $op = $.trim($(this).find("option:selected").attr('data-type'));
            if($op=="date")
            {
                showCalender($(this));
            }else{
                removeCalender($(this));
            } 
        })
        
        $('select[name="fcol[]"]').each(function(){
        
            $op = $.trim($(this).find("option:selected").text());
            if(jQuery.inArray($op,arr)!=-1)
            {
                showCalender($(this));
            }
        })
        
    });
    
    function showCalender(obj)
    {


        $id = obj.attr('id');
        $index = $id.match(/[0-9]+/);
        $("#fval"+$index).datepicker({
            showOn: "both",
            yearRange: '<?= date("Y") ?>:<?= date("Y") + 20 ?>',
            dateFormat: 'yy-mm-dd',
            maxDate: "",
            minDate:"",
            changeMonth: true,
            changeYear: true

        });
    }
    
    function removeCalender(obj)
    {
        $id = obj.attr('id');
        $index = $id.match(/[0-9]+/);
        $("#fval"+$index).datepicker("destroy");
    }    
    
    //End//  
</script>

<? //echo $MainModuleID; ?>
<div id="prv_msg_div" style="display:none;margin-top:50px;"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div">

    <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
        <form name="form1" action=""  method="post" onSubmit="return validateFilter(this);" enctype="multipart/form-data">


            <tr>
                <td  align="center" valign="top"  >


                    <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

                        <tr>
                            <td colspan="4" align="left"    class="head">Details  </td>
                        </tr>

                        <tr>
                            <td  align="right" colspan="4"   >

                        <tr>
                            <td colspan="4"  width="100%">
                                <table width="100%" border="0" cellpadding="4" cellspacing="0">
                                    <tr>
                                        <td  align="right" width="10%">View Name:<span class="red">*</span>
                                        </td>
                                        <td  width="30%">
                                            <input class="inputbox" name="viewName" id="viewName" value="<?= stripslashes($arryTicketfilter[0]['viewname']) ?>" onfocus="this.className = 'inputbox'" onblur="this.className = 'inputbox'" size="40" type="text">
                                        </td>
                                        <td  width="20%">
                                            <input name="setDefault" id="setDefault" <? if ($arryTicketfilter[0]['setdefault'] == 1) echo "checked"; ?>   value="1" type="checkbox">Set as Default
                                        </td>
                                        <!--td  width="20%">
                                            <input name="setMetrics" <? if ($arryTicketfilter[0]['setmetrics'] == 0) echo "checked"; ?> value="0" type="checkbox">List in Metrics.
                                        </td-->
                                        <td  >
                                            <input name="setStatus" <? if ($arryTicketfilter[0]['status'] == 1) echo "checked"; ?> value="1" type="checkbox">
                                            Set as Public
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr><td colspan="4">&nbsp;</td></tr>
                        <tr>
                            <td colspan="4" class="head">
                                Choose Columns
                            </td>
                        </tr>
                        <tr >

                            <?
                            echo '<td colspan="4">';


                            for ($i = 1; $i < 7; $i++) {
                                echo '<select name="column' . $i . '" id="column' . $i . '" onchange="checkDuplicate();" style="margin: 10px;" class="inputbox">';
                                echo '<option value="">None</option>';
                                echo '<optgroup label="' . ucfirst($_GET['type']) . '  Information" class="inputbox" >';


 
                                for ($j = 1; $j <= sizeof($column); $j++) {

                                   
                                    $columnHead = $column[$j - 1]["colum_name"] . ':' . $column[$j-1]["table_name"] . ':' . $column[$j - 1]["colum_value"] . '';

				    $sel='';
				    if(!empty($arryColVal[$i - 1]['colvalue'])){
                                    	$sel = ($column[$j - 1]["colum_value"] == $arryColVal[$i - 1]['colvalue']) ? ('selected') : ('');
				    }
                                    echo '<option value="' . $columnHead . '" ' . $sel . '>' . $column[$j - 1]["colum_name"] . '</option>';
                                }
                                echo '</optgroup></select>';
                                echo "&nbsp";
                                echo "&nbsp";
			 
				
                            }
                            echo "</td>";
                            ?>

                        </tr>
                        <tr><td colspan="4">&nbsp;</td></tr>
                        <tr ><td colspan="4">

                                <div id="mnuTab2" style="display:block">
                                    <table class="borderall" width="100%" cellpadding="5" cellspacing="0">

                                        <tr>
                                            <td>
                                                <table align="center" width="100%" border="0" cellpadding="5" cellspacing="0">
                                                    <tr><td colspan="3" class="head"><b>RULE</b></td></tr>

                                                    <tr >
                                                        <?
 

                                                        echo '<td colspan="4" >';

                                                        echo '<div >';
                                                        for ($i = 1; $i <= 5; $i++) {



                                                            echo '<select name="fcol[]" style="margin: 10px;" id="fcol' . $i . '"  class="inputbox">';
                                                            echo '<option value="" >None</option>';
                                                            echo '<optgroup label="' . ucfirst($_GET['type']) . ' Information" class="inputbox" >';
                                                            foreach ($column as $key => $arr) {
                                                                //for($j=1;$j<=sizeof($column);$j++){
                                                                //if($column[$j]["colum_value"]==$arryQuery[$i-1]['columnname']){ $selRule = "selected";}

								$selRule='';
								if(!empty($arryQuery[$i - 1]['columnname'])){
                                                                	$selRule = ($arr["colum_value"] == $arryQuery[$i - 1]['columnname']) ? ('selected') : ('');
								}

                                                                $RuleCondition = $arr["colum_name"] . ':' . $arr["table_name"] . ':' . $arr["colum_value"] . '';



				$column_type = (!empty($arr["column_type"]))?($arr["column_type"]):("");


                                                                echo '<option data-type ="' . $column_type . '" value="' . $RuleCondition . '" ' . $selRule . '>' . $arr["colum_name"] . '  </option>', PHP_EOL;
                                                            }
                                                            echo '</optgroup></select>';
                                                            echo "&nbsp";

 
$comparatorQry = (!empty($arryQuery[$i - 1]['comparator']))?($arryQuery[$i - 1]['comparator']):("");
                                                            ?>
                                                        <select name="fop[]" id="fop<?= $i ?>" class="inputbox">
                                                            <option value="">None</option>
                                                            <option value="e" <?= ($comparatorQry == 'e') ? ('selected') : ('') ?>>equal to</option>
                                                            <option value="n" <?= ($comparatorQry == 'n') ? ('selected') : ('') ?>>Not equal to</option>
                                                            <option value="l" <?= ($comparatorQry == 'l') ? ('selected') : ('') ?>>Less than</option>
                                                            <option value="g" <?= ($comparatorQry == 'g') ? ('selected') : ('') ?>>Greater than</option>
                                                            <option value="in" <?= ($comparatorQry == 'in') ? ('selected') : ('') ?>>In (..)</option>

                                                        </select>
                                                        <?
$columnnameQry = (!empty($arryQuery[$i - 1]['columnname']))?($arryQuery[$i - 1]['columnname']):("");

                        if ($columnnameQry == 'AssignedTo' || $columnnameQry == 'AssignTo' || $columnnameQry == 'assignTo' || $columnnameQry == 'assignedTo' || $columnnameQry == 'created_id' ) {

                                                            $EmpName = $objFilter->RuleEmp($arryQuery[$i - 1]['value']);
                            $arryQueryColValue = $EmpName;
                        } else {
                            

				$arryQueryColValue = (!empty($arryQuery[$i - 1]['value']))?($arryQuery[$i - 1]['value']):("");
                        }
                        ?>
                &nbsp; <input name="fval[]" id="fval<?= $i ?>" size="30" maxlength="80" value="<?= $arryQueryColValue ?>" class="inputbox" type="text">

                                                        <?
                                                        echo "<br>";
                                                    }

                                                    echo '</div>';
                                                    ?>

                                                    </td>
                                                    </tr>

                                                </table>
                                            </td></tr>
                                        <tr><td>&nbsp;</td></tr>
                                    </table>
                                </div>
                            </td></tr>
                    </table>
                </td></tr>








    </table>








</td>
</tr>



<tr>
    <td  align="center" valign="top">

        <div id="SubmitDiv" align="center" style="display:none1">

            <?
            if ($_GET['edit'] > 0)
                $ButtonTitle = 'Update ';
            else
                $ButtonTitle = ' Save ';
            ?>

            <!--input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?= $ButtonTitle ?> "  /-->
            <input   class="button" name="button2" value="<?= $ButtonTitle ?>"  type="submit">
            <input   class="button" name="button2" onclick="window.history.back();" value="Cancel"  type="button">
            <input type="hidden" name="ModuleType" id="ModuleType" value="<?= $_GET['type'] ?>" />
            <input type="hidden" name="cvid" id="cvid" value="<?= $_GET['edit'] ?>" />

        </div>

    </td>
</tr>
</form>
</table>

</div>
