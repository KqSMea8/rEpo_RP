 <div class="block subscribe">
          <h2>Best Seller Items</h2>
         <div class="recent-items">
            <ul>
               <?php foreach ($bestseller_items as $bestseller_item) {?>
               <li><a href="productDetails.php?id=<?=$bestseller_item['ProductID']?>"><?=$bestseller_item['ProductName'];?></a></li>
               <?php }?>
            </ul>
            </div>
     </div>