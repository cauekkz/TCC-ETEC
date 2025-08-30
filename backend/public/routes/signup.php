<?php
require("../../_inc/init.php");

require_once __DIR__ . '/../../_inc/validation/signupValidator.php';

check_request_method($_SERVER['REQUEST_METHOD'], "POST");

$data = json_decode(file_get_contents('php://input'), true);    

$errors = validate($data);

if (!empty($errors)) {
    $res->set_status("error");
    $res->set_error_message("erro ao criar conta");
    $res->set_response_data($errors);
    $res->response();
    exit;
}

$email = $data['email'];
$name = $data['name'];
$registration = $data['registration'];
$role = (strlen($registration) == 6)? "professor": "estudante";
$birthday =  $data['birthday'];
$password_hash = password_hash($data['password'], PASSWORD_DEFAULT);

$sql = "INSERT INTO user (name, email,password_hash,role,birthday,registration) VALUES (:name, :email,:password_hash,:role,:birthday,:registration)";
$params = ['name' => $name, 'email' => $email, "password_hash" => $password_hash, "role" => $role,"birthday"=>$birthday,"registration"=>$registration];
$response = $db->execute_non_query($sql, $params);

if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message("erro ao criar conta");
    $res->response();
    exit;
}
$res->response();

exit;
