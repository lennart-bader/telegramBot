<?php
class GoogleCache {

    public function __construct() {
        global $db;

        $query = "SHOW TABLES LIKE `p_google_table`";
        $db->query($query);
        if ($db->numRows() == 0) {
            // Table does not exist
            $this->setupDb();
        }
    }


    /*
     * Returns the data for the given query if cached, false otherwise
     * Will return false if none is found and delete all cached data older than the given timeout.
     */
    public function query($search, $type, $timeout = 3600) {
        global $db;
        $query = "DELETE FROM `p_google_table` WHERE UNIX_TIMESTAMP(`timestamp`) < " . (time() - $timeout) . " AND `type` = '".$type."';";
        $db->query($query);
        $query = "SELECT * FROM `p_google_table` WHERE `type` = '".$type."' AND `query` = '".$db->escape($search)."' ORDER BY `timestamp` DESC;";
        $db->query($query);
        if ($db->numRows() > 0) {
            // Cached data found
            $data = $db->fetchArray();
            return json_decode($data["result_data"], true);
        } else {
            // Nothing in cache
            return false;
        }
    }


    /*
     * Will add the given query and data to the cache.
     */
    public function cache($search, $data, $type) {
        global $db;
        $query = "INSERT INTO `p_google_table` (
                `type`,
                `query`,
                `result_data`
            ) VALUES (
                '".$type."',
                '".$db->escape($search)."',
                '".json_encode($data)."'
            );";
        $db->query($query);
    }


    private function setupDb() {
        global $db;
        $query = "
                CREATE TABLE `p_google_table` ( 
                `id` BIGINT NOT NULL AUTO_INCREMENT , 
                `type` VARCHAR(10) NOT NULL , 
                `query` VARCHAR(1000) NOT NULL , 
                `result_data` LONGTEXT NOT NULL , 
                `timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`));
        ";
        $db->query($query);
    }


}
?>