<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
<link rel="stylesheet" type="text/css" href="../../css/jquery.dataTables.css">

<script type="text/javascript">
  var ew_DHTMLEditors = [];
</script>

<script>
function openTab(evt, tabName) {
  //alert('ffff');
  evt.preventDefault();
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
    // Get the element with id="defaultOpen" and click on it
    

}

window.onload = function () { 
load();
//$(document).ready(function() {  
//document.getElementById("defaultOpen").click();
 $("#AddEmailbtn").click(function(e) {
         e.preventDefault();
         $("input[name=EmailSubject], textarea.editor").val("");
          
         //CKeditor.instance["EmailContent"].setData('');
         //$("#EmailContent").val("");
         $("#EmailAddDiv").show();
         $("#EmailList").hide();
        });
 $("#ShowEmailbtn").click(function(e) {
         e.preventDefault();
         $("#EmailAddDiv").hide();
         $("#EmailList").show();
        });


 $("#AddCallbtn").click(function(e) {
         e.preventDefault();
         $("#callSubject").val("");
         $("#callPurpuse").val("");
         $("#callduration").val("");

         
         
         $("#CallAddDiv").show();
         $("#CallList").hide();
        });
 $("#ShowCallbtn").click(function(e) {
         e.preventDefault();
         $("#CallAddDiv").hide();
         $("#CallList").show();
        });
 //12-5-17
 $("#EmailBackbtn").click(function(e) {
         e.preventDefault();
         $("#EmailAddDiv").hide();
         $(".ViewEmailDiv").hide();
         $("#EmailList").show();
        });

//load();

}


$(document).on('click','#EmailButton',function(){ 
    
    $("form#Emailfrm").submit(function(e) {
    
    e.stopImmediatePropagation();
    e.preventDefault();
    //console.log( $( this ).serializeArray() );
  //var data = $(this).serialize();
  if($("#emailsubject").val()!=''){
  var data = {};
  $.each($(this).serializeArray(), function() {
    /*data[this.name] = this.value
        .replace(/&/g, '&amp;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');*/
        data[this.name]=encodeURIComponent(this.value);
    });
      var parentID='<?=$_GET['view']?>';
      var parent_type='<?=$_GET['module']?>';
      var commented_by='<?=$_SESSION['AdminType']?>';
      var commented_id='<?=$_SESSION['AdminID']?>';
  if (data != '') {
    console.log(data);
    
    $.ajax({
      url: "ajax.php?action=EmailLog&parentID="+parentID+"&parent_type="+parent_type+"&commented_by="+commented_by+"&commented_id="+commented_id,
      cache: false,
      type: 'POST',
      //async: false,
      data: data,
      dataType: 'json',
      success:function(result){
        load();
        var results=result.replace(/}/g, '');
        $("#EmailAddDiv").hide();
        $("#EmailList").show();
        //console.log(results);
        $(".EmailHtmlShow").html(results);
        $('#EmailTable').dataTable();
        //$("#EmailTable").html(results);
        
      }
    });
    return false;
  }//empty data
}else{
    alert('Please Enter Subject');
    return false;
}
  //return;

})//form

 });//on click

