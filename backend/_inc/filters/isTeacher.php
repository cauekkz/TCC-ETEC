<?php
require_once __DIR__ . "/../jwt.php";

(function ($res) {


    $jwt = new JwtAuth();
    $tokenJWT = $jwt->get_jwt_by_header();
    

    if ($tokenJWT) {
        $resultJWT = $jwt->validate_token($tokenJWT);
        if ($resultJWT && $resultJWT["role"] == "teacher") {
            return;
        }
        $res->set_status('error');
        $res->set_error_message("Logg in with Teacher account");
        $res->response();
        exit;
    }
    if (isset($_COOKIE["refreshToken"])) {
        $res->set_status('refresh');
        $res->set_error_message("need new JWT");
        $res->response();
        exit;
    }
    $res->set_status('error');
    $res->set_error_message("Logg in with ADM account");
    $res->response();
    exit;
})($res);
