<?php
require("../../_inc/init.php");
check_request_method($_SERVER['REQUEST_METHOD'], "POST");

require_once __DIR__ . '/../../_inc/filters/isLogged.php';

$data = $_POST;

if (empty($data['campus_Ids'])) {
    $errors[] = 'invalid ID Campus';
    $res->set_status("error");
    $res->set_error_message("Invalid Form");
    $res->set_response_data($errors);
    $res->response();
    exit;
}
$campus_Ids_string = $data['campus_Ids'];
$campusArray = explode(",", $campus_Ids_string);
$campusArray = array_filter($campusArray, fn($v) => trim($v) !== "");
$campusArray = array_values(array_unique($campusArray));


$jwt = new JwtAuth();
$tokenJWT = $jwt->get_jwt_by_header();
$resultJWT = $jwt->validate_token($tokenJWT);
$user_id = $resultJWT['id'];
$user_role = $resultJWT['role'];

// Validações de segurança
if (count($campusArray) <= 0) {
    $res->set_status("error");
    $res->set_error_message("At least one campus is required");
    $res->response();
    exit;
}

// Estudantes só podem ter 1 campus, professores podem ter múltiplos
if ($user_role === "student" && count($campusArray) !== 1) {
    $res->set_status("error");
    $res->set_error_message("Students can only have one campus");
    $res->response();
    exit;
}

// Limitar número máximo de campus (prevenir spam)
if (count($campusArray) > 10) {
    $res->set_status("error");
    $res->set_error_message("Maximum 10 campuses allowed");
    $res->response();
    exit;
}

$placeholders = [];
$params = [];

foreach ($campusArray as $index => $id) {
    $key = ":id$index";
    $placeholders[] = $key;
    $params[$key] = $id;
}

$sql = "SELECT id FROM campus WHERE id IN (" . implode(", ", $placeholders) . ")";
$response = $db->execute_query($sql, $params);
if ($response->status != 'success' || empty($response->results)) {
    $res->set_status('error');
    $res->set_error_message($response->mensagem);
    $res->response();
    exit;
}
$validIds = array_map(fn($item) => $item->id, $response->results);




if ($user_role == "student") {
    $campus_id = $validIds[0];
    $sql = "DELETE FROM user_campus WHERE user_id = :user_id";
    $params = ['user_id' => $user_id];
    $response = $db->execute_non_query($sql, $params);
    if ($response->status != 'success') {
        $res->set_status('error');
        $res->set_error_message($response->mensagem);
        $res->response();
        exit;
    }
    
}

$values = [];
$params = [];
$i = 0;

foreach ($validIds as $campus_id) {
    $values[] = "(:user_id, :campus_id$i)";
    $params[":campus_id$i"] = $campus_id;
    $i++; 
}
$params[':user_id'] = $user_id;

$sql = "INSERT INTO user_campus (user_id, campus_id) VALUES " . implode(", ", $values);
$response = $db->execute_non_query($sql, $params);

if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message($response->mensagem);
    $res->response();
    exit;
}
if ($user_role == "student") {
    $sql = "DELETE FROM user_course WHERE user_id = :user_id";
    $params = ['user_id' => $user_id];
    $response = $db->execute_non_query($sql, $params);
    if ($response->status != 'success') {
        $res->set_status('error');
        $res->set_error_message($response->mensagem);
        $res->response();
        exit;
    }
    
}

$res->response();
