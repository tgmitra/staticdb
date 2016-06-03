# JSON based lightweight data store

StaticDB is a small PHP based data store which can be access directly from your storage system or CDN using browser or app, 
the server authentication is optional so without using your server resource browser or end user can access 
good chunk of data to display on your application or website.

## Requirements

1. PHP 5.4 or greater

## Installation

Drag and drop the **/staticdb**,  **/data**, **config.php** and **example.php** (optional) files and directories into your application's directories. 
To use add `require_once( __DIR__ . "/config.php" );` at the top of your controllers to load it into the scope. 
Additionally, as mentioned in example.php use `$staticdb = new \system_base\staticdb(ACCESS_POINT, DATA_DIR_LOCATION, DATA_DIR);` 
where ever you want to use the `statucdb` functions, you may follow the examples available in `example.php`

Also make sure the directory **/data** have necessary write permission.

## Why StaticDB?

Unlike the usual database tables the concept of StaticDB is slightly different, instead of structure like table, which is 
combination of rows and columns this StaticDB have categories and inside each categories cells are available, each cell holds 
the data in JSON format which is directly accessible using HTTP clients.

Here you can even use lightTPD or even external CDN to keep the data cells and then delivered to destination, whether destination
is your browser or mobile application this data transfer can be done with very minimum utilization of your server resources. 
Considering each data cell is nothing but a separate file itself, and directly sending the file over HTTP don't utilize 
much of your server resources unless you are processing the data before delivery, which is happening in all databases such 
as MySQL but not in StaticDB or incase if this is secured data for which you need some special authentication.

## Its a data store for the web

StaticDB is a data store that completely embraces the web. Store your data with JSON documents. Access your documents 
with your web browser via HTTP. Combine, and transform your data store documents with JavaScript. This works well 
with all modern web and mobile apps. You can even serve web apps directly out of StaticDB. And you can distribute your 
data, or your apps efficiently using StaticDB.

## Technical Overview

This overview is intended to give a high-level introduction of key features and functions available in StaticDB

First install the StaticDB as mentioned above, once installation is done make sure the **/data** directory is 
writable, now open the config file ( config.php ) and do the following modification

    1. Make sure the ACCESS_POINT is correct, if needed adjust this as per your system settings, this is what we are 
        going to use for accessing each data cell using HTTP method.

    2. DATA_DIR is the name of directory where we are storing all data cells and categories.

    3. DATA_DIR_LOCATION, as per the system you are using, this is the physical path of DATA_DIR where all data 
        category and cells available. 

Now open the file or controller from where you are going to use StaticDB and add the line `require_once( __DIR__ . "/config.php" );`, 
please note the `__DIR__` is depends on your system, means where you are keeping the StaticDB files, so change if you need to.

Once the config file is included now you are free to call `$staticdb = new \system_base\staticdb(ACCESS_POINT, DATA_DIR_LOCATION, DATA_DIR);` when 
ever and where ever you need.

Now use the `$staticdb` variable to access the StaticDB following methods.


**$staticdb->create_data_category(** _$categoryName_ **)** : Create a new data category, return true if successful or 
the category already exists else return false.

**$staticdb->create_data_cell(** _$categoryName, $cellName_ **)** : Create a new data cell, return false if unable to create or return true
even if the cell already exists.

**$staticdb->remove_cell(** _$categoryName, $cellName_ **)** : If cell is available then remove the data cell and return true or return false.

**$staticdb->remove_category(** _$categoryName_ **)** : Remove an existing category, this will work only if the category is empty,

**$staticdb->select_cell(** _$categoryName, $cellName, true_ **)** : Select a data cell under category, if in case the 
data cell is not available then this method attempt to create if the third parameter is true.

**$staticdb->get_cell_status()** : Once the cell is selected this returns the cell status, otherwise the output is same as select_cell().

**$staticdb->get_cell_url()** : Get the cell URL if cell exists or return false.

**$staticdb->cell_data_insert(** _$cellData, $categoryName, $cellName_ **)** : Insert data into an existing cell by removing all existing data before insert, return false if cell is not available.

**$staticdb->cell_data_delete(** _$categoryName, $cellName_ **)** : Remove all data from selected cell leaving the empty cell intact.

**$staticdb->cell_data_merge(** _$cellData, $categoryName, $cellName_ **)** : Similar to insert but instead or removing existing cell
data before adding new data, this method merge the new cell data with old existing data.

**staticdb->cell_data_item_remove(** _$cellDataItem, $categoryName, $cellName_ **)** : Remove an existing item from cell data, 
return true if successful else return false.

**$staticdb->get_status()** : This method return the status of last operation.

    Please Note: Data operations are done separately on the class file staticdb/staticdb.data.operation.class.php, 
    so if you like to switch to a new file server, or want to use CDN / lightTPD, feel free to update this file 
    with your required settings.

