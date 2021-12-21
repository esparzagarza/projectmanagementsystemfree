<?php

header("Access-Control-Allow-Origin: *");

header("Content-Type: application/json; charset=UTF-8");

header("Access-Control-Allow-Methods: POST, GET, PUT, PATCH, DELETE");

header("Access-Control-Max-Age: 3600");

header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/security.php';

include_once '../config/global.php';

include_once '../config/database.php';

include_once '../entities/category.php';

include_once '../services/categoryService.php';

$database = new Database();

$db = $database->getConnection();

$category = new Category();

$service = new CategoryService($db);

$jsondata = file_get_contents("php://input");

$request = json_decode($jsondata, TRUE);

$data = 'Sin resultados';

http_response_code(404);

if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($request['action']) && $request['action'] == 'add') {

    http_response_code(200);

    $request['categoryid'] = isset($request['categoryid']) ? intval($request['categoryid']) : 1;

    $category->setname($request['name']);

    $category->setcategoryid($request['categoryid']);

    $category->setcreatedBy($_SESSION['session_user']['id']);

    $data = $service->Add($category);
}

if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($request['action']) && $request['action'] == 'edit' && $request['id']) {

    http_response_code(200);

    $request['categoryid'] = isset($request['categoryid']) ? intval($request['categoryid']) : 1;

    if ($data = $service->GetOne($category->table_name, $request['id'])) {

        $category->setid($request['id']);

        $category->setname($request['name']);

        $category->setcategoryid($request['categoryid']);

        $category->setmodifiedBy($_SESSION['session_user']['id']);

        $data = $service->Edit($category);
    }
}

if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($request['action']) && $request['action'] == 'editimage' && $request['id']) {

    http_response_code(200);

    if ($service->CheckExist($category->table_name, $request['id'])) {

        $category->setid($request['id']);

        $category->setimage($request['image']);

        $category->setmodifiedBy($_SESSION['session_user']['id']);

        $data = $service->EditImage($category);
    }
}

if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($request['action']) && $request['action'] == 'editstatus' && $request['id']) {

    http_response_code(200);

    $request['id'] = isset($request['id']) ? intval($request['id']) : null;

    if ($service->CheckExist($category->table_name, $request['id'])) {

        $category->setid($request['id']);

        $category->setstatus($request['status']);

        $category->setmodifiedBy($_SESSION['session_user']['id']);

        $data = $service->EditStatus($category);
    }
}

if ($_SERVER["REQUEST_METHOD"] == 'POST' && $request['action'] == 'countall') {

    http_response_code(200);

    $data = $service->GetCountAll($category->table_name);
}

if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($request['action']) && $request['action'] == 'actives') {

    http_response_code(200);

    $data = $service->GetActives($category->table_name);
}

if ($_SERVER["REQUEST_METHOD"] == 'GET' && isset($request['action']) && $request['action'] == 'one' && $request['id']) {

    http_response_code(200);

    $request['id'] = isset($request['id']) ? intval($request['id']) : null;

    $data = $service->GetOne($category->table_name, $request['id']);
}

if ($_SERVER["REQUEST_METHOD"] == 'GET') {

    http_response_code(200);

    $data = $service->GetAll($category->table_name);
}

if ($_SERVER["REQUEST_METHOD"] == "DELETE" && $request['id']) {

    http_response_code(200);

    $request['id'] = isset($request['id']) ? intval($request['id']) : null;

    if ($service->GetOne($category->table_name, $request['id'])) {

        if ($service->HardDelete($category->table_name, $request['id'])) {

            $data = 'Ha sido eliminado con éxito';
        }
    }
}

echo json_encode($data);
