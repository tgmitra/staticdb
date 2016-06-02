# JSON based lightweight database

A small database which can be access directly from your storage system or CDN using browser or app, 
the server authentication is optional so without using your server resource browser 
or end user can access good chunk of data to display on your application or website.

## Requirements

1. PHP 5.4 or greater

## Installation

Drag and drop the **/staticdb**,  **/data** and **index.php** (optional) files and directories into your application's directories. 
To use add `require_once( __DIR__ . "/config.php" );` at the top of your controllers to load it into the scope. 
Additionally, as mentioned in index.php use `$staticdb = new \system_base\staticdb(ACCESS_POINT, DATA_DIR_LOCATION, DATA_DIR);` 
where ever you want to use the `statucdb` functions, you may follow the example available in `index.php`

Now make sure the directory **/data** have necessary write permission.

## Why staticdb?

Unlike the usual database tables the concept of staticdb is slightly different, as instead of structure like table, which means 
combination of rows and columns this staticdb have categories and inside each categories data cells are available, which is 
directly accessible using HTTP clients.

Here you can even use lightTPD or even external CDN to keep the data cells and then delivered to destination, whether this 
is your browser or mobile application, this data transfer can be done without utilizing your server resource 
unless this is secured data for which you need some special authentication, for which we don't recommend to use staticdb.



