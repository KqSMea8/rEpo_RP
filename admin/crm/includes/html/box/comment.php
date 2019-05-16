
 <script type="text/javascript" src="includes/time.js"></script>

<script language="JavaScript1.2" type="text/javascript">

    $(document).ready(function() {    
     $("#SubmitButton").click(function(e) {
		 e.preventDefault();
		
      var Comment=$("#Comment").val();
	 // var parent=$("#parent").val();
      var parentID='<?=$_GET['view']?>';
	  var parent_type='<?=$_GET['module']?>';
	  var commented_by='<?=$_SESSION['AdminType']?>';
	  var commented_id='<?=$_SESSION['AdminID']?>';
Comment =encodeURIComponent(Comment);


      $.ajax({
          type:"GET",
          url:"ajax.php",
          data:"action=Commented&Comment="+Comment+"&parentID="+parentID+"&parent="+parent+"&parent_type="+parent_type+"&commented_by="+commented_by+"&commented_id="+commented_id,
          success:function(data){
             //$("#info").html(data);
			 $("#Comment").val('');
			 GetCommentLising();
			 
			 
          }

      });
      return false;

   });
   
});
function reply_submit(){

var Comment= document.getElementById("Com").value;
var parent= document.getElementById("parent").value;

  var parentID='<?=$_GET['view']?>';
	  var parent_type='<?=$_GET['module']?>';
	  var commented_by='<?=$_SESSION['AdminType']?>';
	  var commented_id='<?=$_SESSION['AdminID']?>';

		
		var SendUrl = "ajax.php?action=Commented&Comment="+Comment+"&parentID="+parentID+"&parent="+parent+"&parent_type="+parent_type+"&commented_by="+commented_by+"&commented_id="+commented_id+"&r="+Math.random(); 
		//alert(SendUrl);
		httpObj2.open("GET", SendUrl, true);
		httpObj2.onreadystatechange = function ListReply(){
			if (httpObj2.readyState == 4) {
				//alert(httpObj2.responseText);
				document.getElementById("info").innerHTML = httpObj2.responseText;
				
				
			}

		};

		httpObj2.send(null);
 
		 //e.preventDefault();
		 return false;
		 
}

 $(document).ready(function() {    
     $("#rep").click(function() {
		
	
      var Comment2=$("#Com").val();
	 var parent=$("#child").val();
	 
	 alert(Comment2);
	
      var parentID='<?=$_GET['view']?>';
	  var parent_type='<?=$_GET['module']?>';
	  var commented_by='<?=$_SESSION['AdminType']?>';
	  var commented_id='<?=$_SESSION['AdminID']?>';



      $.ajax({
          type:"GET",
          url:"ajax.php",
          data:"action=ReplyCommented&Comment="+Comment+"&parentID="+parentID+"&parent="+parent+"&parent_type="+parent_type+"&commented_by="+commented_by+"&commented_id="+commented_id,
          success:function(data){
             //$("#info").html(data);
			 //$("#Comment2").val('');
			 GetCommentLising();
			 
			 
          }

      });
      return false;

   });
   
});




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




function reply_comment(id){
//alert('pppp');
document.getElementById("child").value=id;
document.getElementById("reply_"+id).style.display="block";



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
<?php  include("includes/html/box/emailcalljs.php"); ?>
<div class="tab">
  <button id="defaultOpen" class="tablinks active" onclick="openTab(event,'Commenttab')">Comment</button>
  <button class="tablinks" onclick="openTab(event,'Email')">Email Log</button>
  <button class="tablinks" onclick="openTab(event,'Call')">Call Log</button>
  </div>
<div id="Commenttab" class="tabcontent" style="display:block">
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
       		 <td colspan="2" align="left"   class="head_comment">Comment Information</td>
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
		<input name="Submit" type="submit" class="button_small" id="SubmitButton" value="Post Comment"  /> 

		</td>     
	</tr>

        </table>
</form>
 	
</td>
        </tr>
<? } ?>
</table>
</div>  
 <div id="Email" class="tabcontent">
  <?  include("includes/html/box/emaillog.php"); ?>
 </div>
 <div id="Call" class="tabcontent">
 <?  include("includes/html/box/calllog.php"); ?>
 </div>
        
	<?php
	//if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
 // $stamp=$values['timestamp'];
    //$diff = $time-$stamp; 

   /* 
   
    switch($diff){
        case ($diff<60):
            $count = $diff;
            $int = "seconds";
            if($count==1){
                $int = substr($int, 0, -1);
            }
        break;
        
        case ($diff>=60&&$diff<3600):
            $count = floor($diff/60);
            $int = "minutes";
            if($count==1){
                $int = substr($int, 0, -1);
            }
        break;
        
        case ($diff>=3600&&$diff<60*60*24):
            $count = floor($diff/3600);
            $int = "hours";
			//echo  $count;
            if($count==1){
                $int = substr($int, 0, -1);
            }
        break;
        
        case ($diff>=60*60*24&&$diff<60*60*24*7):
            $count = floor($diff/(60*60*24));
		
            $int = "days";
            if($count==1){
                $int = substr($int, 0, -1);
            }
        break;
        
        case ($diff>=60*60*24*7&&$diff<60*60*24*30):
            $count = floor($diff/(60*60*24*7));
            $int = "weeks";
            if($count==1){
                $int = substr($int, 0, -1);
            }
        break;
        
        case ($diff>=60*60*24*30&&$diff<60*60*24*365):
            $count = floor($diff/(60*60*24*30));
            $int = "months";
            if($count==1){
                $int = substr($int, 0, -1);
            }
        break;
        
        case ($diff>=60*60*24*30*365&&$diff<60*60*24*365*100):
            $count = floor($diff/(60*60*24*7*30*365));
            $int = "years";
            if($count==1){
                $int = substr($int, 0, -1);
            }
        break;
    }
*/
  ?>

 
 
  
