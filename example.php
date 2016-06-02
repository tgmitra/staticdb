<?php
/*********** Config Start *************/
require_once( __DIR__ . "/config.php" );

/*********** Instanciate staticDB base class *************/
$staticdb = new \system_base\staticdb(ACCESS_POINT, DATA_DIR_LOCATION, DATA_DIR);

/* The below data is for demonstrating example data */
$exampleCategory = 'ARTICLES';
$exampleCell = 'items';
$cell_data = '{"rating" : "5"}';
$cell_data_item = "review";
/****************************************************/


##############################################################
## Create a new data category, return false if unable to create or return true even if the category already exists
$staticdb->create_data_category( $exampleCategory );
##############################################################


##############################################################
## Create a new data cell, return false if unable to create or return true, even if the cell already exists
$staticdb->create_data_cell($exampleCategory, $exampleCell);
##############################################################


##############################################################
## Remove an existing data cell, if available
$staticdb->remove_cell($exampleCategory, $exampleCell);
##############################################################


##############################################################
## Remove an existing category, this will work only if the category is empty
$staticdb->remove_category($exampleCategory);
##############################################################


##############################################################
## Select a particular cell under a category, if the cell is not available then this method attemp to create if the trird param is true
$staticdb->select_cell($exampleCategory, $exampleCell);
##############################################################


##############################################################
## Once the cell is selected this returns the cell status, otherwise the output is same as select_cell()
$staticdb->get_cell_status();
##############################################################


##############################################################
## Get the cell URL if cell exists
$staticdb->get_cell_url();
##############################################################


##############################################################
# Insert data into cell, but before insert data cell needs to available, else return false
$staticdb->cell_data_insert($cellData, $exampleCategory, $exampleCell);
##############################################################


##############################################################
# Remove all data from selected cell, leaving the empty cell intact
$staticdb->cell_data_delete($exampleCategory, $exampleCell);
##############################################################


##############################################################
# Merge a new data with existing cell data
$staticdb->cell_data_merge($cellData, $exampleCategory, $exampleCell);
##############################################################


##############################################################
# Remove an existing item from cell data, return true if removed or item not vailable, or false if category / cell is invalid
$staticdb->cell_data_item_remove($cellDataItem, $exampleCategory, $exampleCell);
##############################################################

##############################################################
# This methods returns the status of last operation
$status = $staticdb->get_status();

# Display the status of last operation
var_dump($status);
##############################################################
?>