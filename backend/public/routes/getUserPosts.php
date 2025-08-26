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
//arrumar isso aqui pra deixar em query separada pois ele faz 2 imgs url nao sei pq
$sql = "SELECT
    p.id,
    p.id_author,
    p.content,
    COUNT(DISTINCT l.id) AS total_likes,
    CASE WHEN l2.id IS NULL THEN 0 ELSE 1 END AS user_liked,
    p.created_at,
    u.name AS author_name,
    u.role,
    u.profile_photo_path,
    pm_agg.media_data
FROM post p
LEFT JOIN likes l ON l.content_type = 'post' AND l.content_id = p.id
LEFT JOIN likes l2 ON l2.content_type = 'post' AND l2.content_id = p.id AND l2.user_id = :user_id
LEFT JOIN user u ON u.id = p.id_author
LEFT JOIN (
    SELECT
        post_id,
        GROUP_CONCAT(CONCAT(media_url, '|', media_type, '|', media_order) ORDER BY media_order ASC SEPARATOR ';') AS media_data
    FROM post_media
    GROUP BY post_id
) AS pm_agg ON pm_agg.post_id = p.id
WHERE p.id_author = :user_query_id
GROUP BY p.id, p.id_author, p.content, p.created_at, user_liked, u.name, u.role, u.profile_photo_path, pm_agg.media_data
ORDER BY p.created_at DESC;";
$params = ['user_query_id' => $user_query_id,'user_id'=>$user_id];
$response = $db->execute_query($sql, $params);
//pegar campus dp user por aqui tbm
$data = [];
if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message($response->mensagem);
    $res->response();
    exit;
}

// Processar posts e mídia
$posts = $response->results;
foreach ($posts as $post) {
    // Processar mídia do GROUP_CONCAT
    $post->media = [];
    if (!empty($post->media_data)) {
        $mediaItems = explode(';', $post->media_data);
        foreach ($mediaItems as $item) {
            $parts = explode('|', $item);
            if (count($parts) === 3) {
                $post->media[] = (object)[
                    'media_url' => $parts[0],
                    'media_type' => $parts[1],
                    'media_order' => (int)$parts[2]
                ];
            }
        }
    }
    unset($post->media_data); // Remover campo temporário
}

$data["posts"] = $posts;

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
