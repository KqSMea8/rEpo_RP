<div class="right-search">
            	<h3><span class="icon"></span>Search</h3>
               
				
				<form class="admin_r_search_form" action="" method="get" name="form2" onSubmit="return ValidateSearch();">
                    <fieldset>
                        <label>Date: </label>
                        <div>
								
						<script type="text/javascript">
						$(function() {
							$('#dt').datepicker(
								{
								showOn: "both", dateFormat: '<?=$Config["DateFormatJS"]?>', 
								yearRange: '1950:<?=date("Y")?>', 
								maxDate: "+1D", 
								changeMonth: true,
								changeYear: true
						
								}
							);

					$("#dt").on("click", function () { 
						$(this).val("");
						}
					);



						});
						</script>
						<input id="dt" name="dt" readonly="" size="10" value="<?=$_GET['dt']?>"  type="text" > 
                         </div>
                    </fieldset>
                  
				  
                    <fieldset>
						<input name="s1" type="submit" class="button_btn" value="Search"  />
                    </fieldset>
                </form>
				<br /><br />
				 <form  class="admin_r_search_form" action="" method="get" name="form3" onSubmit="return ValidateSearch2();">
					 <fieldset>
                        <label>Year: </label>
						 <div class="sel-wrap">
						<?=getYears($_GET['y'],"y","")?>
						</div>
					 </fieldset>
					 <fieldset>
                        <label>Month: </label>
						<div class="sel-wrap">
						<?=getMonths($_GET['m'],"m","textbox")?>
						</div>
					 </fieldset>
				
				
					<fieldset>
						<input name="s2" type="submit" class="button_btn" value="Search"  />
                    </fieldset>
				
				</form>	
            </div>
