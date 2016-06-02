# JSON based lightweight database

A small database which can be access directly from your storage system or CDN using browser or app, 
the server authentication is optional so without using your server resource browser 
or end user can access good chunk of data to display on your application or website.

## Requirements

1. PHP 5.4 or greater

## Installation

Drag and drop the **index.php** , **/staticdb** and  **/data** files and directories into your application's directories. 
To use `require_once( __DIR__ . "/config.php" );` it at the top of your controllers to load it into the scope. 
Additionally, as mentioned in index.php use `$staticdb = new \system_base\staticdb(ACCESS_POINT, DATA_DIR_LOCATION, DATA_DIR);` 
where ever you want to use the `statucdb` functions, you may follow the example available in `index.php`

