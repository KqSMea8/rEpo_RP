
<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
		/*
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  {
			   location.href = 'viewTemplates.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewTemplates.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
			return false;*/
		}
</script>
<div class="had"><?php echo 'Manage Templates';?></div>
<div class="message"><? if(!empty($_SESSION['mess_template'])) {echo $_SESSION['mess_template']; unset($_SESSION['mess_template']); }?></div>
<TABLE WIDTH="99%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
<tr>
		<td  align="right"><a href="editTemplate.php" class="Blue">Add Template</a></td>
	  </tr>
	<tr>
	  <td  valign="top">

	<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch();">
				<table  border="0" cellpadding="0" cellspacing="3"  id="search_table">
                    <tr>
                      <td > <select name="sortby" id="sortby" class="inputbox" >
							<option value="" >All</option>
						    <option value="t.heading" <? if($_GET['sortby']=='t.heading') echo 'selected';?>>Template Heading</option>
						    <option value="c.Name" <? if($_GET['sortby']=='c.Name') echo 'selected';?>>Category</option>
					 </select></td>
                      <td  ><input type='text' name="key"  id="key" class="inputbox" value="<?=$_GET['key']?>"> </td>
                      <td align="left" >
					   <select name="asc" id="asc" class="textbox" >
						 <option value="Asc" <? if($_GET['asc']=='Asc') echo 'selected';?>>Asc</option>
						 <option value="Desc" <? if($_GET['asc']=='Desc') echo 'selected';?>>Desc</option>
					   
					 </select>
					  
                       </td>
                   <td> <input name="search" type="submit" class="search_button" value="Go">
						<? if($_GET['key']!='') {?> <a href="viewTemplates.php">View all</a><? }?>
				   
					
					 
					 </td>
				    </tr>
      </table></form>
	 
<form action="" method="post" name="form1">

 <? 
$num = sizeof($arryTemplate);
  $pagerLink=$objPager->getPager($arryTemplate,12,$_GET['curP']);
 (count($arryTemplate)>0)?($arryTemplate=$objPager->getPageRecords()):("");


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
 
 		<Div align="center" style="width:240px; height:180px; float:left; ">
 		  
 		  <? if($arryTemplate[$i]['Image'] !='' && file_exists('../templates/images/'.$arryTemplate[$i]['Image']) ){ ?>
 		  <Div id="TemplDiv<?=$LineNumber?>"  <?=$ImgStyle?>    ><a href="Javascript:OpenNewPopUp('../showimage.php?img=templates/images/<?=$arryTemplate[$i][Image];?>', 150, 100, 'yes' );"><img src="../resizeimage.php?w=100&h=100&img=templates/images/<?=$arryTemplate[$i]['Image']?>" border=0 class="imgborder" ></a>	</Div>
  <? } ?>	
 		  
 		  <div><strong><?=stripslashes($arryTemplate[$i]['heading'])?></strong></div>
		    <? if(!empty($arryTemplate[$i]['Category'])){?>
				<div>(Category:<?=stripslashes($arryTemplate[$i]['Category'])?>)</div>
			<? } ?>	
 		   <div>
 <? 
		 if($arryTemplate[$i]['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
	
	 

		echo '<a href="editTemplate.php?active_id='.$arryTemplate[$i]["templateID"].'&curP='.$_GET["curP"].'" class="edit">'.$status.'</a>';
		echo ' | <a href="editTemplate.php?edit='.$arryTemplate[$i]["templateID"].'&curP='.$_GET["curP"].'" class="edit">Edit</a>';
		
		if($arryTemplate[$i]["templateID"]>12){
			echo ' | <a href="editTemplate.php?del_id='.$arryTemplate[$i]["templateID"].'&curP='.$_GET["curP"].'" onclick="return confDel(\'Template\')"  class="edit">Delete</a>';
			}
	 ?> 		   
		   
		   
		   </div>  
	    </Div>
 		<? } ?>	




<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>
</td>
	</tr>
	
	
 <tr align="center" >  <td height="20" colspan="7">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryTemplate)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr></table>
