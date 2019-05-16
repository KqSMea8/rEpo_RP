<div class="had">Manage <?=$ModuleName;?></div>
<TABLE WIDTH=98%   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
    <form name="form1" action="" method="post"  enctype="multipart/form-data">
            <? if (!empty($_SESSION['mess_ship'])) {?>
                                                        <tr>
                                                        <td  align="center"  class="message"  >
                                                                <? if(!empty($_SESSION['mess_ship'])) {echo $_SESSION['mess_ship']; unset($_SESSION['mess_ship']); }?>	
                                                        </td>
                                                        </tr>
                                                        <? } ?>
        
        <TR>
            <TD align="center" valign="top"><table width="100%"  border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" valign="middle" >
                             <div  align="right"><a href="viewShipping.php" class="back">Back</a>&nbsp;</div><br>
                            <table width="100%"  border="0" cellpadding="3" cellspacing="1" class="borderall">
                                
                                 <tr>
                                                        <td colspan="2" align="left" class="head">Shipping Rates</td>
                                                    </tr>
                                                           <tr>
                                                               <td colspan="2">
                                                                <table width="100%" cellspacing="1" cellpadding="3" align="center" id="list_table">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="head1">Min Range</td>
                                                                        <td class="head1">Max Range</td>
                                                                        <td class="head1">Shipping Price</td>
                                                                        <td class="head1">Type</td>
                                                                         <td class="head1">Action</td>
                                                                  </tr>
                                                                  <?php  if(count($ShippingRatesArr) > 0) {
                                                                      foreach($ShippingRatesArr as $shippingrate) {   ?>
                                                                    <tr valign="middle" bgcolor="#ffffff" align="left">
                                                                        <td><?=number_format($shippingrate['RateMin'],2);?></td>
                                                                        <td><?=number_format($shippingrate['RateMax'],2);?></td>
                                                                        <td><?= number_format($shippingrate['Price'],2);?></td>
                                                                        <td><?=$shippingrate['PriceType'];?></td>
                                                                        <td><a href="shippingRates.php?Srid=<?=$shippingrate['Srid'] ?>&curP=<?php echo $_GET['curP']; ?>&Ssid=<?= $_GET['Ssid'] ?>&MethodId=<?=$_GET['MethodId'];?>"><?= $edit ?></a>  <a href="javascript:void();" class="deleteShippingRate" alt="<?=$_GET['Ssid']."#".$shippingrate['Srid']?>"><?= $delete ?></a>	</td></td>
                                                                    </tr>
                                                                  <?php   
                                                                            }
                                                                      } else { 
                                                                      ?>
                                                                   <tr valign="middle" bgcolor="#ffffff" align="left">
                                                                        <td class="no_record" colspan="5">No Shipping Rates Found.</td>
                                                                       
                                                                     </tr>
                                                                    <?php   }   ?>
		                    </tbody>
			</table> 
                                                            </td>
                                                           </tr>
                                                           <tr><td colspan="2"></td></tr>
                                                      <tr>
                                                        <td colspan="2" align="left" class="head"><?=$shipHeading;?></td>
                                                    </tr>
                                              <tr>
                                            <td align="center" valign="top" >
                                                <table width="100%" border="0" cellpadding="5" cellspacing="1" >
                                            <tr>
                                                <td width="30%" align="right" valign="top"   class="blackbold"> 
                                               Min Amount<span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="RateMin" id="RateMin" onkeyup="keyup(this);"  value="<?= stripslashes($ShippingRateArr[0]['RateMin']) ?>" type="text" class="inputbox"  size="50" />
                                                </td>
                                            </tr>
                                             <tr>
                                                <td width="30%" align="right" valign="top"   class="blackbold"> 
                                               Max Amount <span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top">
                                                 <input  name="RateMax" id="RateMax" onkeyup="keyup(this);" value="<?= stripslashes($ShippingRateArr[0]['RateMax']) ?>" type="text" class="inputbox"  size="50" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td  align="right" valign="top"   class="blackbold">  	Shipping Price<span class="red">*</span> </td>
                                                <td align="left" valign="top">
                                                      <input  name="Price" id="Price" onkeyup="keyup(this);" value="<?= stripslashes($ShippingRateArr[0]['Price']) ?>" type="text" class="inputbox"  size="50" />
                                                </td>
                                            </tr>
                                              <tr>
                                                <td  align="right" valign="top"   class="blackbold"> Type </td>
                                               <td  align="left" class="blacknormal">           
                                                   <select class="inputbox"  name="PriceType" id="PriceType">
                                                       <option value="amount" <?php if($ShippingRateArr[0]['PriceType'] == "amount"){echo "selected";}?>>USD (amount)</option>
                                                      <option value="percentage" <?php if($ShippingRateArr[0]['PriceType'] == "percentage"){echo "selected";}?>>% (percentage)</option>
                                                  </select>
                                               </td>
                                            </tr>
                                            
                                             

                                        </table>
                                        
                                    </td>
                                </tr>


                            </table></td>
                    </tr>
                    <tr>
                        <td align="center" height="135" valign="top"><br>
                           <? if ($Srid > 0) $ButtonTitle = 'Update'; else $ButtonTitle = 'Save'; ?>
                            <input type="hidden" name="Ssid" id="Ssid" value="<?=$Ssid;?>">  
                               <input type="hidden" name="Srid" id="Srid" value="<?=$Srid;?>">  
                                <input type="hidden" name="MethodId" id="MethodId" value="<?=$MethodId;?>"> 
                            <input name="Submit" type="submit" class="button" id="SubmitShippingRate" value=" <?= $ButtonTitle ?> " />&nbsp;
                           
                    </tr>

                </table></TD>
        </TR>
    </form>
</TABLE>

<SCRIPT LANGUAGE=JAVASCRIPT>
    $(document).ready(function() {
   $("#SubmitShippingRate").click(function(){
       
            var RateMin = $.trim($("#RateMin").val());
            var RateMax = $.trim($("#RateMax").val());
             var Price = $.trim($("#Price").val());
           
           
 if(RateMin == "")
       {
           alert("Please enter min range");
           $("#RateMin").focus();
           return false;
       }
       
     if(RateMax == "")
       {
           alert("Please enter max range");
           $("#RateMax").focus();
           return false;
       }
     
       if(Price == "")
       {
           alert("Please enter price");
           $("#Price").focus();
           return false;
       }
   
     });
     
  $(".deleteShippingRate").click(function(){
       
       var proVal = $(this).attr('alt');
       var SplitVal = proVal.split("#")
       var Ssid = SplitVal[0];
       var Srid = SplitVal[1];
       var MethodId = $("#MethodId").val();
       
       if(confirm("Are you sure you want to delete this ?"))
       {
          var data = '&Ssid=' + Ssid +  '&Srid=' + Srid +'&MethodId=' + MethodId +'&action=deleteShippingRate';

        if (data) {
           
            $.ajax({
                type: "POST",
                url: "e_ajax.php",
                data: data,
                success: function (msg) {
                 window.location.href = msg;
                }
            });
          }
	}
        else{
		return false;
	}
  
       
   });
   
  }); 
    
    function keyup(me)
        {
            if(isNaN(me.value))
            {
                me.value="";
            }
        }
	 
</SCRIPT>