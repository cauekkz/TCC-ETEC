<?php
require("../../_inc/init.php");
require_once __DIR__ . '/../../_inc/filters/isLogged.php';

check_request_method($_SERVER['REQUEST_METHOD'], "GET");
$server_id;
if (isset($_GET['server_id'])) {
    $server_id = $_GET['server_id'];
} else {
    $res->set_status('error');
    $res->set_error_message("erro ao pegar posts");
    $res->response();
    exit;
}


$page = max(1, (int)($_SERVER["HTTP_X_PAGE"] ?? 1));
$limit = min(50, max(1, (int)($_SERVER["HTTP_X_LIMIT"] ?? 10)));

$offset = ($page - 1) * $limit;

$jwt = new JwtAuth();
$tokenJWT = $jwt->get_jwt_by_header();
$resultJWT = $jwt->validate_token($tokenJWT);

$user_id = $resultJWT['id'];



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
    GROUP_CONCAT(
        DISTINCT CONCAT(pm.media_url, '|', pm.media_type, '|', pm.media_order) 
        ORDER BY pm.media_order ASC 
        SEPARATOR ';'
    ) AS media_data,
    GROUP_CONCAT(
        DISTINCT CONCAT(c.id, '|', c.name) 
        ORDER BY c.name ASC 
        SEPARATOR ';'
    ) AS campus_data
FROM post p 
LEFT JOIN likes l ON l.content_type = 'post' AND l.content_id = p.id 
LEFT JOIN likes l2 ON l2.content_type = 'post' AND l2.content_id = p.id AND l2.user_id = :user_id 
LEFT JOIN user u ON u.id = p.id_author
LEFT JOIN post_media pm ON pm.post_id = p.id
LEFT JOIN user_campus uc ON uc.user_id = p.id_author
LEFT JOIN campus c ON c.id = uc.campus_id
WHERE p.server_id = :server_id 
GROUP BY p.id 
ORDER BY p.created_at DESC 
LIMIT $limit OFFSET $offset;";



$params = ['server_id' => $server_id,"user_id"=>$user_id];
$response = $db->execute_query($sql, $params);
if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message("erro ao pegar posts");
    $res->response();
    exit;
}

// Process posts and media
$posts = $response->results;
foreach ($posts as $post) {
    // Process media from GROUP_CONCAT
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
    unset($post->media_data); // Remove temporary field
    
    // Process campuses from GROUP_CONCAT
    $post->campus = [];
    if (!empty($post->campus_data)) {
        $campusItems = explode(';', $post->campus_data);
        foreach ($campusItems as $item) {
            $parts = explode('|', $item);
            if (count($parts) === 2) {
                $post->campus[] = (object)[
                    'id' => (int)$parts[0],
                    'name' => $parts[1]
                ];
            }
        }
    }
    unset($post->campus_data); // Remove temporary field
}


$res->set_response_data($posts);
$res->response();



