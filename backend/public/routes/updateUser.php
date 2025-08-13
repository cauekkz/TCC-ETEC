<?php

require("../../_inc/init.php");
require_once __DIR__ . '/../../_inc/filters/isLogged.php';

require_once __DIR__ . '/../../_inc/validation/updateUserValidator.php';
require_once __DIR__ . '/../../_inc/validation/addressValidator.php';



check_request_method($_SERVER['REQUEST_METHOD'], "POST");
$errors = validate($_POST);
$has_address = ($_POST["has_address"] === "true") ? true : false;
if (!empty($errors)) {
    $res->set_status("error");
    $res->set_error_message("Invalid Form");
    $res->set_response_data($errors);
    $res->response();
    exit;
}
if ($has_address) {
    $errors = addressValidate($_POST);
    if (!empty($errors)) {
        $res->set_status("error");
        $res->set_error_message("Invalid Form");
        $res->set_response_data($errors);
        $res->response();
        exit;
    }
}
$jwt = new JwtAuth();
$tokenJWT = $jwt->get_jwt_by_header();
$resultJWT = $jwt->validate_token($tokenJWT);

$user_id = $resultJWT['id'];
$email = $_POST['email'];
$name = $_POST['name'];
$phone = $_POST['phone'] ?? null;
$course_id = $_POST['course'] ?? null;
$campus_id = $_POST['campus'] ?? null;
$profile_photo_path = null;

$address = ($has_address) ? $_POST['street'] . ', ' . $_POST['address_number'] . ', ' . $_POST['city'] . ', ' . $_POST['state'] . ', ' . $_POST['zip_code'] : null;
$sql = "";
$params  = null;
if (isset($_FILES['profilePic']) && $_FILES['profilePic']['error'] == 0) {
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

    $file = $_FILES['profilePic'];
    $filename = uniqid() . '_' . basename($file['name']);
    $filename = preg_replace('/[^a-zA-Z0-9._-]/', '_', $filename);

    $targetPath = $uploadDir . $filename;

    move_uploaded_file($file['tmp_name'], $targetPath);
    $profile_photo_path = "uploads/profilePhotos/$user_id/" . $filename;
    $sql = "UPDATE user SET name = :name , email = :email,phone = :phone,profile_photo_path = :profile_photo_path, address = :address  WHERE id = :id";
    $params = ['id' => $user_id, 'name' => $name, 'email' => $email, 'phone' => $phone, "profile_photo_path" => $profile_photo_path, "address" => $address];
} else {
    $sql = "UPDATE user SET name = :name , email = :email,phone = :phone, address = :address  WHERE id = :id";
    
    $params = ['id' => $user_id, 'name' => $name, 'email' => $email, 'phone' => $phone, "address" => $address];
}




$response = $db->execute_non_query($sql, $params);
if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message($response->mensagem);
    $res->response();
    exit;
}
$res->response();

exit;
