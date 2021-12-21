<?php

header("Access-Control-Allow-Origin: *");

header("Content-Type: application/json; charset=UTF-8");

header("Access-Control-Allow-Methods: POST, GET, PUT, PATCH, DELETE");

header("Access-Control-Max-Age: 3600");

header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/security.php';

include_once '../config/global.php';

include_once '../config/database.php';

include_once '../classes/password_compatibility_library.php';

include_once '../entities/user.php';

include_once '../services/userService.php';

$database = new Database();

$db = $database->getConnection();

$user = new User();

$service = new UserService($db);

$jsondata = file_get_contents("php://input");

$request = json_decode($jsondata, TRUE);

$data = 'Sin resultados';

http_response_code(404);

if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($request['action']) && $request['action'] == 'add') {

    http_response_code(200);

    if (!$service->GetOneEmail($user->table_name, $user->getemail())) {

        $user->setfullname($request['fullname']);

        $user->setemail($request['email']);

        $user->setpassword($request['password']);

        $user->setrole($request['role']);

        $user->setcreatedBy($_SESSION['session_user']['id']);

        $data = $service->Add($user);
    } else $data = false;
}

if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($request['action']) && $request['action'] == 'edit' && $request['id']) {

    http_response_code(200);

    if ($service->GetOne($user->table_name, $request['id'])) {

        $user->setid($request['id']);
        
        $user->setfullname($request['fullname']);

        $user->setrole($request['role']);

        $user->setmodifiedBy($_SESSION['session_user']['id']);

        $data = $service->Edit($user);
    }
}

if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($request['action']) && $request['action'] == 'editimage' && $request['id']) {

    http_response_code(200);

    if ($service->CheckExist($user->table_name, $request['id'])) {

        $user->setid($request['id']);

        $user->setimage($request['image']);

        $user->setmodifiedBy($_SESSION['session_user']['id']);

        $data = $service->EditImage($user);
    }
}

if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($request['action']) && $request['action'] == 'editpassword' && $request['id']) {

    http_response_code(200);

    if ($service->CheckExist($user->table_name, $request['id'])) {

        $user->setid($request['id']);

        $user->setpassword($request['password']);

        $user->setmodifiedBy($_SESSION['session_user']['id']);

        $data = $service->EditPassword($user);
    }
}

if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($request['action']) && $request['action'] == 'editstatus' && $request['id']) {

    http_response_code(200);

    if ($service->CheckExist($user->table_name, $request['id'])) {

        $user->setid($request['id']);

        $user->setstatus($request['status']);

        $user->setmodifiedBy($_SESSION['session_user']['id']);

        $data = $service->EditStatus($user);
    }
}

if ($_SERVER["REQUEST_METHOD"] == 'POST' && $request['action'] == 'countall') {

    http_response_code(200);

    $data = $service->GetCountAll($user->table_name);
}

if ($_SERVER["REQUEST_METHOD"] == 'GET' && isset($request['action']) && $request['action'] == 'one' && $request['id']) {

    http_response_code(200);

    $data = $service->GetOne($user->table_name, $request['id']);
}

if ($_SERVER["REQUEST_METHOD"] == 'GET' && !isset($request['action'])) {

    http_response_code(200);

    $data = $service->GetAll($user->table_name);
}

if ($_SERVER["REQUEST_METHOD"] == "DELETE" && $request['id']) {

    http_response_code(200);

    if ($service->GetOne($user->table_name, $request['id'])) {

        if ($service->HardDelete($user->table_name, $request['id'])) {

            $data = 'Ha sido eliminado con éxito';
        }
    }
}

echo json_encode($data);
