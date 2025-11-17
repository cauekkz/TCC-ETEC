<?php 
require("../../_inc/init.php");
require("../../_inc/jwt.php");
   
require_once __DIR__ . '/../../_inc/filters/isTeacher.php';
check_request_method($_SERVER['REQUEST_METHOD'], "POST");

require_once __DIR__ . '/../../_inc/validation/NoticeValidator.php';

$data = json_decode(file_get_contents('php://input'), true);
$errors = validate($data);
if (!empty($errors)) {
    $res->set_status("error");
    $res->set_error_message("Invalid Form");
    $res->set_response_data($errors);
    $res->response();
    exit;
}
$jwt = new JwtAuth();
$tokenJWT = $jwt->get_jwt_by_header();
$resultJWT = $jwt->validate_token($tokenJWT);

$user_id = $resultJWT['id'];

$server_id = $data["server_id"];
$title = $data["title"];
$description = $data["description"];
$type = $data["type"];

$sqlAuthCheck = "
SELECT s.id
FROM server s
LEFT JOIN user_campus uc ON s.campus_id = uc.campus_id AND uc.user_id = :userId
WHERE 
  s.id = :serverId
  AND (
    s.id = 1
    OR LOWER(s.name) = 'geral'
    OR uc.id IS NOT NULL
  )
LIMIT 1;
";
$paramsAuthCheck = [
    'userId' => $user_id,
    'serverId' => $server_id
];

$authResult = $db->execute_query($sqlAuthCheck, $paramsAuthCheck);
if (count($authResult->results) === 0) {
    $res->set_status("error");
    $res->set_error_message("Você não tem permissão para postar neste servidor.");
    $res->response();
    exit;
}



$sql = "INSERT INTO notice (server_id,title,description,type) VALUES (:server_id,:title,:description,:type)";
$params = ["server_id"=>$server_id,"title"=>$title,"description"=>$description,"type"=>$type];
$response = $db->execute_non_query($sql, $params);

if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message($response->mensagem);
    $res->response();
    exit;
}
$res->response();


?>