/*  $(document).on('click','.EmailBut',function(){alert('sdsadf');
 $("#Emailfrm").submit(function(e){
e.stopImmediatePropagation();e.preventDefault();alert('first');})
 });*/

 $(document).on('click','#CallButton',function(){ 
    
    $("form#Callfrm").submit(function(e) {
    
    e.stopImmediatePropagation();
    e.preventDefault();
    console.log( $( this ).serializeArray() );
  var data = $(this).serialize();
  if($("#callsubject").val()!=''){
  
      var parentID='<?=$_GET['view']?>';
      var parent_type='<?=$_GET['module']?>';
      var commented_by='<?=$_SESSION['AdminType']?>';
      var commented_id='<?=$_SESSION['AdminID']?>';
  if (data != '') {
    console.log(data);
    
    $.ajax({
      url: "ajax.php?action=CallLog&parentID="+parentID+"&parent_type="+parent_type+"&commented_by="+commented_by+"&commented_id="+commented_id,
      cache: false,
      type: 'GET',
      data: data,
      dataType: 'json',
      success:function(result){
        load();
        var results=result.replace(/}/g, '');
        $("#CallAddDiv").hide();
        $("#CallList").show();
        //console.log(results);
        $(".CallHtmlShow").html(results);//CallTable
        $('#CallTable').dataTable();
    //$('#EmailTable').dataTable();
        //$("#CallTable").html(results);
        
      }
    });
    return false;
  }//empty data
}else{
    alert('Please Enter Subject');
    return false;
}
  //return;

})//form

 });//on click


 function Delete_Log(Logtype,ID){
    //alert('gggg'+Logtype+"_"+ID);
if(ID!=''){
$.ajax({
    
      url: "ajax.php",
      cache: false,
      type: 'GET',
      data: "action=DeleteLog&commID="+ID,
      dataType: 'json',
      success:function(result){
        load();
        //console.log(result);
        $("."+Logtype+"_"+result).hide();
        
        
      }
    });
}
  return false;
 }
 function ViewEmail_Log(Logtype,ID){
    //alert('gggg'+Logtype+"_"+ID);
if(ID!=''){
$.ajax({
    
      url: "ajax.php",
      cache: false,
      type: 'GET',
      data: "action=ViewEmailLog&commID="+ID,
      dataType: 'json',
      success:function(result){
        load();
        //console.log(result);
        $("#EmailList").hide();
        $("#EmailAddDiv").hide();
        $(".ViewEmailDiv").show();
        $(".ViewEmailLog").html(result);
        //$("."+Logtype+"_"+result).hide();
        
        
      }
    });
}
  return false;
 }
</script>
<script type='text/javascript'>
// 0/1 = start/end
// 2 = state
// 3 = length, ms
// 4 = timer
// 5 = epoch
// 6 = disp el
// 7 = lap count

var t=[0, 0, 0, 0, 0, 0, 0, 1];

function ss() {
    t[t[2]]=(new Date()).valueOf();
    t[2]=1-t[2];

    if (0==t[2]) {
        clearInterval(t[4]);
        t[3]+=t[1]-t[0];
        
        var tt=(t[7]++);
        
        var laap=format(t[1]-t[0]);
        
        var tot=format(t[3]);
        
        document.getElementById('callduration').value=tot;
        
        t[4]=t[1]=t[0]=0;
        disp();
    } else {
        t[4]=setInterval(disp, 43);
    }
}
function r() {
    if (t[2]) ss();
    t[4]=t[3]=t[2]=t[1]=t[0]=0;
    disp();
    //document.getElementById('lap').innerHTML='';
    t[7]=1;
}

function disp() {

    if (t[2]) t[1]=(new Date()).valueOf();
    t[6].value=format(t[3]+t[1]-t[0]);
}
function format(ms) {
    // used to do a substr, but whoops, different browsers, different formats
    // so now, this ugly regex finds the time-of-day bit alone
    var d=new Date(ms+t[5]).toString()
        .replace(/.*([0-9][0-9]:[0-9][0-9]:[0-9][0-9]).*/, '$1');
    var x=String(ms%1000);
    while (x.length<3) x='0'+x;
    d+='.'+x;
    return d;
}

function load() {
    //alert('fff');
    t[5]=new Date(1970, 1, 1, 0, 0, 0, 0).valueOf();
    t[6]=document.getElementById('disp');

    disp();

    
}

/*function remote() {
    window.open(
        document.location, '_blank', 'width=700,height=350'
    );
    return false;
}*/
</script>
<style>
   
