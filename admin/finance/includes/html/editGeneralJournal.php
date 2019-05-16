<a href="<?=$ListUrl?>" class="back">Back</a>
<div class="had">
<?=$MainModuleName?>    <span>&raquo;
	<? 	echo (!empty($_GET['edit']))?("Edit ".$ModuleName) :("Add ".$ModuleName); ?>
		
		</span>
</div>

 <div class="message"><? if (!empty($_SESSION['mess_journal'])) {  echo stripslashes($_SESSION['mess_journal']);   unset($_SESSION['mess_journal']);} ?></div>
<script language="JavaScript1.2" type="text/javascript">
 
var ConfigCurrency = "<?=$Config['Currency']?>";
 
function GetCurrencyRate(ConfigCurrency){	
	var CurrencyGL = $("#Currency").val();
	var CurrencyDate =  $("#JournalDate").val();
	$("#ConversionRate").val('');
	$("#ConversionRate").addClass('loaderbox');
	if(ConfigCurrency!=CurrencyGL){	
		$("#ConversionRate").show();
		$("#ConversionRateLabel").show();		
		var SendUrl ='action=getCurrencyRateByModule&Module=GL&Currency='+escape(CurrencyGL)+'&CurrencyDate='+escape(CurrencyDate)+'&r='+Math.random(); 
		
		$.ajax({
			type: "GET",
			async:false,
			url: 'ajax.php',
			data: SendUrl,
			success: function (responseText) { 
				$("#ConversionRate").removeClass('loaderbox');	
				$("#ConversionRate").val(responseText);						
			}

		});
	}else{
		$("#ConversionRate").removeClass('loaderbox');	
		$("#ConversionRate").val('1');
		$("#ConversionRate").hide();
		$("#ConversionRateLabel").hide();			
	}

	
}


function SetForInfinite(){
	if(document.getElementById("Infinite").checked){
		$("#EntryToLabel").hide();
		$("#EntryToVal").hide();
		$("#JournalDateTo").val("");
	}else{
		$("#EntryToLabel").show();
		$("#EntryToVal").show();
	}
	 
}


jQuery('document').ready(function(){
	SetForInfinite();

	$('#Infinite').click(function(){
		SetForInfinite();
	});

});

/********************************/

function  GetBankCurrencyRate(opt) { 
	var CreditAmnt1 = $("#CreditAmnt1").val();
	var BankConversionRate1 = $("#BankConversionRate1").val();
	var BankConversionRate2 = $("#BankConversionRate2").val();
	var ConversionRate = ConversionRate2 = 1;
 
	if(opt!='1'){		
		$("#BankConversionRate1").val('');
		$("#BankConversionRate1").hide();
		$("#BankConversionRate2").val('');
		$("#BankConversionRate2").hide();
		$("#BaseCurrencyValue1").hide();
		$("#DebitAmnt2").val('0.00');
	}else{
		ConversionRate = BankConversionRate1;
		ConversionRate2 = BankConversionRate2; 
	}
	 
 	if(CreditAmnt1>0){ 
	 	var BankCurrency1 = $("#BankCurrency1").val();
		var BankCurrency2 = $("#BankCurrency2").val();
		if(BankCurrency1 != null && BankCurrency2 != null){
			if(BankCurrency1 != BankCurrency2 && opt!='1'){

				/***********/
				if(BankCurrency1 != ConfigCurrency && BankCurrency2 != ConfigCurrency){
					
					$("#BankConversionRate1").addClass('loaderbox');
					var SendUrl =  'action=getBankCurrencyRate&Module=GL&FromCurrency='+escape(BankCurrency1)+'&ToCurrency='+escape(ConfigCurrency)+'&r='+Math.random(); 		
					$.ajax({
						type: "GET",
						async:false,
						url: 'ajax.php',
						data: SendUrl,
						success: function (responseText) { 
							ConversionRate = responseText;
							$("#BankConversionRate1").removeClass('loaderbox');	 
							
							/***********/
							
							$("#BankConversionRate2").addClass('loaderbox');
							var SendUrl2 = 'action=getBankCurrencyRate&Module=GL&FromCurrency='+escape(ConfigCurrency)+'&ToCurrency='+escape(BankCurrency2)+'&r='+Math.random(); 		
							$.ajax({
								type: "GET",
								async:false,
								url: 'ajax.php',
								data: SendUrl2,
								success: function (responseText2) { 
									ConversionRate2 = responseText2;
										
								$("#BankConversionRate2").removeClass('loaderbox');	 
										
								

								}
							});
							/***********/

						}
					});

					
				
				}else{   /***********/
					
					$("#BankConversionRate1").addClass('loaderbox');
					var SendUrl ='action=getBankCurrencyRate&Module=GL&FromCurrency='+escape(BankCurrency1)+'&ToCurrency='+escape(BankCurrency2)+'&r='+Math.random(); 		
					$.ajax({
						type: "GET",
						async:false,
						url: 'ajax.php',
						data: SendUrl,
						success: function (responseText) { 
							ConversionRate = responseText;
							$("#BankConversionRate1").removeClass('loaderbox');	
							 					
						}

					});
				}
			}
			

			if(ConversionRate !='1' && ConversionRate>0){
				$("#BankConversionRate1").show();
			}

			$("#BankConversionRate1").val(ConversionRate);			
			var DebitAmnt2 = GetConvertedAmount(ConversionRate,CreditAmnt1);  
			var DebitAmnt2 = parseFloat(DebitAmnt2).toFixed(2)
			$("#DebitAmnt2").val(DebitAmnt2); 

			$("#BankConversionRate2").val(ConversionRate2);
			if(ConversionRate2 !='1' && ConversionRate2>0){
				$("#BankConversionRate2").show();
				$("#BaseCurrencyValue1").show();	
				$("#BaseCurrencyValue1").html(DebitAmnt2+' '+ConfigCurrency); 
				var DebitAmnt3 = GetConvertedAmount(ConversionRate2,DebitAmnt2);  
				var DebitAmnt3 = parseFloat(DebitAmnt3).toFixed(2)
				$("#DebitAmnt2").val(DebitAmnt3); 
			} 
			 
			
		} 
	} 
}


