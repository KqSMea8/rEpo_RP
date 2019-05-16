<div class="had">  <?php
                            if ($_GET['edit'] > 0) {
                               echo  'Edit Vendor';
                            } else {
                               echo  'Add Vendor';
                            }
                            ?></div>

 <div class="message"><? if (!empty($_SESSION['msg_error'])) {  echo stripslashes($_SESSION['msg_error']);   unset($_SESSION['msg_error']);} ?></div>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" valign="top">
              <form name="form1" action="" method="post"  enctype="multipart/form-data"
			  onsubmit="return validation();"
			  >
                <table width="100%"  border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" valign="middle">
                            <div  align="right"><a href="vendor.php" class="back">Back</a>&nbsp;</div><br>
                            <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="borderall">
                                <tr>
                                    <td align="center" valign="top" ><table width="100%" border="0" cellpadding="5" cellspacing="1" >
                                            
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    First Name : <span class="red">*</span></td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="inputFirstName" id="fname" value="<?=isset($user[0]['fname']) ? stripslashes($user[0]['fname']) : ''; ?>" type="text" class="inputbox"  size="50" />
                                                </td>
                                            </tr>

                                            <tr>
                                                <td width="30%" align="right" valign="top"   class="blackbold"> 
                                                    Last Name : <span class="red">*</span> </td>
                                                <td  align="left"  class="blacknormal">
                                                    <input  name="inputLastName" id="lname" value="<?=isset($user[0]['fname']) ? stripslashes($user[0]['lname']) : '';?>" type="text" class="inputbox"  size="50" />
                                                </td>
                                            </tr>

                                            <tr>
                                                <td width="30%" align="right" valign="top"   class="blackbold"> 
                                                    Email : <span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="inputEmail" id="email" value="<?=isset($user[0]['user_name']) ? stripslashes($user[0]['user_name']) : ''; ?>" type="text" class="inputbox"  size="50" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="right" valign="top" class="blackbold"> 
                                                    Password :  </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="password" id="Password"  value="" type="Password" class="inputbox"  size="50" placeholder="********" />
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td width="30%" align="right" valign="top" class="blackbold">  Address  : </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="inputAddress" id="Address1" value="<?=isset($user[0]['address1']) ? stripslashes($user[0]['address1']) : ''; ?>" type="text" class="inputbox"  size="50" />
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td  align="right"   class="blackbold"> Country : </td>
                                                <td   align="left" >
                                                    <?
                                                    if (!empty($user) && $user[0]['country'] != '') {
                                                        $CountrySelected = $user[0]['country'];
                                                    } else {
                                                        $CountrySelected = '';
                                                    }
                                                    ?>
                                                    <select name="Country" class="inputbox" id="country_id"  onChange="Javascript: StateListSend();">
                                                        <? for ($i = 0; $i < sizeof($arryCountry); $i++) { ?>
                                                            <option value="<?= $arryCountry[$i]['country_id'] ?>" <? if ($arryCountry[$i]['country_id'] == $CountrySelected) {
                                                            echo "selected";
                                                        } ?>>
                                                            <?= $arryCountry[$i]['name'] ?>
                                                            </option>
                                                            <? } ?>
                                                    </select>        
                                                </td>
                                            </tr>
                                            <tr>
                                                <td  align="right" valign="middle" nowrap="nowrap"  class="blackbold"> State : </td>
                                             <td  align="left" id="state_td" class="blacknormal">&nbsp;</td>
                                            </tr>
                                            
                                            <tr>
                                                <td  align="right"   class="blackbold"><div id="MainCityTitleDiv"> City : </div></td>
                                                <td  align="left"  ><div id="city_td"></div></td>
                                            </tr> 
                                          
                                              <tr>
                                                <td valign="middle" align="right" class="blackbold"> Status :  </td>
                                                <td align="left" class="blacknormal">
<table width="151" cellspacing="0" cellpadding="0" border="0" class="blacknormal margin-left">
<tbody><tr>
    <td width="20" valign="middle" align="left"><input type="radio" checked="" value="Yes" name="inputStatus" <?php if(!empty($user) && $user[0]['status']=="1"){ echo "selected"; }  ?>></td>
    <td width="48" valign="middle" align="left">Active</td>
    <td width="20" valign="middle" align="left"><input type="radio" value="No" name="inputStatus" <?php if(!empty($user) && $user[0]['status']=="0"){ echo "selected"; }  ?>></td>
    <td width="63" valign="middle" align="left">Inactive</td>
</tr>
</tbody></table>                      
                                                </td>
                                            </tr>

											
                                        </table>
                                    </td>
                                </tr>


                            </table></td>
                    </tr>
                    <tr>
                        <td align="center" height="135" valign="top"><br>
                            <?php
                            if ($_GET['edit'] > 0) {
                                $ButtonTitle = 'Update';
                            } else {
                                $ButtonTitle = 'Submit';
                            }
                            ?>
                            <!--<input type="hidden" name="CustId" id="CustId" value="<?= $CustId; ?>" />-->
                            <input type="hidden" name="edit" id="edit" value="<?=(isset($_GET['edit'])) ? $_GET['edit'] : ''; ?>" />
							 <input type="hidden" value="<?php echo (!empty($user)) ? $user[0]['state'] : ''; ?>" id="main_state_id" name="main_state_id">		
                            <input type="hidden" name="main_city_id" id="main_city_id" value="<?php echo (!empty($user)) ? $user[0]['city'] : ''; ?>" />
                            <input name="Submit" type="submit" class="button" id="UpdateCustomer" value=" <?= $ButtonTitle ?> " />&nbsp;
                        </td>    
                    </tr>

                </table>
               </form>
            </td>
        </tr>

</table>

<SCRIPT LANGUAGE=JAVASCRIPT> 
  <?php if ($_GET['edit'] > 0) { ?>
    StateListSend();
  <?php } ?>
  
  
  function validation(){
	  
	  var fname =  $("#fname").val();
	  if(fname==""){
		  alert("Please Enter First Name");
		  return false;
	  }


	  var lname =  $("#lname").val();
	  if(lname==""){
		  alert("Please Enter Last Name");
	      return false; 
	 }	

      var email =  $("#email").val();
	  if(email==""){
		  alert("Please Enter Email");
		  return false; 
	  }	  
	  
	  var pattern=/^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
    if(pattern.test(email)){         
		//alert("true");   
    }else{   
		alert("Please Enter Valid Email");
	    return false;  
    }
	  
	  return true;
  }
   
</SCRIPT>


