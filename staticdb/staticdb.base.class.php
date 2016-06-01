<?php
namespace system_base;
use system_base\status;

class staticdb {
    
    private $path, $base_url, $data_dir;
    private $data_category, $data_cell, $physical_cell_location;
    private $status = array();
    
    /**
     * Constructor for base class
     * @param type $base_url
     * @param type $path
     */
    public function __construct($base_url, $path, $data_dir){	 
        $this->path = $path;
        $this->base_url = $base_url;
        $this->data_dir = $data_dir;
    }

    
    /**
     * get path for data
     * @return type
     */
    public function get_path() {
        return $this->path;
    }
    
    
    /**
     * get Base URL
     * @return type
     */
    public function get_base_url() {
       return $this->base_url; 
    }
    
    
    /**
     * Get status of last request.
     * @param type $flag
     * @return type
     */
    public function get_status( $flag = false){
        return $this->status;
    }
    
    
    /**
     * Set status of last request
     * @param type $status
     * @return type
     */
    public function set_status( $status ){
        $this->status = $status;
        return $this->status;
    }
    
    /**
     * Validate data category
     * @param type $data_category
     * @return boolean
     */
    public function validate_category($data_category) {
        if(preg_match('/[^'.DATA_CATEGORY_VALIDATION.']/i', $data_category)){
          $this->set_status( \system_base\status::$STATUS_SELECT_INVALID_CATEGORY );
          return false;
        }
        else {
            return true;
        }
    }
    
    /**
     * Validate data cell
     * @param type $data_cell
     * @return boolean
     */
    public function validate_cell($data_cell) {
        if(preg_match('/[^'.DATA_CELL_VALIDATION.']/i', $data_cell)){
          $this->set_status( \system_base\status::$STATUS_SELECT_INVALID_CELL );
          return false;
        }
        else {
            return true;
        }
    }

    /**
     * Validate physical location of data cell and validate if file exists
     * @return type
     */
    public function validate_physical_location() {
        list($physical_dir_location, $physical_cell_location) = $this->get_physical_location();
        return is_dir($physical_dir_location) && file_exists($physical_cell_location);
    }
    
    ## Start File Operation Methods ##
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
    ## End File Operation Methods ##
    
    /**
     * Select a cell and return the cell related value
     * @param type $data_category
     * @param type $data_cell
     * @param type $force_create
     * @return boolean
     */
    public function select_cell($data_category, $data_cell, $force_create = false, $show_only_url=false) {
   
        if($this->validate_category($data_category) && $this->validate_cell($data_cell)) {
            $this->data_category = $data_category;
            $this->data_cell = $data_cell;

            if(!$this->validate_physical_location()) {
                if($force_create) {
                    $this->create_data_cell();
                    $this->set_status( \system_base\status::$STATUS_CELL_CREATED );
                    return $this->get_cell_status('', '', $show_only_url);
                }
                else {
                    $this->set_status( \system_base\status::$STATUS_CELL_NOT_AVAILABLE );
                    return false;
                }
            }
            else {
                $this->set_status( \system_base\status::$STATUS_SELECT_SUCESS );
                return $this->get_cell_status('', '', $show_only_url);
            }
        }
        return false;
    }

    /**
     * get cell status
     * @return type
     */
    public function get_cell_status($data_category = '', $data_cell = '', $show_only_url = false) {
        
        if($data_category <> '' && $data_cell <> '') {            
            if(!$cell_details = $this->validate_and_select_cell($data_category, $data_cell, true)) {
                $this->set_status( \system_base\status::$STATUS_SELECT_INVALID_CELL );
                return false;
            }
        }
        
        list($physical_dir_location, $physical_cell_location) = $this->get_physical_location();
        
        if(!file_exists($physical_cell_location))
            return false;
        
        if(file_exists($physical_cell_location))
            $last_update_time = date ("YmdHis", filemtime($physical_cell_location));
        else
            return false;
        
        if($show_only_url)
            return $this->getCellURL('', '', $last_update_time);
        
        $result = array(
            'file_url' => $this->getCellURL('', '', $last_update_time),
            'last_modification' => $last_update_time
        );
        
        return $result;
    }
    
