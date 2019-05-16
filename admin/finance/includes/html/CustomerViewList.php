<script language="JavaScript1.2" type="text/javascript">
function getvenderid(id){
var siteUrl='editSupplier.php?customer='+id;
window.parent.location.href=siteUrl;
parent.jQuery.fancybox.close();
 }

</script>
<div class="had">Select Customer</div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right" valign="bottom">

<form name="frmSrch" id="frmSrch" action="CustomerViewList.php" method="get" onSubmit="return ResetSearch();">
	<input type="text" name="key" id="key" placeholder="<?=SEARCH_KEYWORD?>" class="textbox" size="20" maxlength="30" value="<?=$_GET['key']?>">&nbsp;<input type="submit" name="sbt" value="Go" class="search_button">
	<input type="hidden" name="link" id="link" value="<?=$_GET['link']?>">
</form>



		</td>
      </tr>
	 
	<tr>
	  <td  valign="top" height="400">
	


<div id="prv_msg_div" style="display:none;padding:50px;"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div">

<table <?=$table_bg?>>
    <tr align="left"  >
      <td width="15%"  class="head1" >Customer Code</td>
     	<td class="head1" >Customer Type</td>
	<td class="head1" >Customer</td>
       <td width="14%" class="head1" >Email Address</td>
       <td width="14%" class="head1" >Country</td>
       <td width="14%" class="head1" >State</td>
       <td width="14%" class="head1" >Phone</td>
     
    </tr>
   
    <?php 
//print_r($arryCustomerViewList);die('aaa');
  if(is_array($arryCustomerViewList) && $num>0){
  	$flag=true;
	$Line=0;
	
  	foreach($arryCustomerViewList as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;
	if(empty($values["Taxable"])) $values["Taxable"]="No";
	
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
    <td>
	<a href="javascript:void(0);" onclick="getvenderid('<?= $values['Cid'] ?>')"><?= $values["CustCode"] ?></a>
	</td>
					<td><?=stripslashes($values["CustomerType"])?></td>     					
					<td><?=stripslashes($values["Company"])?></td> 
                                        <td><?=stripslashes($values["Email"])?></td> 
                                        <td><?=stripslashes($values["CountryName"])?></td> 
                                        <td><?=stripslashes($values["StateName"])?></td> 
                                        <td><?=htmlentities($values["Landline"], ENT_IGNORE)?></td> 
                                      
      
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="6" class="no_record"><?=NO_CUSTOMER?></td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="7"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryCustomerViewList)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 

  

</td>
	</tr>
</table>


