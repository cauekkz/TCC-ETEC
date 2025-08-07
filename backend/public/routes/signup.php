<?php
require("../../_inc/init.php");

require_once __DIR__ . '/../../_inc/validation/signupValidator.php';

check_request_method($_SERVER['REQUEST_METHOD'], "POST");

$data = json_decode(file_get_contents('php://input'), true);    

$errors = validate($data);

if (!empty($errors)) {
    $res->set_status("error");
    $res->set_error_message("Invalid Form");
    $res->set_response_data($errors);
    $res->response();
    exit;
}

$email = $data['email'];
$name = $data['name'];
$role = $data['role'];
$password_hash = password_hash($data['password'], PASSWORD_DEFAULT);

$sql = "INSERT INTO user (name, email,password_hash,role) VALUES (:name, :email,:password_hash,:role)";
$params = ['name' => $name, 'email' => $email, "password_hash" => $password_hash, "role" => $role];
$response = $db->execute_non_query($sql, $params);

if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message($response->mensagem);
    $res->response();
    exit;
}
$res->response();

exit;
