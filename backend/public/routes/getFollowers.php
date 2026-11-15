<?php
require_once '../../_inc/init.php';
require_once __DIR__ . '/../../_inc/filters/isLogged.php';

check_request_method($_SERVER['REQUEST_METHOD'], "GET");

$jwt = new JwtAuth();
$tokenJWT = $jwt->get_jwt_by_header();
$resultJWT = $jwt->validate_token($tokenJWT);

if (!$resultJWT) {
    $res->set_status('error');
    $res->set_error_message('Token inválido');
    $res->response();
    exit;
}

$auth_user_id = $resultJWT['id'];

// Checks
if (!isset($_GET['user_id'])) {
    $res->set_status('error');
    $res->set_error_message('ID do usuário não informado');
    $res->response();
    exit;
}

if (!isset($_GET['type'])) {
    $res->set_status('error');
    $res->set_error_message('Tipo não informado');
    $res->response();
    exit;
}

$userId = (int) $_GET['user_id'];
$type = $_GET['type']; // followers | following

try {

    // -------------------------
    // SEGUIDORES
    // -------------------------
    if ($type === 'followers') {
        $sql = "
            SELECT 
                u.id,
                u.name,
                u.role,
                u.profile_photo_path,

                CASE 
                    WHEN fcheck.id IS NULL THEN 0 
                    ELSE 1 
                END AS is_following

            FROM follower f
            INNER JOIN user u 
                ON u.id = f.follower_id

            LEFT JOIN follower fcheck 
                ON fcheck.follower_id = :auth_user_id
                AND fcheck.followed_id = u.id

            WHERE f.followed_id = :user_id
            ORDER BY f.created_at DESC
        ";

        $params = [
            'user_id' => $userId,
            'auth_user_id' => $auth_user_id
        ];
    }

    // -------------------------
    // SEGUINDO
    // -------------------------
    else if ($type === 'following') {
        $sql = "
            SELECT 
                u.id,
                u.name,
                u.role,
                u.profile_photo_path,

                CASE 
                    WHEN fcheck.id IS NULL THEN 0 
                    ELSE 1 
                END AS is_following

            FROM follower f
            INNER JOIN user u 
                ON u.id = f.followed_id

            LEFT JOIN follower fcheck 
                ON fcheck.follower_id = :auth_user_id
                AND fcheck.followed_id = u.id

            WHERE f.follower_id = :user_id
            ORDER BY f.created_at DESC
        ";

        $params = [
            'user_id' => $userId,
            'auth_user_id' => $auth_user_id
        ];
    }

    else {
        $res->set_status('error');
        $res->set_error_message('Tipo inválido');
        $res->response();
        exit;
    }

    $response = $db->execute_query($sql, $params);

    if ($response->status !== 'success') {
        $res->set_status('error');
        $res->set_error_message('Erro ao buscar dados');
        $res->response();
        exit;
    }

    $res->set_status('success');
    $res->set_response_data($response->results);
    $res->response();

} catch (PDOException $e) {
    $res->set_status('error');
    $res->set_error_message('Erro ao buscar seguidores');
    $res->response();
    exit;
}
?>
