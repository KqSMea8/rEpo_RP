<SCRIPT LANGUAGE=JAVASCRIPT>
function ValSearch()
{
	if(!ValidateForSimpleBlank(document.getElementById("key"),"Search Keyword")){
		return false;
	}

	location.href="search.php?k="+document.getElementById("key").value+'&t='+document.getElementById("t").value;
	LoaderSearch();	
	return false;
}
</SCRIPT>

<div class="had">Search CRM</div>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="left" height="50">

<form name="frmSrch" id="frmSrch" action="search.php" method="get" onSubmit="return ValSearch();">

 <table  border="0" cellpadding="3" cellspacing="0"  id="search_table" style="margin:0;background:#fff" >

		<tr>
		 <td> <input type="text" name="key" id="key" placeholder="<?=SEARCH_KEYWORD?>" class="textbox" size="20" maxlength="30" value="<?=$_GET['k']?>">
		</td>

		<td align="left" >

		<select name="t" class="textbox" id="t" >
		  <option value="">--- All ---</option>
		  <? 
		$arrayDenyModule = array('115','116','160','164','176','195','2001','2003','2025');
		for($i=0;$i<sizeof($arrayHeaderMenus);$i++) {
			if(!in_array($arrayHeaderMenus[$i]['ModuleID'],$arrayDenyModule)){

?>
		  <option value="<?=stripslashes($arrayHeaderMenus[$i]['Module'])?>" <?  if($arrayHeaderMenus[$i]['Module']==$_GET['t']){echo "selected";}?>>
		  <?=stripslashes($arrayHeaderMenus[$i]['Module'])?>
		  </option>
		  <? }} ?>
		</select>	
	
		</td>
		 <td>&nbsp;</td> 
		

		
		 <td>
		<input type="submit" name="sbt" value="Go" class="search_button">
		 
		 </td> 
		  
        </tr>
</table>




</form>



		</td>
      </tr>
    <tr>
        <td  valign="top" height="30">
	</td>
      </tr>
    <tr>
        <td  valign="top" height="300">


            <form action="" method="post" name="form1">

                <div id="preview_div">

<TABLE width="100%" align="center" cellpadding="10" cellspacing="1" id="myTable">
 <tr align="left"  bgcolor="#fff">
                       
                        <?php


                        if (is_array($arryResult) && $num > 0) {
                            $flag = true;
                            $Line = 0;
                            $OrderType = '';



                            foreach ($arryResult as $key => $values) {
                                $flag = !$flag;
                                $bgcolor = ($flag) ? ("#FAFAFA") : ("#FFFFFF");
                                $Line++;
$ViewUrl='';                                 
if($values['Section']=='Lead'){
$ViewUrl = 'leadInfo.php?module=lead&view='.$values['SectionID'];
}else if($values['Section']=='Opportunity'){
$ViewUrl = 'opportunityInfo.php?module=Opportunity&view='.$values['SectionID'];
}else if($values['Section']=='Ticket'){
$ViewUrl = 'ticketInfo.php?module=Ticket&view='.$values['SectionID'];
}else if($values['Section']=='Contact'){
$ViewUrl = 'contactInfo.php?module=Contact&view='.$values['SectionID'];
}else if($values['Section']=='Quote'){
$ViewUrl = 'quoteInfo.php?module=Quote&view='.$values['SectionID'];
}else if($values['Section']=='Event'){
$ViewUrl = 'activityInfo.php?module=Activity&view='.$values['SectionID'];
}else if($values['Section']=='Document'){
$ViewUrl = 'documentInfo.php?module=Document&view='.$values['SectionID'];
}else if($values['Section']=='Campaign'){
$ViewUrl = 'campaignInfo.php?module=Campaign&view='.$values['SectionID'];
}else if($values['Section']=='Customer'){
$ViewUrl = '../custInfo.php?CustID='.$values['SectionID'];
}
             
                                
                                ?>

                    

<td width="33%" valign="top">
	<a href="<?=$ViewUrl?>" class="fancybox fancybox.iframe"><?=stripslashes($values["Heading"])?></a>

<? 
if(empty($_GET['t'])) echo ' ['.$values['Section'].']';
if(!empty($values['CompanyName'])) echo '<br>Company: '.stripslashes($values['CompanyName']);
if(!empty($values['Phone'])) echo '<br>Phone: '.stripslashes($values['Phone']);

?>

</td>






                            <?php 

if($Line%3==0) echo '</tr><tr align="left"  bgcolor="#fff">';


} // foreach end //



if($Line%3==1) echo '<td>&nbsp;</td><td>&nbsp;</td>';
else if($Line%3==2) echo '<td>&nbsp;</td>';

 ?>

 </tr>
<?php }else { ?>
                            <tr align="center" >
                                <td  colspan="5" class="no_record"><?= NO_RECORD ?> </td>
                            </tr>
<?php } ?>

                        <tr>  <td  colspan="5"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryResult) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php
                                    echo $pagerLink;
                                }
                                ?></td>
                        </tr>
                    </table>

                </div> 


            
            </form>
        </td>
    </tr>
</table>

