<?php
namespace system_base;

class status {
    
    public static $STATUS_SELECT_SUCESS = array(
        'code' => 1,
        'message' => 'Data cell successfully selected.'
    );

    public static $STATUS_REMOVE_SUCESS = array(
        'code' => 1,
        'message' => 'Data from the selected cell removed.'
    );
    
    public static $STATUS_REMOVE_ITEM_SUCESS = array(
        'code' => 1,
        'message' => 'Data item removed from cell.'
    );
    
    public static $STATUS_REMOVE_ITEM_FAILED = array(
        'code' => 1,
        'message' => 'Data item not found on your cell.'
    );
    
    public static $STATUS_SELECT_INVALID_CATEGORY = array(
        'code' => 2,
        'message' => 'Invalid Category ID.'
    );
    
    public static $STATUS_SELECT_INVALID_CELL = array(
        'code' => 3,
        'message' => 'Invalid Cell ID.'
    );
    
    public static $STATUS_CELL_NOT_AVAILABLE = array(
        'code' => 4,
        'message' => 'Data cell not available.'
    );
    
    public static $STATUS_CATEGORY_NOT_AVAILABLE = array(
        'code' => 4,
        'message' => 'Data category not available.'
    );
    
    public static $STATUS_CELL_CREATED = array(
        'code' => 1,
        'message' => 'Data cell created.'
    );
    
    public static $STATUS_CANNOT_CREATE_DIR = array(
        'code' => 5,
        'message' => 'Cannot create category.'
    );
    
    public static $STATUS_CATEGORY_NOT_EMPTY = array(
        'code' => 6,
        'message' => 'Category is not empty.'
    );
    
}
?>