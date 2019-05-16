<script src="https://www.java.com/js/deployJava.js"></script>
<script>
    if (deployJava.versionCheck('1.6+')) {     
    } else {
      
     jQuery('.installjava').html('Please Install Java Greater Then 1.6.0 <a href="http://www.java.com/en/download/index.jsp">Click here</a>');
    }
</script>         
<style>
 applet{height: 283px;}
</style>
<applet
  archive  = "webphone.jar"
  codebase = "."
  code     = "webphone.webphone.class"
  name     = "webphone"
  width    = "300"
  height   = "330"
  hspace   = "0"
  vspace   = "0"
  align    = "middle"  
  mayscript = "true"
  scriptable = "true"
  alt="Enable java: http://www.java.com/en/download/index.jsp"
>
<param name = "serveraddress" value = "<?php echo $server_ip;?>"> 
<param name = "username" value = "">
<param name = "password" value = "">
<param name = "callto" value = "">
<param name = "loglevel" value = "1">
<param name = "MAYSCRIPT" value = "true">
<param name = "mayscript" value = "yes">
<param name = "scriptable" value = "true">
<param name = "pluginspage" value = "http://java.com/download/">
<param name = "permissions" value = "all-permissions">
<!-- 
You can set any applet parameters here as described in the webphone documentation like <param name = "SETTINGNAME" value = "VALUE"> 
-->
<b>You must enable java or install from <a href="http://www.java.com/en/download/index.jsp"> here </a>  </b>
</applet>
<div class="installjava"></div>