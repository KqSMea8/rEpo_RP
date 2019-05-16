<script language="JavaScript1.2" type="text/javascript">
function getvenderid(id){
var siteUrl='addCustomer.php?vender='+id;
window.parent.location.href=siteUrl;
parent.jQuery.fancybox.close();
 }

</script>
<div class="had">Select Vender</div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right" valign="bottom">

<form name="frmSrch" id="frmSrch" action="VenderList.php" method="get" onSubmit="return ResetSearch();">
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
      <td width="15%"  class="head1" >Vendor Code</td>
     	<td class="head1" >Vendor Type</td>
       <td width="14%" class="head1" >Company Name</td>
       <td width="14%" class="head1" >Country</td>
       <td width="14%" class="head1" >State</td>
       <td width="14%" class="head1" >City</td>
      <td width="10%"  class="head1" >Currency</td>
    </tr>
   
    <?php 
  if(is_array($arryVenderList) && $num>0){
  	$flag=true;
	$Line=0;
	
  	foreach($arryVenderList as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;
	if(empty($values["Taxable"])) $values["Taxable"]="No";
	
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
    <td>
	<a href="javascript:void(0);" onclick="getvenderid('<?= $values['SuppID'] ?>')"><?= $values["SuppCode"] ?></a>
	</td>
    					<td><?=stripslashes($values["SuppType"])?></td> 
                                        <td><?=stripslashes($values["CompanyName"])?></td> 
                                        <td><?=stripslashes($values["Country"])?></td> 
                                        <td><?=stripslashes($values["State"])?></td> 
                                        <td><?=htmlentities($values["City"], ENT_IGNORE)?></td> 
                                        <td><?=$values["Currency"]?></td>
      
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="6" class="no_record"><?=NO_CUSTOMER?></td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="7"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryVenderList)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 

  

</td>
	</tr>
</table>


