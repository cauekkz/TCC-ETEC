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
  p.id,
  p.id_author,
  p.content,
  COUNT(l.id) AS total_likes,
  CASE WHEN l2.id IS NULL THEN 0 ELSE 1 END AS user_liked,
  p.created_at,
  u.name AS author_name,
  u.role,
  u.profile_photo_path
FROM post p
LEFT JOIN likes l ON l.content_type = 'post' AND l.content_id = p.id
LEFT JOIN likes l2 ON l2.content_type = 'post' AND l2.content_id = p.id AND l2.user_id = :user_query_id
LEFT JOIN user u ON u.id = p.id_author
WHERE p.id_author = :user_query_id
GROUP BY p.id, p.id_author, p.content, p.created_at, user_liked, u.name, u.role, u.profile_photo_path
ORDER BY p.created_at DESC
";
$params = ['user_query_id' => $user_query_id];
$response = $db->execute_query($sql, $params);

$data = [];
if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message($response->mensagem);
    $res->response();
    exit;
}
$data["posts"] = $response->results;

$sql = "SELECT c.* FROM user_campus uc
    inner join  campus c on uc.campus_id = c.id
    where uc.user_id = :user_query_id
";
$params = ['user_query_id' => $user_query_id];
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

$res->set_response_data($data);
$res->response();
exit;
