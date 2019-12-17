<?php

if (!isset($_POST['mode'])) {
    die;
}

$mode = $_POST['mode'];

$user = 'root';
$password = 'root';
$db = 'gojs_db';
$host = 'localhost';
$port = 8889;

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

$return_data = [];
$user_id = $_REQUEST['userID'] ?: 1; // or session.
// var_dump($_REQUEST['userID'], $user_id);
$flow_id = $_REQUEST['flowID'] ?: 1; // or session.
$campaign_id = $_REQUEST['campaignID'] ?: 1; // or session.
if ($mode == "load") {
    $sql = "SELECT * FROM flows WHERE userID = $user_id AND flowID = $flow_id AND campaignID = $campaign_id ORDER BY flowOrder";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $row['value'] = htmlspecialchars_decode($row['value'], ENT_QUOTES);
            $row['value_detail'] = htmlspecialchars_decode($row['value_detail'], ENT_QUOTES);
            $return_data['data'][$row['flowID']][] = $row;
        }
    } else {
        $return_data = "empty";
    }
} else if ($mode == "save") {
    $data = $_POST['data'];
    $rsc_data = json_decode($data);
    
    $save_sql = "";
    foreach($rsc_data as $flow) {
        if (empty($flow)) continue;
        $head_key = [];
        $save_sql .= "INSERT INTO flows (";
        foreach($flow[0] as $key => $col) {
            if ($key == "userID" || $key == "id") continue;
            $save_sql .= "`".$key."`, ";
            $head_key[] = $key; 
        }
        $save_sql .= "`userID`) VALUES ";
        foreach($flow as $cell) {
            $cell->userID = $user_id;
            $cell->value = htmlspecialchars($cell->value, ENT_QUOTES);
            if ($cell->object_type == "condition") {
                $cell->value_detail = htmlspecialchars($cell->value_detail, ENT_QUOTES);
            } else {
                $cell->value_detail = htmlspecialchars($cell->value_detail, ENT_QUOTES);
            }
            $save_sql .= "(";
            foreach($head_key as $col) {
                $save_sql .= "'".$cell->$col."', ";
            }
            $save_sql .= "'".$user_id."'),";
        }
        $save_sql = substr($save_sql,0,-1).";";
    } 
    // var_dump($save_sql); die();
    $old_sql = "SELECT * FROM flows WHERE userID = $user_id AND flowID = $flow_id AND campaignID = $campaign_id";
    $result_old = $link->query($old_sql);
    if ($result_old->num_rows > 0) {
        $old_sql = "DELETE FROM flows WHERE userID = $user_id AND flowID = $flow_id AND campaignID = $campaign_id";
        $result_old = $link->query($old_sql);
    }
    
    $result = $link->multi_query($save_sql);
    if (!$result) $return_data = "failed";
}

echo json_encode($return_data);

$link->close();