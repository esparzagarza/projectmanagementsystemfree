<?php

header("Access-Control-Allow-Origin: *");

header("Content-Type: application/json; charset=UTF-8");

header("Access-Control-Allow-Methods: POST, GET, PUT, PATCH, DELETE");

header("Access-Control-Max-Age: 3600");

header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//include_once '../config/security.php';

include_once '../config/global.php';

include_once '../config/database.php';

include_once '../entities/task.php';

include_once '../services/taskService.php';

$database = new Database();

$db = $database->getConnection();

$task = new Task();

$service = new TaskService($db);

$jsondata = file_get_contents("php://input");

$request = json_decode($jsondata, TRUE);

$data = 'Sin resultados';

http_response_code(404);

if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($request['action']) && $request['action'] == 'add') {

    http_response_code(200);

    $request['projectid'] = isset($request['projectid']) ? intval($request['projectid']) : 1;

    $request['enteid'] = isset($request['enteid']) ? intval($request['enteid']) : 1;

    $request['userid'] = isset($request['userid']) ? intval($request['userid']) : 1;

    $request['categoryid'] = isset($request['categoryid']) ? intval($request['categoryid']) : 1;

    $request['type'] = isset($request['type']) ? $request['type'] : 'tarea';

    $request['name'] = isset($request['name']) ? $request['name'] : '';

    $request['description'] = isset($request['description']) ? $request['description'] : '';

    $request['duedate'] = isset($request['duedate']) ? $request['duedate'] : '';

    $request['prio'] = isset($request['prio']) ? $request['prio'] : 'media';

    $request['notes'] = isset($request['notes']) ? $request['notes'] : '';

    $task->setprojectid($request['projectid']);

    $task->setenteid($request['enteid']);

    $task->setuserid($request['userid']);

    $task->setcategoryid($request['categoryid']);

    $task->settype($request['type']);

    $task->setname($request['name']);

    $task->setdescription($request['description']);

    $task->setduedate($request['duedate']);

    $task->setprio($request['prio']);

    $task->setnotes($request['notes']);

    $task->setcreatedBy(1);

    $data = $service->Add($task);
}

if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($request['action']) && $request['action'] == 'edit' && $request['id']) {

    http_response_code(200);

    $request['id'] = isset($request['id']) ? intval($request['id']) : null;

    if ($service->CheckExist($task->table_name, $request['id'])) {

        $request['projectid'] = intval($request['projectid']);

        $request['enteid'] = intval($request['enteid']);

        $request['userid'] = intval($request['userid']);

        $request['categoryid'] = intval($request['categoryid']);

        $task->setprojectid($request['projectid']);

        $task->setenteid($request['enteid']);

        $task->setuserid($request['userid']);

        $task->setcategoryid($request['categoryid']);

        $task->settype($request['type']);

        $task->setname($request['name']);

        $task->setdescription($request['description']);

        $task->setduedate($request['duedate']);

        $task->setprio($request['prio']);

        $task->setnotes($request['notes']);

        $task->settags($request['tags']);

        $task->setstatus($request['status']);

        $task->setcreatedBy(1);

        $task->setid($request['id']);

        $task->setmodifiedBy(1);

        $data = $service->Edit($task);
    }
}

if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($request['action']) && $request['action'] == 'editstatus' && $request['id']) {

    http_response_code(200);

    $request['id'] = isset($request['id']) ? intval($request['id']) : null;

    if ($service->CheckExist($task->table_name, $request['id'])) {

        $task->setid($request['id']);

        $task->setstatus($request['status']);

        $task->setmodifiedBy(1);

        $data = $service->EditStatus($task);
    }
}

if ($_SERVER["REQUEST_METHOD"] == 'POST' && $request['action'] == 'countperiod') {

    http_response_code(200);

    $request['days'] = isset($request['days']) ? intval($request['days']) : 0;

    $data = $service->GetCountPeriod($task->table_name, $request['days']);
}

if ($_SERVER["REQUEST_METHOD"] == 'POST' && $request['action'] == 'countall') {

    http_response_code(200);

    $data = $service->GetCountAll($task->table_name);
}

if ($_SERVER["REQUEST_METHOD"] == 'POST' && $request['action'] == 'recentlyaddedtograph') {

    http_response_code(200);

    $request['days'] = isset($request['days']) ? intval($request['days']) : 0;

    $data = $service->GetRecentlyAddedtograph($task->table_name, $request['days']);
}

if ($_SERVER["REQUEST_METHOD"] == 'POST' && $request['action'] == 'projects' && $request['id']) {

    http_response_code(200);

    $request['id'] = isset($request['id']) ? intval($request['id']) : null;

    $data = $service->GetProjectTask($task->table_name, $request['id']);
}

if ($_SERVER["REQUEST_METHOD"] == 'POST' && $request['action'] == 'projectsclosed' && $request['id']) {

    http_response_code(200);

    $request['id'] = isset($request['id']) ? intval($request['id']) : null;

    $data = $service->GetProjectTaskClosed($task->table_name, $request['id']);
}

if ($_SERVER["REQUEST_METHOD"] == 'POST' && $request['action'] == 'projectsactive' && $request['id']) {

    http_response_code(200);

    $request['id'] = isset($request['id']) ? intval($request['id']) : null;

    $data = $service->GetProjectTaskActive($task->table_name, $request['id']);
}

if ($_SERVER["REQUEST_METHOD"] == 'GET') {

    http_response_code(200);

    $data = $service->GetAll($task->table_name);
}

if ($_SERVER["REQUEST_METHOD"] == "DELETE" && $request['id']) {

    http_response_code(200);

    $request['id'] = isset($request['id']) ? intval($request['id']) : null;

    if ($service->GetOne($task->table_name, $request['id'])) {

        if ($service->HardDelete($task->table_name, $request['id'])) {

            $data = 'Ha sido eliminado con éxito';
        }
    }
}

echo json_encode($data);
