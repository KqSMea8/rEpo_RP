CREATE TABLE IF NOT EXISTS `inv_variant_manageOption` (
  `id` int(11) NOT NULL  AUTO_INCREMENT,
  `variant_name_id` int(11) NOT NULL,
  `option_value` varchar(255) NOT NULL,
  `item_id` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `inv_variant_type` (
  `id` int(11) NOT NULL  AUTO_INCREMENT,
  `field_name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


INSERT INTO `inv_variant_type` (`id`, `field_name`, `status`) VALUES
(1, 'Text Field', 1),
(2, 'Text Area', 1),
(4, 'Multiple Select', 1),
(5, 'Dropdown', 1),
(6, 'Price', 1),
(7, 'Fixed Product Tax', 1);


CREATE TABLE IF NOT EXISTS `inv_variant_value` (
  `id` int(11) NOT NULL  AUTO_INCREMENT,
  `variant_type_id` int(11) NOT NULL,
  `variant_name` varchar(255) NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `item_id` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `c_quote_item_variant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `quote_item_ID` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `variantID` int(11) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `c_quote_item_variantOptionValues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quote_item_ID` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `variantID` int(11) NOT NULL,
  `variantOPID` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
