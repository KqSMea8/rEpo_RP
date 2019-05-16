<script language="JavaScript1.2" type="text/javascript">
$( function() {
	var myPos = { my: "center top", at: "center top+200", of: window };
	dialog = $( "#AddCommentdialog" ).dialog({
      autoOpen: false,
      show: {
        effect: "blind",
        duration: 100
      },
      hide: {
        effect: "blind",
        duration: 100
      },
      position: myPos,
      modal: true,
      width: 350
     
    });

	dialog1 = $( "#CommentListdialog").dialog({
	      autoOpen: false,
	      show: {
	        effect: "blind",
	        duration: 100
	      },
	      hide: {
	        effect: "blind",
	        duration: 100
	      },
	      position: myPos,
	      height: 400,
	      width: 400
	     
	    });
 
    $( "#CommentList" ).on( "click", function() {
      $( "#CommentListdialog" ).dialog( "open" ,"#CommentListdialog");
    });

    $( "#AddComment" ).on( "click", function() {
        $( "#AddCommentdialog" ).dialog( "open" ,"#AddCommentdialog");
      });

    form = dialog.find( "form3" ).on( "submit", function( event ) {
        event.preventDefault();
        addComment();
      });

    $("#module_type").change(function(){
		if($( this ).val()!=''){
			$(".hideC").hide();
		}else{
			$(".hideC").show();
		}
	});
	

  } );

var CommentSourse = 'Comment';
<?php if($module=='Invoice'){ ?>
	CommentSourse = 'InvoiceComment';
<?php } ?>

function addComment(){  
	var  sendParam='';
	var module_type = $("#module_type").val();
	var view_type = $("#view_type").val();
	var newcomment = $("#newcomment").val();
	var module_type = $("#module_type").val();
	MultiComment = $("#" + CommentSourse).val();
	if(newcomment.length < 2 && module_type==null){
		alert("Please enter comment!");
		return false;
	}
  	sendParam='Action=AddComment&module_type='+ module_type +'&view_type='+ view_type + '&invoice_type=<?=$module_type?>&comment='+newcomment+'&module_type='+module_type+'&MultiComment='+ MultiComment + '&order_id=<?=$_GET['edit'] ?>';
	$.ajax({
    type: "POST",
    async:false,
    url: 'ajax.php',
    data: sendParam,
    success: function (responseText) { 
		var data = jQuery.parseJSON(responseText);
			if(data > 0){
				MultiComment = MultiComment + '##' + parseInt(data);
				$("#" + CommentSourse).val(MultiComment);
				dialog.dialog( "close" );
				if(module_type){ 
					newcomment = $("#module_type option:selected").attr('title');
				}
				var appendTxt = '<p id="cmt_'+ data + '">' + newcomment +'<span class="comment_delete" onclick="deleteComment('+ data +', 0);" ><img class="delicon" src="../images/delete.png"></span><br/> <span style="text-align: right;display: block;">Now</span></p>'; 
				$("#CommentListdialog").append(appendTxt);

				$("#AddCommentdialog").find("input[type=text], textarea").val("");

				cmtCount = $("#CommentList span").text();
				$("#CommentList span").text(parseInt(cmtCount)+1);
				
			}else{
				alert("Not able to add Comment.");
			}
    }
	});
}

function deleteComment(commentID, masterCommentID){  
	var  sendParam='';
	MultiComment = $("#" + CommentSourse).val();
	if(confirm("Are you sure you want to delete this comment!")==false){
		return false;
	}
  	sendParam='Action=DeleteComment&commentID='+ commentID +'&invoice_type=<?=$module_type?>&masterCommentID='+ masterCommentID + '&MultiComment='+ MultiComment+'&order_id=<?=$_GET['edit']?>';
	$.ajax({
    type: "POST",
    async:false,
    url: 'ajax.php',
    data: sendParam,
    success: function (responseText) {
		var data = jQuery.parseJSON(responseText);
			if(data > 0){
				MultiComment = MultiComment.replace("##"+commentID, "");
				$("#" + CommentSourse).val(MultiComment);
				$("p").remove("#cmt_"+ commentID);
				cmtCount = $("#CommentList span").text();
				$("#CommentList span").text(parseInt(cmtCount)-1);
			}else{
				alert("Not able to delete Comment.");
			}
    }
	});
}


</script>

<style>
<!--
div#CommentListdialog p {
    border: 1px solid #EB8;
    padding: 8px;
    border-radius: 7px;
    background-color: antiquewhite;
}

.comment_delete{
    text-align: right;
    display: block;
    margin-top: -25px;
    margin-right: -6px;
    cursor: pointer;
}

