
			

<div class="right-search">
            	<h3><span class="icon"></span>Search</h3>
               
	 <form onsubmit="return LoaderSearch();" name="form2" enctype="multipart/form-data" class="admin_r_search_form" method="get" action="">
			<fieldset>  
			<label>Select Vendor:</label>
			<div class="sel-wrap">
			<select id="vendor" name="vendor">
			<?php  if(count($getvendorByCompnayID)>0){ foreach($getvendorByCompnayID as $values){  ?>                       
			<option value="<?php echo $values['ref_id']; ?>" <?php if($_GET['vendor']==$values['ref_id']){ echo  "selected"; } ?>><?php echo  $values['fname']." ".$values['lname'] ;?>  </option>
			<?php  } } ?>
			</select>
			</div>
			</fieldset>
					  
			<fieldset>  
			<label>Select Location:</label>
			<div class="sel-wrap">
			<select id="location" name="location">
			
			</select>
			</div>
			</fieldset>                   

			 <fieldset>
                     <label>Order ID:</label>
                      <input type="text" value="<?php  echo $_GET['OrderID']; ?>" class="inputbox" id="OrderID" name="OrderID"> 
             	</fieldset>
                 <fieldset>  
                    <label>Order Status:</label>
                     <div class="sel-wrap">
                      <select id="OrderStatus" name="OrderStatus">
                        <option value="" selected="">Any</option>
                        <option value="processing" <?php if($_GET['OrderStatus']=="processing"){ echo  "selected"; } ?>>Process</option>
                        <option value="cancelled" <?php if($_GET['OrderStatus']=="cancelled"){ echo  "selected"; } ?>>Cancelled</option>
                        <option value="completed" <?php if($_GET['OrderStatus']=="completed"){ echo  "selected"; } ?>>Completed</option>
                      </select>
                      </div>
                      </fieldset>
                  
                     
                    <fieldset>  
                    <label>Order Period:</label>
                     <div class="sel-wrap">
					 <!--
                      <select id="OrderPeriod" name="OrderPeriod">
                       <option selected="" value="">Any</option>
                        <option value="24" <?php if($_REQUEST['OrderPeriod']=="24"){ echo  "selected"; } ?>>Last 24 hours</option>
                        <option value="72" <?php if($_REQUEST['OrderPeriod']=="72"){ echo  "selected"; } ?>>Last 3 days</option>
                        <option value="168" <?php if($_REQUEST['OrderPeriod']=="168"){ echo  "selected"; } ?>>Last week</option>
                        <option value="336" <?php if($_REQUEST['OrderPeriod']=="336"){ echo  "selected"; } ?>>Last 2 weeks</option>
                        <option value="744" <?php if($_REQUEST['OrderPeriod']=="744"){ echo  "selected"; } ?>>Last month</option>
                      </select>
					  -->
					 <input id="f" name="f"  class="datebox" readonly="" value="<?php echo $_GET['f'];?>" placeholder="From Date" type="text">
					 <input id="t" name="t" class="datebox"  readonly="" value="<?php echo $_GET['t'];?>" placeholder="To Date" type="text">
                      </div>
                      </fieldset>
                   
                                                  
                          <fieldset>
                           <input type="submit" value="Search" class="button_btn" name="search">
                            </fieldset>
                 

            </form>
            </div>
			
<script>

$(function(){
	
	var getVendor  =  $("#vendor").val();
	var getSelectedLocation   =  "<?php echo  $_GET['location'];   ?>";
	    if(getVendor){
			 $.ajax({
				    type:'get',
                    url:'ajax.php',
                    data:{'vendor':getVendor,'location':getSelectedLocation,'action':'getLocation'},
                    success:function(respose){
						if(respose){
							$("#location").html(respose);
							
						}
					}					
				 
			  });
		}
		
		
	$("#vendor").on('change',function(){
		var getVendor  =  $("#vendor").val();
	    if(getVendor){
			 $.ajax({
				    type:'get',
                    url:'ajax.php',
                    data:{'vendor':getVendor,'action':'getLocation'},
                    success:function(respose){
						if(respose){
							$("#location").html(respose);
							
						}
					}					
				 
			  });
		}
	});	
	
});

</script>

<script>
$(function() {
	$('#f').datepicker(
				{
				showOn: "both",dateFormat: 'yy-mm-dd', 
				yearRange: '<?=date("Y")-20?>:<?=date("Y")?>', 
				maxDate: "+0D", 
				changeMonth: true,
				changeYear: true

				}
			);
});
</script>
<script>
		$(function() {
			$('#t').datepicker(
				{
				showOn: "both",dateFormat: 'yy-mm-dd', 
				yearRange: '<?=date("Y")-20?>:<?=date("Y")?>', 
				maxDate: "+0D", 
				changeMonth: true,
				changeYear: true

				}
			);
		});
		</script>
