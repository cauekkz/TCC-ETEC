<?php

require("../../_inc/init.php");
require_once __DIR__ . '/../../_inc/filters/isLogged.php';

require_once __DIR__ . '/../../_inc/validation/updateUserValidator.php';



check_request_method($_SERVER['REQUEST_METHOD'], "POST");
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
$email =$_POST['email'];
$name = $_POST['name'];
$phone = $_POST['phone'] ?? null;
$profile_photo_path = null;
$password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

if (isset($_FILES['profile_photo'])) {
    $uploadDir = "../../uploads/profilePhotos/$user_id/";
    if (is_dir($uploadDir)) {
        $files = glob($uploadDir . '*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    } else {
        mkdir($uploadDir, 0777, true);
    }

    $file = $_FILES['profile_photo'];
    $filename = uniqid() . '_' . basename($file['name']);
    $filename = preg_replace('/[^a-zA-Z0-9._-]/', '_', $filename);

    $targetPath = $uploadDir . $filename;

    move_uploaded_file($file['tmp_name'], $targetPath);
    $profile_photo_path = "uploads/profilePhotos/$user_id/" . $filename;
}


$sql = "UPDATE user SET name = :name , email = :email, password_hash = :password_hash,phone = :phone,profile_photo_path = :profile_photo_path   WHERE id = :id";
$params = ['id' => $user_id, 'name' => $name, 'email' => $email, "password_hash" => $password_hash, 'phone' => $phone,"profile_photo_path"=>$profile_photo_path];
$response = $db->execute_non_query($sql, $params);
if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message($response->mensagem);
    $res->response();
    exit;
}
$res->response();

exit;
