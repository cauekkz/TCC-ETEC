<?php
require("../../_inc/init.php");
check_request_method($_SERVER['REQUEST_METHOD'], "GET");
$sql = "SELECT id,name FROM campus ORDER BY name";

$response = $db->execute_query($sql);

if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message($response->message);
    $res->response();
    exit;
}
// if it returns [] there's nothing; first add the ones with id_parent_comment == null, then organize the rest
$res->set_response_data($response->results);

$res->response();