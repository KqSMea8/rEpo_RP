<script type="text/javascript" src="../js/scroll_to_top.js"></script>
<link href="../css/scroll_to_top.css" rel="stylesheet" type="text/css">

<style type="text/css">
#Help_Desk_info {
    background: none repeat scroll 0 0 #fff;
    border: 1px solid #dcdcdc;
    border-radius: 6px;
    display: table;
    padding: 20px;
    width: 94.5%;
}
.wrap_head{
   border-bottom:1px solid #f4af1a;
margin-bottom: 10px;
}
hr {
   
    margin: 16.8269px 0;
    border:1px dashed #dcdcdc;
}
.border{
    border:1px solid #f4af1a;
    margin: 16.8269px 0;
}
.des {
    border-bottom: 1px solid #dcdcdc;
    margin: 15px 0;
}
.desk-content .List_Cat {
    border-bottom: 1px solid #dcdcdc;
    padding: 0 0 15px;
}
.List_Cat {
    margin: 0 0 10px;
    padding: 0 0 10px;
}
.List_Cat h2 a {
    font-size: 18px;
	color: #0a263c;
}
</style>

<div id="Help_Desk_info">

<div class="wrap_head">
     <div align="left" class="blackbold"><strong><h1>All Notifications </h1></strong></div>
    </div>
<?php 
 
foreach($arryNotification as $listHCbyCatName) { ?>
<div class="List_Cat">
<h2 class="desk-heading"><a href="notificationdetail.php?NotifiID=<?php echo $listHCbyCatName['NotificationId']?>"><?php echo stripslashes($listHCbyCatName['Heading']);?></a></h2>
<div class="desk-content"><?php 

echo ($listHCbyCatName['Date']>0)?(date($Config['DateFormat'], strtotime($listHCbyCatName['Date']))):('');

  /* $limit = 500;
  $summary = stripslashes($listHCbyCatName['Detail']);

    if (strlen($summary) > $limit){
	$summary = strip_tags($summary);
      $summary = substr($summary, 0, strrpos(substr($summary, 0, $limit), ' ')) . '...';
    }
      echo $summary;*/
?></div>
</div>
<?php } ?>



</div>



<p style="display: none1;" id="back-top">

		<a href="#top" title="Top"><span id="button"></span><span id="link">Back to top</span>
		</a>
	</p>

 <script type="text/javascript">
       
            function loadFrame() {
              parent.$.fancybox.close();
            }

    </script>

