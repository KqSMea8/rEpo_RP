<div class="main-container">
  <div class="mid_wraper clearfix">
    <?php include_once("includes/left.php"); ?>
    <div class="right_pen">
    <div class="advancesearch">
      <h1><?= ADVANCE_PRODUCTS_SEARCH ?></h1>
      <p>You may customize your search by using special keywords</p>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="left" valign="top">
          <table cellspacing="0" cellpadding="0" width="100%" align="center">
              <tr>
                <td height="32">
                    <form action="products.php"  method="get" enctype="multipart/form-data" name="MoreSearch">
                    <table width="100%" border="0"  cellpadding="0" cellspacing="0">
                      <tr>
                        <td height="82"  valign="top">
                        <table width="100%" class="pro_search" border="0" align="center" cellpadding="3" cellspacing="3">
                            <tr>
                              <td width="29%" height="30" style="text-align:right" valign="middle" class="txt">Search By</td>
                              <td width="71%" height="30"  valign="middle">
                              <div class="sel-wrap-friont"><select name="search_in" id="search_in">
                                  <option value="all">Product Description</option>
                                  <option value="name">Product Name</option>
                                  <option value="id">Product Sku</option>
                                </select>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td width="29%" height="30" style="text-align:right" valign="middle" class="txt"><?= ENTER_KEYWORD_ITEM ?></td>
                              <td width="71%" height="30"  valign="middle"><input name="search_str" id="search_str" type="text"  class="txtfield_normal"  maxlength="30"/>
                              </td>
                            </tr>
                            <tr>
                              <td  height="30" style="text-align:right" valign="middle" class="txt">Manufacturer</td>
                              <td  height="30"  valign="middle">
                              <div class="sel-wrap-friont"><select name="Mfg" class="txtfield_normal" id="Mfg" >
                                  <option value="" selected="selected">--- Select ---</option>
                                  <? for ($i = 0; $i < sizeof($arryManufacturer); $i++) { ?>
                                  <option value="<?= $arryManufacturer[$i]['Mid'] ?>" <? if ($arryManufacturer[$i]['Mid'] == $_GET['Mfg']) {
                                                                        echo "selected";
                                                                    } ?>>
                                  <?= stripslashes($arryManufacturer[$i]['Mname']) ?>
                                  </option>
                                  <? } ?>
                                </select>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td  style="text-align:right"  valign="middle" class="txt">Price From (
                                <?= $Config['Currency'] ?>
                                )</td>
                              <td  align="left" valign="middle"><input name="priceFrom" id="priceFrom" type="text" onkeyup="keyup(this);" class="txtfield_normal"  maxlength="10"/>
                              </td>
                            </tr>
                            <tr>
                              <td width="29%"  style="text-align:right"  valign="middle" class="txt">Price To (
                                <?= $Config['Currency'] ?>
                                )</td>
                              <td width="71%"  align="left" valign="middle"><input name="priceTo" id="priceTo" type="text" onkeyup="keyup(this);" class="txtfield_normal"  maxlength="10"/>
                              </td>
                            </tr>
                            <tr>
                              <td style="text-align:right"  valign="middle" class="txt">Sort By</td>
                              <td  align="left" valign="middle"><div class="sel-wrap-friont"><select name="shortBy" id="shortBy" class="txtfield_normal" >
                                  <option value="" selected="selected">--None--</option>
                                  <option value="Name">Product Name</option>
                                  <option value="lprice">Lowest Price</option>
                                  <option value="hprice">Highest Price</option>
                                </select></div></td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td height="50" valign="bottom" class="btn">
                                  <input name="" id="SubmitButton" type="submit" value="Search" class="button advaceSearch" />
                              </td>
                            </tr>
                          </table></td>
                      </tr>
                    </table>
                    <input type="hidden" name="mode" value="search">
                  </form>
                </td>
              </tr>
            </table>
          </td>
            <td>&nbsp;</td>
        </tr>
      </table>
    </div>
    </div>
  </div>
</div>
