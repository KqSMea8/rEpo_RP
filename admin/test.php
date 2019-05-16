<?


exec("convert '1.gif' '1.pdf' ", $output, $return_var);

if($return_var == 0) { 
	print "Conversion OK";
}
else{
 print "Conversion failed.<br />".$output;
 
}

exit;

      session_start();
       $_POST['posttogl']='24745';
        $pdf_cmd = 1;
        $post_data = array();
        $post_data[] = urlencode('CmpID') . '=' . urlencode($_SESSION['CmpID']);
        $post_data[] = urlencode('AdminID') . '=' . urlencode($_SESSION['AdminID']);
        $post_data[] = urlencode('AdminType') . '=' . urlencode($_SESSION['AdminType']);
        $post_data[] = urlencode('posttogl') . '=' . urlencode($_POST['posttogl']);
        $post_data[] = urlencode('pdfbycmd') . '=' . urlencode($pdf_cmd);
	$post_data[] = urlencode('CmpDatabase') . '=' . urlencode($_SESSION['CmpDatabase']);

        $post_data = implode('&', $post_data);
        //print_r($post_data);die;
	echo 'php /var/www/html/erp/admin/pdfCmd.php "' . $post_data . '" ';exit;
        $pid = exec('php /var/www/html/erp/admin/pdfCmd.php "' . $post_data . '" > /dev/null & echo $!;', $output, $return);
        if (!$return) {
            $ErrorMsg = "Process is running";
            $_SESSION['pid'] = $pid;
        } else {
            $ErrorMsg = "Failed! Please try again.";
            unset($_SESSION['pid']);
        }
        //echo $ErrorMsg . $_SESSION['pid'] . 'pl';
        /** *cmd code by sachin*** */
?>
