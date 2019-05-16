
<link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen" />
<script src="js/jquery.min.js"></script>
<script defer src="js/jquery.flexslider.js"></script>
<script type="text/javascript">
function subcription(){
	var email = document.getElementById("NewsletterEmail").value;
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	if(re.test(email)){
	if(email!=''){
	$.ajax({
		type: "POST",
		url: "ajax.php",
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

<script type="text/javascript">
$(document).ready(function() {
	// Change CAPTCHA on each click or on refreshing page.
	$("#reload").click(function() {
	
	$("#img").remove();
	$('<img id="img" src="captcha.php" />').appendTo("#imgdiv");
	});
	// Validation Function
	$('#button1').click(function() {
	var name = $("#name").val();
	var email = $("#email").val();
	var phone = $("#phone").val();
	var comments = $("#comments").val();
	var captcha = $("#captcha1").val();
	var dataString = 'name=' + name + '&email=' + email + '&phone=' + phone + '&comments=' + comments + '&captcha=' + captcha ;
	if(name =='' || email =='' || comments =='' || captcha=='' ){
		alert("Please Fill Required Fields.");
	}else{

		$.ajax({
		type: "POST",
		url: "ajax.php",
		data: dataString,
		success: function(html) {
		alert(html);
		location.reload(); 
		}
		});
	}


	});
	});
</script>

<script type="text/javascript">
    $(function(){
      SyntaxHighlighter.all();
    });
    $(window).load(function(){
      $('.flexslider').flexslider({
        animation: "slide",
        start: function(slider){
          $('body').removeClass('loading');
        }
      });
    });
  </script>
<style media="all" type="text/css">
 /*--&gt;&lt;![CDATA[/*&gt;&lt;!--*/ #back-top {
	right: 40px;
}

#back-top span#button {
	background-color: #CCCCCC;
}

#back-top span#button:hover {
	opacity: 1;
	filter: alpha(opacity =     1);
	background-color: #777777;
}

span#link {
	display: none;
}

/*]]&gt;*/

</style>


<?php 
if($_GET['slug']!='about-eznet-crm' && $_GET['slug']!='home' && $_GET['slug']!=''){?>
<div class="top-cont1">
</div>	
<?php } ?>

<?php
$slug1=$_GET['slug'];

if( $slug1 =='about-eznet-crm'){ ?>
<div class="top-cont">
    <div id="highlighted">
        <div class="region region-highlighted">
            <div class="block block-block" id="block-block-8">
                <div class="content">
                    <div class="aboutus-tab">
                        <ul>
                            <li><a href="#1">What is CRM Software</a></li>
                            <li><a href="#2">How CRM Works?</a></li>
                            <li><a href="#3">How to Evaluate CRM Software?</a></li>
                            <li><a href="#4">How to Buy CRM Software</a></li>
                            <li><a href="#5">New to CRM?</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>


<?php echo $datah['Content'];?>

<section id="mainContent">
	<div class="inner-cont-text">
		<div class="inner-content">
            <div class="werp">
                <?php $cslug=$_GET['slug'];if($cslug=='contact-us'){?> 
                <div class="contact-leftcl">
                    <form novalidate="novalidate" class="webform-client-form" enctype="multipart/form-data" id="webform-client-form-70" accept-charset="UTF-8">
                        <div class="form-item webform-component webform-component-textfield" id="webform-component-name-contactus">
                            <label for="edit-submitted-name-contactus">Name <span class="form-required" title="This field is required.">*</span></label>
                            <input type="text" id="name" name="name" value="" size="60" maxlength="128" class="form-text required">
                            <div class="cerror"></div>
                        </div>
                        <div class="form-item webform-component webform-component-email" id="webform-component-email-contactus">
                            <label for="edit-submitted-email-contactus">Email <span class="form-required" title="This field is required.">*</span></label>
                            <input type="text" class="email form-text form-email required" id="email" name="email" size="60" value="" >
                            <div class="cerror1"></div>
                        </div>
                        <div class="form-item webform-component webform-component-textfield" id="webform-component-phone-no-contactus">
                           <label for="edit-submitted-phone-no-contactus">Phone No </label>
                           <input type="text" id="phone" name="phone" value="" size="60" maxlength="128" class="form-text">
                        </div>
                        <div class="form-item webform-component webform-component-textarea" id="webform-component-comments-contactus">
                           <label for="edit-submitted-comments-contactus">Comments <span class="form-required" title="This field is required.">*</span></label>
                           <div class="form-textarea-wrapper resizable textarea-processed resizable-textarea"><textarea id="comments" name="comments" cols="60" rows="5" class="form-textarea required"></textarea><div class="grippie"></div></div>
                           <div class="cerror2"></div>
                        </div>
            
                        <div class="form-item webform-component webform-component-textfield" id="webform-component-phone-no-contactus">
                            <label for="edit-submitted-phone-no-contactus">CAPTCHA</label>
                            <div id="imgdiv"><img id="img" src="captcha.php" />
                            <div class="cerror3"></div>
                            </div>
                            <div class="form-item form-type-textfield form-item-captcha-response">
                               <label for="edit-captcha-response">What code is in the image? <span title="This field is required." class="form-required">*</span></label>
                               <input id="captcha1" name="captcha" type="text">
                            </div>
                        </div>
            
                        <input type='button' class="form-submit" id="button1" value='Submit' title="Submit">
                    </form>
                </div>
            
                <div class="contact-rightcl">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3498.4886990963546!2d-81.3593064!3d28.734822599999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88e7729280e1f805%3A0xd044757d450f0a40!2s650+Technology+Park%2C+Lake+Mary%2C+FL+32746%2C+USA!5e0!3m2!1sen!2sin!4v1434953253527" width="100%" height="390" frameborder="0" style="border:0" allowfullscreen></iframe>
                    <br>
                </div>
                <?php }?>
            </div>
        </div>
	</div>
</section>
</div>


