<?php
/**
 * ---------------------------------------------------
 *  This file is API backend for saving diagram infos.
 * ---------------------------------------------------
 * 
 * @param integer userID
 * @param integer flowID
 * @param integer campaignID
 * @param string mode | load, save
 * @param array data (insert data)
 * 
 * @return array data
 */

if (!isset($_POST['mode'])) {
    die;
}

$mode = $_POST['mode'];

/**
 * Connection MySQL database
 */
$user = 'root';
$password = 'root';
$db = 'gojs';
$host = 'localhost';
$port = 3306;

$link = mysqli_init();
$success = mysqli_real_connect(
   $link,
   $host,
   $user,
   $password,
   $db,
   $port
);

if (!$success) die("Couldn't connect MySQL Server");

$return_data = []; // Definition return array.

/**
 * Configuration.
 */
$user_id = $_REQUEST['userID'] ?: 1; // or session.
$flow_id = $_REQUEST['flowID'] ?: 1; // or session.
$campaign_id = $_REQUEST['campaignID'] ?: 1; // or session.

/**
 * API Request
 */
if ($mode == "load") {
    // Load api | return: array [diagram data] or string "empty"

    // Get diagram data
    $sql = "SELECT * FROM flows_new WHERE userID = $user_id AND flowID = $flow_id AND campaignID = $campaign_id ORDER BY flowOrder";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $return_data['data'][$row['flowID']][] = $row;
        }
    } else {
        $return_data = "empty";
    }
} else if ($mode == "save") {
    // Save api | return: 

    $data = $_POST['data']; // Saving diagram data
    $rsc_data = json_decode($data);
    

    $save_sql = ""; // Definition insert sql query with multi line.
    foreach($rsc_data as $flow) {
        if (empty($flow)) continue;

        // Insert query head start
        $head_key = [];
        $save_sql .= "INSERT INTO flows_new (";
        foreach($flow[0] as $key => $col) {
            if ($key == "userID" || $key == "id") continue;
            $save_sql .= "`".$key."`, ";
            $head_key[] = $key; 
        }
        $save_sql .= "`userID`) VALUES ";

        // Insert query values start
        foreach($flow as $cell) {
            if (empty($cell)) continue;

            $cell->userID = $user_id;

            // For the text, real escape string
            $cell->value = $link->real_escape_string($cell->value);
            $cell->value_detail = $link->real_escape_string($cell->value_detail);

            // Value query
            $save_sql .= "(";
            foreach($head_key as $col) {
                $save_sql .= "'".$cell->$col."', ";
            }
            $save_sql .= "'".$user_id."'),";
        }
        $save_sql = substr($save_sql, 0, -1).";"; // End of Insert query
    } 
    
    // Delete old flow data
    $old_sql = "SELECT * FROM flows_new WHERE userID = $user_id AND flowID = $flow_id AND campaignID = $campaign_id";
    $result_old = $link->query($old_sql);
    if ($result_old->num_rows > 0) {
        $old_sql = "DELETE FROM flows_new WHERE userID = $user_id AND flowID = $flow_id AND campaignID = $campaign_id";
        $result_old = $link->query($old_sql);
    }
    
    // Excute insert query
    $result = $link->multi_query($save_sql);
    if (!$result) $return_data = "failed"; // Return if it's failed
}

echo json_encode($return_data); // Return load data

$link->close();