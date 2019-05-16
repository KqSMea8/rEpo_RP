<? require_once("includes/html/box/pop_loader.php"); ?>	
<? require_once("includes/html/".$SelfPage);  ?>
                <input type="hidden" name="Cid" id="Cid" value="<?=$_SESSION['Cid'];?>">
                <input type="hidden" name="CatID" id="CatID" value="<?=$_GET['cat'];?>">
                <input type="hidden" name="shortBy" id="shortBy" value="<?=$_GET['shortBy'];?>">
                <input type="hidden" name="Mfg" id="Mfg" value="<?=$_GET['Mfg'];?>">
                <input type="hidden" name="search_str" id="search_str" value="<?=$_GET['search_str'];?>">
	        <input type="hidden" name="homeCompleteUrl" id="homeCompleteUrl" value="<?=$Config['homeCompleteUrl'];?>"></input>
	 <div class="footer-container clearfix" id="footer">
    <div class="mid_wraper">
      <div class="footer">
        <div class="copyright">Copyright &copy; <?=$arrayConfig[0]['SiteName']?>. All Rights Reserved. </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>

