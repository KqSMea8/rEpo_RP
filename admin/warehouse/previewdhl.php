<?php
$HideNavigation = 1;
/**************************************************/

$ThisPageName = 'editReturn.php';

/**************************************************/
include_once("../includes/header.php");


$total = $_GET['total'];

?>

<div class="fdpre">
<?php 
if($total>0){?>
	<span>Total Freight = $&nbsp;<?=$total;?></span>
<? }else{?>
	<span>Not valid data</span>
<? } ?>
</div>

<?php
require_once("../includes/footer.php");
?>


