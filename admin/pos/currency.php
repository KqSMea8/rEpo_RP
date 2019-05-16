 <?php
 
 function getPriceWithCurrency($price,$currency='USD'){
	 return get_currency_symbol($currency).number_format($price, 2);  
}

//https://gist.github.com/Gibbs/3920259
function get_currency_symbol($cc)
{
    $cc = strtoupper($cc);
    $currency = array(
    "USD" => "&#36;" , //U.S. Dollar
    "AUD" => "&#36;" , //Australian Dollar
    "BRL" => "R&#36;" , //Brazilian Real
    "CAD" => "C&#36;" , //Canadian Dollar
    "CZK" => "K&#269;" , //Czech Koruna
    "DKK" => "kr" , //Danish Krone
    "EUR" => "&euro;" , //Euro
    "HKD" => "&#36" , //Hong Kong Dollar
    "HUF" => "Ft" , //Hungarian Forint
    "ILS" => "&#x20aa;" , //Israeli New Sheqel
    "INR" => "&#8377;", //Indian Rupee
    "JPY" => "&yen;" , //Japanese Yen
    "MYR" => "RM" , //Malaysian Ringgit
    "MXN" => "&#36" , //Mexican Peso
    "NOK" => "kr" , //Norwegian Krone
    "NZD" => "&#36" , //New Zealand Dollar
    "PHP" => "&#x20b1;" , //Philippine Peso
    "PLN" => "&#122;&#322;" ,//Polish Zloty
    "GBP" => "&pound;" , //Pound Sterling
    "SEK" => "kr" , //Swedish Krona
    "CHF" => "Fr" , //Swiss Franc
    "TWD" => "&#36;" , //Taiwan New Dollar
    "THB" => "&#3647;" , //Thai Baht
    "TRY" => "&#8378;" //Turkish Lira
    );
	if(array_key_exists($cc, $currency)){
        return $currency[$cc];
    }
}

?>