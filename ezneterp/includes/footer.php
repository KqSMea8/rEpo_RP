<!-- ********************************Amit Singh**************************** -->

<div class="push"></div>

</div>
<footer>
        <div class="werp">
            <div class="left-footer"><h5>FOLLOW US</h5>
               
                <?php
                $socialDat = getSocialLinks();
                foreach ($socialDat as $socialData) { ?>
                <a href="<?php echo $socialData['URI']; ?>" target="_blank">
                    <img alt="<?php echo stripslashes($socialData['Title']); ?>" 
                        title="<?php echo stripslashes($socialData['Title']); ?>" 
                        src="img/<?php echo $socialData['Icon']; ?>"> </a>
                <?php } ?>
            </div>
            <div class="center-footer">
                <nav>
                   
                    <?php foreach ($footerMenuData as $footerM) { ?>

                    <a href="<?php echo $footerM['UrlCustom']; ?>"
                            class="sf-depth-1" style="text-transform:none;"><?php echo stripslashes($footerM['Title']); ?> </a>
     
                    <?php } ?>
                </nav>
                <p class="copyright"> &#169; <?php echo date("Y"); ?>, eZnet ERP. All Rights Reserved</p>   
                        <!--p> © 2016 , eZnet ERP. All Rights Reserved </p--> 
            </div>
            <div class="right-footer">
                <span class="contact"><img src="img/cont.png" />407-544-3201 | 1-877-368-4446</span>
  <span class="email" style="color:fff;"><img src="img/info.png" /><a href="mailto:support@ezneterp.com" style="
    color: #fff;">support@ezneterp.com</a>
                <!--img src="img/info.png" />info@ezneterp.com--></span>
            </div>
        </div>
    </footer>




<p style="display: none;" id="back-top">
    <a href="#top" title="Top"><span id="button"></span><span id="link">Back to top</span>
    </a>
</p>


</body>
</html>
