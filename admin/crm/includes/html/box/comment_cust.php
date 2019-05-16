
<script type="text/javascript" src="includes/time.js"></script>

<script language="JavaScript1.2" type="text/javascript">

    $(document).ready(function() {
        $("#SubmitButton").click(function(e) {
            e.preventDefault();

            var Comment = $("#Comment").val();
            // var parent=$("#parent").val();
            var parentID = '<?= $_GET['view'] ?>';
            var parent_type = '<?= $_GET['module'] ?>';
            var commented_by = '<?= $_SESSION['AdminType'] ?>';
            var commented_id = '<?= $_SESSION['AdminID'] ?>';



            $.ajax({
                type: "GET",
                url: "ajax.php",
                data: "action=CustCommented&Comment=" + Comment + "&parentID=" + parentID + "&parent=" + parent + "&parent_type=" + parent_type + "&commented_by=" + commented_by + "&commented_id=" + commented_id,
                success: function(data) {
                    //$("#info").html(data);
                    $("#Comment").val('');
                    GetCommentLising();


                }

            });
            return false;

        });

    });
    function reply_submit() {

        var Comment = document.getElementById("Com").value;
        var parent = document.getElementById("parent").value;

        var parentID = '<?= $_GET['view'] ?>';
        var parent_type = '<?= $_GET['module'] ?>';
        var commented_by = '<?= $_SESSION['AdminType'] ?>';
        var commented_id = '<?= $_SESSION['AdminID'] ?>';


        var SendUrl = "ajax.php?action=CustCommented&Comment=" + Comment + "&parentID=" + parentID + "&parent=" + parent + "&parent_type=" + parent_type + "&commented_by=" + commented_by + "&commented_id=" + commented_id + "&r=" + Math.random();
        //alert(SendUrl);
        httpObj2.open("GET", SendUrl, true);
        httpObj2.onreadystatechange = function ListReply() {
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


            var Comment2 = $("#Com").val();
            var parent = $("#child").val();

            alert(Comment2);

            var parentID = '<?= $_GET['view'] ?>';
            var parent_type = '<?= $_GET['module'] ?>';
            var commented_by = '<?= $_SESSION['AdminType'] ?>';
            var commented_id = '<?= $_SESSION['AdminID'] ?>';



            $.ajax({
                type: "GET",
                url: "ajax.php",
                data: "action=ReplyCommented&Comment=" + Comment + "&parentID=" + parentID + "&parent=" + parent + "&parent_type=" + parent_type + "&commented_by=" + commented_by + "&commented_id=" + commented_id,
                success: function(data) {
                    //$("#info").html(data);
                    //$("#Comment2").val('');
                    GetCommentLising();


                }

            });
            return false;

        });

    });




    function GetCommentLising() {

        var parentID = '<?= $_GET['view'] ?>';
        var parent_type = '<?= $_GET['module'] ?>';
        var commented_by = '<?= $_SESSION['AdminType'] ?>';
        var commented_id = '<?= $_SESSION['AdminID'] ?>';


        var SendUrl = "ajax.php?action=CustCommented&parentID=" + parentID + "&parent_type=" + parent_type + "&commented_by=" + commented_by + "&commented_id=" + commented_id + "&r=" + Math.random();
        httpObj2.open("GET", SendUrl, true);
        httpObj2.onreadystatechange = function ListLocalTime() {
            if (httpObj2.readyState == 4) {
                //alert('pppp');
                document.getElementById("info").innerHTML = httpObj2.responseText;

            }

        };

        httpObj2.send(null);


    }




    function reply_comment(id) {
//alert('pppp');
        document.getElementById("child").value = id;
        document.getElementById("reply_" + id).style.display = "block";



    }

    function Delete_comment(ID) {
        var parentID = '<?= $_GET['view'] ?>';
        var parent_type = '<?= $_GET['module'] ?>';
        var commented_by = '<?= $_SESSION['AdminType'] ?>';
        var commented_id = '<?= $_SESSION['AdminID'] ?>';
        var SendUrl = "ajax.php?action=CustCommented&del_comment=delete&commID=" + ID + "&parentID=" + parentID + "&parent_type=" + parent_type + "&commented_by=" + commented_by + "&commented_id=" + commented_id + "&r=" + Math.random();
        //var SendUrl = "ajax.php?action=Commented&del_comment=delete&commentID="+ID+"&r="+Math.random(); 
        //alert(SendUrl);
        httpObj2.open("GET", SendUrl, true);
        httpObj2.onreadystatechange = function ListLocalTime() {
            if (httpObj2.readyState == 4) {
                //alert('pppp');
                document.getElementById("info").innerHTML = httpObj2.responseText;

            }

        };

        httpObj2.send(null);
//alert(ID);
    }



    GetCommentLising();



    $(document).ready(function() {
        $('#key').on('input', function() {
            
            var parentID = '<?= $_GET['view'] ?>';
            var parent_type = '<?= $_GET['module'] ?>';
            var searchKeyword = $(this).val();
            
            if(searchKeyword == ''){
               GetCommentLising();  
            }
           
            if (searchKeyword.length >= 3) {
                
                 var SendUrl = "ajax.php?action=CustCommented&SearchKey=" + searchKeyword + "&parentID=" + parentID +  "&parent_type=" + parent_type + "&r=" + Math.random();
                httpObj2.open("GET", SendUrl, true);
                httpObj2.onreadystatechange = function ListLocalTime() {
            if (httpObj2.readyState == 4) {
                //alert('pppp');
                document.getElementById("info").innerHTML = httpObj2.responseText;

            }

        };

        httpObj2.send(null);
                
                
                
                
               
            }
        });
    });

</script>
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
    <tr>
        <td colspan="2" align="left"   class="head">Comment Information</td>
    </tr>
    <tr>
        <td colspan="2" align="right">
            <!--form name="frmSrch" id="frmSrch" action="" method="get" onsubmit="return ResetSearch();"-->
                <input name="key" id="key" placeholder="Search Keyword" class="textbox" size="20" maxlength="30" value="" type="text">
                

            <!--/form-->
        </td>


    </tr>
    <tr>
        <td colspan="2" align="left"   >
            <div id="info"></div> 
        </td>
    </tr>

    <tr>
        <td colspan="2" align="left"   class="head">Comment </td>
    </tr>	

    <tr>
        <td colspan="2" align="left"   >
            <form name="form1" id="frm"  method="post" enctype="multipart/form-data">
                <table width="100%" border="0" cellpadding="5" cellspacing="0" >

                    <tr>
                        <td align="right"    valign="top">Add Comment  :</td>
                        <td  align="left" >
                            <textarea name="Comment" style="width:600px;" type="text" class="textarea" id="Comment" placeholder="Enter Your Post Here"></textarea>	 </td>
                    </tr>
                    <tr>
                        <td align="center" colspan="2"   > 
                            <input type="hidden" name="parentID"  id="parentID" value="<?= $_GET['view'] ?>"  />

                            <input name="Submit" style="margin-left:465px;" type="submit" class="button" id="SubmitButton" value="Post Comment"  /> 
                        </td>     
                    </tr>
                </table>
            </form>

        </td>
    </tr>

</table>

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




