<?php	
define("CART_UPDATED","Cart Settings has been updated successfully.");
define("ALL_PRODUCT_DELETE","All Items will be deleted for this SubCategory. Are you sure, you want to delete this SubCategory Completely.");
define("ALL_PRODUCT_AND_SUBCAT_DELETE","All SubCategories & Items will be deleted for this Category. Are you sure, you want to delete this Category Completely.");


define("CAT_BLANK_MESSAGE","Please Enter the Category.");
define("CAT_ADD","Category  has been added successfully.");
define("CAT_UPDATE","Category  has been updated successfully.");
define("CAT_REMOVE","Category  has been removed successfully.");
define("CAT_CAN_NOT_REMOVE","Sorry, Category can't be removed as it contains products. first remove them.");
define("CAT_SUBCAT_CAN_NOT_REMOVE","Sorry, Category can't be removed as it contains subcategories. first remove them.");
define("SUbCAT_BLANK_MESSAGE","Please Enter the Sub Category.");
define("SUbCAT_ADD","Sub Category  has been added successfully.");
define("SUbCAT_UPDATE","Sub Category  has been updated successfully.");
define("SUbCAT_REMOVE","Sub Category  has been removed successfully.");
define("SUbCAT_CAN_NOT_REMOVE","Sorry, Sub Category can't be removed as it contains products. first remove them.");


define("COND_BLANK_MESSAGE","Please Enter the Condition.");
define("COND_ADD","Condition  has been added successfully.");
define("COND_UPDATE","Condition  has been updated successfully.");
define("COND_REMOVE","Condition  has been removed successfully.");
define("COND_CAN_NOT_REMOVE","Sorry, Condition can't be removed as it contains Items. first remove them.");
define("CAT_SUBCOND_CAN_NOT_REMOVE","Sorry, Condition can't be removed as it contains subConditions. first remove them.");
define("SUbCOND_BLANK_MESSAGE","Please Enter the Sub Condition.");
define("SUbCOND_ADD","Sub Condition  has been added successfully.");
define("SUbCOND_UPDATE","Sub Condition  has been updated successfully.");
define("SUbCOND_REMOVE","Sub Condition  has been removed successfully.");
define("SUbCOND_CAN_NOT_REMOVE","Sorry, Sub Condition can't be removed as it contains Items. first remove them.");



define("STATUS"," Status has been changed successfully.");
define("REMOVED"," has been removed successfully.");
define("ADDED"," has been added successfully.");
define("UPDATED"," has been updated successfully.");
define("UPDATE_QTY"," Item Quantity has been updated successfully.");

define("ACTIVATED"," has been activated successfully.");
define("INACTIVATED"," has been inactivated.");

define("UPDATE_BASIC", "Basic Item details has been updated successfully.");
define("UPDATE_IMAGE", "Item images has been updated successfully.");
define("UPDATE_PRICE", "Item Price has been updated successfully.");
define("UPDATE_SUPP", "Item Vendor has been updated successfully.");
define("UPDATE_DESCRIPTION", "Item description has been updated successfully.");
define("UPDATE_DIMENSION", "Item Dimensions has been updated successfully.");
 
define("UPDATE_SEO", "Item seo properties has been updated successfully.");
define('INSERT_ATTRIBUTES',"Item attributes has been save successfully.");
define("UPDATE_ATTRIBUTES", "Item attributes has been save successfully.");
define("INSERT_DISCOUNT", "Item discount has been save successfully.");
define("UPDATE_DISCOUNT", "Item discount has been updated successfully.");
define("UPDATE_INVENTORY", "Item inventory has been updated successfully.");

define("ADJ_STATUS"," Status has been changed successfully.");
define("ADJ_REMOVED"," has been removed successfully.");
define("ADJ_ADDED"," has been added successfully.");
define("ADJ_UPDATED"," has been updated successfully.");

define("NO_RECORD_ADJUST","No Stock Adjustment found");
define("TOTAL_ADJUST_RECORD","Total Records");

