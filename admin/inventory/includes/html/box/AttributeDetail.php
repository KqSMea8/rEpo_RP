

                                                    <tr>
                                                        <td colspan="2" align="right"> <a class="add" href="editItem.php?edit=<? echo $_GET['edit']; ?>&curP=<?php echo $_GET['curP']; ?>&CatID=<?= $_GET['CatID'] ?>&attID=<?= $attribute['paid']; ?>&tab=addattributes"> Add New Attribute  </a></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <table width="100%" cellspacing="1" cellpadding="3" align="center" id="list_table">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="head1">Attribute Name</td>
                                                                        <td class="head1">Priority</td>
                                                                        <td class="head1">Active</td>
                                                                        <td class="head1">Action</td>
                                                                    </tr>
    <?php if (count($AttributesArr) > 0) {
        foreach ($AttributesArr as $attribute) {
            ?>
                                                                            <tr valign="middle" bgcolor="#ffffff" align="left">
                                                                                <td><?= $attribute['name']; ?></td>
                                                                                <td><?= $attribute['priority']; ?></td>
                                                                                <td><?= $attribute['is_active']; ?></td>
                                                                                <td><a href="editItem.php?edit=<? echo $_GET['edit']; ?>&curP=<?php echo $_GET['curP']; ?>&CatID=<?= $_GET['CatID'] ?>&attID=<?= $attribute['paid']; ?>&tab=editattributes"><?= $edit ?></a>  <a href="javascript:void();" class="deleteProductAttribute" alt="<?=$_GET['edit'] . "#" . $attribute['paid'] ?>"><?= $delete ?></a>	</td>
                                                                            </tr>
                                                                            <?php
                                                                        }
                                                                    } else {
                                                                        ?>
                                                                        <tr valign="middle" bgcolor="#ffffff" align="left">
                                                                            <td class="no_record" colspan="5">No Attributes Found.</td>

                                                                        </tr>
    <?php } ?>
                                                                </tbody>
                                                            </table> 
                                                        </td>
                                                    </tr>

                                                    <!--tr>
                                                        <td colspan="2">
                                                            <div class="formItemComment dialog-add-attribute-help">
                                                                You are allowed to enter an unlimited number of attributes to any product. 
                                                                Attributes allow you to give your customer's choices for any product. 
                                                                Examples include size, color, or type. Each new selection must be entered on a new line for it to appear correctly. 
                                                                If the attribute is a price modifier, you need to tell the system to increase or decrease the price (+ or -) 
                                                                between parenthesis ( ) at the end of each attribute.You can also modify weight on an attribute by entering the increase or decrease after the price and separated by a comma. 
                                                                Examples below.<br><br>
                                                                <table cellspacing="0" cellpadding="0" width="100%" class="attribute-admin-list-table">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>Small(-25,-10)</td>
                                                                            <td>Decrease price by 25, decrease weight by 10</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Small(+25,+10)</td>
                                                                            <td>Increase price by 25, Increase weight by 10</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>X-Large(+10)</td>
                                                                            <td>Increase price by 10</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>


                                                        </td>
                                                    </tr-->



