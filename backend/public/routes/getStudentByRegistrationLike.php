<?php
require("../../_inc/init.php");
require_once __DIR__ . '/../../_inc/filters/isTeacher.php';
check_request_method($_SERVER['REQUEST_METHOD'], "GET");
$jwt = new JwtAuth();
$tokenJWT = $jwt->get_jwt_by_header();
$resultJWT = $jwt->validate_token($tokenJWT);

$user_id = $resultJWT['id'];

$registration_param  = isset($_GET["registration_param"])
    ? $_GET["registration_param"]
    : null;
if ($registration_param === null) {
    $res->set_status("error");
    $res->set_error_message("Invalid Form");
    $res->response();
    exit;
}
$sql = "SELECT 
  user.id,
  user.profile_photo_path,
  user.name,
  user.phone,
  user.email,
  user.registration,
  user.birthday,
  user.role,
  user.created_at,
  user.address
  FROM user
  where user.registration LIKE :registration_param AND user.role = 'estudante'  ORDER BY user.name ASC ;
";
$params = ['registration_param' => "$registration_param%"];
$response = $db->execute_query($sql, $params);
if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message("erro ao pegar informações");
    $res->response();
    exit;
}
$res->set_response_data($response->results);
$res->response();
exit;