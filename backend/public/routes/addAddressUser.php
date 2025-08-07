<?php 

require("../../_inc/init.php");

require_once __DIR__ . '/../../_inc/filters/isLogged.php';


require_once __DIR__ . '/../../_inc/validation/addressValidator.php';

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
$street = $data['street'];
$address_number = $data['address_number'];
$city = $data['city'];
$state = $data['state'];
$zip_code = $data['zip_code'];

$sql = "INSERT INTO address (street, address_number,city,state,zip_code) VALUES (:street, :address_number,:city,:state,:zip_code)";
$params = ['street' => $street, 'address_number' => $address_number, "city" => $city, "state" => $state,"zip_code" => $zip_code];
$response = $db->execute_non_query($sql, $params);

if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message($response->mensagem);
    $res->response();
    exit;
}
$newAddressId = $response->last_id;


$jwt = new JwtAuth();
$tokenJWT = $jwt->get_jwt_by_header();
$resultJWT = $jwt->validate_token($tokenJWT);

$user_id = $resultJWT['id'];

$sql = "SELECT address_id FROM user WHERE id = :user_id";
$params = ['user_id' => $user_id];
$response = $db->execute_query($sql, $params);

    $oldAddressId = $response->results[0]->address_id;


$sql = "UPDATE user set address_id = :newAddressId WHERE id = :user_id";
$params = ['user_id' => $user_id,"newAddressId"=>$newAddressId];
$response = $db->execute_non_query($sql, $params);





if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message($response->mensagem);
    $res->response();
    exit;
}

$sql = "DELETE FROM address WHERE id = :oldAddressId ";
$params = ["oldAddressId"=>$oldAddressId];
$response = $db->execute_non_query($sql, $params);


//se a pessoa entrar mais de 1 vez nesse breakpoint vai deixar o ultimo endereço triste.
$res->response();

?>