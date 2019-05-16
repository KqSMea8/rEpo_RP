<?php
/**
 * Recent items
 */
class RecentItems extends dbClass
{
	private $_itemsLimit = 10;
	
	/**
	 * Add item to recent
	 */
	public function add($url, $text,$image,$price)
	{
		global $_SESSION;
		$urlMD5 = md5($url);
		$items = isset($_SESSION["userRecentItems"]) ? $_SESSION["userRecentItems"] : array();
		if (count($items) >= $this->_itemsLimit)
		{
			$c = array_key_exists($urlMD5, $items) ? 0 : 1;
			$_items = array_reverse($items);
			$items = array();
			foreach ($_items as $itemKey=>$item)
			{
				if (count($items) < $this->_itemsLimit - $c) $items[$itemKey] = $item;	
			}
			$items = array_reverse($items);
		}
		if (array_key_exists($urlMD5, $items))
		{
			unset($items[$urlMD5]);				
		}
		$items[$urlMD5] = array("url"=>$url, "Name"=>$text,"Image"=>$image,"Price"=>$price);
		$_SESSION["userRecentItems"] = $items;
	}
	
	
	public function getRecentItems()
	{
		global $_SESSION;
		return isset($_SESSION["userRecentItems"]) ? (is_array($_SESSION["userRecentItems"]) && count($_SESSION["userRecentItems"]) ? array_reverse($_SESSION["userRecentItems"]) : false) : false;
	}
}


?>