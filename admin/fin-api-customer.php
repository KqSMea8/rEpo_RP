<?php
//$HideNavigation = 1;
	
include_once("includes/header.php");
include_once("includes/finicity.config.php");
include_once("../classes/fin.api.class.php");
	require_once("../classes/company.class.php");
$objFiniCity = new fincity();
$objCompany=new company();


$arryInst = $objFiniCity->GetInstution($Api_key,$url,$_GET['token']);
//$arryInstLogin = $objFiniCity->GetLoginForm($Api_key,$_GET['token']);

$objCompany->InsertInstitution($arryInst['institution'],'');

if($_GET['instutionID']!=''){
$arrycustomer = $objFiniCity->GetCutomer($Api_key,$_GET);
echo "<pre>";
print_r($arryInst['institution']);
exit;
}
?>


  <table cellspacing="0" cellpadding="0" border="0" width="100%" align="center">     


 <tbody>

           

<tr>
 <td align="right" height="40" valign="bottom">
<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch(this);">
	 <table  border="0" cellpadding="3" cellspacing="0"  id="search_table" style="margin:0" >

		<tr>
		<td   >
		<select id="instutionID" class="inputbox" name="instutionID" style="width:200px;">
			   <option value="">---Select Bank---</option>
			     <?php foreach($arryInst['institution'] as $institution){?>
				 <option value="<?=$institution['id'];?>" <?php if($_GET['instutionID'] == $institution['id']){echo "selected";}?>><?php echo $institution['name']; ?></option>
				<?php }?>
			</select>
		</td>
	<td   >
		<input name="customer" id="customer"  type="text" class="inputbox" placeholder="Customer" value="<?=$_GET['customer']?>"  />	
		</td>
		
	
	  <td align="right"  > <input name="token" id="token" type="hidden" placeholder="Customer" value="<?=$_GET['token']?>"  />  <input name="search" type="submit" class="search_button" value="Go"  />	  
	
	  
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
																<td class="head1" width="">Customer ID</td>
																<td class="head1" width="">Username</td>
																<td class="head1" width="">First Name</td>
																<td class="head1" width="">Last Name</td>
																<td class="head1 head1_action" align="center" width="13%">Action</td>
															</tr>
                                   <? for($i=0;$i<sizeof($arrycustomer['customer']);$i++){?>                     
                                <tr class="evenbg" align="left" bgcolor="#FFFFFF">       
																			<td><?=$arrycustomer['customer'][$i]['id']?></td>
																			<td><?=$arrycustomer['customer'][$i]['username']?></td>
																			<td><?=$arrycustomer['customer'][$i]['firstName']?></td>
																			<td><?=$arrycustomer['customer'][$i]['lastName']?></td>
																			<td><a class="fancybox reqbox  fancybox.iframe" href="gettransaction.php?cuid=<?=$arrycustomer['customer'][$i]['id']?>&instid=<?=$_GET['instutionID']?>&token=<?=$_GET['token']?>" >Trnasaction</a></td>
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



