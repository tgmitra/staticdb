# JSON based lightweight database

StaticDB is a small database which can be access directly from your storage system or CDN using browser or app, 
the server authentication is optional so without using your server resource browser or end user can access 
good chunk of data to display on your application or website.

## Requirements

1. PHP 5.4 or greater

## Installation

Drag and drop the **/staticdb**,  **/data** and **index.php** (optional) files and directories into your application's directories. 
To use add `require_once( __DIR__ . "/config.php" );` at the top of your controllers to load it into the scope. 
Additionally, as mentioned in index.php use `$staticdb = new \system_base\staticdb(ACCESS_POINT, DATA_DIR_LOCATION, DATA_DIR);` 
where ever you want to use the `statucdb` functions, you may follow the example available in `index.php`

Also make sure the directory **/data** have necessary write permission.

## Why StaticDB?

Unlike the usual database tables the concept of StaticDB is slightly different, as instead of structure like table, which means 
combination of rows and columns this StaticDB have categories and inside each categories data cells are available, which is 
directly accessible using HTTP clients.

Here you can even use lightTPD or even external CDN to keep the data cells and then delivered to destination, whether this 
is your browser or mobile application this data transfer can be done without utilizing your server resource 
unless this is secured data for which you need some special authentication, for which we don't recommend to use StaticDB.

## Its a database for the web

StaticDB is a database that completely embraces the web. Store your data with JSON documents. Access your documents 
with your web browser via HTTP. Index, combine, and transform your database documents with JavaScript. This works well 
with all modern web and mobile apps. You can even serve web apps directly out of StaticDB. And you can distribute your 
data, or your apps, efficiently using StaticDB.

