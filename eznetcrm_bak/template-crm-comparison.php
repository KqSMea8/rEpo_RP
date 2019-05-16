

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

										<h1 id="page-title" class="title">eZnet CRM Pricing &amp;
											Signup</h1>
										<div id="messages">
											<div class="">
												<div
													style="overflow: visible; position: fixed; z-index: 9999; width: 400px; top: 46px; left: 474.5px; display: none;"
													id="better-messages-wrapper"
													class="better-messeges-processed">
													<div id="better-messages-default">
														<div id="messages-inner">
															<table>
																<tbody>
																	<tr>
																		<td class="tl"></td>
																		<td class="b"></td>
																		<td class="tr"></td>
																	</tr>
																	<tr>
																		<td class="b"></td>
																		<td class="body">
																			<div class="content">
																				<h2 class="messages-label error">Error</h2>
																				<div class="messages error">
																					<ul>
																						<li class="message-item first"><em
																							class="placeholder">Notice</em>: Undefined index:
																							und in <em class="placeholder">comparison_search_view()</em>
																							(line <em class="placeholder">54</em> of <em
																							class="placeholder">/home/crmuser/public_html/sites/all/modules/custom/comparison/comparison.module</em>).</li>
																						<li class="message-item"><em class="placeholder">Notice</em>:
																							Undefined index: und in <em class="placeholder">comparison_search_view()</em>
																							(line <em class="placeholder">54</em> of <em
																							class="placeholder">/home/crmuser/public_html/sites/all/modules/custom/comparison/comparison.module</em>).</li>
																						<li class="message-item last"><em
																							class="placeholder">Notice</em>: Undefined index:
																							und in <em class="placeholder">comparison_search_view()</em>
																							(line <em class="placeholder">54</em> of <em
																							class="placeholder">/home/crmuser/public_html/sites/all/modules/custom/comparison/comparison.module</em>).</li>
																					</ul>
																				</div>
																			</div>
																			<div class="footer">
																				<span class="message-timer" style="display: none;"></span><a
																					href="#" class="message-close"></a>
																			</div>
																		</td>
																		<td class="b"></td>
																	</tr>
																	<tr>
																		<td class="bl"></td>
																		<td class="b"></td>
																		<td class="br"></td>
																	</tr>
																</tbody>
															</table>
														</div>
													</div>

												</div>
											</div>
										</div>
										<!-- /.section, /#messages -->
										<div class="tabs"></div>

										<div id="banner"></div>
										<div class="region region-content">
											<div class="block block-system" id="block-system-main">


												<div class="content">
													<div class="CompareWrap">
														<div class="compareleftinfo1">
														<?php
														$feature=$pf=$pktfeatureVal=$allpackages=array();
														
														$pf=getPackFeature();
														if(!empty($pf)){
															foreach($pf as $pfKey=>$pfValue){
																$feature[$pfValue['ModuleID']]=$pfValue['feature'];
																	
															}
														}
															
														$pkType=getPackType();
														//echo "<pre>";print_r($pkType);
														$packagefeature=array();

														if(!empty($pkType)){
															$j=0;
															foreach($pkType as $pktKey=>$pktValue){
                                                                 
																$pktfeatureVal=array();
																$pktfeatureVal = unserialize($pktValue['value']);
																// print_r($pktfeatureVal);
																$allpackages=getPack('AND package_type="'.$pktValue['id'].'"');
																echo '<div class="heading-cl">'.$pktValue['name'];
																
																?>

															<ul class="cl-lft<?php echo $j;?>">
																<li>Free Space</li>
																<li>Additional Space Price</li>
															</ul>
															<?php
															echo'</div>';

															if(!empty($allpackages)){	$i=0;
															foreach($allpackages as $allpackage){
																//print_r($allpackage);
																$packagefeature[$i]=unserialize($allpackage['features']);
																//echo '<div class="heading-cl">'.$allpackage['name'].'<span class="price">' .$allpackage['price'].'</span><span class="unit">'.$allpackage['duration'].'</span><span class="Free_space">'.$allpackage['space'].'</span><span class="Additional_space">'.$allpackage['free_space'].'</span>
																?>
															<div class="heading-cl">

																<li class="headings"><?php echo $allpackage['name'];?></li>
																<?php
																if(!empty($allpackage['price'])){?>

																<li class="listprice">us<span class="price"> $<?php echo $allpackage['price'];?>
																</span><span class="unit"><?php echo $allpackage['duration'];?>
																</span></li>
																<li class="Free_space"><?php echo $allpackage['space'];?>GB</li>
																<li class="Additional_space">$<?php echo $allpackage['additional_spaceprice'];?>
																	/ 10GB</li>

																	<?php }
																	?>

															</div>
															<?php

															$i++;
															}
															}

															//asort($pktfeatureVal);
															$max = sizeof($pktfeatureVal);
															//echo $max;
															foreach($pktfeatureVal as $pktfeature){
																 ++$k;
																
																
																echo '<ul class="feature-list-compare"><li>'.$feature[$pktfeature];
																if(!empty($packagefeature)){
																	
																	foreach($packagefeature as $packagefea){
																		
																		//echo '<li>';
																		//echo (in_array($pktfeature,$packagefea))?'Yes':'No';
																		
																		?>
															<li class="<?php if(in_array($pktfeature,$packagefea)){echo "yes";}else{echo "no";}?>"><?php if(in_array($pktfeature,$packagefea)){echo "yes";}else{echo "no";}?>
															</li>
															<?php
															
		
															
															
															
															//echo '</li>';
																	}
																	
																	
																}
																	
																echo '</li>';
																
																//echo '<li>' .end($pktfeatureVal).'</li>';
																
																	
																
																echo '</ul>';
																
																if($k==$max){
																echo '<ul class="feature-list-compare"><li></li>
																<li class="upgrade"><span class="buttons1"><a href="index.php?slug=upgrade&pack_id=7">Upgrade Now</a></span></li>
															    <li class="upgrade"><span class="buttons1"><a href="index.php?slug=upgrade&pack_id=8">Upgrade Now</a></span></li>
																<li class="upgrade"><span class="buttons1"><a href="index.php?slug=upgrade&pack_id=9">Upgrade Now</a></span></li>
																</ul>';
																}
																
															}
															$j++;
															
														
																
															}
															
															
														}
																												
																
														//print_r($packagefeature);
														?>
														
														<ul class="feature-list-compare"><li></li>
																<li class="upgrade"><span class="buttons1"><a href="index.php?slug=upgrade&pack_id=7">Upgrade Now</a></span></li>
															    <li class="upgrade"><span class="buttons1"><a href="index.php?slug=upgrade&pack_id=8">Upgrade Now</a></span></li>
																<li class="upgrade"><span class="buttons1"><a href="index.php?slug=upgrade&pack_id=9">Upgrade Now</a></span></li>
														</ul>

														</div>
													</div>

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

