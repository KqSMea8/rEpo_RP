<?php
/*if($TopCatID>0){
	$arrayLeftCategory = $objCategory->GetSubCategoryByParent(1,$TopCatID);
}else{
	$arrayLeftCategory = $arryTopCategory;
}*/
$arrayLeftCategory = $arryTopCategory;
?>

<script>
     
    w(document).ready(function(){
     
        w(".tree").treeview({
            collapsed:true,
            animated:"medium",
            persist:"location"
        });
        
        <?php if(!empty($_GET['cat'])){?>
        w(".tree a").click(function() {
            w.cookie("catMenu", w(this).parent("li").parent("ul").attr("id"));
        });
        
        
        
        varActiveMenu = w.cookie("catMenu");
        
        w("#" + varActiveMenu).parentsUntil(".tree").show();
        w("#" + varActiveMenu).show();
        
        w("#" + varActiveMenu).parentsUntil(".tree").removeClass('expandable');
        w("#" + varActiveMenu).parentsUntil(".tree").removeClass('lastExpandable');
        
        w("#" + varActiveMenu).parentsUntil(".tree").find("div").removeClass('expandable-hitarea');
        w("#" + varActiveMenu).parentsUntil(".tree").find("div").removeClass('lastExpandable-hitarea'); 

        w("#" + varActiveMenu).parentsUntil(".tree").find("div").addClass('collapsable-hitarea');
        w("#" + varActiveMenu).parentsUntil(".tree").find("div").addClass('lastCollapsable-hitarea'); 
        
        
        w("#" + varActiveMenu).parentsUntil(".tree").addClass('collapsable');
        w("#" + varActiveMenu).parentsUntil(".tree").addClass('lastCollapsable');
        
        
        
        //w(".clsMenu_1").find("li").find("div").removeClass('expandable-hitarea');
        //w(".clsMenu_1").find("li").find("div").removeClass('lastExpandable');      
        
        //alert(w("#" + varActiveMenu).attr("class"));
        
        /*for(i = 1; i <= (varLevel[2]+1); i++) {
            //alert(i);
            
            
            w(".clsMenu_" + i).show();
            
            //w(".clsMenu_" + varLevel[1] + "_" + i).show();
        }*/
    
        /*w("#" + varActiveMenu).show();
        w("#" + varActiveMenu).parent("li").parent("ul").show();
        
        
        w("#" + varActiveMenu).parent("li").removeClass('expandable');
        w("#" + varActiveMenu).parent("li").removeClass('lastExpandable');
        w("#" + varActiveMenu).parent("li").addClass('collapsable');
        w("#" + varActiveMenu).parent("li").addClass('lastCollapsable');
        
        w("#" + varActiveMenu).parent("li").find("div").removeClass('expandable-hitarea');
        w("#" + varActiveMenu).parent("li").find("div").addClass('collapsable-hitarea');
         
        
        
        w("#" + varActiveMenu).parent("li").parent("ul").parent("li").parent("ul").show();
        w("#" + varActiveMenu).parent("li").parent("ul").parent("li").parent("ul").parent("li").parent("ul").show();*/
        <?php } else {?>
        $.removeCookie("catMenu");
        <?php }?>

   });  
</script>
<style>
    
  .treeview .hover{color:inherit}
 .menu-item-current span{color: #D33F3E;}
</style>
<div class="block left-nav">
          <h2><?=CATEGORIES?></h2>
          <div class="content ">
<ul class="tree treeview">
   <?php for($i=0;$i<sizeof($arrayLeftCategory);$i++) {
       $arrySecondSubCategory = $objCategory->GetSubCategoryByParent(1,$arrayLeftCategory[$i]['CategoryID']);
       $catName = stripslashes($arrayLeftCategory[$i]['Name']);		
       ?>
   
    <li>
        <a class="<?php if($arrayLeftCategory[$i]['CategoryID'] == $_GET['cat']){ echo "menu-item-current"; }?>" href="products.php?cat=<?=$arrayLeftCategory[$i]['CategoryID']?>">
            <span><?=$catName?></span></a>
        <?php if(count($arrySecondSubCategory)>0) {?>
        <ul id="menu_<?=$arrayLeftCategory[$i]['CategoryID']?>_1">
            <?php
             
             for($j=0;$j<sizeof($arrySecondSubCategory);$j++) {
            $arryThirdSubCategory = $objCategory->GetSubSubCategoryByParent(1,$arrySecondSubCategory[$j]['CategoryID']);
            ?>
            <li>
            <a  href="products.php?cat=<?=$arrySecondSubCategory[$j]['CategoryID']?>" class=<?php if($arrySecondSubCategory[$j]['CategoryID'] == $_GET['cat']){ echo "menu-item-current"; }?>>
                <span><?=stripslashes($arrySecondSubCategory[$j]['Name'])?></span>
            </a>
           <?php if(count($arryThirdSubCategory)>0) { ?>
             <ul id="menu_<?=$arrySecondSubCategory[$j]['CategoryID']?>_2">
                  <?php
                        for($k=0;$k<sizeof($arryThirdSubCategory);$k++) {
                         
                         $arryFourthSubCategory = $objCategory->GetSubSubCategoryByParent(1,$arryThirdSubCategory[$k]['CategoryID']);
                                                                          
                           ?>
                       <li>
                     <a  href="products.php?cat=<?=$arryThirdSubCategory[$k]['CategoryID']?>" class=<?php if($arryThirdSubCategory[$k]['CategoryID'] == $_GET['cat']){ echo "menu-item-current"; }?>>
                         <span><?=stripslashes($arryThirdSubCategory[$k]['Name'])?></span></a>
                  <?php  if(count($arryFourthSubCategory)>0) {?>   
                  <ul id="menu_<?=$arryThirdSubCategory[$k]['CategoryID']?>_3">
                    <?php
                        for($l=0;$l<sizeof($arryFourthSubCategory);$l++) {
                        $arryFifthSubCategory = $objCategory->GetSubSubCategoryByParent(1,$arryFourthSubCategory[$l]['CategoryID']);
                                                                          
                           ?>
                    <li>
                        <a  href="products.php?cat=<?=$arryFourthSubCategory[$l]['CategoryID']?>" class=<?php if($arryFourthSubCategory[$l]['CategoryID'] == $_GET['cat']){ echo "menu-item-current"; }?>>
                            <span><?=stripslashes($arryFourthSubCategory[$l]['Name'])?></span></a>
                    <?php   if(count($arryFifthSubCategory)>0) {?>
                        <ul id="menu_<?=$arryFourthSubCategory[$l]['CategoryID']?>_4">
                             <?php  for($m=0;$m<sizeof($arryFifthSubCategory);$m++) {       ?>
                            <li <?php if($arryFifthSubCategory[$m]['CategoryID'] == $_GET['cat']){ ?> class="drop-down-menu-item-current" <?php }?>>
                                <a  href="products.php?cat=<?=$arryFifthSubCategory[$m]['CategoryID']?>" class=<?php if($arryFifthSubCategory[$m]['CategoryID'] == $_GET['cat']){ echo "menu-item-current"; }?>>
                                    <span><?=stripslashes($arryFifthSubCategory[$m]['Name'])?></span></a></li>
                             <?php  } ?>
                             </ul>
                         <?php }?>
                     </li>
                    <?php  } ?>   
                    </ul>
                 <?php }?>
                </li>
               <?php }?>       
               </ul>
            <?php } ?> 
            </li>
            <?php } ?> 
        </ul>
         <?php }?>
             
            
    </li>
<?php }?>        
</ul>
      
</div>
</div>