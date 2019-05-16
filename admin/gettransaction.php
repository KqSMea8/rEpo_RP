<?php
$HideNavigation = 1;
	
	include_once("includes/header.php");
include_once("includes/finicity.config.php");
include_once("../classes/fin.api.class.php");
$objFiniCity = new fincity();




$arryInstLogin = $objFiniCity->GetLoginForm($Api_key,$_GET['token']);
$arryaccount = $objFiniCity->GetCutomerAccounts($Api_key,$_GET);

if($_GET['accountID']!=''){

$Fromd = DateTime::createFromFormat('Y-m-d',$_GET['fromDate'] );
$_GET['frDate'] =  $Fromd->getTimestamp();

$Tod = DateTime::createFromFormat('Y-m-d',$_GET['ToDate'] );
$_GET['TDate'] =  $Tod->getTimestamp();
$arryTransaction = $objFiniCity->GetAccountTransaction($Api_key,$_GET);



}
?>


  
 <table cellspacing="0" cellpadding="0" border="0" width="100%" align="center">     


 <tbody>

           

<tr>
 <td align="right" height="40" valign="bottom">
<form action="" method="get" enctype="multipart/form-data" name="form2" >
	 <table  border="0" cellpadding="3" cellspacing="0"  id="search_table" style="margin:0" >

		<tr>
		<td   >
		<select id="accountID" class="inputbox" name="accountID" style="width:200px;">
			   <option value="">---Select Accounts---</option>
			     <?php foreach($arryaccount['account'] as $account){?>
				 <option value="<?=$account['id'];?>" <?php if($_GET['accountID'] == $account['id']){echo "selected";}?>><?php echo $account['name'].'['.$account['number'].']'; ?></option>
				<?php }?>
			</select>
		</td>
	
		

       
        <td   align="left" >

<script type="text/javascript">
$(function() {
	$('#fromDate').datepicker(
		{
		showOn: "both",
		yearRange: '<?=date("Y")-20?>:<?=date("Y")+10?>', 
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true

		}
	);
});
</script>


<input id="fromDate" name="fromDate" readonly="" placeholder="From Date" class="datebox" value="<?=$_GET['fromDate']?>"  type="text" > 


</td>
	      <td   align="left" >

<script type="text/javascript">
$(function() {
	$('#ToDate').datepicker(
		{
		showOn: "both",
		yearRange: '<?=date("Y")-20?>:<?=date("Y")+10?>', 
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true

		}
	);
});
</script>


<input id="ToDate" name="ToDate" readonly="" class="datebox" placeholder="To Date" value="<?=$_GET['ToDate']?>"  type="text" > 


</td>
	  <td align="right"  >  
		<input name="cuid" id="cuid"  type="hidden" class="inputbox"  value="<?=$_GET['cuid']?>"  />	
<input name="instid" id="instid"  type="hidden" class="inputbox"  value="<?=$_GET['instid']?>"  />	
<input name="token" id="token"  type="hidden" class="inputbox"  value="<?=$_GET['token']?>"  />	
		 <input name="search" type="submit" class="search_button" value="Go"  />	  
	
	  
	  </td> 
 </tr>


</table>
</form>
</td>
</tr>


        <tr>
            <td valign="top">



                
                <div id="preview_div">

                    <table id="list_table" align="center" width="100%" cellpadding="3" cellspacing="1">
                           <tbody>
															<tr align="left">
																<td class="head1" width="">Transaction ID</td>
																<td class="head1" width="">amount</td>
																<td class="head1" width="">description</td>
																<td class="head1" width="">transactionDate</td>
																
															</tr>
                                   <? for($i=0;$i<sizeof($arryTransaction['transaction']);$i++){?>                     
                                <tr class="evenbg" align="left" bgcolor="#FFFFFF">       
																			<td><?=$arryTransaction['transaction'][$i]['id']?></td>
																			<td><?=$arryTransaction['transaction'][$i]['amount']?></td>
																			<td><?=$arryTransaction['transaction'][$i]['description']?></td>
																			<td><?=date('m/d/Y H:i:s', $arryTransaction['transaction'][$i]['transactionDate']);?></td>
																			
                                </tr>
                        <? }?>            

                        <tr>  <td colspan="6">Total Record(s) : </td>
                        </tr>
                    </tbody></table>

                </div> 
                   
  

               
            </td>
        </tr>
    </tbody>

</table>
</body>
</html>



