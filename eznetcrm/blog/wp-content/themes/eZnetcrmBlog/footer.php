<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>      
        </div>
	</div><!-- #main .wrapper -->
        </div><!--mainContainer -->
	<footer id="footer">

			<div class="wrap clearfix respfooter">

				<div class="followUs">
					<h2 class="followus">Follow Us</h2>
					<div class="region region-footer-firstcolumn">
						<div class="block block-block" id="block-block-1">


							<div class="content">
								<div class="social-icon">
																	<span><a target="_blank" href="https://www.facebook.com/pages/eZnetCRM/1499005770386551?fref=ts"><img src="<?php bloginfo('template_directory');?>/images/1421322090facebook_circle1_1.png" title="Follow eZnet CRM on facebook" alt="Follow eZnet CRM on facebook"> </a></span>
																				<span><a target="_blank" href="https://twitter.com/eZnetCRM"><img src="<?php bloginfo('template_directory');?>/images/1421322112twitter-old1_0.png" title="Follow eZnet CRM on twitter" alt="Follow eZnet CRM on twitter"> </a></span>
																				<span><a target="_blank" href="https://plus.google.com/+EznetcrmSoftware/posts"><img src="<?php bloginfo('template_directory');?>/images/1421322124google_circle1_1.png" title="Follow eZnet CRM on google plus" alt="Follow eZnet CRM on google plus"> </a></span>
																				<span><a target="_blank" href="https://www.youtube.com/channel/UCIebsABUVH8G9kG1sRtNxEA"><img src="<?php bloginfo('template_directory');?>/images/1421322192youtube1_0.png" title="Follow eZnet CRM on youtube" alt="Follow eZnet CRM on youtube"> </a></span>
											

								</div>


								
								<h2 class="Subscribe">Subscribe to our Newsletter</h2>
							</div>
						</div>
						<div class="block block-simplenews" id="block-simplenews-1">


							<div class="content">

								<div class="messages error clientside-error" id="clientsidevalidation-simplenews-block-form-1-errors" style="display: none;">
									<ul></ul>
								</div>
								<form accept-charset="UTF-8" name="form" id="srform" class="simplenews-subscribe" novalidate="novalidate">
									<div>
										<div class="form-item form-type-textfield form-item-mail">
											<label for="edit-mail">E-mail <span title="This field is required." class="form-required">*</span> </label> <input type="text" class="form-text required" maxlength="128" size="20" name="email" id="email" placeholder="Your Email">
										</div>
										<a onclick="subcription()" id="submit" href="javascript:void(0)">Subscribe</a>
										<!-- <input id="submit" onclick="subcription()" name="submit" value="Subscribe" type="submit"> -->
                                                                                <div class="msg" style="display:none;"><span class="error">Please Enter Valid Email</span></div>
									</div>
								</form>


							</div>
						</div>
					</div>

				</div>

				<div class="quickLinks">

					<div class="region region-footer-secondcolumn">
						<div class="block block-system block-menu" id="block-system-main-menu">

							<h2>Main menu</h2>

							<div class="content">
								<ul class="menu footmenu">
								
									<li class="leaf" id="menu-218-1"><a style="text-transform:none;" class="sf-depth-1" href="<?php echo get_site_url(); ?>">Home </a>
									</li>


									
									<li class="leaf" id="menu-218-1"><a style="text-transform:none;" class="sf-depth-1" href="<?php $url?>/erp/eznetcrm/index.php?slug=about-eznet-crm">About eZnet CRM </a>
									</li>


									
									<li class="leaf" id="menu-218-1"><a style="text-transform:none;" class="sf-depth-1" href="<?php $url?>/erp/eznetcrm/index.php?slug=contact-us">Contact Us  </a>
									</li>


									
									<li class="leaf" id="menu-218-1"><a style="text-transform:none;" class="sf-depth-1" href="<?php $url?>/erp/eznetcrm/index.php?slug=privacy-policy">Privacy Policy </a>
									</li>


									
								</ul>

							</div>
						</div>
					</div>
					<div class="region region-footer">
						<div class="block block-block" id="block-block-17">


							<div class="content">
								<p style="font-size: 14px; font-family: 'Open Sans', sans-serif; text-align: center; font-weight: 400;">
									&copy;
									2015									, eZnet CRM. All Rights Reserved<br><br><span style="font-size:11px;">Powered By: <a target="_blank" href="http://www.virtualstacks.com">Virtual Stacks</a></span>
								</p>
							</div>
						</div>
					</div>

				</div>

				<div class="newsLetter logedout">

					<div class="region region-footer-thirdcolumn">
						<div class="block block-block" id="block-block-15">


<div class="content">
<p style="line-height: 175%;">&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;<img title="eZnet CRM logo" alt="eZnet CRM logo" src="<?php bloginfo('template_directory');?>/img/eZnetLogo_0_1.png"></p>
<!-- <p><p><span style="font-size:15px; font-weight: 400; font-family:'Open Sans', sans-serif; line-height: 150%;">&nbsp; &nbsp; &nbsp; &nbsp; 650 Technology Park</span></p>
<p><span style="font-family:'Open Sans', sans-serif; font-size:15px; font-weight: 400; line-height: 150%;">&nbsp; &nbsp; &nbsp; &nbsp; Lake Mary, FL 32746</span></p>
<p><span style="font-family:'Open Sans', sans-serif; font-size:15px; font-weight: 400; line-height: 150%;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 1-877-368-4446</span></p>
<p> -->
<p class="footp">
<img width="30px" height="30px" alt="Contact information eZnet CRM" src="<?php bloginfo('template_directory');?>/img/headphones-icon-customer-support_1.png" style="display: inline; vertical-align: text-bottom;">
<span style="font-family:'Open Sans', sans-serif; font-size:15px; font-weight: 400; line-height: 150%;">&nbsp;&nbsp;407-544-3201 | 1-877-368-4446</span></p>
<p class="footp"><img width="30px" height="30px" alt="Email address eZnet CRM" src="<?php bloginfo('template_directory');?>/img/edit-icon_0.png" style="display: inline; vertical-align: text-bottom;"><span style="font-family:'Open Sans', sans-serif; font-size:15px; font-weight: 400; line-height: 150%;">&nbsp; <a href="mailto:info@eznetcrm.com">info@eznetcrm.com</a></span></p>
</div>


						</div>
					</div>

				</div>

			</div>

		</footer><!-- #colophon -->
</div><!-- #page -->
<script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/responsive-menu-9-script.js"></script>
<?php wp_footer(); ?>
</body>
</html>
