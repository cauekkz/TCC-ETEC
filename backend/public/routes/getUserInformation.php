<?php
require("../../_inc/init.php");

require_once __DIR__ . '/../../_inc/filters/isLogged.php';

check_request_method($_SERVER['REQUEST_METHOD'], "GET");

$jwt = new JwtAuth();
$tokenJWT = $jwt->get_jwt_by_header();
$resultJWT = $jwt->validate_token($tokenJWT);

$user_id = $resultJWT['id'];

$user_query_id = isset($_GET["user_id"])
    ? ($_GET["user_id"] === "mine" ? $user_id : $_GET["user_id"])
    : null;
if ($user_query_id === null) {
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
  where id = :user_id
";
$params = ['user_id' => $user_query_id];
$response = $db->execute_query($sql, $params);


if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message($response->mensagem);
    $res->response();
    exit;
}
$data = [];
$data["user"] = $response->results[0];


$addressString = $data["user"]->address?? null;

if ($addressString !== null) {
    $addressParts = array_map('trim', explode(',', $addressString));

    $data['address'] = [
        'street' => $addressParts[0] ?? null,
        'address_number' => $addressParts[1] ?? null,
        'city' => $addressParts[2] ?? null,
        'state' => $addressParts[3] ?? null,
        'zip_code' => $addressParts[4] ?? null
    ];
}
unset($data["user"]->address);


$sql = "SELECT c.* FROM user_course uc
    inner join  course c on uc.course_id = c.id
    where uc.user_id = :user_id
";
$params = ['user_id' => $user_query_id];
$response = $db->execute_query($sql, $params);


if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message($response->mensagem);
    $res->response();
    exit;
}

if (!empty($response->results)) {
    $data["course"] = $response->results;
}

$sql = "SELECT c.* FROM user_campus uc
    inner join  campus c on uc.campus_id = c.id
    where uc.user_id = :user_id
";
$params = ['user_id' => $user_query_id];
$response = $db->execute_query($sql, $params);

if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message($response->mensagem);
    $res->response();
    exit;
}
if (!empty($response->results)) {
    $data["campus"] = $response->results;
}


$sql = "SELECT COUNT(*) AS followers_count FROM follower WHERE followed_id = :user_id";
$params = ['user_id' => $user_query_id];
$response = $db->execute_query($sql, $params);
if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message($response->mensagem);
    $res->response();
    exit;
}
$data["followers_count"] = $response->results[0];



$sql = "SELECT COUNT(*) AS following_count FROM follower WHERE follower_id = :user_id";
$params = ['user_id' => $user_query_id];
$response = $db->execute_query($sql, $params);
if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message($response->mensagem);
    $res->response();
    exit;
}
$data["following_count"] = $response->results[0];



$res->set_response_data($data);
$res->response();
exit;
