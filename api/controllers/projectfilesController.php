<?php

header("Access-Control-Allow-Origin: *");

header("Content-Type: application/json; charset=UTF-8");

header("Access-Control-Allow-Methods: POST, GET, PUT, PATCH, DELETE");

header("Access-Control-Max-Age: 3600");

header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/security.php';

include_once '../config/global.php';

include_once '../config/database.php';

include_once '../entities/projectfiles.php';

include_once '../services/projectfilesService.php';

$database = new Database();

$db = $database->getConnection();

$projectfiles = new Projectfiles();

$service = new ProjectfilesService($db);

$jsondata = file_get_contents("php://input");

$request = json_decode($jsondata, TRUE);

$data = 'Sin resultados';

http_response_code(404);

if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($request['action']) && $request['action'] == 'add') {

    http_response_code(200);

    $request['id'] = isset($request['id']) ? intval($request['id']) : 1;

    $projectfiles->setprojectid($request['id']);

    $projectfiles->settitle($request['title']);

    $projectfiles->setsrc($request['src']);

    $projectfiles->setcreatedBy($_SESSION['session_user']['id']);

    $data = $service->Add($projectfiles);
}

if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($request['action']) && $request['action'] == 'editstatus' && $request['id']) {

    http_response_code(200);

    $request['id'] = isset($request['id']) ? intval($request['id']) : null;

    if ($service->CheckExist($projectfiles->table_name, $request['id'])) {

        $projectfiles->setid($request['id']);

        $projectfiles->setstatus($request['status']);

        $projectfiles->setmodifiedBy($_SESSION['session_user']['id']);

        $data = $service->EditStatus($projectfiles);
    }
}

if ($_SERVER["REQUEST_METHOD"] == 'POST' && $request['action'] == 'projects' && $request['id']) {

    http_response_code(200);

    $request['id'] = isset($request['id']) ? intval($request['id']) : null;

    $data = $service->GetProjectFiles($projectfiles->table_name, $request['id']);
}

if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($request['action']) && $request['action'] == 'actives') {

    http_response_code(200);

    $data = $service->GetActives($projectfiles->table_name);
}

if ($_SERVER["REQUEST_METHOD"] == 'GET' && isset($request['action']) && $request['action'] == 'one' && $request['id']) {

    http_response_code(200);

    $request['id'] = isset($request['id']) ? intval($request['id']) : null;

    $data = $service->GetOne($projectfiles->table_name, $request['id']);
}

if ($_SERVER["REQUEST_METHOD"] == 'GET') {

    http_response_code(200);

    $data = $service->GetAll($projectfiles->table_name);
}

if ($_SERVER["REQUEST_METHOD"] == "DELETE" && $request['id']) {

    http_response_code(200);

    $request['id'] = isset($request['id']) ? intval($request['id']) : null;

    if ($service->GetOne($projectfiles->table_name, $request['id'])) {

        if ($service->HardDelete($projectfiles->table_name, $request['id'])) {

            $data = 'Ha sido eliminado con éxito';
        }
    }
}

echo json_encode($data);
