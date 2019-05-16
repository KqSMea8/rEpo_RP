</div>
		<? //require_once($MainPrefix."../includes/html/box/pop_loader.php"); ?>



	<? require_once("includes/html/".$SelfPage); ?>

		<footer id="footer">

			<div class="wrap clearfix">

				<div class="followUs">
					<h2>Follow Us</h2>
					<div class="region region-footer-firstcolumn">
						<div id="block-block-1" class="block block-block">


							<div class="content">
								<ul>
								<?php
								$socialDat=getSocialLinks();
								foreach($socialDat as $socialData){?>
									<li><a href="<?php echo $socialData['URI'];?>" target="_blank"><img
											src="../../images/<?php echo $socialData['Icon'];?>"> </a></li>
											<?php } ?>


								</ul>


								<br> <br> <br> <br> <br>
								<h2>Subscribe to our Newsletter</h2>
							</div>
						</div>
						<div id="block-simplenews-1" class="block block-simplenews">


							<div class="content">

								<div style="display: none;"
									id="clientsidevalidation-simplenews-block-form-1-errors"
									class="messages error clientside-error">
									<ul></ul>
								</div>
								<form novalidate="novalidate" class="simplenews-subscribe"
									id="srform" name="form" accept-charset="UTF-8">
									<div>
										<div class="form-item form-type-textfield form-item-mail">
											<label for="edit-mail">E-mail <span class="form-required"
												title="This field is required.">*</span> </label> <input
												placeholder="Your Email" id="email" name="email" size="20"
												maxlength="128" class="form-text required" type="text">
										</div>
										<a href="javascript:void(0)" id="submit"
											onclick="subcription()">Subscribe</a>
										<!-- <input id="submit" onclick="subcription()" name="submit" value="Subscribe" type="submit"> -->
										<div class="msg"></div>
									</div>
								</form>


							</div>
						</div>
					</div>

				</div>

				<div class="quickLinks">

					<div class="region region-footer-secondcolumn">
						<div id="block-system-main-menu"
							class="block block-system block-menu">

							<h2>Main menu</h2>

							<div class="content">
								<ul class="menu">
								<?php
								$bannerDt=showBanner();
								foreach($mData as $meData){ //echo "<pre>";print_r($meData);?>

									<li id="menu-218-1" class="leaf"><a
										href="index.php?slug=<?php echo $meData['UrlCustom'];?>"
										class="sf-depth-1"><?php echo $meData['Title'];?> </a>
									</li>


									<?php } ?>

								</ul>

							</div>
						</div>
					</div>
					<div class="region region-footer">
						<div id="block-block-17" class="block block-block">


							<div class="content">
								<p
									style="font-size: 14px; font-family: 'Open Sans', sans-serif; text-align: center; font-weight: 400;">
									&#169;
									<?php echo date("Y"); ?>
									, eZnet CRM. All Rights Reserved
	<br><br><span>Powered By: <a href="http://www.virtualstacks.com" target="_blank">Virtual Stacks</a></span></p>

								</p>
							</div>
						</div>
					</div>

				</div>

				<div class="newsLetter logedout">

					<div class="region region-footer-thirdcolumn">
						<div id="block-block-15" class="block block-block">


<div class="content">
<p style="line-height: 175%;">&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;<img src="../img/eZnetLogo_0_1.png" alt="eZnet CRM logo" title="eZnet CRM logo"></p>

<p><img width="30px" height="30px" style="display: inline; vertical-align: text-bottom;" src="../img/headphones-icon-customer-support_1.png"><span style="font-family:'Open Sans', sans-serif; font-size:15px; font-weight: 400; line-height: 150%;">&nbsp;&nbsp;407-544-3201 | 1-877-368-4446</span></p>
<p><img width="30px" height="30px" style="display: inline; vertical-align: text-bottom;" src="../img/edit-icon_0.png"><span style="font-family:'Open Sans', sans-serif; font-size:15px; font-weight: 400; line-height: 150%;">&nbsp; <a href="mailto:info@eznetcrm.com">info@ezShare.com</a></span></p>
</div>


						</div>
					</div>

				</div>

			</div>

		</footer>


	</div>


	<p style="display: none;" id="back-top">
		<a href="#top"><span id="button"></span><span id="link">Back to top</span>
		</a>
	</p>
		<div id="dialog-modal" style="display: none;"></div>
</body>
</html>