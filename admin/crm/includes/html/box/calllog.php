<div id="CallList">
 <table width="100%" border="0" cellpadding="5" cellspacing="0">
 <tr>  
            <td valign="top" align="right"><a class="add" id="AddCallbtn">Add Call Log</a></td>
 </tr>
 </table>
 <div class="CallHtmlShow">
 <table id="CallTable" width="100%" border="0" cellpadding="3" cellspacing="1" class="borderall borderall2">
 <thead>
 <tr align="left">
<th class="head1">Subject</th>
<th class="head1">Call Purpose</th>
<th class="head1">Call Type</th>
<th class="head1">Call Duration</th>
<th class="head1">Date</th>
<th class="head1">Action</th>
</tr>
</thead>
<tbody>
<?php if(!empty($arryCalllogList)){ 
foreach($arryCalllogList as $cval){?>
 <tr class="Call_<?=$cval['CommentID']?>">
          <td ><?=$cval['subject']?></td>
          <td ><?=$cval['callPurpuse']?></td>
          <td ><?=$cval['calltype']?></td>
          <td ><?=gmdate("H:i:s", $cval['callduration'])?></td>
          <td ><?=date($Config['DateFormat'] . "  ,".$_SESSION['TimeFormat']."", strtotime($cval['CommentDate']))?></td>
          <td><a href="javascript:;" style="color:white;"  onclick="Delete_Log('Call', '<?=$cval['CommentID']?>');" class="button">Delete</a></td>
</tr>

<?php }}?>
</tbody></table>
</div>
</div>
 <div id="CallAddDiv" style="display:none;">
<table width="100%" border="0" cellpadding="5" cellspacing="0">
 <tr>  
            <td valign="top" align="right"><a class="add" id="ShowCallbtn">Log Call</a></td>
 </tr>
 </table>
 <form name="Callfrm" id="Callfrm"  method="post" enctype="multipart/form-data">
 <table width="100%" border="0" cellpadding="0" cellspacing="0" >
 <tr>
          <td align="left" width="10%"   valign="top">Subject  :</td>
          <td  align="left" >
         <input type="text" class="inputbox" name="callSubject"  id="callSubject" value="" placeholder="Enter Call Subject"  />   </td>
</tr>
 <tr>
          
          <td align="left" width="10%"   valign="top">Call Purpose  :</td>
          <td  align="left" >
         <input type="text" class="inputbox" name="callPurpuse"  id="callPurpuse" value="" placeholder="Enter Call Purpose"  />   </td>
</tr>
<tr>
          
          <td align="left" width="10%"   valign="top">Call Type  :</td>
          <td  align="left" >
         <select id="calltype" name="calltype" class="textbox">
          <option value="Inbound">Inbound</option>
          <option value="Outbound">Outbound</option>
         </select>

         </td>
</tr>
<tr>
<td  align="left" colspan="2">
<div id='main'>
<button type='button' onclick='ss()' class="button_startrest" onfocus='this.blur()'>Start / Stop</button>
  <input type='text' id='disp' class="inputbox" />
  
  <button type='button' onclick='r()' class="button_startrest" onfocus='this.blur()'>Reset</button>
  </td>
  </div>
</tr>
<tr>
         <td align="left" width="10%"   valign="top"></td>
    <td  align="left"> 

    <input type="hidden" name="callduration" id="callduration" value="" />             
    <input name="CallButton" type="submit"  class="button_small" id="CallButton" value="Save"  /> 

    </td>     
  </tr>
</table>
 </form>
 </div>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
 <script type="text/javascript">

 $(function(){
  $('#CallTable').dataTable();
  $('#EmailTable').dataTable();
});

 </script> 
