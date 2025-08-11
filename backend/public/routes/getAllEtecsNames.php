<?php
require("../../_inc/init.php");
check_request_method($_SERVER['REQUEST_METHOD'], "GET");
$sql = "SELECT id,name FROM campus ORDER BY name";

$response = $db->execute_query($sql);

if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message($response->mensagem);
    $res->response();
    exit;
}
//se retorna [] nao tem NADA, primeiro add os que tem id_parent_comment == null dps organiza o resto
$res->set_response_data($response->results);

$res->response();
