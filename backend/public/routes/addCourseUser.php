<?php
require("../../_inc/init.php");
check_request_method($_SERVER['REQUEST_METHOD'], "POST");

require_once __DIR__ . '/../../_inc/filters/isStudent.php';

$data = $_POST;

if (empty($data['courses_ids'])) {
    $errors[] = 'invalid ID Course';
    $res->set_status("error");
    $res->set_error_message("Invalid Form");
    $res->set_response_data($errors);
    $res->response();
    exit;
}
$course_id = $data['courses_ids'];

$courses_Ids_string = $data['courses_ids'];
$coursesArray = explode(",", $courses_Ids_string);
$coursesArray = array_filter($coursesArray, fn($v) => trim($v) !== "");
$coursesArray = array_values(array_unique($coursesArray));

$jwt = new JwtAuth();
$tokenJWT = $jwt->get_jwt_by_header();
$resultJWT = $jwt->validate_token($tokenJWT);
$user_id = $resultJWT['id'];


$placeholders = [];
$params = [];

foreach ($coursesArray as $index => $id) {
    $key = ":id$index";
    $placeholders[] = $key;
    $params[$key] = $id;
}


$sql = "SELECT id FROM course WHERE id IN (" . implode(", ", $placeholders) . ")";
$response = $db->execute_query($sql, $params);
if ($response->status != 'success' || empty($response->results)) {
    $res->set_status('error');
    $res->set_error_message($response->mensagem);
    $res->response();
    exit;
}
$validIds = array_map(fn($item) => $item->id, $response->results);

$values = [];
$params = [];
$i = 0;

foreach ($validIds as $campus_id) {
    $values[] = "(:user_id, :course_id$i)";
    $params[":course_id$i"] = $campus_id;
    $i++; 
}
$params[':user_id'] = $user_id;

$sql = "INSERT INTO user_course (user_id, course_id) VALUES " . implode(", ", $values);
$response = $db->execute_non_query($sql, $params);
if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message($response->mensagem);
    $res->response();
    exit;
}

$res->response();
