
<div class="main-container clearfix">
    <div class="main">
	
      <div class="my-dashboard-nav clearfix">
	  <h4 class="had">My <?=$ModuleName?></h4>

<? include("../includes/html/box/clock.php");
   include("../includes/html/box/icon.php");
                $WidthRow1 = 'width:270px;'; 
		$WidthRow2 = 'width:270px;'; 
		$WidthRow3 = 'width:380px;';
		$callFlag = $CommFlag = $SalesReportFlag = '';



?>
       
      </div>
      
      <div class="my-dashboard clearfix">
        <div class="rows clearfix callrow" style="display:block;">
<? /****************************************First Row *********************/ ?>
                    
          <?    if(in_array('102',$arryMainMenu)){  
			include("includes/html/box/home_lead.php"); 
		}
		if(in_array('176',$arryMainMenu)){ 
			if($_SESSION['AdminType'] != "admin"){	
				$callFlag=1;		 	
				include("includes/html/box/home_call_quota.php"); 
			}
		}

	      if(in_array('104',$arryMainMenu) && $callFlag!=1){
		include("includes/html/box/home_ticket_open.php"); 
	      }


	    
	     	if($_SESSION['AdminType'] != "admin"){ 
			if(empty($arryCompany[0]['Department']) || substr_count($arryCompany[0]['Department'],7)==1){
				$CommFlag=1;
				$StyleCom = 'style="width:380px;margin-right:10px;"';
				require_once("../includes/html/box/commission_dashboard.php"); 
			}
		}

		if(in_array('136',$arryMainMenu) && $CommFlag!=1){
			include("includes/html/box/home_task_chart.php");
		}
	 ?>    
          
	</div>
<? /****************************************First Row Close*********************/ ?>
<? /****************************************Second Row *********************/ ?> 
 <div class="rows clearfix" style="display:block;"> 
	 <?  
	      if(in_array('103',$arryMainMenu)){ 
	      	include("includes/html/box/home_opp.php"); 
	      }
		
	      if(in_array('136',$arryMainMenu)){
		include("includes/html/box/home_task.php"); 
	      }
	      

	      if($_SESSION['AdminType'] != "admin"){ 
		if(empty($arryCompany[0]['Department']) || substr_count($arryCompany[0]['Department'],7)==1){		  
			$SalesReportFlag=1;
			include("includes/html/box/home_comm_report.php"); 
		}
	     }

	      if(in_array('104',$arryMainMenu) && $SalesReportFlag!=1){ 	
			include("includes/html/box/home_ticket_priority.php"); 	
	      }

	 ?> 

</div>

<? /****************************************Second Row Close*********************/ ?>


<? /****************************************Third Row *********************/ ?>

        <div class="rows clearfix" style="display:block;">
	  <?  if(in_array('108',$arryMainMenu)){  
		include("includes/html/box/home_created_quote.php");
	      }
	      if(in_array('106',$arryMainMenu)){
		include("includes/html/box/home_campaign.php");
	      }
	
	     if(in_array('108',$arryMainMenu)){
		include("includes/html/box/home_quote.php"); 
	      }


		

		
		
	?>
      
<? /****************************************Third Row close *********************/ ?>
        </div>
  <?php /*************** Four Row ********************/ ?> 

	
	
	
	<div class="rows clearfix" style="display:block;">
	<? 

if($Config['FullPermission']==1){
	include("includes/html/box/home_sales_comm_chart_admin.php"); 
}


 ?>
	 </div>
	
	
        <div class="rows clearfix callrowadmin" style="display:block;">
	  <?  
	if(in_array('176',$arryMainMenu)){ 
		if($Config['FullPermission']==1){
		//if(in_array('176',$arryMainMenu)){ 
			include("includes/html/box/home_call_quota_admin.php"); 
		}
	}

//if(!empty($empQuota[0]->q_time) AND 1==2){
?>
	 <!--div class="second_col" style="width:355px;">
            <div class="block p_timesheets">
	              <h3>Call Graph</h3>
	              <div class="bgwhite" style="padding-top:5px;">	             
					<img src="barcall.php?quota=<?php //echo $empQuota[0]->q_time?>&total=<?php //echo $total;?>">					
	              </div>
              </div>
       </div-->
<?php //}?>
          
 
        </div>
	



        
      
</div>




    </div>
  </div>
  


