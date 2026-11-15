<?php
require("../../_inc/init.php");
require_once __DIR__ . '/../../_inc/filters/isLogged.php';
check_request_method($_SERVER['REQUEST_METHOD'], "POST");

require_once __DIR__ . '/../../_inc/validation/messageValidator.php';


$errors = validate($_POST);
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

$mediaUrl = null;
$mediatype = $_POST["media_type"] ?? null;
$receiver_id = $_POST['receiver_id'];
$content = $_POST["content"] ?? null;
if (isset($_FILES['media_file'])) {
    $file = $_FILES['media_file'];
    $filename = uniqid() . '_' . basename($file['name']);
    $filename = preg_replace('/[^a-zA-Z0-9._-]/', '_', $filename);

    $targetPath = '../../uploads/mediaMessage/' . $filename;

    move_uploaded_file($file['tmp_name'], $targetPath);
    $mediaUrl = 'uploads/mediaMessage/' . $filename;
}

$sql = "INSERT INTO message (sender_id,receiver_id,content,media_url,media_type) VALUES (:user_id,:receiver_id,:content,:mediaUrl,:mediatype)";
$params = ['content' => $content, "user_id" => $user_id, "receiver_id" => $receiver_id, "mediaUrl" => $mediaUrl, "mediatype" => $mediatype];
$response = $db->execute_non_query($sql, $params);

if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message($response->message);
    $res->response();
    exit;
}

$res->response();
