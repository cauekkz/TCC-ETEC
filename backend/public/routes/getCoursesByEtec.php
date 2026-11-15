<?php

require("../../_inc/init.php");

check_request_method($_SERVER['REQUEST_METHOD'], "GET");


if (empty($_GET["campus_id"])) {
    $res->set_status("error");
    $res->set_error_message("Invalid Form");
    $res->response();
    exit;
}

$campus_id = $_GET["campus_id"];
$sql = "SELECT c.id,c.name FROM course c 
INNER JOIN campus_course cc ON cc.course_id =c.id
WHERE cc.campus_id = :campus_id
 ORDER BY name";
$params = ["campus_id"=>$campus_id];

$response = $db->execute_query($sql,$params);

if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message($response->message);
    $res->response();
    exit;
}
$res->set_response_data($response->results);

$res->response();
