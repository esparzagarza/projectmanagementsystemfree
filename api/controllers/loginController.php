<?php

header("Access-Control-Allow-Origin: *");

header("Content-Type: application/json; charset=UTF-8");

header("Access-Control-Allow-Methods: POST, GET, DELETE");

header("Access-Control-Max-Age: 3600");

header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../classes/password_compatibility_library.php";

include '../config/global.php';

include '../config/database.php';

include '../entities/login.php';

include '../services/loginService.php';

$database = new Database();

$db = $database->getConnection();

$login = new Login();

$service = new LoginService($db);

$jsondata = file_get_contents("php://input");

$request = json_decode($jsondata, TRUE);

if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($request['email']) && isset($request['password']) && $request['action'] == 'login') {

    http_response_code(200);

    session_start();

    if (isset($_SESSION['session_user'])) unset($_SESSION['session_user']);

    $login->setemail(htmlspecialchars(strip_tags($request['email'])));

    $login->setpassword(htmlspecialchars(strip_tags($request['password'])));

    if ($data = $service->GetOneEmail($login->table_name, $login->getemail())) {

        $login->setid($data['id']);

        $login->setstatus($data['status']);

        if ($login->getstatus()) {

            if (password_verify($login->getpassword(), $data['password'])) {

                if ($service->Lastlogin($login)) {

                    unset($data['password']);

                    $_SESSION['session_user'] = $data;

                    echo true;
                } else echo 0;
            } else echo 0;
        } else echo json_encode('cuenta suspendida');
    } else echo 0;
}

if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($request['action']) && $request['action'] == 'isactivesession') {

    http_response_code(200);

    session_start();

    if (isset($_SESSION['session_user'])) {

        echo true;
    } else echo 0;
}

if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($request['action']) && $request['action'] == 'getactivesession') {

    http_response_code(200);

    session_start();

    if (isset($_SESSION['session_user'])) {

        if (isset($_SESSION['session_user']['password'])) unset($_SESSION['session_user']['password']);

        echo json_encode($_SESSION['session_user']);
    } else echo 0;
}

if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($request['action']) && $request['action'] == 'logout') {

    http_response_code(200);

    session_start();

    unset($_SESSION['session_user']);

    session_destroy();

    echo json_encode('Haz cerrado sesión');
}

if (!isset($request['action'])) {

    http_response_code(404);

    echo 0;
}
