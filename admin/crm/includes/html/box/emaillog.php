<div id="EmailList">
 <table width="100%" border="0" cellpadding="5" cellspacing="0">
 <tr>  
            <td valign="top" align="right"><a class="add" id="AddEmailbtn">Add Email</a></td>
 </tr>
 </table>
 <div class="EmailHtmlShow">
 <table id="EmailTable" width="100%" border="0" cellpadding="3" cellspacing="1" class="borderall borderall2">
 <thead>
 <tr align="left">
<th class="head1">Subject</th>
<th class="head1">Content</th>
<th class="head1">Date</th>
<th class="head1">Action</th>
</tr>
</thead>
 <tbody>

<?php if(!empty($arryEmaillogList)){ 
foreach($arryEmaillogList as $eval){
  $DataContentlen=strlen($eval['Comment']);
  //echo $DataContentlen;
  $DataContent = stripslashes($eval['Comment']); 
if($DataContentlen>250){  
$DataContent = substr(stripslashes($eval['Comment']),0,300); 
$DataContent =$DataContent.'....&nbsp;<a href="javascript:;" style="color:white;"  onclick="ViewEmail_Log(\'Email\', '.$eval['CommentID'].');" class="button">View More</a>';
}

  ?>
 <tr class="Email_<?=$eval['CommentID']?>">
          <td width="15%"><?=$eval['subject']?></td>
          <td width="50%"><?=$DataContent?></td>
          <td width="15%"><?=date($Config['DateFormat'] . "  ,".$_SESSION['TimeFormat']."", strtotime($eval['CommentDate']))?></td>
          <td width="20%"><a href="javascript:;" style="color:white;"  onclick="Delete_Log('Email', '<?=$eval['CommentID']?>');" class="button">Delete</a></td>
</tr>
 
<?php }}?>
</tbody></table>
</div>
</div>
<div id="EmailAddDiv" style="display:none;">
<table width="100%" border="0" cellpadding="5" cellspacing="0">
 <tr>  
            <td valign="top" align="right"><a class="add" id="ShowEmailbtn">Log Email</a></td>
 </tr>
 </table>
 <form name="Emailfrm" id="Emailfrm"  method="post" enctype="multipart/form-data">
 <table width="100%" border="0" cellpadding="0" cellspacing="0" >
 <tr>
          <td align="left" width="10%"   valign="top">Subject  :</td>
          <td  align="left" >
         <input type="text" class="inputbox" name="EmailSubject"  id="emailsubject" value="" placeholder="Enter Email Subject"  />   </td>
</tr>
 <tr>
          <td align="left" width="10%"   valign="top">Content:</td>
          <td  align="left" >
           

        <textarea name="EmailContent" id="EmailContent" class="bigbox editor" maxlength="500"></textarea>
         </td>
</tr>
<tr>
         <td align="left" width="10%"   valign="top"></td>
    <td  align="left"> 

                 
    <input name="EmailButton" type="submit"  class="button_small EmailBut" id="EmailButton" value="Save"  /> 

    </td>     
  </tr>
</table>
 </form>
 <script type="text/javascript">

var editorName = 'EmailContent';

var editor = new ew_DHTMLEditor(editorName);
//EmailCompose
editor.create = function() {
  var sBasePath = '../FCKeditor/';
  var oFCKeditor = new FCKeditor(editorName, '100%', 200, 'EmailCompose');
  //var oFCKeditor = new FCKeditor(editorName, '100%', 200, 'Basic');
  oFCKeditor.BasePath = sBasePath;
  oFCKeditor.ReplaceTextarea();
  this.active = true;
}
ew_DHTMLEditors[ew_DHTMLEditors.length] = editor;

ew_CreateEditor(); 


</script> 
 </div>
 <div class="ViewEmailDiv" style="display:none;">
 <table width="100%" border="0" cellpadding="5" cellspacing="0">
 <tr>  
            <td valign="top" align="right"><a class="back" id="EmailBackbtn">Back</a></td>
 </tr>
 </table>
 <div class="ViewEmailLog">
</div>
 </div>
