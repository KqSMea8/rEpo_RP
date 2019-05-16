
<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
 
<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>

    <link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
    <link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />
<script type="text/javascript">
	var ew_DHTMLEditors = [];
</script>
<script language="JavaScript1.2" type="text/javascript">



function validate(frm){
		if( ValidateForSimpleBlank(frm.title, "Document Title")
		//&& ValidateForSimpleBlank(frm.AssignTo,"Assign To")
		    && ValidateOptionalDoc(frm.FileName, "Document")
		){
		
		
		

			var Url = "isRecordExists.php?DocumentTitle="+escape(document.getElementById("title").value)+"&editID="+document.getElementById("documentID").value;
			SendExistRequest(Url,"title","Document Title");
			return false;
		}else{
			return false;	
		}
		
}
</script>
<SCRIPT LANGUAGE=JAVASCRIPT>

function SelectAllRecord()
{	
	for(i=1; i<=document.form1.Line.value; i++){
		document.getElementById("EmpID"+i).checked=true;
	}

}

function SelectNoneRecords()
{
	for(i=1; i<=document.form1.Line.value; i++){
		document.getElementById("EmpID"+i).checked=false;
	}
}

 function getval(sel) {
 
       //alert(sel.value);
	   document.getElementById("activity_type").value = sel.value;
    }
</SCRIPT>
  <script>
$(document).ready(function() {
        $('#assign1').click(function() {
                $('#group').hide();
                $('#user').show();

        });
       $('#assign2').click(function() {
                 $('#user').hide();
                $('#group').show();
                
        });
    });
       

    </script>

<div class="had">
Document  Details
</div>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
	<td align="left" valign="top">
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
<form name="form1" action="<?=$ActionUrl?>"  method="post" onSubmit="return validate(this);" enctype="multipart/form-data">

   <tr>
    <td  align="center" valign="top" >


<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

	<tr>
	<td  align="right" width="40%"   class="blackbold"> Title  : </td>
	<td   align="left" >
	<?php echo stripslashes($arryDocument[0]['title']); ?>            </td>
	</tr>

<tr>
<td align="right"   class="blackbold"> Assigned To  : </td>
<td   align="left" >
<span class="red"> <?=$Name?></span>
   </td>
</tr>

	 
<tr >
  <td align="right"   class="blackbold"> &nbsp;&nbsp; </td>
        <td  align="left" >

		<?=$Emp?>
		
          </td>
      </tr>


<tr>
        <td  align="right"   class="blackbold">  Customer : </td>
        <td   align="left" >
<? if(!empty($arryCustomer[0]['FullName'])){?><a class="fancybox fancybox.iframe" href="../custInfo.php?view=<?=$arryCustomer[0]['CustCode']?>"><?=(stripslashes($arryCustomer[0]['FullName']))?> </a> <?} else { echo NOT_SPECIFIED;?> <? }?>	    

            </td>
            </tr>







	  <tr>

	     <td align="right"  valign="middle"  class="blackbold">Status :</td>
                      <td align="left" class="blacknormal">
       <?=($DocumentStatus==1)?"Active":""?>  <?=($DocumentStatus==0)?"Inactive":""?></td>
           
                      
		
	
	  </tr>


</table>	
  
  
	
	</td>
   </tr>

  
   </form>
</table>

	
	</td>
    </tr>
 
</table>
<? //echo '<script>SetInnerWidth();</script>'; ?>
