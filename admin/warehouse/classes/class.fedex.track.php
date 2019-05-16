<?php
/**
 * Mubashir Ali
 * saad_ali6@yahoo.com
 */
    class fedexTrack extends fedexAPI
    {
        private $parsed_str = "";
        public function __construct()
        {
            parent::__construct();
        }
        
        public function trackRequest($tracking_number)
        {                        
            $request['WebAuthenticationDetail'] = $this->getAuthenticationDetail();            
            $request['ClientDetail'] = $this->getClientDetail();
            $request['TransactionDetail'] = array('CustomerTransactionId' => '*** Track Request v5 using PHP ***');
            $request['Version'] = $this->getServiceVersion();
            $request['PackageIdentifier'] = array(
                    'Value' => $tracking_number, 
                    'Type' => 'TRACKING_NUMBER_OR_DOORTAG');

            return $request;

        }
        
        public function trackDetails($details, $spacer) 
        {
            $this->parsed_str .= '<ul>';
            
            foreach ($details as $key => $value) 
            {
                if (is_array($value) || is_object($value)) 
                {
                    $newSpacer = $spacer . '&nbsp;&nbsp;&nbsp;&nbsp;';
                    $this->parsed_str .= '<li><b class="tableStandardOne">' . $spacer . $key . '</b></li>';
                    $this->trackDetails($value, $newSpacer);
                } 
                elseif (empty($value)) 
                {
                    $this->parsed_str .= '<li><b class="tableStandardOne">' . $spacer . $key . '</b></li>';
                } 
                else 
                {
                    $this->parsed_str .= '<li><b class="tableStandardOne">' . $spacer . $key . ': </b><span class="tableStandardOne">' . $value . '</span></li>';
                }
            }
            $this->parsed_str .= "</ul>";
            return $this->parsed_str;
        }
    }
?>