<script type="text/javascript" src="FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="js/ewp50.js"></script>

<form name="form1" id="form1" action=""  method="post" enctype="multipart/form-data">
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">



   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<?php 
//By Chetan//
 if(isset($_GET['parent_type']) && $_GET['parent_type'] != '')
 {
     $Narry = array_map(function($arr){
        
            if($arr['head_value'] == 'Related To')
            {
                unset($arr);
            }else{
               return $arr;
            }
    }, $arryHead);
   $arryHead = array_values(array_filter($Narry));
}

 $head=1;
 for($h=0;$h<sizeof($arryHead);$h++){

     ?>
                
                    <tr>
                        <td colspan="5" align="left" class="head"><?=$arryHead[$h]['head_value']?></td>
                    </tr>

 <?php $arryField = $objField->getFormField('',$arryHead[$h]['head_id'],'1'); 

include("includes/html/box/CustomFieldsNew.php"); 
if($h == 0){?>
                    <tr style="display: none;" id="notifi">
	 <td valign="top"  align="right" >Notifications :<span class="red">*</span></td>
                <td valign="top"  align="left" >
                    
                    <select name="notifications" class="inputbox"  id="notifications" >
                        <option value="">--Select--</option>
                        <option value="All">All</option>
                        <?php foreach($arryTicketStatus as $arr){?>
                            
                                <option value="<?=$arr['attribute_value']?>"><?=$arr['attribute_value']?></option> 

                            
                       <?php }?>
                        
                    </select>
                    <div class="red" id="notificationserr" style="margin-left:5px;"></div> 
                </td>
                
                </td>
                        
                        
</tr>
                   
                    
 <?php } }
//head close?> 	 
          
          

         
	
</table>	
  

<script type="text/javascript">
$('#piGal table').bxGallery({
  maxwidth: 300,
  maxheight: 200,
  thumbwidth: 75,
  thumbcontainer: 300,
  load_image: 'ext/jquery/bxGallery/spinner.gif'
});
</script>


<script type="text/javascript">
$("#piGal a[rel^='fancybox']").fancybox({
  cyclic: true
});
</script>



	
	  
	
	</td>
   </tr>

 

   <tr>
    <td  align="center">
    
	<div id="SubmitDiv" style="display:none1">
	
	<?php if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />
      
<input type="hidden" name="created_by" id="created_by"  value="<?=$_SESSION['AdminType']?>" />	
<input type="hidden" name="created_id" id="created_id"  value="<?=$_SESSION['AdminID']?>" />

<input type="hidden" name="parent_type" id="parent_type"  value="<?=(isset($_GET['parent_type'])) ? $_GET['parent_type'] : '';?>" />	
<input type="hidden" name="parentID" id="parentID"  value="<?=(isset($_GET['parentID'])) ? $_GET['parentID'] : '';?>" />
<input type="hidden" name="module" id="module"  value="<?=$_GET['module']?>" />

<input type="hidden" name="TicketID" id="TicketID" value="<?=$_GET['edit']?>" />


</div>

</td>
   </tr>
</table>
       </form>


