		<? 
	 
		require_once($MainPrefix."includes/html/box/pop_loader.php"); 
	require_once("includes/html/".$SelfPage);


$FooterStyle='';


if($LoginPage!=1){

	?>
	
		<? if($InnerPage==1){
			//echo 'Test';
				echo '</div>';				
				if($ThisPageName=='dashboard.php'){
					
					if($_SESSION['UserType']=='customer')
					$RightFile = 'includes/html/box/right_vCustomer.php';
					elseif($_SESSION['UserType']=='vendor')
					$RightFile = 'includes/html/box/right_v_supplier.php';
					elseif($_SESSION['UserType']=='customerContact')
						$RightFile = 'includes/html/box/right_v_customerContact.php';
					else 
					$RightFile = 'includes/html/box/right_'.$SelfPage;						
				}else{				
				$RightFile = 'includes/html/box/right_'.$SelfPage;					
				}				
				if(file_exists($RightFile)){				
					include($RightFile);
				}else{	
					$SetInnerWidth=1;
				}
				
				
				if($SetInnerWidth==1){	
					if($SetFullPage==1){
						echo '<script>SetFullPage();</script>';
					}else{		
						echo '<script>SetInnerWidth();</script>';
					}
				}
				
			}
		 ?>
	
	</div>
	<div class="clear"></div>
 </div>
<? }else{ $FooterStyle = 'style="background:none"'; } ?>



	<? if($HideNavigation!=1){ ?>

  <div id="footer" class="footer-container clearfix" <?=$FooterStyle?>>
    	<div class="footer">
        	 <div class="copyright">Copyright &copy; <?=$arrayConfig[0]['SiteName']?>. All Rights Reserved. </div>
        </div>
    </div>


	<div id="dialog-modal" style="display: none;"></div>
	<? } ?>
	
</div>


<? 

if(empty($arryCompany[0]['Department']) || substr_count($arryCompany[0]['Department'],5)==1){

	if(!empty($_SESSION['CmpID']) && !empty($_SESSION['AdminID'])  && $HideNavigation!=1){ 
		require_once($MainPrefix."includes/html/box/pop_crm.php");
	}
}
 ?>


</body>
</HTML>

<style>
.three-four{
width:84% !important;
}
</style>

<script language="javascript1.2" type="text/javascript">
function SetThreeFourthPage(){
	document.getElementById("inner_mid").style.width="84%";
	$(".main-container .main .left-main-nav").hide();

}

$(document).ready(function () {
	if( $('#inner_mid').length )         
	{
		SetThreeFourthPage();  
	}
	$("#ZipCode").on("click", function () { 
		autozipcode();
	});	
	 
});

function showChart(obj){
	var arrField = obj.value.split(":");

	$('#'+arrField[0]).show();
	$('#'+arrField[1]).hide();
}

if(document.getElementById("list_table") != null){
	$('#list_table tr:nth-child(even)').addClass('evenbg');
	$('#list_table tr:nth-child(odd)').addClass('oddbg');

	$('#list_table tr:first-child').removeAttr('class');
	$('#list_table tr:last-child').removeAttr('class');

	/***************************/
	/*$('.export_button').attr('title', $('.export_button').val());
	$('.print_button').attr('title', $('.print_button').val());
	$('.add').attr('title', $('.add').html());
	$('.add_quick').attr('title', $('.add_quick').html());
	/***************************/
}



if(document.getElementById("load_div") != null){
	document.getElementById("load_div").style.display = 'none';
	
	var TitleBar = remove_tags($('.had')[0].innerHTML);
	window.document.title = TitleBar;

}
</script>


