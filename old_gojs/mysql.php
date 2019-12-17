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

$env_text = [
    "Visitor Check" => "visit web",
    "Go to upsell and discount page" => "go to upsell",
    "Go to credit card page" => "go to credit"
];
$env_url = [
    "visit web" => "https://visitor.com",
    "go to upsell" => "https://upsell.com",
    "go to credit" => "https://checkout.com"
];

$return_data = [];
$user_id = $_POST['user'] ?: 1; // or session.
if ($mode == "load") {
    $sql = "SELECT * FROM gojs WHERE userid = $user_id ORDER BY date desc LIMIT 1";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        $row = $result->fetch_assoc();
        $return_data = $row;
        $return_data['data'] = htmlspecialchars_decode($row['data'], ENT_QUOTES);
    } else {
        $return_data = "true";
    }
} else if ($mode == "save") {
    $data = $_POST['data'];
    $rsc_data = json_decode($data);
    foreach($rsc_data->nodeDataArray as $rsc_da) {
        $nodeDataArray[$rsc_da->key] = $rsc_da->text;
        if($rsc_da->category == "Conditional") {
            $save_data[0]["position"] = $env_text[$rsc_da->text];
        }
    }
    foreach($rsc_data->linkDataArray as $rsc_ld) {
        if ($rsc_ld->text == "Yes") {
            $save_data[0]["yes"] = $env_text[$nodeDataArray[$rsc_ld->to]];
        } else if ($rsc_ld->text == "No") {
            $save_data[0]["no"] = $env_text[$nodeDataArray[$rsc_ld->to]];
        }
    }

    $save_data[0]["url"] = $env_url[$save_data[0]["position"]];
    $save_data[1]["position"] = $save_data[0]["yes"];
    $save_data[1]["url"] = $env_url[$save_data[1]["position"]];
    $save_data[2]["position"] = $save_data[0]["no"];
    $save_data[2]["url"] = $env_url[$save_data[2]["position"]];

    $sql = "SELECT * FROM gojs WHERE userid = $user_id ORDER BY date desc LIMIT 1";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        $sql = "DELETE FROM gojs WHERE userid = $user_id";
        $result = $link->query($sql);
    }
    $json_data = htmlspecialchars($data, ENT_QUOTES);
    $sql = "INSERT INTO gojs (`userid`, `position`, `yes`, `no`, `url`, `date`, `data`) VALUES ";
    foreach($save_data as $sa) {
        $sql .= "($user_id, '".$sa['position']."', '".$sa['yes']."', '".$sa['no']."', '".$sa['url']."', '".date('Y-m-d H:i:s')."', '$json_data'),";
    }
    $sql = substr($sql,0,-1).";";
    
    $result = $link->query($sql);
    if (!$result) $return_data = "false";
}

echo json_encode($return_data);

$link->close();