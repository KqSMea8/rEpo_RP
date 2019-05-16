<?
 
/****************/  	
$SessionTimeoutBefore = $_SESSION['SessionTimeout'] - 120;
$SessionTimeoutBeforeMili = $SessionTimeoutBefore*1000;
$SessionTimeout = (time() + $_SESSION['SessionTimeout'])*1000; 
/****************/
?>

<div id="session_div" style="display:none;width:550px;border:none;background:none"  >
<table width="100%" border="0" cellpadding="5" cellspacing="0" >	 
	<tr>
		 <td colspan="2" align="left" class="head" >Your session is about to expire...</td>
	</tr>
	<tr>
		 <td   align="center" >&nbsp;</td>
	</tr>
	<tr>
		 <td colspan="2" align="center"><b>Please renew session to continue.</b></td>
	</tr>
<tr>
		 <td   align="center" >&nbsp;</td>
	</tr>
	<tr>
		 <td colspan="2" align="center" ><div id="defaultCountdown" ></div> </td>
	</tr>
	<tr>
		 <td   align="center" >&nbsp;</td>
	</tr>
	<tr>
		 <td colspan="2" align="center"><input type="button" name="RenewSession" id="RenewSession"  class="button" value="Renew Session">&nbsp;&nbsp;&nbsp;<input type="button" name="CancelSession" id="CancelSession" class="button" value="Cancel">



</td>
	</tr>
	<tr>
		 <td colspan="2" >&nbsp;</td>
	</tr>
</table>
</div>

<link rel="stylesheet" href="<?=$Prefix?>countdown/jquery.countdown.css">
 
<script src="<?=$Prefix?>countdown/jquery.plugin.js"></script>
<script src="<?=$Prefix?>countdown/jquery.countdown.js"></script>
 <script>
$(function () {
	var austDay = new Date(<?=$SessionTimeout?>);
	 
	 
	//austDay.setTime( austDay.getTime() + austDay.getTimezoneOffset()*60*1000 );

	$('#defaultCountdown').countdown({until: austDay});
	$('#year').text(austDay.getFullYear());
});
</script>

<script language="JavaScript1.2" type="text/javascript">
	var SessionExpiry  = 0 ;
	
	function session_checking(){
		var responseText='';
		var sendParam='&r='+Math.random();  
                $.ajax({
                        type: "GET",
                        async:false,
                        url: "<?=$MainPrefix?>session_expiry.php",
                        data: sendParam,
                        success: function (responseText) {  
                                 if(responseText == "EXPIRED"){	
					SessionExpiry  = 1 ;
					$("#session_div").fancybox({'closeBtn': false }).click();
				 }
                        }
                });


		/*
	    	$.post( "<?=$MainPrefix?>session_expiry.php", function( Respdata ) {
		alert(Respdata);

		if(Respdata == "1"){
			alert('not expired');
		}else{
			alert('expired');
			SessionExpiry  = 1 ;
			   $("#session_div").fancybox({  'closeBtn': false }).click(
		
			   );
			   //alert("Your session is about to expire. Please click ok to renew session.");
			   //location.reload();         
		} 

	   	 });
		*/


	}

	$(document).ready(function(){	
		window.setTimeout(session_checking, <?=$SessionTimeoutBeforeMili?>);   
		setInterval(CheckExpiryTime, 2000);   
	});



	$('#RenewSession').on('click', function(e) {
		e.preventDefault();
		e.stopPropagation();		
		//$.fancybox.close();
		location.reload(); 
	});


	$('#CancelSession').on('click', function(e) {
		e.preventDefault();
		e.stopPropagation();		
		//$.fancybox.close();
		location.href = "<?=$MainPrefix?>logout.php";
	});


	function CheckExpiryTime(){
		var Hour = $('#defaultCountdown .countdown-section .countdown-amount')[0].innerHTML;
		var Min = $('#defaultCountdown .countdown-section .countdown-amount')[1].innerHTML;
		var Sec = $('#defaultCountdown .countdown-section .countdown-amount')[2].innerHTML;
		if(SessionExpiry==1 && Min==0 && Sec==0){
			location.href = "<?=$MainPrefix?>logout.php";
		}	
	}

</script>
