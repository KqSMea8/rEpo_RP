<style>.inputbox {
        display: block;
        width: 100px;
    }
   
    input.inputbox {
        display: inline-block;
    }
    
.searchBox {
    margin-bottom: 10px;
        margin-top:25px;
}
</style>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<div class="had">Manage Customer</div>


<div class="mid-continent" id="inner_mid" style="text-align: center; margin-left: 10%; width: 80%;">	    
        <tr>
        <div><a href="index.php" class="back" >Back</a></div>
           <td valign="top">
               <div id="preview_div">
                        <div class="searchBox" >
                            <?php if (!empty($_GET['type'])) { ?>
                            <a class="back" style="float: right; background-color:#3498db !important;" href="customerList.php" >Clear Search</a>
                            <?php } ?>
                            <label class="head1">Search By</label>
                            <select id="searchBy" >
                                <option value="none" >Select</option>
                                <option value="nameSearch" >Name</option>
                                <option value="emailSearch" >Email</option>
                               <!-- <option value="companySearch" >Company</option>-->
                                 <option value="createdDateSearch" >Registered Date</option>
                            </select>

                            <table>
                                <tr id="nameSearch" class="filterByTr" style="display: none" >
                                    <td>
                                        <fieldset>
                                            <form action="" name="form1" class="searchForm" >
                                                <label>Search By Name</label>
                                                <input type="text" class="inputbox keyword" name="keyword">
                                                <input type="hidden" readonly="readonly" class="inputbox" name="type" value="byName">
                                                <input type="submit" class="button" name="searchButton" value="Search">
                                            </form>
                                        </fieldset></td>
                                </tr>
                                <tr id="emailSearch" class="filterByTr" style="display: none" >
                                    <td>
                                        <fieldset>
                                            <form action=""  name="form2" class="searchForm"  >
                                                <label>Search By Email</label>
                                                <input type="text" class="inputbox keyword" name="keyword">
                                                <input type="hidden" readonly="readonly"class="inputbox" name="type" value="byEmail">
                                                <input type="submit" class="button" name="searchButton" value="Search">
                                            </form>
                                        </fieldset></td>
                                </tr>
                               <!-- <tr id="companySearch" class="filterByTr" style="display: none" >
                                    <td>
                                        <fieldset>
                                            <form action="" name="form3" class="searchForm"  >
                                                <label>Search By Company</label>
                                                <input type="text" class=" inputbox keyword"  name="keyword">
                                                <input type="hidden" readonly="readonly" class="inputbox" name="type" value="byCompany">
                                                <input type="submit" class="button" name="searchButton" value="Search">
                                            </form>
                                        </fieldset></td>
                                </tr>-->
                                <tr id="createdDateSearch" class="filterByTr" style="display: none" >
                                    <td>
                                        <fieldset>
                                            <form action=""  name="form4" class="searchForm"  >
                                                <label>Search By Registered Date</label>
                                                <input type="text" class="datepicker inputbox keyword" readonly="true" name="keyword">
                                                <input type="hidden" readonly="readonly" class="inputbox" name="type" value="byRegisteredDate"> 
                                                <input type="submit" class="button" name="searchButton" value="Search">
                                            </form>
                                        </fieldset></td>
                                </tr>
                            </table>
                            </form>
                        </div>
                        <table <?= $table_bg ?>>

                            <tr align="left">
                                
                                <td width="5%" class="head1">S.N</td>                             
                                <td width="15%" class="head1">Name</td>
                                <td class="head1" width="8%">Email</td>
                                <td width="15%" class="head1">Telephone</td>
                                <td width="8%" class="head1">State</td>
                                <td width="8%" class="head1">City</td>
                                <td width="6%" class="head1">ZipCode</td>
                                <td width="6%" class="head1">Company Code</td>
                                <td width="8%" class="head1">Registered Date</td>
                                
                                
                                
                            </tr>

                            <?php
                           
                            
                            if (is_array($arryCustomer)&& $num > 0 ) {
                             
                                $flag = true;
                                $Line = 0;
                                $sn = 0;
                                foreach ($arryCustomer as $key => $values) {
                                
                                    $values = get_object_vars($values);
                                    $flag = !$flag;
                                    #$bgcolor=($flag)?("#FDFBFB"):("");
                                    $Line++;
                             
                                    ?>
                                    <tr align="left" bgcolor="<?= $bgcolor ?>" data-id="<?= $values['id'] ?>"  data-status="<?= $values['status']; ?>" >
                                          
                                        <td ><?= ++$sn; ?></td>
                                                <td height="50" ><?php echo $values["firstName"] . " " . $values["lastName"] ?> </td>
                                                <td><?php echo '<a href="mailto:' . $values['username'] . '">' . $values['username'] . '</a>'; ?></td>
                                                <td><?= $values["phone"]; ?></td>
                                                <td><?= $values["state"]; ?></td>
                                                <td><?= $values["city"]; ?></td>
                                                <td><?= $values["zipCode"]; ?></td>
                                                 <td><?= $values["company_code"]; ?></td>
                                                <td><?php $data = new DateTime($values["recordInsertedDate"]);
                                                   echo $data->format('d-M-Y');?></td>
                                  
                                    </tr>
                                <?php } // foreach end //     ?>

                            <?php } else { ?>
                                <tr align="center">
                                    <td colspan="10" class="no_record">No record found.</td>
                                </tr>
                            <?php } ?>

                            <tr>
                                <td colspan="9">Total Record(s) : &nbsp;<?php echo $num; ?> <?php if (count($arryCustomer) > 0) { ?>
                                        &nbsp;&nbsp;&nbsp; Page(s) :&nbsp; <?php
                                        echo $pagerLink;
                                    }
                                    ?></td>
                            </tr>
                            
                            
                        </table>

                    </div>
                     <input type="hidden" name="CurrentPage" id="CurrentPage"
                                   value="<?php echo $_GET['curP']; ?>"> <input type="hidden" name="opt"
                                   id="opt" value="<?php echo $ModuleName; ?>">
                    </td>
                    </tr>
                    </table>
                </div>
            <script>
                    
                    $("#searchBy").change(function () {
                        var showId = $("#searchBy").val();
                        
                        $(".filterByTr").hide();
                        $("#" + showId).show();
                    });
                    $(".searchForm").submit(function (e) {
                        var keyword = $(this).find(".keyword").val();
                        
                        
                        if (keyword == '') {
                            alert("Please enter search keyword");
                            e.preventDefault();
                        }
                    });
                </script>
                <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
                <script>
                    $(function () {
                        $(".datepicker").datepicker({dateFormat: 'yy-mm-dd'});
                    });
                </script>    