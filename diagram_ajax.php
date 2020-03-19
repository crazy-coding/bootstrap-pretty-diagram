<?php

if (!isset($_POST['mode'])) {
    die;
}

$mode = $_POST['mode'];

$user = 'root';
$password = 'root';
$db = 'diagram_db';
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

if (!$success) {
    echo '{"data":{"1":[{"id":"107","userID":"1","campaignID":"1","flowID":"1","flowOrder":"1","object_type":"start","title":"Start","value":"Add_To_List","value_detail":"2|","delay":"2","delay_value":"hour","pos_x":"487px","pos_y":"-35px","parent_cam":"0","path_str":""},{"id":"108","userID":"1","campaignID":"1","flowID":"1","flowOrder":"2","object_type":"message","title":"Initiate","value":"We noticed you didn\u2019t complete your purchase, anything we can to help? [trackinglink]","value_detail":"","delay":"3","delay_value":"hour","pos_x":"438px","pos_y":"85px","parent_cam":"1","path_str":"Yes"},{"id":"109","userID":"1","campaignID":"1","flowID":"1","flowOrder":"3","object_type":"condition","title":"Need Help?","value":"Conversion_Happened","value_detail":"5|9","delay":"20","delay_value":"hour","pos_x":"778px","pos_y":"83px","parent_cam":"2","path_str":""},{"id":"110","userID":"1","campaignID":"1","flowID":"1","flowOrder":"5","object_type":"message","title":"Ready for help","value":"We are ready for you anytime.","value_detail":"","delay":"3","delay_value":"hour","pos_x":"644px","pos_y":"218px","parent_cam":"3","path_str":"Yes"},{"id":"111","userID":"1","campaignID":"1","flowID":"1","flowOrder":"6","object_type":"condition","title":"Kind","value":"Conversion_Happened","value_detail":"7|8","delay":"0","delay_value":"hour","pos_x":"653px","pos_y":"329px","parent_cam":"5","path_str":""},{"id":"112","userID":"1","campaignID":"1","flowID":"1","flowOrder":"7","object_type":"message","title":"How can we help you?","value":"What kind of goods do you want?","value_detail":"","delay":"0","delay_value":"hour","pos_x":"864px","pos_y":"438px","parent_cam":"6","path_str":"Yes"},{"id":"113","userID":"1","campaignID":"1","flowID":"1","flowOrder":"8","object_type":"message","title":"Waiting for you","value":"We are waiting for you.","value_detail":"","delay":"0","delay_value":"hour","pos_x":"592px","pos_y":"455px","parent_cam":"6","path_str":"No"},{"id":"114","userID":"1","campaignID":"1","flowID":"1","flowOrder":"9","object_type":"message","title":"Waiting for you","value":"We are waiting to help you anytime.","value_detail":"","delay":"3","delay_value":"hour","pos_x":"951px","pos_y":"210px","parent_cam":"3","path_str":"No"}]}}'; exit;
    // die("Couldn't connect MySQL Server");
};

$return_data = [];
$user_id = $_REQUEST['userID'] ?: 1; // or session.
$flow_id = $_REQUEST['flowID'] ?: 1; // or session.
$campaign_id = $_REQUEST['campaignID'] ?: 1; // or session.
if ($mode == "load") {
    $sql = "SELECT * FROM flows_new WHERE userID = $user_id AND flowID = $flow_id AND campaignID = $campaign_id ORDER BY flowOrder";
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
    // var_dump($rsc_data);die;
    $save_sql = "";
    foreach($rsc_data as $flow) {
        if (empty($flow)) continue;
        $head_key = [];
        $save_sql .= "INSERT INTO flows_new (";
        foreach($flow[0] as $key => $col) {
            if ($key == "userID" || $key == "id") continue;
            $save_sql .= "`".$key."`, ";
            $head_key[] = $key; 
        }
        $save_sql .= "`userID`) VALUES ";
        foreach($flow as $cell) {
            if (empty($cell)) continue;
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
    $old_sql = "SELECT * FROM flows_new WHERE userID = $user_id AND flowID = $flow_id AND campaignID = $campaign_id";
    $result_old = $link->query($old_sql);
    if ($result_old->num_rows > 0) {
        $old_sql = "DELETE FROM flows_new WHERE userID = $user_id AND flowID = $flow_id AND campaignID = $campaign_id";
        $result_old = $link->query($old_sql);
    }
    
    $result = $link->multi_query($save_sql);
    if (!$result) $return_data = "failed";
}

echo json_encode($return_data);

$link->close();