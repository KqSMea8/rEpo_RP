<div class="main-container clearfix">
    <div class="main">
	
      <div class="my-dashboard-nav clearfix">
	  <h4 class="had">My Dashboard</h4>
		<?  include("../includes/html/box/clock.php");	
		
			include("../includes/html/box/icon.php");
		 
		?>
      </div>
	  
	  
      <div class="my-dashboard clearfix">
        <?  
		if($ShowDashboard==1){
				$WidthRow1 = 'width:270px;'; 
				$WidthRow2 = 'width:380px;'; 
				$WidthRow3 = 'width:270px;';
		
				include("includes/html/box/home_row1.php");
		
				if($ShowEmp==1){ 
				 	include("includes/html/box/home_row2.php");
				} 
		
		
				//include("includes/html/box/home_row3.php");
				 

		
				if($ShowEmp==1 && $IsDeptHead==1 && $arryEmployee[0]['ExistingEmployee']==1){ 
					include("includes/html/box/home_row_leave.php");
				} 
		}
		?>
		
		
        
      </div>
    </div>
  </div>


<? 
	/*if($_SESSION['AdminType'] == "employee") { 
		include("includes/html/box/punch_form.php"); 
	}*/
	include("includes/html/box/holiday_list.php");

?>

