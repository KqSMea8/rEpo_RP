<?php $MainDir = $Config['FileUploadDir'].$Config['C_DocumentDir']; ?>
<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';
		/*
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  { 
			   location.href = 'viewDocument.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewDocument.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
			return false;
			*/
	}
        $(document).ready(function(){
            
              
              $('input[name="attcDoc"]').change(function () {

    
                if ($(this).prop('checked')) {  //which checkbox was checked
 
                       
                        
                        //window.parent.document.getElementById("addrow").innerHTML = "llll";
                        
                        var newRow = $('<tr id="q'+$(this).val()+'">');
		        var cols = "";
                         cols += '<td align="left" id="gg"><img src="../images/delete.png" id="attcremove" title="Delete" style="cursor:pointer;">&nbsp;&nbsp;'+$(this).val()+'<input type="hidden" name="fromDocument[]" value="<?=$MainDir?>'+$(this).val()+'"></td></tr>';
		         newRow.append(cols);
                         parent.$(newRow).insertAfter( '#attcfileplace');
                } 

          });
          
                $("table.order-list").on("click", "#test11", function (event) {

                      /********Edited by pk **********/
                      var row = $(this).closest("tr");
                      var id = row.find('input[name^="id"]').val(); 
                      if(id>0){
                              var DelItemVal = $("#DelItem").val();
                              if(DelItemVal!='') DelItemVal = DelItemVal+',';
                              $("#DelItem").val(DelItemVal+id);
                      }
                      /*****************************/
                      $(this).closest("tr").remove();
                      //calculateGrandTotal();

              });
              
              
              
        });
</script>
<div class="had">Attach <?=$_GET['parent_type']?> Document</div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_Document'])) {echo $_SESSION['mess_Document']; unset($_SESSION['mess_Document']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	
	  <td  valign="right">
	  
		 <? if($_GET['key']!='') {?>
	  	<a href="<?=$ViewUrl?>" class="grey_bt">View All</a>
		<? }?>


		</td>
      </tr>
	 
	<tr>
	  <td  valign="top">
		 
	
<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
<div id="piGal">
<table <?=$table_bg?>>
   
    <tr align="left"  >
      <!--<td width="2%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','documentID','<?=sizeof($arryDocument)?>');" /></td>-->
      <!--td width="14%"  class="head1" >Document ID</td-->
      <td width="10%"   align="center" class="head1" >Select</td>
      <td width="13%"  class="head1" >FileName</td>
      <td width="20%"  class="head1" >Title</td>
      <td class="head1" >Description</td>
      
      <td width="15%" class="head1" >  Created On</td>
	  <!--<td width="11%" class="head1" > Assign To</td>-->
      
    </tr>
   
    <?php 
  if(is_array($arryDocument) && $num>0){
  	$flag=true;
	$Line=0;
	 
	
  	foreach($arryDocument as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;
	
	//if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
        
        
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
     <!-- <td ><input type="checkbox" name="documentID[]" id="documentID<?=$Line?>" value="<?=$values['documentID']?>" /></td>-->
       <!--td ><?=stripslashes($values['documentID'])?></td-->
   
    <td  align="center" class="head1_inner"  >
 
       <?  
        if($values['FileName'] !='' && file_exists($MainDir.$values['FileName']) ){
	$DocExist=1;	
      } else {	
	$DocExist=0;
	
	}
?> 
        <? if($DocExist==1){ ?>
        <br>
        <input type="checkbox" name="attcDoc" id="<?=$values['documentID']?>" value="<?=$values['FileName']?>">
        
        <!--a class="fancybox fancybox.iframe" href="<?='sendDoc.php?view='.$values['documentID'].'&curP='.$_GET['curP']?>" >Send Document</a-->
        <? } ?>

     </td>    
        
  <td >

 <? 

 if($values['FileName'] !='' && file_exists($MainDir.$values['FileName']) ){
	$DocExist=1;
	?>
        <?=$values['FileName']?>
	<!--a href="dwn.php?file=<?=$MainDir.$values['FileName']?>" class="download">Download</a-->	
	
    <? } else {	
	$DocExist=0;
	echo NOT_UPLOADED;
	}
?> 

       </td>
       
    <td ><?=stripslashes($values['title'])?></td>
    <td><?=stripslashes($values['description'])?></td>
    
    
      
      
      
      
      
	  <td><? if($values['AddedDate']) echo date($Config['DateFormat'].", H:i:s" , strtotime($values["AddedDate"])); ?> </td>
	  <!--<td><?=$values['AssignTo']?></td>-->
	   
      
    </tr>
    <?php
    
       
        } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="9" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="9" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryDocument)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>
  </div>
  </div> 
 
  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
   <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">

 
 
</form>
</td>
	</tr>
</table>
