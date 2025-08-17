    <?php
    require("../../_inc/init.php");
    require_once __DIR__ . '/../../_inc/filters/isLogged.php';
    $data = $_POST;
    if (empty($data['campus_Ids'])) {
        $errors[] = 'invalid ID Campus';
        $res->set_status("error");
        $res->set_error_message("Invalid Form");
        $res->set_response_data($errors);
        $res->response();
        exit;
    }
    $campus_Ids_string = $data['campus_Ids'];
    $campusArray = explode(",", $campus_Ids_string);
    $campusArray = array_filter($campusArray, fn($v) => trim($v) !== "");
    $campusArray = array_values(array_unique($campusArray));
    $jwt = new JwtAuth();
    $tokenJWT = $jwt->get_jwt_by_header();
    $resultJWT = $jwt->validate_token($tokenJWT);
    $user_id = $resultJWT['id'];


    $placeholders = [];
    $params = [];

    foreach ($campusArray as $index => $id) {
        $key = ":id$index";
        $placeholders[] = $key;
        $params[$key] = $id;
    }
    $params["user_id"] = $user_id;
    $sql = "DELETE FROM user_campus WHERE campus_id IN (" . implode(", ", $placeholders) . ") AND user_id = :user_id";
    $response = $db->execute_non_query($sql, $params);
    if ($response->status != 'success') {
        $res->set_status('error');
        $res->set_error_message($response->mensagem);
        $res->response();
        exit;
    }
    $res->response();
