<div class="nav-container">
<div class="mid_wraper">
      <ul>
          <li <?php if(curPageName() == "index.php"){?>class="active"<?php }?>><a href="index.php">Home</a></li>
        <?php 
   
         $url = $_GET["url"];
        if(!empty($url)){
            $urlMd5 = md5($url);
            $arryPageId=$cmsObj->getPageIdByHash($urlMd5);
        }

 
   if(!empty($arryPageId[0]['PageId'])){$pageId = $arryPageId[0]['PageId'];}else{$pageId = $_GET['page_id'];}
        foreach($arryPages as $key=>$value){
            	$menu_url = $value['UrlCustom'];
                    if(!empty($menu_url))
                    {
                       $menu_link=$menu_url.".html";
                    }
                    else
                    {
                      $menu_link = "page.php?page_id=".$value['PageId'];
                    }
             if($value['PageId'] == $pageId)
             {
                 $active = "active";
             }
            else {
                $active = "";
            }
            ?>
        <li class="<?=$active?>"><a href="<?=$menu_link;?>"><?=$value['Name']?></a></li>
        <?php }?>
        <?php if($settings['BestsellersAvailable'] == "Yes" && $settings['BestsellersDisplay'] == "top")     {  ?>
        <li><a href="bestseller.php">Bestseller</a></li>
        <?php }?>
      </ul>
    </div>
    </div>