<?php
//IsCrmSession();
ValidateCrmSession();
require_once("../classes/cmp.class.php");
$objCmp=new cmp();
$CmpId=$_SESSION['CrmAdminID'];
$arrayOrder=$objCmp->getOrderByCmpId($CmpId);
$num=$objCmp->numRows();
//print_r($arrayOrder);

?>	

	<style>
.tabs {
	display: block;
}

#page-title {
	color: #333;
	font-size: 32px;
	font-weight: 300;
	margin: 50px 0 0;
	padding: 0 0 30px;
	text-align: left;
}
</style>


<div class="top-cont1"> </div>

			<section id="mainContent">
			<?php //echo $datah['Content'];?>

				<div class="InfoText">

					<div class="wrap clearfix">





						<article id="leftPart">

							<div class="detailedContent">
								<div class="column" id="content">
									<div class="section">
										<a id="main-content"></a>




											<h1 id="page-title" class="title">Payment History</h1>

										<div class="message" id="msg_div" align="center">
										<? if(!empty($_SESSION['mess_dash'])) {echo $_SESSION['mess_dash']; unset($_SESSION['mess_dash']); }?>
										</div>

										<div class="tabs">
											<h2 class="element-invisible">Primary tabs</h2>
											<ul class="tabs primary">
												<li><a href="my-profile">My Profile</a></li>
												<li class="active"><a class="active"
													href="index.php?slug=payment-history">Payment History<span
														class="element-invisible">(active tab)</span> </a></li>
												<li><a href="change-password">Change Password</a>
												</li>
											</ul>
										</div>

										<div id="banner"></div>
										<div class="region region-content">
											<div class="block block-system" id="block-system-main">
												<div id="msg_div" class="message">
												<?=$mess?>
												</div>

												<div class="content">
													<div class="error">
													<?php echo $error;?>

													</div>

													<h2></h2>
													<table>
														<tbody>
															<tr>
																<th>Plan Type</th>
																<th>Start Date</th>
																<th>End Date</th>
																<th>Updated Date</th>
																<th>No Of Users</th>
																<th>Plan Duration</th>
																<th>Total Amount($)</th>
																<th>Status</th>
																<th>Transaction Id</th>
																<th>Free Space</th>
																<th>Additional Space</th>
															</tr>
															<?php 
															
															if(is_array($arrayOrder) && $num>0){
															  	$flag=true;
																$Line=0;
															  	foreach($arrayOrder as $key=>$values){
															?>
															<tr>
																<td><?php echo stripslashes($values["PaymentPlan"]);?></td>
																<td><?php echo date("j F, Y",strtotime($values['StartDate']));?></td>
																<td><?php echo date("j F, Y",strtotime($values['EndDate']));?></td>
																<td><?php echo date("j F, Y",strtotime($values['UpdatedDate']));?></td>
																<td><?php echo stripslashes($values["MaxUser"]);?></td>
																<td><?php echo stripslashes($values["PlanDuration"]);?></td>
																<td><?php echo stripslashes($values["TotalAmount"]);?></td>
																<td><?php  if($values['Status'] ==1){echo 'Success'; }else{ echo  'Pending';}?></td>
																<td><?php echo stripslashes($values["TransactionID"]);?></td>
																<td><?php echo $values["FreeSpace"].' '.$values["FreeSpaceUnit"];?></td>
																<td><?php if($values["AdditionalSpace"]>0){echo $values["AdditionalSpace"].' '.$values["AdditionalSpaceUnit"];}?></td>
															</tr>
															<?php } }else{?>
															<tr>
																<td colspan=11>No Record Found.</td>
																
															</tr>
															<?php } ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

						</article>

					</div>

				</div>
			</section>

		</div>


	