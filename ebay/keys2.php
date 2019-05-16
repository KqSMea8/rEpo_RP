<?php
/*  © 2013 eBay Inc., All Rights Reserved */ 
/* Licensed under CDDL 1.0 -  http://opensource.org/licenses/cddl1.php */
    //show all errors
    error_reporting(E_ALL);

    // these keys can be obtained by registering at http://developer.ebay.com
    
    $production         = true;   // toggle to true if going against production
    $compatabilityLevel = 717;    // eBay API version
    
   if ($production)
		{
        $devID = '2ae1ed27-d935-4e14-9f84-57d0848490cc';   // these prod keys are different from sandbox keys
        $appID = 'Virtuals-dc6e-412d-8ce7-566bd2c1b4de';
        $certID = '9d7f9e96-2a80-4a02-b010-afc71c34a3f2';
        //set the Server to use (Sandbox or Production)
        $serverUrl = 'https://api.ebay.com/ws/api.dll';      // server URL different for prod and sandbox
        //the token representing the eBay user to assign the call with
        $userToken = 'AgAAAA**AQAAAA**aAAAAA**KmMzVg**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wFk4ukDpWBogydj6x9nY+seQ**bOwCAA**AAMAAA**WYKubMzVr99wSAobHb6xtbMCJmWCl803bmu1nFeaVIT4gosdWO2vXBnYsCXOKn9theMc6R0CRuLOpzfvttt9++rpbK3KVW88Bfydzp0GBhQeIDTJaMqsloNb7qhWvOjtD9+3azrRr+QXgGTOZLo33aN+adD5711tgZi5BhpS2+rkfUdgJSr8h8AjgXzMsXDmI8da/rHdJAca6IA0hWAUkNLnFpkTuL8R716E0LeBZRza6Sq2U0RDRlMRGklwUijCFVeYH7/NC0y/SzdXAa9FX79a0LadKvjjVd0q1vvZhjiLq8m9OLUb+wj3ABNVewRYesfUkdnviR3c2S2MmtcFykEsM5sHZ2sya+jOBz9LdXPp/dwIr4OBZ0dsTFpr6zbi6pWMlVVYHk6H4LtPUkrbDyj2G1Y3XpF5frt6/9yY4+J8TlOHAFhecBln9bCHbKP2Qf/bxeFoqTIDKbKbI/V/O6KpIbq28hU05ezxpJo1oNjDa2kqmbgSHclrj9oNUQfMVnqdquU87JN7LqUhV+V8hDgMLy1mrQiGhOz0bK6AObGNVaPYtJM/w5qy9MpRHEhfTTElYTDok/64z3ayLxjPAR1s2smI77wt6OY00gdmZyGxK+HieCvn8/5zU11QM4/bcjKGyeOMytYdT8DFjf1496nNTcNbqnf/k+rw+zoN2oQ4So5IQnICwRIZ0zvrV54QPvYfgWlimByT3+TRJkkTRC+58DMbNMoE7rFw6RWexn6zVzBjOV/ef0eGuAZ+G2Gq'; 
        //$paypalEmailAddress= 'sales@eoptionsonline.com';		
    }
	else 
	{  
        $devID = '2ae1ed27-d935-4e14-9f84-57d0848490cc';         // insert your devID for sandbox
        $appID = 'Virtuals-dcbd-47ea-92cb-006b3eb48375';   // different from prod keys
        $certID = 'ff10f81b-748a-4bec-a4b7-9f2adea3e94c';  // need three 'keys' and one token
        //set the Server to use (Sandbox or Production)
        $serverUrl = 'https://api.sandbox.ebay.com/ws/api.dll';
        // the token representing the eBay user to assign the call with 
        // this token is a long string - don't insert new lines - different from prod token
        $userToken = 'AgAAAA**AQAAAA**aAAAAA**Fsc5Vg**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wJnY+lCpmBpwqdj6x9nY+seQ**wIIDAA**AAMAAA**l3pf0tY6d09npbLF/vnu1sA9Xq0HjCi1Zlrro89K7U0S49l2e2rUbACqZw5a+s227ebRMrpnBNU/fWTo7M29ois66ImCfzOlsAIJt5F2CyC+3o5A8961sTx6lEfF0C3wkkUMuDeFoFZN56iMYvsaUv/bdW2FGNGRGNhKOj5AVndkx7gGYXjj7+NeH8GdsgNIIbmH05WQLmtysiKMdVFlbhgUg1o0VOf2JmXMUUwq+rmiMVtCKRPNzmYjsvmpkcEmXZ4BQymbJKtsqvG6v+du5ZffCb9JmEqHWtp62Y2Zh3bJFxLI6WwPK8m8lyfhcSoW5J4iAaCFPVGwrvpqD0iKiD1XiK++DEmlpoOISmq5zp7mVAyDG+XXcyxRzu7XbSmHwWrmvXkGBG0Lc2/CKJuao0IGh5YiW/crMpxJTElQgfsM1KK1qlWycYDxHbjshkipxPqww2q4kRNn+RBaul/eVDi8qimedeodeNOF9HxItPq61j7hj+xMYUeka448V5XLE/N0qj2e4jVtWp49Azn4+KF4Ij0ulTWFeC5cpp99aUg/ptRwW8oHDT8HF3H7ZCa+zLTPa4yzGrTR/u4cQczakvi1ZeBI9XXQ6zju2SfmgfAfQIIfsYjRxG4/VRk/F2g2pNTa4eWVA1ahwKIybi8/d1iEGtr1jrouv+F5KYS0poIofPwoKMOubQQnM79kHDEXizWm21X7kYBBYy8PO1qPbUK1gsWU6UnH1ZET/uWD/ky6d5Mou2lm6dIEUgO5ABC9';
       // $paypalEmailAddress = 'nafees.spn@gmail.com';
      //  $paypalEmailAddress = 'vstacks.developer-facilitator@gmail.com';		
    }
    
    
?>