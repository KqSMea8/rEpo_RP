<?php
/**
 * CLICKATELL SMS API
 *
 * This class is meant to send SMS messages via the Clickatell gateway
 * and provides support to authenticate to this service and also query
 * for the current account balance. This class use the fopen or CURL module
 * to communicate with the gateway via HTTP/S.
 *
 * For more information about CLICKATELL service visit http://www.clickatell.com
 *
 * @version 1.3d
 * @package sms_api
 * @author Aleksandar Markovic <mikikg@gmail.com>
 * @copyright Copyright © 2004, 2005 Aleksandar Markovic
 * @link http://sourceforge.net/projects/sms-api/ SMS-API Sourceforge project page
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 */



class sms {

    /**
    * Clickatell API-ID
    * @link http://sourceforge.net/forum/forum.php?thread_id=1005106&forum_id=344522 How to get CLICKATELL API ID?
    * @var integer
    */
    var $api_id = "3134078";

    /**
    * Clickatell username
    * @var mixed
    */
    var $user = "webotrading";

    /**
    * Clickatell password
    * @var mixed
    */
    var $password = "46monkeys";

    /**
    * Use SSL (HTTPS) protocol
    * @var bool
    */
    var $use_ssl = false;

    /**
    * Define SMS balance limit below class will not work
    * @var integer
    */
    var $balace_limit = 0;

    /**
    * Gateway command sending method (curl,fopen)
    * @var mixed
    */
    var $sending_method = "fopen";

    /**
    * Optional CURL Proxy
    * @var bool
    */
    var $curl_use_proxy = false;

    /**
    * Proxy URL and PORT
    * @var mixed
    */
    //var $curl_proxy = "http://127.0.0.1:8080";
    var $curl_proxy = "http://174.123.232.242:8080";

    /**
    * Proxy username and password
    * @var mixed
    */
    var $curl_proxyuserpwd = "webo:webo321";

    /**
    * Callback
    * 0 - Off
    * 1 - Returns only intermediate statuses
    * 2 - Returns only final statuses
    * 3 - Returns both intermediate and final statuses
    * @var integer
    */
    var $callback = 0;

    /**
    * Session variable
    * @var mixed
    */
    var $session;

    /**
    * Class constructor
    * Create SMS object and authenticate SMS gateway
    * @return object New SMS object.
    * @access public
    */
    function sms () {
        if ($this->use_ssl) {
            $this->base   = "http://api.clickatell.com/http";
            $this->base_s = "https://api.clickatell.com/http";
        } else {
            $this->base   = "http://api.clickatell.com/http";
            $this->base_s = $this->base;
        }

        $this->_auth();
    }

    /**
    * Authenticate SMS gateway
    * @return mixed  "OK" or script die
    * @access private
    */
    function _auth() {
    	$comm = sprintf ("%s/auth?api_id=%s&user=%s&password=%s", $this->base_s, $this->api_id, $this->user, $this->password);
        $this->session = $this->_parse_auth ($this->_execgw($comm));
    }

    /**
    * Query SMS credis balance
    * @return integer  number of SMS credits
    * @access public
    */
    function getbalance() {
    	$comm = sprintf ("%s/getbalance?session_id=%s", $this->base, $this->session);
        return $this->_parse_getbalance ($this->_execgw($comm));
    }

    /**
    * Send SMS message
    * @param to mixed  The destination address.
    * @param from mixed  The source/sender address
    * @param text mixed  The text content of the message
    * @return mixed  "OK" or script die
    * @access public
    */
    function send($to=null, $from=null, $text=null) {

    	/* Check SMS credits balance */
    	if ($this->getbalance() < $this->balace_limit) {
    	    echo "You have reach the SMS credit limit!";
			exit;
    	};

    	/* Check SMS $text length */
        if (strlen ($text) > 465) {
    	    echo "Your message is to long! (Current lenght=".strlen ($text).")";
			exit;
    	}

    	/* Does message need to be concatenate */
        if (strlen ($text) > 160) {
            $concat = "&concat=3";
    	} else {
            $concat = "";
        }

    	/* Check $to and $from is not empty */
        if (empty ($to)) {
    	    echo "You not specify destination address (TO)!";
			exit;
    	}
        if (empty ($from)) {
    	    echo "You not specify source address (FROM)!";
			exit;
    	}

    	/* Reformat $to number */
        $cleanup_chr = array ("+", " ", "(", ")", "\r", "\n", "\r\n");
        $to = str_replace($cleanup_chr, "", $to);

    	/* Send SMS now */
    	$comm = sprintf ("%s/sendmsg?session_id=%s&to=%s&from=%s&text=%s&callback=%s%s",
            $this->base,
            $this->session,
            rawurlencode($to),
            rawurlencode($from),
            rawurlencode($text),
            $this->callback,
            $concat
        );
        return $this->_parse_send ($this->_execgw($comm));
    }

    /**
    * Execute gateway commands
    * @access private
    */
    function _execgw($command) {
        if ($this->sending_method == "curl")
            return $this->_curl($command);
        if ($this->sending_method == "fopen")
            return $this->_fopen($command);
        echo "Unsupported sending method!";
		exit;
    }

    /**
    * CURL sending method
    * @access private
    */
    function _curl($command) {
        $this->_chk_curl();
        $ch = curl_init ($command);
        curl_setopt ($ch, CURLOPT_HEADER, 0);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER,0);
        if ($this->curl_use_proxy) {
            curl_setopt ($ch, CURLOPT_PROXY, $this->curl_proxy);
            curl_setopt ($ch, CURLOPT_PROXYUSERPWD, $this->curl_proxyuserpwd);
        }
        $result=curl_exec ($ch);
        curl_close ($ch);
        return $result;
    }

    /**
    * fopen sending method
    * @access private
    */
    function _fopen($command) {
        $result = '';
        $handler = @fopen ($command, 'r');
        if ($handler) {
            while ($line = @fgets($handler,1024)) {
                $result .= $line;
            }
            fclose ($handler);
            return $result;
        } else {
            echo "Error while executing fopen sending method!<br>Please check does PHP have OpenSSL support and check does PHP version is greater than 4.3.0.";
			exit;
        }
    }

    /**
    * Parse authentication command response text
    * @access private
    */
    function _parse_auth ($result) {
    	$session = substr($result, 4);
        $code = substr($result, 0, 2);
        if ($code!="OK") {
            echo "Error in SMS authorization! ($result)";
			exit;
        }
        return $session;
    }

    /**
    * Parse send command response text
    * @access private
    */
    function _parse_send ($result) {
    	$code = substr($result, 0, 2);
    	if ($code!="ID") {
    	    echo "Error sending SMS! ($result)";
			exit;
    	} else {
    	    $code = "OK";
    	}
        return $code;
    }

    /**
    * Parse getbalance command response text
    * @access private
    */
    function _parse_getbalance ($result) {
    	$result = substr($result, 8);
        return (int)$result;
    }

    /**
    * Check for CURL PHP module
    * @access private
    */
    function _chk_curl() {
        if (!extension_loaded('curl')) {
            echo "This SMS API class can not work without CURL PHP module! Try using fopen sending method.";
			exit;
        }
    }
}

?>