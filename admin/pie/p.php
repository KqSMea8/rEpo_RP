<?
// +----------------------------------------------------------------------+
// | PIE Graph Class                                                      |
// | Creating Pie Graphs on the fly                                       |
// | Requirements: GD Library >= 2.0                                      |
// | This file explains how to use and call the class                     |
// +----------------------------------------------------------------------+
// | Author: Nico Puhlmann <nico@puhlmann.com>                            |
// +----------------------------------------------------------------------+
// $Id: example.php,v 1.0 2005/05/02 17:41:12 npuhlmann Exp $


require("pi.class.php");

// class call with the width, height & data
$pie = new PieGraph(300, 220, array(100,30,122,32,54,66));

// colors for the data
$pie->setColors(array("#d3932f","#d6666c","#d9802c","#c3cc38","#c8b935","#fff333"));

// legends for the data
$pie->setLegends(array("Internet Explorer","Safari" ,"Mozilla Firefox","Opera","Netscape","Chrome"));

// Display creation time of the graph
$pie->DisplayCreationTime();

// Height of the pie 3d effect
$pie->set3dHeight(15);

// Display the graph
$pie->display();
?>
