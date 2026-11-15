<?php
require("../../_inc/init.php");
check_request_method($_SERVER['REQUEST_METHOD'], "GET");
$sql = "SELECT * FROM server s
ORDER BY name";

$response = $db->execute_query($sql);

if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message($response->message);
    $res->response();
    exit;
}
$res->set_response_data($response->results);

$res->response();