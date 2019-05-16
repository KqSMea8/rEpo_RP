<?
$footerMenuData=getFooterMenu('footer');
?>

</div>
		<? //require_once($MainPrefix."../includes/html/box/pop_loader.php"); ?>
<script type="text/javascript">
function subcription(){

	var email = document.getElementById("NewsletterEmail").value;
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	if(re.test(email)){

	if(email!=''){
		
	$.ajax({
	
		type: "POST",
		url: "../ajax.php",
		data:{NewsletterEmail:email},
		cache: false,
		  success: function(){
			 
			  $('.msg').addClass().html('<span class="success">Subcribed Successfully</span>');
	       $('.msg').fadeIn(1000);
	 
	     }
		});}else{
			 $('.msg').addClass().html('<span class="error">Please Enter Email</span>');
		       $('.msg').fadeIn(1000);
		}
	}else{
		 $('.msg').addClass().html('<span class="error">Please Enter Valid Email</span>');
	       $('.msg').fadeIn(1000);
	}

	
	return false;
	
}
</script>


	<? 

require_once("includes/html/".$SelfPage); ?>

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
                            alt="<?php echo stripslashes($socialData['Title']);?>" title="<?php echo stripslashes($socialData['Title']);?>" src="<?=$Prefix?>images/<?php echo $socialData['Icon'];?>" > </a>

                            </li>
                            <?php } ?>


                            </ul><br> <br> <br> <br> <br>
                            <h2>Subscribe to our Newsletter</h2>
                        </div>
                    </div>
                    <div id="block-simplenews-1" class="block block-simplenews">
                        <div class="content">

                            <div style="display: none;" id="clientsidevalidation-simplenews-block-form-1-errors"
                                                class="messages error clientside-error">
                                <ul></ul>
                            </div>
                            <form novalidate="novalidate" class="simplenews-subscribe" id="srform" name="form" accept-charset="UTF-8">
                                <div>
                                        <div class="form-item form-type-textfield form-item-mail">
                                                <label for="edit-mail">E-mail <span class="form-required"
                                                        title="This field is required.">*</span> </label> <input
                                                        placeholder="Your Email" id="NewsletterEmail" name="NewsletterEmail" size="20"
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
                    <div id="block-system-main-menu" class="block block-system block-menu">

                        <h2>Main menu</h2>
                        <div class="content">
                            <ul class="menu">
                            <?php
                            //$bannerDt=showBanner();

                            foreach($footerMenuData as $footerM){ ?>

                                    <li id="menu-218-1" class="leaf"><a
                                            href="<?php echo $MainPrefix.$footerM['UrlCustom'];?>"
                                            class="sf-depth-1" style="text-transform:none;"><?php echo stripslashes($footerM['Title']);?> </a>
                                    </li>


                                    <?php } ?>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="region region-footer">
                    <div id="block-block-17" class="block block-block">
                        <div class="content">
                            <p style="font-size: 14px; font-family: 'Open Sans', sans-serif; text-align: center; font-weight: 400;">
                                &#169;
                                <?php echo date("Y"); ?>
                                , eZnet ERP. All Rights Reserved
                                <br><br><span>Powered By: <a href="http://www.virtualstacks.com" target="_blank">Virtual Stacks</a></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

<div class="newsLetter logedout">
    <div class="region region-footer-thirdcolumn">
        <div id="block-block-15" class="block block-block">


<div class="content">
<p style="line-height: 175%;">&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;<img src="<?=$MainPrefix?>img/logo.png" alt="eZnet ERP logo" title="eZnet ERP logo"></p>

<p><img width="30px" height="30px" style="display: inline; vertical-align: text-bottom;" src="<?=$MainPrefix?>img/headphones-icon-customer-support_1.png"><span style="font-family:'Open Sans', sans-serif; font-size:15px; font-weight: 400; line-height: 150%;">&nbsp;&nbsp;407-544-3201 | 1-877-368-4446</span></p>
<p><img width="30px" height="30px" style="display: inline; vertical-align: text-bottom;" src="<?=$MainPrefix?>img/edit-icon_0.png"><span style="font-family:'Open Sans', sans-serif; font-size:15px; font-weight: 400; line-height: 150%;">&nbsp; <a href="mailto:info@ezneterp.com">info@ezneterp.com</a></span></p>
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
