<?php

header("Access-Control-Allow-Origin: *");

header("Content-Type: application/json; charset=UTF-8");

header("Access-Control-Allow-Methods: POST, GET, PUT, PATCH, DELETE");

header("Access-Control-Max-Age: 3600");

header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/security.php';

include_once '../config/global.php';

include_once '../config/database.php';

include_once '../entities/project.php';

include_once '../services/projectService.php';

$database = new Database();

$db = $database->getConnection();

$project = new Project();

$service = new ProjectService($db);

$jsondata = file_get_contents("php://input");

$request = json_decode($jsondata, TRUE);

$data = 'Sin resultados';

http_response_code(404);

if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($request['action']) && $request['action'] == 'add') {

  http_response_code(200);

  $request['enteid'] = isset($request['enteid']) ? intval($request['enteid']) : 1;

  $request['responsibleid'] = isset($request['responsibleid']) ? intval($request['responsibleid']) : 1;

  $request['description'] = isset($request['description']) ? $request['description'] : '';

  $request['name'] = isset($request['name']) ? $request['name'] : '';

  $request['estimatedbudget'] = isset($request['estimatedbudget']) ? $request['estimatedbudget'] : 1;

  $request['estimatedduration'] = isset($request['estimatedduration']) ? $request['estimatedduration'] : 1;

  $project->setenteid($request['enteid']);

  $project->setresponsibleid($request['responsibleid']);

  $project->setdescription($request['description']);

  $project->setname($request['name']);

  $project->setestimatedbudget($request['estimatedbudget']);

  $project->setestimatedduration($request['estimatedduration']);

  $project->setcreatedBy($_SESSION['session_user']['id']);

  $data = $service->Add($project);
}

if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($request['action']) && $request['action'] == 'edit' && $request['id']) {

  http_response_code(200);

  $request['id'] = isset($request['id']) ? intval($request['id']) : null;

  if ($data = $service->GetOne($project->table_name, $request['id'])) {

    $request['enteid'] = intval($request['enteid']);

    $request['responsibleid'] = intval($request['responsibleid']);

    $project->setenteid($request['enteid']);

    $project->setresponsibleid($request['responsibleid']);

    $project->setdescription($request['description']);

    $project->setname($request['name']);

    $project->setestimatedbudget($request['estimatedbudget']);

    $project->setestimatedduration($request['estimatedduration']);

    $project->setmodifiedBy($_SESSION['session_user']['id']);

    $project->setid($request['id']);

    $data = $service->Edit($project);
  }
}

if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($request['action']) && $request['action'] == 'editstatus' && $request['id']) {

  http_response_code(200);

  $request['id'] = isset($request['id']) ? intval($request['id']) : null;

  if ($service->CheckExist($project->table_name, $request['id'])) {

    $project->setid($request['id']);

    $project->setstatus($request['status']);

    $project->setmodifiedBy($_SESSION['session_user']['id']);

    $data = $service->EditStatus($project);
  }
}

if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($request['action']) && $request['action'] == 'editprogress' && $request['id']) {

  http_response_code(200);

  $request['id'] = isset($request['id']) ? intval($request['id']) : null;

  $request['progress'] = isset($request['progress']) ? intval($request['progress']) : 0;

  if ($service->CheckExist($project->table_name, $request['id'])) {

    $project->setid($request['id']);

    $project->setprogress($request['progress']);

    $project->setmodifiedBy($_SESSION['session_user']['id']);

    $data = $service->EditProgress($project);
  }
}

if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($request['action']) && $request['action'] == 'actives') {

  http_response_code(200);

  $data = $service->GetActives($project->table_name);
}

if ($_SERVER["REQUEST_METHOD"] == 'GET' && isset($request['action']) && $request['action'] == 'one' && $request['id']) {

  http_response_code(200);

  $request['id'] = isset($request['id']) ? intval($request['id']) : null;

  $data = $service->GetOne($project->table_name, $request['id']);
}

if ($_SERVER["REQUEST_METHOD"] == 'POST' && $request['action'] == 'countperiod') {

  http_response_code(200);

  $data = $service->GetCountPeriod($project->table_name, $request['days']);
}

if ($_SERVER["REQUEST_METHOD"] == 'POST' && $request['action'] == 'countall') {

  http_response_code(200);

  $data = $service->GetCountAll($project->table_name);
}

if ($_SERVER["REQUEST_METHOD"] == 'POST' && $request['action'] == 'recentlyadded') {

  http_response_code(200);

  $data = $service->GetRecentlyAdded($project->table_name);
}

if ($_SERVER["REQUEST_METHOD"] == 'POST' && $request['action'] == 'recentlymodified') {

  http_response_code(200);

  $data = $service->GetRecentlyModified($project->table_name);
}

if ($_SERVER["REQUEST_METHOD"] == 'POST' && $request['action'] == 'recentlyaddedtograph') {

  http_response_code(200);

  $data = $service->GetRecentlyAddedtograph($project->table_name, $request['days']);
}

if ($_SERVER["REQUEST_METHOD"] == 'GET') {

  http_response_code(200);

  $data = $service->GetAll($project->table_name);
}

if ($_SERVER["REQUEST_METHOD"] == "DELETE" && $request['id']) {

  http_response_code(200);

  $request['id'] = isset($request['id']) ? intval($request['id']) : null;

  if ($service->GetOne($project->table_name, $request['id'])) {

    if ($service->HardDelete($project->table_name, $request['id'])) {

      $data = 'Ha sido eliminado con éxito';
    }
  }
}

echo json_encode($data);