function SetBankCurrency(id,opt){

	var AccountIDVal = $("#AccountID"+id).val();
 	if(AccountIDVal>0){
	 	var BankCurrency = $("#AccountID"+id+" option:selected").attr("BankCurrency");
		var CurrencyArray = BankCurrency.split(",");
		var numCurrency = CurrencyArray.length; 
	 	$("#BankCurrency"+id).empty();	
		var sel  = '';
		var BankCurrencySel = $("#BankCurrencySel"+id).val();
		for(var i=0; i < numCurrency; i++){ 
			if(BankCurrencySel == CurrencyArray[i]) sel='selected'; else sel='';
			$("#BankCurrency"+id).append('<option value="'+CurrencyArray[i]+'" '+sel+'>'+CurrencyArray[i]+'</option>'); 
		}
		$("#BankCurrency"+id).show(); 		
	}else{
		$("#BankCurrency"+id).empty();	
		$("#BankCurrency"+id).hide(); 
	}
	GetBankCurrencyRate(opt);
}

function BankTransferCheck() { 
	var JournalID = $("#JournalID").val();
 	var BankTransfer = $("#BankTransfer").val();
	
      	if(BankTransfer=="1"){	
		$("#BankTransfer" ).prop( "disabled", true );
		$("#BankTransfer" ).prop( "class", "disabled" );
		$("#CurrencyShowHide").html('');
		$("#addrowdiv").html('');

		$(".bank_currency_td").show();
		$(".conversion_td").show();
		 
		$("#JournalType").val("one_time"); 
		$("#JournalType" ).prop( "disabled", true );
		$("#JournalType").attr("class","disabled");
		$("#JournalType").trigger("change");
		$("#JournalType").hide();
		$("#JournalType").closest('td').prev('td').html('');

		$("#totallabel").hide();
		if(JournalID<=0){
			$("#DebitAmnt1").val("0.00"); $("#DebitAmnt2").val("0.00");
			$("#CreditAmnt1").val("0.00"); $("#CreditAmnt2").val("0.00");
		}
 
		$("#DebitAmnt1").attr("class","disabled");$("#DebitAmnt1").attr("readonly","true");
		$("#DebitAmnt2").attr("class","disabled");$("#DebitAmnt2").attr("readonly","true");
		$("#CreditAmnt2").attr("class","disabled");$("#CreditAmnt2").attr("readonly","true");

		$("#CreditAmnt1").blur(function(){
			GetBankCurrencyRate();
		}); 
		

	 	$("table.order-list").find('select[name^="AccountID"]').each(function () {
			var id =  $(this).attr("id").replace("AccountID", "");
 
			if(id>2){
				$(this).closest("tr").remove();
			}else{			
				$("#AccountID"+id+" option").each(function() {
				     var BankFlag = $(this).attr("BankFlag");
				     if(BankFlag=="0")$(this).remove();
				});
				
				if(JournalID<=0){
					$("#AccountID"+id).val('');
					$("#AccountID"+id).select2();
				}else{
					SetBankCurrency(id,1); //on load in edit
				}
 
				$("#AccountID"+id).change(function(){
 					SetBankCurrency(id,0);
				}); 
				
			}			 
 
		}); 		  
			 
        }else{
		$(".bank_currency_td").hide();
		$(".conversion_td").hide();
	}         
}
/********************************/
</script>

<? if (!empty($errMsg)) {?>
    <div align="center"  class="red" ><?php echo $errMsg;?></div>
  <?php }
    else{  
  
      //if ($currentDate >= $GLFROM && $currentDate <= $GLTO) { 
        if ($FiscalYearStartDate == "" && $FiscalYearEndDate == "") {
          
          echo '<div class="red" style="font-size: 15px;text-align: center">'.SETUP_FISCAL_YEAR.'</div>';
           
                
      }else{
           if(!empty($_GET['edit'])){
                             include("includes/html/box/edit_journal_entry_form.php");
                     }else {
                             include("includes/html/box/add_journal_entry_form.php");
                     }
      }        
   }	
 ?>