    /**
     * Get file URL
     * @param type $last_update_time
     * @return type
     */
    public function getCellURL($data_category = '', $data_cell = '', $last_update_time='') {
        
        if($data_category <> '' && $data_cell <> '') {            
            if(!$cell_details = $this->validate_and_select_cell($data_category, $data_cell, true)) {
                $this->set_status( \system_base\status::$STATUS_SELECT_INVALID_CELL );
                return false;
            }
        }
        
        if(!$this->validate_physical_location())
            return false;

        $this->base_url = substr($this->base_url, -1) == "/" ? $this->base_url : $this->base_url."/";
        list($physical_dir_location, $physical_cell_location) = $this->get_physical_location();
        return $this->base_url . $this->data_dir .$this->data_category. "/" . $this->data_cell.".".DATA_CELL_EXTN.($last_update_time<>''?'?v'.$last_update_time : '');
    }


    /**
     * Get physical location
     * @return type
     */
    public function get_physical_location() {
        if($this->data_cell == '' && $this->data_category == "")
            return false;
        
        $this->physical_dir_location = $this->path.$this->data_category;
        if($this->data_cell == '' && $this->data_category <> "")
            return array($this->physical_dir_location);

        $this->physical_cell_location = $this->physical_dir_location."/" . $this->data_cell.".".DATA_CELL_EXTN;
        
        return array(
            $this->physical_dir_location, $this->physical_cell_location
        );
    }
    
    /**
     * Create data category so we can save multiple cell inside category
     * @param type $data_category
     * @return boolean
     */
    public function create_data_category($data_category = '') {
        $data_category = trim($data_category);
        if($data_category == '') {
            $this->set_status( \system_base\status::$STATUS_SELECT_INVALID_CATEGORY );
            return false;
        }
        
        $this->data_category = $data_category;
        list($physical_dir_location) = $this->get_physical_location();

        if(!is_dir($physical_dir_location)) {
            if(!$this->create_physical_category($physical_dir_location)) {
                $this->set_status( \system_base\status::$STATUS_CANNOT_CREATE_DIR );
                return false;
            }
            return true;
        }
        else {
            return true;
        }
    }


    /**
     * Create data cell
     * @return boolean
     */
    public function create_data_cell($data_category = '', $data_cell = '') {
        $data_cell = trim($data_cell);
        $data_category = trim($data_category);
        
        if($data_category <> '' && $data_cell <> '') {            
            if(!$cell_details = $this->validate_and_select_cell($data_category, $data_cell, true)) {
                $this->set_status( \system_base\status::$STATUS_SELECT_INVALID_CELL );
                return false;
            }
        }
        
        list($physical_dir_location, $physical_cell_location) = $this->get_physical_location();
        
        if($physical_dir_location=="" || $physical_cell_location=="")
            return false;
        
        if(!is_dir($physical_dir_location)) {
            if(!$this->create_physical_category($physical_dir_location)) {
                $this->set_status( \system_base\status::$STATUS_CANNOT_CREATE_DIR );
                return false;
            }
        }
        
        $handle = fopen($physical_cell_location, "w+");
        fclose($handle);
        return true;
    }
    
    /**
     * Remove data cell
     * @param type $data_category
     * @param type $data_cell
     * @return boolean
     */
    public function remove_cell($data_category, $data_cell) {
        $this->data_category = $data_category;
        $this->data_cell = $data_cell;

        if($this->validate_physical_location()) {
            list($physical_dir_location, $physical_cell_location) = $this->get_physical_location();
            unlink($physical_cell_location);
            return true;
        }
        return false;
    }
    
    /**
     * Remove category
     * @param type $data_category
     * @return boolean
     */
    public function remove_category($data_category = '') {
        if($data_category <> '') {
            $this->data_category = $data_category;
            
            if($this->data_category == '')
                $this->set_status( \system_base\status::$STATUS_CATEGORY_NOT_AVAILABLE );
        }
        else {
            $this->data_category = $data_category;
        }
        
        # Get Category directory location
        list($physical_dir_location) = $this->get_physical_location();
        
        # Get Directory
        if(is_dir( $physical_dir_location )) {
            $d = dir( $physical_dir_location );
            $itemNum = 0;
            while (false !== ($entry = $d->read())) {
               if($entry<>'.' && $entry<>'..')
                   $itemNum++;
            }
            $d->close();  
            
            if($itemNum > 0) {
                $this->set_status( \system_base\status::$STATUS_CATEGORY_NOT_EMPTY );
                return false;
            }
            else {
                $this->remove_physical_category($physical_dir_location);
                return true;
            }       
        }
        
        $this->set_status( \system_base\status::$STATUS_CATEGORY_NOT_AVAILABLE );
        return false;
    }

    /**
     * Validate and select cell
     * @param type $data_category
     * @param type $data_cell
     * @return boolean
     */
    private function validate_and_select_cell($data_category, $data_cell, $force_create = false) {        
        $cell_status = $this->select_cell($data_category, $data_cell, $force_create);
        $status = $this->get_status();
        
        if($status['code'] == 1) {
            $this->data_category = $data_category;
            $this->data_cell = $data_cell;
            
            if($this->validate_physical_location()) {
                return $this->get_physical_location();
            }
        }
        return false;
    }
    
