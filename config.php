<?php
require_once( __DIR__ . "/staticdb/system.status.class.php" );
require_once( __DIR__ . "/staticdb/staticdb.data.operation.class.php" );
require_once( __DIR__ . "/staticdb/staticdb.base.class.php" );

define("ACCESS_POINT", "http://localhost/staticdb/");
define("DATA_DIR", "data/");
define("DATA_DIR_LOCATION", __DIR__.'/'.DATA_DIR);


define("DATA_CATEGORY_VALIDATION", "a-z_\-.0-9");
define("DATA_CELL_VALIDATION", "0-9");
define("DATA_CELL_EXTN", "json");
?>