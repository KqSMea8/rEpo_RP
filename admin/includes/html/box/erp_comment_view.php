<style>
#load_div{ display:none;}
</style>
 <script type="text/javascript" src="includes/time.js"></script>
<script language="JavaScript1.2" type="text/javascript">
function submitPost(){
var Comment=$("#Comment").val();
	 // var parent=$("#parent").val();
      var parentID='<?=$_GET['view']?>';
	  var parent_type='<?=$_GET['module']?>';
	  var commented_by='<?=$_SESSION['AdminType']?>';
	  var commented_id='<?=$_SESSION['AdminID']?>';
		 var po ='<?=$_GET['po']?>'? '<?=$_GET['po']?>':'';
		 var so ='<?=$_GET['so']?>' ? '<?=$_GET['so']?>' : '';
		 var sq ='<?=$_GET['sq']?>' ? '<?=$_GET['sq']?>' : '';
		 var qo ='<?=$_GET['qo']?>' ? '<?=$_GET['qo']?>' : '';
		var ar ='<?=$_GET['AR']?>' ? '<?=$_GET['AR']?>' : '';
	 	var ap ='<?=$_GET['AP']?>' ? '<?=$_GET['AP']?>' : '';
	  
var module_type ='';
	 if(po){	 
	 	var module_type = 'PO';
	 }
	 else if(so){	 		
	 var module_type = 'SO';	 	
	 }
	 else if(qo){	 	
	 	var module_type = 'QO';
	 }
	 else if(sq){	 	
	 	var module_type = 'SQ';
	 }
	 else if(ar){	 	
	 	var module_type = 'AR';
	 }
	else if(ap){	 	
	 	var module_type = 'AP';
	 }


    Comment = encodeURIComponent(Comment);
      $.ajax({
          type:"GET",
          url:"ajax.php",
        data:"action=Commented&Comment="+Comment+"&parentID="+parentID+"&parent="+parent+"&parent_type="+parent_type+"&commented_by="+commented_by+"&commented_id="+commented_id+"&module_type="+module_type,
         success:function(data){
             //$("#info").html(data);
			 $("#Comment").val('');
			 GetCommentLising();			 
          }

      });
      return false;	
	
}

function GetCommentLising(){

      var parentID='<?=$_GET['view']?>';
	  var parent_type='<?=$_GET['module']?>';
	  var commented_by='<?=$_SESSION['AdminType']?>';
	  
	  var commented_id='<?=$_SESSION['AdminID']?>';
	  var popup='<?=$_GET['pop']?>';
	  if(parent_type=='junk') parent_type = 'lead';
		
	var SendUrl = "ajax.php?action=Commented&parentID="+parentID+"&parent_type="+parent_type+"&commented_by="+commented_by+"&commented_id="+commented_id+"&r="+Math.random(); 
		httpObj2.open("GET", SendUrl, true);
		httpObj2.onreadystatechange = function ListLocalTime(){
			if (httpObj2.readyState == 4) {
				//alert('pppp');
				document.getElementById("info").innerHTML = httpObj2.responseText;
				if(popup==1) $(".button").hide();
			}

		};

		httpObj2.send(null);
		

}

function Delete_comment(ID){
	  var parentID='<?=$_GET['view']?>';
	  var parent_type='<?=$_GET['module']?>';
	  var commented_by='<?=$_SESSION['AdminType']?>';
	  var commented_id='<?=$_SESSION['AdminID']?>';
	  
var SendUrl = "ajax.php?action=Commented&del_comment=delete&commID="+ID+"&parentID="+parentID+"&parent_type="+parent_type+"&commented_by="+commented_by+"&commented_id="+commented_id+"&r="+Math.random();
		//var SendUrl = "ajax.php?action=Commented&del_comment=delete&commentID="+ID+"&r="+Math.random(); 
		//alert(SendUrl);
		httpObj2.open("GET", SendUrl, true);
		httpObj2.onreadystatechange = function ListLocalTime(){
			if (httpObj2.readyState == 4) {
				//alert('pppp');
				document.getElementById("info").innerHTML = httpObj2.responseText;
				
			}

		};

		httpObj2.send(null);
//alert(ID);
}

// by rajan 
function Edit_comment(ID,obj,fr){
	  
	if(fr =='edit')
	{
		$text = $(obj).closest('div').parent().prev().text();
		$(obj).closest('div').parent().prev().html('<textarea type="text" class="textarea" id="editcomment'+ID+'"  style="width:98%;" name="editcomment">'+$text+'</textarea>');

		$(obj).text('Update').css("background-color","#d40503").attr('onclick',"Edit_comment('"+ID+"',this,'update')");

	
	}else{
	
		var Comment=$("#editcomment"+ID+"").val();
Comment =encodeURIComponent(Comment);
		$.ajax({
	          type:"GET",
	          url:"ajax.php",
	          data:"action=EditCommented&Comment="+Comment+"&CommentID="+ID,
	          success:function(data){ }
	
	      });
		$(obj).closest('div').parent().prev().html(Comment);		
		$(obj).text('Edit').attr('onclick',"Edit_comment('"+ID+"',this,'edit')");

		GetCommentLising();
	}			
	 
}
//end
GetCommentLising();

</script>
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
       		 <td colspan="2" align="left"   class="head_comment">Leave Comments</td>
        </tr>
<tr>
       		 <td colspan="2" align="left"   >
<div id="info"> </div> 
</td>
        </tr>
<? if($_GET['pop']!=1){ ?>
<tr>
	 <td colspan="2" align="left"  class="head">Comment</td>
</tr>	
<tr>
       		 <td colspan="2" align="left" >
<form name="form1" id="frm"  method="post" enctype="multipart/form-data">
<table width="100%" border="0" cellpadding="5" cellspacing="0" >

      <tr>
          <td align="right" width="25%"   valign="top">Add Comment  :</td>
          <td  align="left" >
	       <textarea name="Comment" style="width:98%;" type="text" class="textarea" id="Comment" placeholder="Enter Your Post Here"></textarea>	 </td>
       </tr>

	<tr>
		<td  align="left" ></td>     
		<td align="right"> 

		<input type="hidden" name="parentID"  id="parentID" value="<?=$_GET['view']?>"  />     
		<span name="Submit" type="submit" class="button_small" onclick="submitPost();" id="SubmitButton" value="Post Comment">Post Comment</span>
		        
		<!--<input name="Submit" type="submit" class="button_small" id="SubmitButton" value="Post Comment"  /> -->

		</td>     
	</tr>

        </table>
</form>
 	
</td>
        </tr>
<? } ?>
</table>
        


 
 
  
