<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
                <form action=""  method="post" enctype="multipart/form-data" name="formRegistration" id="formRegistration" >

	  <tr>
        <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?>  <?=$Nav_MemberPortal?> </span> <?=SELECT_TEMPLATE?></td>
      </tr>
      <tr>
        <td  align="left" valign="middle" class="heading"><?=SELECT_TEMPLATE?></td>
      </tr>
      <tr>
        <td height="15"></td>
      </tr>
<tr>
            <td height="35" align="left" valign="top"  class="txt">
			
	 <? if(sizeof($arryTemplateCategory)>0){?>
	 
	 <strong>Browse By Category : </strong>
		  <select name="catID" class="txtfield_contact" id="catID" style="width: 120px;" onchange="Javascript:ChangeCategory();" >
		  	  <option value="">--- All ---</option>
              <? for($i=0;$i<sizeof($arryTemplateCategory);$i++) {?>
              <option value="<?=$arryTemplateCategory[$i]['catID']?>" <?  if($arryTemplateCategory[$i]['catID']==$_GET['catID']){echo "selected";}?>>
              <?=stripslashes($arryTemplateCategory[$i]['Name'])?>
              </option>
              <? } ?>
            </select> 
	<? }?>	
				
			<input type="hidden" name="curPage" id="curPage" value="<?=$_GET['curP']?>" />	
			</td>
          </tr>
		  	  
		     <tr>
            <td height="15"></td>
          </tr>   <? if(!empty($_SESSION['mess_template'])) { ?>
	   <tr>
              <td align="center" valign="top" class="redtxt" height="35">
			  		<?
			  		echo $_SESSION['mess_template'];
					unset($_SESSION['mess_template']); 
					?>
			  </td>
       </tr>
	  <? } ?>              

	  <tr>
        <td height="32" class="generaltxt_inner" align="center">
		
 <? 
 

 for($i=0;$i<sizeof($arryTemplate);$i++) {
 $LineNumber=$i+1;
  if($arryTemplate[$i]['templateID']==$arryMember[0]['templateID']){
  	$CheckTemplate = "checked";
	$ImgStyle = 'class="ImgTemplateSel"';
  	$OnMouseOut = '';
 }else{
  	$CheckTemplate = "";
	$ImgStyle = '';
	$OnMouseOut = "onMouseOut=\"this.className='ImgTemplateNone'\"";
 }




 
 ?>
 
 		<Div style="width:170px; height:160px; float:left" align="center" >
 		  
 		  <? if($arryTemplate[$i]['Image'] !='' && file_exists('templates/images/'.$arryTemplate[$i]['Image']) ){ 
			  
						//imageThumb('templates/images/'.$arryTemplate[$i]['Image'],'templates/images/thumb/'.$arryTemplate[$i]['Image'],100,100);
			  
			$ImagePath = 'resizeimage.php?img=templates/images/'.$arryTemplate[$i]['Image'].'&w=100&h=100'; 
  
			  
			  ?>
 		  <Div align="center" id="TemplDiv<?=$LineNumber?>"  <?=$ImgStyle?> onMouseOver="this.className='ImgTemplateSel'" <?=$OnMouseOut?> ><a href="Javascript:OpenNewPopUp('showimage.php?img=templates/images/<?=$arryTemplate[$i][Image]?>', 150, 100, 'yes' );"  ><img src="<?=$ImagePath?>" border=0 class="imgborder" style="float:none; margin-left:10px;" ></a>	</Div>
 		 <? } ?>	
 		  
 		  <div>
 		    <input name="templateID" id="templateID" type="radio" value="<?=$arryTemplate[$i]['templateID']?>"  <?=$CheckTemplate?> >&nbsp;<?=$arryTemplate[$i]['heading']?>
 		    </div> 
		  </Div>
 		<? } ?>			
		
		</td>
      </tr>
	 
	  <tr>
	  <td align="center"   >
	  <? if(empty($_SESSION['SelectedTemplate'])){	  ?>
	  <input name="SubmitButton" alt="Continue" title="Continue" id="SubmitButton" type="image" value=" " src="images/continue.jpg" width="112" height="30" />
	  <? }else{ ?>
	  <input name="SubmitButton" alt="Save" title="Save" id="SubmitButton" type="image" value=" " src="images/submit.jpg" width="88" height="31" />
	  <? } ?>
	  <input type="hidden" name="OldTemplateID" id="OldTemplateID" value="<? echo $arryMember[0]['templateID']; ?>">
	  
	  <input type="hidden" name="MemberID" id="MemberID" value="<? echo $_SESSION['MemberID']; ?>" />
	  
	  <input type="hidden" name="WebsiteStoreOption" id="WebsiteStoreOption" value="<? echo $_GET['ws']; ?>"  />
	  
	  </td>
	  </tr>
	  <? if($_SESSION['WebsiteStoreOption']=='ws'){ ?>
		   <tr>
            <td  style="text-align:center"class="generaltxt_inner" height="35"><?=CHANGE_REFLECT_MSG?></td>
          </tr>
		 <? } ?> 
	  
	   <tr>
            <td height="60" align="center">

<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td>&nbsp;<?php 
			if($num>count($arryTemplate)){ echo $pagerLink; }
			?></td>
  </tr>
</table>

			
			
			
			</td>
			</tr>	
	</form>
    </table></td>
    <td align="right" valign="top"><? require_once("includes/html/box/right.php"); ?>
    </td>
  </tr>
</table>
</td>
</tr>
</table>
