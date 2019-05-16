 <div class="block quick_find">
          <h2>Quick Find</h2>
          <form name="searchForm" method="get" action="products.php">
            <input type="text" name="search_str" value="<?=$_GET['search_str'];?>" placeholder="Find Here" />
            <input type="hidden" name="mode" value="search">
            <input type="submit" name="" value="" />
          </form>
          <p>Use keywords to find the product you are looking for.</p>
          <a class="advance_s" href="advanceSearch.php">Advanced Search</a> 
        </div>