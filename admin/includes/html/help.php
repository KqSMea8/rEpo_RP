 
 <style type="text/css">

.wrap_head{
   border-bottom:1px solid #f4af1a;
}

#Help_Desk {
    background: none repeat scroll 0 0 #fff;
    border: 1px solid #dcdcdc;
    border-radius: 6px;
    display: table;
    padding: 20px;
    width: 94.5%;
}
.list-lead{
    color: inherit;
    font-size: 18px;
    font-weight: 200;
    line-height: 28.4375px;
    margin:7.29167px 0;
}
.list-lead a{
     font-size: 18px;
     color: #333;
}
.wrap-left ul{
     margin-top:10px;
}
.wrap-left {
    float: left;
    margin-bottom: 20px;
    margin-right: 3%;
    min-height: 208px;
    width: 47%;
}
.ellipsis > a {
    font-size: 14px;
    
}
.wrap-left ul li::before {
    background-image: url("https://d1k77w8c6z6pel.cloudfront.net/assets/cdn-ignored/sprites/portal/icon-sff283fff0f.png");
    background-position: 0 -154px;
    background-repeat: no-repeat;
    content: "";
    height: 20px;
    left: 0;
    position: absolute;
    vertical-align: text-top;
    width: 19px;
    
}
.wrap-left ul li{
    margin-bottom: 6px;
    list-style: outside none none;
    padding-left: 30px;
    position: relative;
     line-height: 21.875px;
}

.see-more::before {
    content: "";
    display: inline-block;
    margin-right: 8px;
    vertical-align: text-top;
    background-position: 0 -519px;
    height: 20px;
    width: 20px;
    background-image: url("https://d1k77w8c6z6pel.cloudfront.net/assets/cdn-ignored/sprites/portal/icon-sff283fff0f.png");
    background-repeat: no-repeat;
}
a.see-more {
    color: rgba(4, 156, 219, 0.5);
    font-size:14px;
}
  
</style>

<script type="text/javascript" src="../js/scroll_to_top.js"></script>
<link href="../css/scroll_to_top.css" rel="stylesheet" type="text/css">


<!-- Start Wrapper -->
<div id="Help_Desk">
<TABLE WIDTH="100%"   BORDER=0 align="left" CELLPADDING=0 CELLSPACING=0 >
  <table align="left" cellspacing="1" cellpadding="3" width="100%" id="help_list_table">
    <div class="wrap_head">
     <div align="left" class="blackbold"><strong><h1>Help Desk</h1></strong></div>
    </div>
    <?php $site_url= 'http://'. $_SERVER['SERVER_NAME'].'/erp/';?>
    <?php if(sizeof($listworkflow)>0){ ?>
    <div class="wrap">
    
    <?php
    //echo "<pre>";print_r($output);
    foreach($output as $key=>$helpvalues){ 

	(!isset($helpvalues[0]['CategoryName']))?($helpvalues[0]['CategoryName']=""):("");
?>
      <div class="wrap-left">
      <div class="list-lead">
		<a title="<?php echo $helpvalues[0]['CategoryName'];?>" href="helpCategoryList.php?depID=<?php echo $helpvalues[0]['depID'];?>&cat=<?=$helpvalues[0]['CategoryID']?>"> <?php echo $key.' ('.$helpvalues[0]['DepartmentCount'].')';?></a>
	  </div>
      <ul>	
       <?php    
       $arrayHelp=array_slice($helpvalues,0, 5); 
				
       //print_r($arrayHelp) ;
       foreach($arrayHelp as $hKey=>$hValue){
       	?>   	
       	 <li>
			<div class="ellipsis">
			  <a href="helpinfo.php?WsID=<?=$hValue['WsID']?>" title="<?php echo $hValue['Heading'] ;?>"><?php echo $hValue['Heading'] ;?></a>
			</div>
		</li>
       	
      <?php }?>
      
      <?php if(sizeof($arrayHelp)>=5){?>

        <a class="see-more" href="helpCategoryList.php?depID=<?php echo $helpvalues[0]['depID'];?>&cat=<?=$helpvalues[0]['CategoryID']?>">See all <?php echo $helpvalues[0]['DepartmentCount'];?> articles</a>
         
		<?php }?>
      </ul>
      
      </div>
    <?php  }  ?>
    </div>
   <?php } ?>
           <input type="hidden" name="depID" id="depID" value="<?php echo $_GET['depID']; ?>">
  </table>
</TABLE>
</div>
 <!-- End Wrapper -->
 <p style="display: none1;" id="back-top">
		<a href="#top" title="Top"><span id="button"></span><span id="link">Back to top</span>
		</a>
	</p>
