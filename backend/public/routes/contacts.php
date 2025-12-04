<?php
require("../../_inc/init.php");
require_once __DIR__ . '/../../_inc/filters/isLogged.php';
check_request_method($_SERVER['REQUEST_METHOD'], "GET");

$jwt = new JwtAuth();
$tokenJWT = $jwt->get_jwt_by_header();
$resultJWT = $jwt->validate_token($tokenJWT);
$user_id = $resultJWT['id'];

$sql = "
SELECT 
    u.id AS user_id,
    u.name,
    u.profile_photo_path,
    u.role,
    MAX(m.created_at) AS last_message_at,
    SUM(CASE WHEN m.receiver_id = :user_id AND m.is_read = FALSE THEN 1 ELSE 0 END) AS unread_count
FROM user u
JOIN message m
    ON (u.id = m.sender_id AND m.receiver_id = :user_id)
    OR (u.id = m.receiver_id AND m.sender_id = :user_id)
WHERE u.id != :user_id
GROUP BY u.id, u.name, u.profile_photo_path
ORDER BY last_message_at DESC
";
$params = ["user_id" => $user_id];
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