//Alias
define("ALIAS_REMOVED","Alias has been removed successfully.");
define("ALIAS_ADDED","Alias has been added successfully.");
define("ALIAS_UPDATED","Alias has been updated successfully.");
 

//Model - Genration

define("ADD_BIN","Warehouse/Bin location has been added successfully.");
define("DEL_BIN","Warehouse/Bin location has been deleted successfully.");


 
 
//////////////


define("ADJ_NO"," Adjustment No");
define("ADJ_DATE"," Adjustment Date");
define("ADJ_WAREHOUSE"," WareHouse");
define("ADJ_REASON"," Adjust Reason");

define("TOT_ADJ_REASON","Total Quantity");
define("TOTAL_ADJUST_VALUE","Total value");
define("VIEW_STATUS","Status");
define("Action","Action");


define("BOM_NO"," Bill No");
define("BOM_DATE"," Bill Date");
define("BOM_ITEM_DESC"," Item Description");
define("BOM_ITEM"," Item Sku");
define("NO_RECORD_BOM","No BOM found");


define("BOM_ITEM_CURRENCY","Currency");
define("BOM_ITEM_COST","Total Cost");

define("Assemble_NO"," Assemble No");
define("Assemble_DATE"," Assemble Date");
define("Assemble_Location","Warehouse Location");
define("Assemble_ITEM_DESC"," Item Description");
define("Assemble_ITEM"," Item Code");

define("DAssemble_NO"," Disassembly No");
define("DAssemble_DATE"," Disassembly Date");
define("DAssemble_Location","Warehouse Location");
define("DAssemble_ITEM_DESC"," Item Description");
define("DAssemble_ITEM"," Item Code");
define("TOT_DAssemble_REASON","Total Disassembly Quantity");
define("TOTAL_DAssemble_VALUE","Total Disassembly value");

define("TOT_Assemble_REASON","Total Assemble Quantity");
define("TOTAL_Assemble_VALUE","Total Assemble value");


/**************Report*****************/

define("NO_WAREHOUSE","No Warehouse found.");
define("NO_ADJ","No Stock Adjustment found.");
define("NO_TRANSFER","No Stock Transfer found.");
define("NO_ITEM_RECEIVED","No item received.");
 
 
define("NO_ITEM_RETURNED","No item returned.");


///Model 

define("MODEL_STATUS"," Model Status has been changed successfully.");
define("MODEL_REMOVED"," Model has been removed successfully.");
define("MODEL_ADDED"," Model has been added successfully.");
define("MODEL_UPDATED","Model has been updated successfully.");

// option bill

define("OPTION_REMOVED"," Option Bill has been removed successfully.");
define("OPTION_ADDED"," Option Bill has been added successfully.");
define("OPTION_UPDATED","Option Bill has been updated successfully.");
define("UPDATE_COMPONENT","Component Item has been updated successfully.");


define("UPDATE_RQUEIRED","Required Items has been updated successfully.");

define("BOM_PART_EXIST","This part number already exists in the bom list."); 
 


//Variant

define("VARIANT_STATUS","Variant Status has been changed successfully.");
define("VARIANT_REMOVED"," Variant has been removed successfully.");
define("ADD_VARIANT","Variant has been added successfully.");
define("VARIANT_UPDATED","Variant has been updated successfully.");
define("EXIST_VARIANT"," Variant name already exist.");
define("ERROR_VARIANT"," Please enter the variant name.");

// Custom Search by chetan 16Feb//
define('CS_DEL_ERROR',"Search has been deleted successfully.");
define('CS_SAVE_ERROR',"Search has been created successfully.");
define('CS_UPDATE_ERROR',"Search has been updated successfully.");
//End//

define("SELECT_GL_ADJUSTMENT","Adjustment has not been completed.<br>Please set gl accounts for Inventory and Inventory Adjustment in Global Settings under Finance.");

define("SELECT_GL_ASM","Assembly has not been completed.<br>Please set gl account for Inventory in Global Settings under Finance.");
define("SELECT_GL_DSM","Disassembly has not been completed.<br>Please set gl account for Inventory in Global Settings under Finance.");
?>
