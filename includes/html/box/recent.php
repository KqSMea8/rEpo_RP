 <div class="block subscribe">
          <h2>Recently Viewed Items</h2>
         <div class="recent-items">
            <ul>
               <?php foreach ($recent_items as $recent_item) {?>
               <li><a href="<?=$recent_item['url']?>"><?=$recent_item['Name'];?></a></li>
               <?php }?>
            </ul>
            </div>
     </div>