a#CommentList, a#AddComment {
    text-decoration: blink;
    font-weight: bold;
    cursor: pointer;
}

a#CommentList{margin-right: 40px;}
-->
</style>
<div id="CommentListdialog" title="Comment List" style="display:none;">
 <!--  <input type="hidden" name="Comment" id="Comment" value="<?php //echo stripslashes($arrComments); ?>"/>-->
 <?php $cmtCount = 0;
 		if(!empty($arrComments)){
 		$MultiComment = @explode("##",$arrComments);
 		$cmtIDS = array_filter($MultiComment);
 		$cmtIDS = @implode(',', $cmtIDS);
 		$CommentData = $objBankAccount->getComment($cmtIDS, true);
 		foreach ($CommentData as $cmt){ 
 			if($cmt['user_id']!=$_SESSION['AdminID'] && $cmt['view_type']=='private' && $_SESSION['AdminType']!='admin') continue;
 		?>
		<p id="cmt_<?=$cmt['CommentID']?>"><?=stripslashes($cmt['comment'])?> <span class="comment_delete" onclick="deleteComment('<?=$cmt['CommentID']?>', '<?=$cmt['MasterCommentID']?>');" ><?= $delete ?></span><br/> <span style="text-align: right;display: block;"><?=date($Config['DateFormat'], strtotime($cmt["comment_date"]))?></span></p>
		<?php 
		$cmtCount = $cmtCount+1;
 		}
 		}?>
</div>
		
		<a id="CommentList"><span><?=$cmtCount?></span> Comment(s)</a>
		
		<div id="AddCommentdialog" title="Add Comment" style="display:none;">
		
			 <form name="form3" action="" method="post">
	  		 <table width="100%" border="0" cellpadding="5" cellspacing="1" class="" >
                  
                  <?php 
					$commentList = $objBankAccount->getMasterCommentList($_SESSION['AdminID'],$module_type);
					if(!empty($commentList)){ ?> 
                   <tr>
                      <td width="30%" align="right" valign="top" =""  class="blackbold"> Comment :<span class="red">*</span> </td>
                      <td width="56%"  align="left" valign="top">
                       <select name="module_type" id="module_type" class="inputbox" >
                       		<option value="">--- Select From List ---</option>
					 <?php foreach ($commentList as $cvalue){ ?>
                       		<option value="<?=$cvalue['MasterCommentID']?>" title="<?=stripslashes($cvalue['comment'])?>"><?php echo substr(stripslashes($cvalue['comment']),0,80); if(strlen($cvalue['comment'])>80) echo "..."; ?></option>
                       		<?php }?>
                       </select>
					  </td>
                    </tr>
                    
                     <tr class="hideC">
                      <td width="56%"  align="left" valign="top" colspan="2"> <b>OR, Add New</b> </td>
                    </tr>   
                    <?php } ?>
                    
                    <!--  <tr>
                      <td width="30%" align="right" valign="top" =""  class="blackbold"> Assign To :<span class="red">*</span> </td>
                      <td width="56%"  align="left" valign="top">
                       <select name="module_type" id="module_type" class="inputbox" >
                       		<option value="sales" >Sales</option>
                       		<option value="purchases">Purchases</option>
                       		<option value="both">Both</option>
                       </select>
					  </td>
                    </tr>
                    
                     <tr>
                      <td width="30%" align="right" valign="top" =""  class="blackbold"> View Type :<span class="red">*</span> </td>
                      <td width="56%"  align="left" valign="top">
                       <select name="view_type" id="view_type" class="inputbox" >
                       		<option value="public" >Public</option>
                       		<option value="private" >Private</option>
                       </select>
                       
					  </td>
                    </tr> -->               
                     			
					<tr class="hideC">
                      <td width="30%" align="right" valign="top" =""  class="blackbold"> Comment :<span class="red">*</span> </td>
                      <td width="56%"  align="left" valign="top">

<?php $newcomment = (!empty($arryComments[0]['comment']))?($arryComments[0]['comment']):("");?>	

                       <textarea name="newcomment" id="newcomment" class="inputbox" maxlength="200" rows="6"><?=stripslashes($newcomment)?></textarea>
					  </td>
                    </tr>
                   
                 <tr>
                 <td align="right" valign="top"></td>
					<td align="left" valign="top">
					<select name="view_type" id="view_type" class="inputbox" style="width:70px;height: 27px;">
                       		<option value="public">Public</option>
                       		<option value="private">Private</option>
                       </select>
					<input name="Submit" type="button" class="button" id="SubmitButton" value=" Submit " onclick="addComment();" />&nbsp;
					</td>
		  		 </tr>
		  		
			   </table>
			   </form>
		</div>
		
	<a id="AddComment">Add Comment</a>
