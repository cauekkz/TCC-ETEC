<?php

require("../../_inc/init.php");
require_once __DIR__ . '/../../_inc/filters/isLogged.php';
require_once __DIR__ . '/../../_inc/validation/addressValidator.php';

check_request_method($_SERVER['REQUEST_METHOD'], "POST");
$jwt = new JwtAuth();
$tokenJWT = $jwt->get_jwt_by_header();
$resultJWT = $jwt->validate_token($tokenJWT);
$user_id = $resultJWT['id'];

$errors = validate($_POST);

if (!empty($errors)) {
    $res->set_status("error");
    $res->set_error_message("Invalid Form");
    $res->set_response_data($errors);
    $res->response();
    exit;
}

$street = $_POST['street'];
$address_number = $_POST['address_number'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip_code = $_POST['zip_code'];

$sqlUpdate = "UPDATE address SET street = :street, address_number = :address_number, city = :city, state = :state, zip_code = :zip_code WHERE user_id = :user_id";
$paramsUpdate = [
    'street' => $street,
    'address_number' => $address_number,
    'city' => $city,
    'state' => $state,
    'zip_code' => $zip_code,
    'user_id' => $user_id
];

$responseUpdate = $db->execute_non_query($sqlUpdate, $paramsUpdate);

if ($responseUpdate->status == 'success' && $responseUpdate->affected_rows > 0) {
    $res->set_status('success');
    $res->set_response_data(['message' => 'Endereço atualizado com sucesso']);
    $res->response();
    exit;
}

$sqlInsert = "INSERT INTO address (user_id, street, address_number, city, state, zip_code) VALUES (:user_id, :street, :address_number, :city, :state, :zip_code)";
$paramsInsert = [
    'user_id' => $user_id,
    'street' => $street,
    'address_number' => $address_number,
    'city' => $city,
    'state' => $state,
    'zip_code' => $zip_code
];

$responseInsert = $db->execute_non_query($sqlInsert, $paramsInsert);

if ($responseInsert->status != 'success') {
    $res->set_status('error');
    $res->set_error_message($responseInsert->mensagem ?? 'Erro ao inserir endereço');
    $res->response();
    exit;
}

$res->set_status('success');
$res->set_response_data(['message' => 'Endereço criado com sucesso']);
$res->response();
exit;
