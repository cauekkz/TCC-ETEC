<?php 
require("../../_inc/init.php");
require_once __DIR__ . '/../../_inc/filters/isLogged.php';
check_request_method($_SERVER['REQUEST_METHOD'], "GET");


$contact_id = $_GET['contact_id'] ?? null;

if (!$contact_id || !is_numeric($contact_id)) {
    http_response_code(400);
    echo json_encode(['error' => 'ID do contato inválido ou ausente.']);
    exit;
}
$contact_id = (int) $contact_id; 

$jwt = new JwtAuth();
$tokenJWT = $jwt->get_jwt_by_header();
$resultJWT = $jwt->validate_token($tokenJWT);
$user_id = $resultJWT['id'];


$sql = "SELECT 
            id, sender_id, receiver_id, content, created_at, is_read 
        FROM 
            message 
        WHERE
            (sender_id = :user_id AND receiver_id = :contact_id)
            OR
            (sender_id = :contact_id AND receiver_id = :user_id)
        ORDER BY
            created_at ASC";

$params = [
    "user_id" => $user_id,
    "contact_id" => $contact_id
];

$response = $db->execute_query($sql, $params);

if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message($response->mensagem);
    $res->response();
    exit;
}

$res->set_response_data($response->results);
$res->response();
exit;
?>