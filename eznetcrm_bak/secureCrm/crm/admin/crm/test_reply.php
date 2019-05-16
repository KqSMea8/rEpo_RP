
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
 <script>
   $('.reply').click(function() {       
    var cId = $(this).closest('table').find('input[id^="comment-id"]');        
    $("#respond").val($(cId).val());
    $("#comments").focus();
});
$(".submit-comment").click(function(){
    var a="",b=0;
    var n=$("#your-name").val();
    var e=$("#your-email").val();
    var w=$("#your-website").val();
    var c=$("#comments").val();
    var pg=$("#page-no").val();
    var rp=$("#respond").val();
    var ch=$("[name=recaptcha_challenge_field]").val();
    var re=$("[name=recaptcha_response_field]").val();
    var confirmAuthor=0;
    n=$.trim(n);
    e=$.trim(e);
    w=$.trim(w);
    c=$.trim(c);
    var h="name="+n+"&email="+e+"&web="+w+"&comment="+c+"&challenge="+ch+"&response="+re+"&respond="+rp+"&page_id="+pg;
    document.getElementById("recaptcha_reload_btn").click();
    if(n==""||e==""||c==""||$.trim(re)==""){
        a+="\n Please Write Your 'Name' , 'Email' , 'Comments' and 'Captcha' Before Submiting. ";
        b++;
    }else{
        var i=/[-_@'$&`~;?%^)*(#!0-9]/;
        var temp=n;
        temp.toLowerCase();
        if(temp=="author"){
            a+="\nInvalid User Name";
            b++;
        }
        if(i.test(n)){
            a+="\nPlease Write a Correct Name ! ";
            b++;
        }
        i=/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/;
        if(!i.test(e)){
            a+="\nPlease Write Valid Email Address ! ";
            b++;
        }
    }
    if(b>=1){
        alert(a);
    }
    if(b==0){
        $("#flash").show();
        $("#flash").fadeIn(400).html('<img src="images/loading.gif" align="absmiddle"> <span class="loading">Loading Comment...</span>');
        $.ajax({
            type:"POST",
            url:"admin/include/ajax-comments.php",
            data:h,
            cache:false,
            success:function(a){
                $("ol#update").append(a);
                $("ol#update li:last").fadeIn("slow");
                document.getElementById("your-email").value="";
                document.getElementById("your-name").value="";
                document.getElementById("your-website").value="";
                document.getElementById("comments").value="";
                document.getElementById("respond").value="";
                $("#recaptcha_reload_btn").click();
                $("#your-name").focus();
                $("#flash").hide();                    
            }
        })
    }
    return false;
});<script>
