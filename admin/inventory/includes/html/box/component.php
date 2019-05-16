	<tr>
	<td colspan="2">

	<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">


	</td>
	</tr>
	<tr>
	<td colspan="2" align="left" class="head">Component Item Setting  </td>
	</tr>
	<tr>
	<td align="right" width="50%"  class="blackbold">Show Component Item :</td>
	<td align="left"  class="blacknormal">
            <select  name="compnent_show" id="component_show" style="width: 100px">
                <option value="">No</option>
                <option value="1" <?php if(($arryProduct[0]['showcomponent'] && $arryProduct[0]['showcomponent'] == '1')){ echo "selected='selected'";} ?>>Yes</option>
            </select></td>
	</tr>

	
	
