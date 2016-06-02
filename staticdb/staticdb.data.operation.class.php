<?php
namespace data_operation;

class dataOperation {
    
    /**
     * Save cell data
     * @param type $physical_cell_location
     * @param type $result
     * @return type
     */
    public function save_cell_data($physical_cell_location, $result) {
        $handle = fopen($physical_cell_location, "w+");
        fwrite($handle, $result);
        return fclose($handle);
    }

    /**
     * Create category 
     * @param type $category
     * @return type
     */
    public function create_physical_category($category) {
        return mkdir($category);
    }
    
    /**
     * Remove category 
     * @param type $category
     * @return type
     */
    public function remove_physical_category($category) {
        return rmdir($category);
    }
    
    /**
     * Check if data cell exists
     * @param type $cell_location
     * @return type
     */
    public function cell_exists($cell_location) {
        return file_exists($cell_location);
    }

    /**
     * Check last update time
     * @param type $cell_location
     * @return type
     */
    public function check_last_update($cell_location) {
        return filemtime($cell_location);
    }
}
?>