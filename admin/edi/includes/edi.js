     $(document).ready(function(){
    	 function isNumberKey(evt)
         {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
               return false;

            return true;
         }
		  $("#SubmitPage").click(function(){

                    var Name = $.trim($("#Name").val());
                    


                    if(Name == "")
                    {
                        alert("Please Enter Page Name");
                        $("#Name").focus();
                        return false;
                    }

                   
                    
                    ShowHideLoader('1','S');

                });
				
				$("#SubmitCat").click(function(){

                    var Name = $.trim($("#Name").val());
                    


                    if(Name == "")
                    {
                        alert("Please Enter Category Name");
                        $("#Name").focus();
                        return false;
                    }

                   
                    
                    ShowHideLoader('1','S');

                });	
				
				$("#SubmitArticle").click(function(){

                    var Title = $.trim($("#Title").val());
                   


                    if(Title == "")
                    {
                        alert("Please Enter Title");
                        $("#Title").focus();
                        return false;
                    }
					
                   
                    
                    ShowHideLoader('1','S');

                });	
				
				 $("#SubmitForm").click(function(){

	                    var Name = $.trim($("#FormName").val());
	                    


	                    if(Name == "")
	                    {
	                        alert("Please Enter Form Name");
	                        $("#FormName").focus();
	                        return false;
	                    }

	                   
	                    
	                    ShowHideLoader('1','S');

	                });
				 

				 $("#SubmitFormField").click(function(){

	                    var FormId = $.trim($("#FormId").val());
	                    var FieldType = $.trim($("#FieldType").val());
	                    var FieldName = $.trim($("#FieldName").val());
	                    var Fieldlabel = $.trim($("#Fieldlabel").val());
	                    
	                    	

	                    if(FormId == "")
	                    {
	                        alert("Please Select Form ");
	                        $("#FormId").focus();
	                        return false;
	                    }
	                    else if(FieldType == "")
	                    {
	                        alert("Please Select Field Type ");
	                        $("#FormId").focus();
	                        return false;
	                    }
	                    else if(FieldName == "")
	                    {
	                        alert("Please Enter Field Name ");
	                        $("#FormId").focus();
	                        return false;
	                    }
	                    else if(Fieldlabel == "")
	                    {
	                        alert("Please Enter Field Label ");
	                        $("#FormId").focus();
	                        return false;
	                    }
	                   
	                    
	                    ShowHideLoader('1','S');

	                });
				 
								
		});
     
     
     