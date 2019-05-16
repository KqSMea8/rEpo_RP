<div class="left_pen">
       <?php 
            include_once("includes/html/box/menu.php");
            include_once("includes/html/box/manufactures.php");
            include_once("includes/html/box/search.php");
            include_once("includes/html/box/newsletter.php");
            if(!empty($recent_items)){
             include_once("includes/html/box/recent.php");
            }
           if($settings['BestsellersAvailable'] == "Yes" && $settings['BestsellersDisplay'] == "left")
            {
             include_once("includes/html/box/bestseller.php");
            }
       ?>
      </div>