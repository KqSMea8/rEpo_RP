<?php
$to = "pankaj.jingle@gmail.com";
$subject = "HTML email";

$message = "
<html>
<head>
<title>HTML email</title>
</head>
<body>
<p>This email contains HTML Tags!</p>
<table>
<tr>
<th>Firstname</th>
<th>Lastname</th>
</tr>
<tr>
<td>John</td>
<td>Doe</td>
</tr>
</table>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <webmaster@example.com>' . "\r\n";
$headers .= 'Cc: myboss@example.com' . "\r\n";

mail($to,$subject,$message,$headers);
?>
 12:33:01 up 41 days, 17:13,  1 user,  load average: 0.03, 0.01, 0.00
 12:34:01 up 41 days, 17:14,  1 user,  load average: 0.04, 0.02, 0.00
 12:35:01 up 41 days, 17:15,  1 user,  load average: 0.16, 0.05, 0.01
 12:36:01 up 41 days, 17:16,  1 user,  load average: 0.06, 0.04, 0.00
 12:37:01 up 41 days, 17:17,  1 user,  load average: 0.02, 0.03, 0.00
 12:38:01 up 41 days, 17:18,  1 user,  load average: 0.00, 0.02, 0.00
 12:39:01 up 41 days, 17:19,  1 user,  load average: 0.00, 0.02, 0.00
 12:40:01 up 41 days, 17:20,  1 user,  load average: 0.00, 0.01, 0.00
 12:41:01 up 41 days, 17:21,  1 user,  load average: 0.00, 0.00, 0.00
 12:42:01 up 41 days, 17:22,  1 user,  load average: 0.00, 0.00, 0.00
