<div class="block manufactures">
          <h2>Manufacturers</h2>
          <div class="sel-wrap-friont">
            <select name="manufacturerList" id="manufacturerList">
              <option>Please Select</option>
              <?php foreach($arryManufacturer as $key=>$value){?>
              <option value="<?=$value['Mid'];?>" <?php if($_GET['Mfg'] == $value['Mid']){echo "selected";} ?>><?=$value['Mname'];?></option>
              <?php } ?>
            </select>
          </div>
        </div>