<style>
	.showTr{	
	}
	.hideTr{
		display:none;
	}
	.expandrow{
		cursor:pointer;
	}
</style>
<script type="text/javascript">
			$(function() {
				$('#ToDate').datepicker(
				{
					showOn: "both",
					dateFormat: 'yy-mm-dd',
					changeMonth: true,
					changeYear: true

				}
				);
			});
			
			$(function() {
				$('#FromDate').datepicker(
				{
					showOn: "both", 
					dateFormat: 'yy-mm-dd',
					changeMonth: true,
					changeYear: true

				}
				);
			});

function SetAccountHistory(str){
		ShowHideLoader('1','F');
                var AccountID = str;
		 window.location = 'accountHistory.php?accountID='+AccountID;
		 
	}
 function ResetSearch(){
		ShowHideLoader('1','F');
             		 
	}
/*
$(function() {
	$( "#accountID" ).selectmenu({
	  change: function( event, ui ) {
             console.log(ui);
               var vals = ui.item.value;		
           	SetAccountHistory(vals);
         }

     });
      
});*/

</script>

<link href="<?=$Prefix?>css/select2.min.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?=$Prefix?>js/select2.min.js"></script>

<div class="had"><?=ACCOUNT_HISTORY;?>
<?php if($num > 0){
$EmailUrl=$DownloadUrl='';
?>
<!--<a href="<?=$EmailUrl?>" target="_blank" class="fancybox fancybox.iframe email_button" style="float:right;margin-left:5px;">Email</a>
<input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/>
<a href="<?=$DownloadUrl?>" target="_blank" class="download" style="float:right;margin-left:5px;">Download</a>-->
<?php }?>
</div>
<br>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td valign="bottom">

<table id="search_table" cellspacing="0" cellpadding="0" border="0" style="margin:0">
<form name="frmSrch" id="frmSrch" action="accountHistory.php" method="get" onSubmit="return ResetSearch();">
<tr>
<td align="left"> Select Account :  </td>


<td align="left"> <select name="accountID" class="inputbox" id="accountID"  onChange="Javascript: SetAccountHistory(this.value);">
					 
					<? for($i=0;$i<sizeof($arryBankAccountList);$i++) {?>
						<option value="<?=$arryBankAccountList[$i]['BankAccountID']?>" <?php if($arryBankAccountList[$i]['BankAccountID'] == $_GET['accountID']){ echo "selected";}?>>
						<?=stripslashes($arryBankAccountList[$i]['AccountName']);?>
						[<?=$arryBankAccountList[$i]['AccountNumber']?>]
				   </option>
					<? } ?>
			</select> 

<script>
$("#accountID").select2();
</script> 

	</td>


<? if(sizeof($CurrencyArray)>1){ ?>
   <td align="left">
	  &nbsp; &nbsp; &nbsp;Currency :

	</td>
 <td align="left">
<select name="Currency" class="inputbox" id="Currency" style="width:70px">		
	<?	
	foreach($CurrencyArray as $Currency){ 
		$sel = ($_GET['Currency']==$Currency)?("selected"):("");
		echo '<option value="'.$Currency.'" '.$sel.'>'.$Currency.'</option>';				
	 }
	?>
</select> 

<script>
$("#Currency").select2();
</script> 
</td>
<? } ?>

   <td align="left">
	  &nbsp; &nbsp; &nbsp;From :

	</td>

	 <td align="left">
<input id="FromDate" name="FromDate" readonly="" class="datebox" value="<?=$FromDate;?>"  type="text">
	</td>

	 <td align="left">

	
	 &nbsp; &nbsp; &nbsp;To : 

	</td>

	 <td align="left"><input id="ToDate" name="ToDate" readonly="" class="datebox" value="<?=$ToDate;?>"  type="text">
	
	</td>
		 <td align="left"> &nbsp;
	<input type="text" name="key" id="key" placeholder="<?=SEARCH_KEYWORD?>" class="textbox" size="20" maxlength="30" value="<?=$_GET['key']?>">
	</td>
	 <td align="left">	
	<input type="submit" name="sbt" value="Go" class="search_button">
	<input type="hidden" name="link" id="link" value="<?=$_GET['link']?>">
	
	
	 
  
	</td>

</tr>
</form>
</table>


		</td>
      </tr>

<tr>
	  <td align="right">
<b>Currency : <?
if(!empty($Config['ModuleCurrencySel'])){		
	echo $_GET['Currency'];
}else{
	echo $Config['Currency'];
}


?></b>
</td>
      </tr>



	<tr>
	  <td align="right">

<? if($num>0){?>
<ul class="export_menu">
	<li><a class="hide" href="#">Export History</a>
	<ul>
		<li class="excel" ><a href="export_account_history.php?<?=$QueryString?>" ><?=EXPORT_EXCEL?></a></li>
		 
	</ul>
	</li>
</ul>

		<input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/>
		 
		<? } ?>



		</td>
      </tr> 

<tr>
	  <td  valign="top">
	
 		  <? include_once("includes/html/box/account_history_data.php");   ?>
</td>
</tr>


	<tr>
	  <td  valign="top" height="400">
	
</td>
	</tr>
</table>
	

<? echo '<script>SetInnerWidth();</script>'; ?>