/* Style the tab */
div.tab {
    overflow: hidden;
    border: 1px solid #ccc;
    background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
div.tab button {
    background-color: inherit;
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
    font-size: 17px;
}

/* Change background color of buttons on hover */
div.tab button:hover {
    background-color: #ddd;
}

/* Create an active/current tablink class */
div.tab button.active {
    background-color: #ccc;
}


/* Style the tab content */
.tabcontent {
    display: none;
    padding: 6px 12px;
    border: 1px solid #ccc;
    border-top: none;
}
.button_startrest {
    background: #ccc none repeat scroll 0 0;
    border: 0 solid #094989;
    border-radius: 2px;
    color: #3d3d3d;
    cursor: pointer;
    font-size: 11px;
    font-weight: bold;
    height: 19px;
    padding: 1px 3px 3px;
}
#disp{
    margin-left: 10px;
    width: 12%;
    
}
.borderall2, .borderall2 tr, .borderall2 td {
    border: 1px solid #ccc;
    border-collapse: collapse;
}
button::-moz-focus-inner {
  border: 0;
}
.dataTables_wrapper {
    overflow: hidden;
}
.dataTables_filter > label > input[type="text"] {
    border: 1px solid #ccc;
    margin-bottom: 5px;
    padding: 3px 5px;
}
/*.dataTables_filter > label {
    display: none;
}*/
.dataTables_length > label > select {
    border: 1px solid #9c9c9c;
    margin-bottom: 5px;
}
 table.dataTable thead th {
    border-bottom: 1px solid #ccc;
    color: #333;
    background: #f1f1f1;
    border: 1px solid #ccc;
}
.borderall2 a.button {
    height: auto !important;
    display: inline-block;
}
table.dataTable tr.odd, table.dataTable tr.odd td.sorting_1 {
    background: transparent;
}
a.paginate_disabled_previous:before {
    position: absolute;
    content: "";
    border-right: 8px solid #777;
    border-top: 5px solid transparent;
    border-bottom: 5px solid transparent;
    width: 0px;
    height: 0px;
    left: 6px;
    margin: auto;
    top: 0px;
    bottom: 0px;
}
a.paginate_disabled_next:after {
    position: absolute;
    content: "";
    border-left: 8px solid #777;
    border-top: 5px solid transparent;
    border-bottom: 5px solid transparent;
    width: 0px;
    height: 0px;
    right: 6px;
    margin: auto;
    top: 0px;
    bottom: 0px;
}
.paginate_disabled_previous, .paginate_disabled_next {
    position: relative;
    background: none;
    display: inline-block;
    line-height: 19px;
}
table.dataTable tr.even td.sorting_1 {
  background: none;
}
.head1 {
    background: #efefef none repeat scroll 0 0;
    border-right: 1px solid #ccc;
    color: #000000;
    font-size: 11px;
    font-weight: bold;
    height: 28px;
    padding: 4px;
    text-decoration: none;
}

.ViewEmailLog td {
    border: 1px solid #ccc;
}
.EmailHtmlShow table tr td p,.ViewEmailLog table tr td p{
  background:none;
  border-bottom:none;
  padding:0;
}
/*12-5-2017*/
div#main button.button_startrest {
    display: inline-block;
    background: #106db2;
    color: #fff;
    padding: 10px 5px 10px 15px;
    font-size: 10px;
    border-radius: 14px 0px 0px 14px;
    float: left;
    height: 33px;
    position: relative;
    min-width: 50px;
}
div#main button.button_startrest:last-child {
    border-radius: 0px 14px 14px 0px;
    padding: 10px 15px 10px 5px;
}
div#main button.button_startrest:after {
    position: absolute;
    content: "";
    width: 0px;
    height: 0px;
    border-left: 8px solid #106db2;
    border-top: 8px solid transparent;
    border-bottom: 8px solid transparent;
    left: 100%;
    top: 0px;
    bottom: 0px;
    margin: auto;
}
div#main button.button_startrest:last-child:after {
    border-right: 10px solid #106db2;
    border-left: 10px solid transparent;
    right: 100%;
    left: auto;
}
#disp {
    width: 100%;
    margin: 0px 0px;
    background: #d33f3e;
    padding: 8px 10px;
    border: 0px;
    border-radius: 0px;
    color: #fff;
    text-align: center;
    max-width: 140px;
    font-size: 15px;
    float: left;
    height: 33px;
    box-sizing: border-box;
}
input#CallButton, #EmailButton {
    padding: 7px 15px;
    height: auto;
    font-size: 14px;
    border-radius: 4px;
}
</style>
