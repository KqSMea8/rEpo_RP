<?php
	require_once("../includes/header.php");
        
        require_once($Prefix."classes/orders.class.php");
        require_once($Prefix."classes/customer.class.php");
        require_once($Prefix."classes/category.class.php");
         require_once($Prefix."classes/product.class.php");
        
	$objOrder = new orders();
        $objCustomer = new Customer();
        $objCategory = new category();
        $objProduct = new product();
        
        global $Config;
        
        $totalSale = $objOrder->totalSale();
        $totalSaleCurrentYear = $objOrder->totalSaleCurrentYear();
        $GetOrders = $objOrder->GetOrders();
        $TotalOrders=$objOrder->numRows();
        
        $latestOrders = $objOrder->getLatestFiveOrders();
        
        $GetCustomer = $objCustomer->getCustomers();
        $TotalCustomer = $objCustomer->numRows();
        
        $GetCategory = $objCategory->GettotalActiveCategory();
        $TotalCategory = $objCategory->numRows();
        
        $GetProduct = $objProduct->GettotalActiveProduct();
        $TotalProduct = $objProduct->numRows();
        
        
        $maxDays=date('t');
        $currentYear = date("Y");
        $currentMonth = date("m");
        global $Config;
        $value =array();
	for($i=1;$i<=$maxDays;$i++) {
               $datestring = $currentYear.'-'.$currentMonth.'-'.$i;
		$totalOrderAmnt = $objOrder->getOrderAmountByDate($datestring);
		$ttAmnt = $totalOrderAmnt*$Config['CurrencyValue'];
		$value[$i] = (float)$ttAmnt;
                $month[] = $i;
	}
        
     
        
            function array_setkeys(&$array, $fill = NULL) {
                $indexmax = $maxDays;
                for (end($array); $key = key($array); prev($array)) {
                if ($key > $indexmax)
                $indexmax = $key;
                }
                for ($j = 0; $j <= $indexmax; $j++) {
                if (!isset($array[$j]))
                $array[$j] = (float) $fill;
                }
                ksort($array);
            }


              array_setkeys($value, 0);
        
                $Yname ='Sales in '.$Config['Currency'];//y-axis name
		 
                include 'php-ofc-library/open-flash-chart.php';
                 
                $title2 ='Sales for '.date("F").' '.$currentYear;
                $title = new title( $title2 );
 
                $bar = new bar_glass();
                $bar->set_values($value);
                $bar->colour( '#1D498C' );
                $bar->set_tooltip($Config['CurrencySymbol'].'#val#' );
                
                $chart = new open_flash_chart();
                $chart->add_element( $bar );
                $chart->set_title( $title );
                $chart->set_bg_colour('#FFFFFF');
                
               
                $x = new x_axis();
                $x->set_colour( '#3A8897' );
                $x->steps(1);
                $chart->set_x_legend( $x_legend );
                $x->set_range(1,$maxDays);
                $x->set_grid_colour( '#CCCCCC' );
                $chart->set_x_axis( $x );
               
                $y = new y_axis();
                $YmaxVal = max($value)>0?max($value):"1";
                
                $YmaxVal = floor($YmaxVal);
               
                $round = (strlen($YmaxVal)-2)*-1;
                $YmaxVal = round($YmaxVal,$round);
                
                if($YmaxVal > 100 && $YmaxVal < 500)
                {
                  $YmaxVal = $YmaxVal+100; 
                }
                else if($YmaxVal > 500 && $YmaxVal < 1000)
                {
                  $YmaxVal = $YmaxVal+200; 
                }
                else if($YmaxVal > 1000 && $YmaxVal < 10000)
                {
                  $YmaxVal = $YmaxVal+500; 
                }
               
                else{
                     $YmaxVal = $YmaxVal+1000; 
                }
                
                $y->set_range( 0, $YmaxVal, 100);
                $y->set_stroke(3);
                $y->set_colour( '#909092' );
                $y->set_grid_colour( '#CCCCCC' );
                $y_legend = new y_legend($Yname);
                $y_legend->set_style( '{font-size: 15px; color: #B50000}' );
                $chart->set_y_legend( $y_legend );
                $chart->set_y_axis( $y );
        
	require_once("../includes/footer.php"); 
?>