    /**
     * Insert new json element by replacing existing or creating from code
     * @param type $data_category
     * @param type $data_cell
     * @param type $json_data
     * @return boolean
     */
    public function cell_data_insert($json_data, $data_category='', $data_cell='') {
        
        if($data_category == '')
            $data_category = $this->data_category;

        if($data_cell == '')
            $data_cell = $this->data_cell;
        
        if(!$cell_details = $this->validate_and_select_cell($data_category, $data_cell, true)) {
            $this->set_status( \system_base\status::$STATUS_SELECT_INVALID_CELL );
            return false;
        }

        list($physical_dir_location, $physical_cell_location) = $cell_details;
        
        # Replace the existing content
        return $this->save_cell_data($physical_cell_location, $json_data);
    }

    /**
     * Empty the entire cell
     * @param type $data_category
     * @param type $data_cell
     * @return boolean
     */
    public function cell_data_delete($data_category='', $data_cell='') {
        if($data_category == '')
            $data_category = $this->data_category;

        if($data_cell == '')
            $data_cell = $this->data_cell;

        if(!$cell_details = $this->validate_and_select_cell($data_category, $data_cell, true)) {
            $this->set_status( \system_base\status::$STATUS_SELECT_INVALID_CELL );
            return false;
        }

        list($physical_dir_location, $physical_cell_location) = $cell_details;
        # Replace the existing content
        $handle = fopen($physical_cell_location, "w+");
        fclose($handle);
        
        $this->set_status( \system_base\status::$STATUS_REMOVE_SUCESS );
        return true;
    }
    
    /**
     * Takes two JSON documents and saves the combined result, this also insert elements to the end of previous JSON document
     * @param type $new_cell_data
     * @param type $data_category
     * @param type $data_cell
     * @return boolean
     */
    public function cell_data_merge($new_cell_data, $data_category='', $data_cell='') {

        if($data_category == '')
            $data_category = $this->data_category;
        
        if($data_cell == '')
            $data_cell = $this->data_cell;
        
        if(!$cell_details = $this->validate_and_select_cell($data_category, $data_cell, true)) {
            $this->set_status( \system_base\status::$STATUS_SELECT_INVALID_CELL );
            return false;
        }

        list($physical_dir_location, $physical_cell_location) = $cell_details;

        #Get existing data from cell
        $cell_data = file_get_contents($physical_cell_location);

        #Decode existing data
        $cell_data = json_decode($cell_data, true);

        #Decode new data from cell
        $new_json_data = json_decode($new_cell_data, true);

        #Merge the new data with existing data
        if(!is_array($cell_data))
            $result = $new_json_data;
        else
            $result = array_merge($cell_data, $new_json_data);

        #Convert new data into JSON formt
        $result = json_encode($result);

        #Write back the new data into cell and once everthing done return status
        return $this->save_cell_data($physical_cell_location, $result);
    }
    
    /**
     * Remove an existing item from cell data, return true if removed or item not vailable, or false if category / cell is invalid
     * @param type $cell_data_item
     * @param type $data_category
     * @param type $data_cell
     * @return boolean
     */
    public function cell_data_item_remove($cell_data_item, $data_category='', $data_cell='') {
        if($data_category == '')
            $data_category = $this->data_category;
        
        if($data_cell == '')
            $data_cell = $this->data_cell;
        
        if(!$cell_details = $this->validate_and_select_cell($data_category, $data_cell, true)) {
            $this->set_status( \system_base\status::$STATUS_SELECT_INVALID_CELL );
            return false;
        }

        list($physical_dir_location, $physical_cell_location) = $cell_details;

        #Get existing data from cell
        $cell_data = file_get_contents($physical_cell_location);

        #Decode existing data
        $cell_data = json_decode($cell_data, true);
        
        if(is_array($cell_data) && isset($cell_data[$cell_data_item])) {
            unset($cell_data[$cell_data_item]);
 
            #Convert new data into JSON formt
            $result = json_encode($cell_data);

            #Write back the new data into cell           
            $this->set_status( \system_base\status::$STATUS_REMOVE_ITEM_SUCESS );
            
            #once everthing done return status
            return $this->save_cell_data($physical_cell_location, $result); 
        }
        else {
            $this->set_status( \system_base\status::$STATUS_REMOVE_ITEM_FAILED );
            return true;
        }
    }
}
?>