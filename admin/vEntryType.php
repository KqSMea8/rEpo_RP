<? 
$HideNavigation = 1;

require_once("includes/header.php");
require_once("../classes/sales.quote.order.class.php");

$objSale = new sale();

$arryRecurr = $objSale->GetLineItemById($_GET['view']);

require_once("includes/footer.php");
?>
