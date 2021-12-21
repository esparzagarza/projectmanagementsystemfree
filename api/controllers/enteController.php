<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, PATCH, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and ente files
include_once '../config/security.php';
include_once '../config/global.php';
include_once '../config/database.php';
include_once '../entities/ente.php';
include_once '../services/enteService.php';

// initialize ente
$database = new Database();
$db = $database->getConnection();
$ente = new Ente();
$service = new EnteService($db);

// get posted data
$jsondata = file_get_contents("php://input");
$request = json_decode($jsondata, TRUE);
$data = 'Sin datos';
http_response_code(404);

// quickAdd
if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($request['action']) && $request['action'] == 'quickadd') {

  http_response_code(200);

  $request['fullname'] = isset($request['fullname']) ? $request['fullname'] : '';
  $request['email'] = isset($request['email']) ? $request['email'] : '';
  $request['phone'] = isset($request['phone']) ? $request['phone'] : '';
  $request['website'] = isset($request['website']) ? $request['website'] : '';
  $request['type'] = isset($request['type']) ? $request['type'] : 'cliente';
  $request['level'] = isset($request['level']) ? intval($request['level']) : 1;

  $ente->setfullname($request['fullname']);
  $ente->setemail($request['email']);
  $ente->setphone($request['phone']);
  $ente->setwebsite($request['website']);
  $ente->settype($request['type']);
  $ente->setlevel($request['level']);
  $ente->setcreatedBy($_SESSION['session_user']['id']);
  $ente->setmodifiedBy($_SESSION['session_user']['id']);

  $data = $service->quickAdd($ente);
}


// Add
if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($request['action']) && $request['action'] == 'add') {

  http_response_code(200);

  $request['fullname'] = isset($request['fullname']) ? $request['fullname'] : '';
  $request['email'] = isset($request['email']) ? $request['email'] : '';
  $request['phone'] = isset($request['phone']) ? $request['phone'] : '';
  $request['website'] = isset($request['website']) ? $request['website'] : '';
  $request['address'] = isset($request['address']) ? $request['address'] : '';
  $request['rfc'] = isset($request['rfc']) ? $request['rfc'] : '';
  $request['razonsocial'] = isset($request['razonsocial']) ? $request['razonsocial'] : '';
  $request['fiscaladdress'] = isset($request['fiscaladdress']) ? $request['fiscaladdress'] : '';
  $request['type'] = isset($request['type']) ? $request['type'] : 'cliente';
  $request['level'] = isset($request['level']) ? intval($request['level']) : 1;

  $ente->setfullname($request['fullname']);
  $ente->setemail($request['email']);
  $ente->setphone($request['phone']);
  $ente->setwebsite($request['website']);
  $ente->setaddress($request['address']);
  $ente->setrfc($request['rfc']);
  $ente->setrazonsocial($request['razonsocial']);
  $ente->setfiscaladdress($request['fiscaladdress']);
  $ente->settype($request['type']);
  $ente->setlevel($request['level']);

  $ente->setcreatedBy($_SESSION['session_user']['id']);
  $ente->setmodifiedBy($_SESSION['session_user']['id']);

  $data = $service->Add($ente);
}

// Edit
if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($request['action']) && $request['action'] == 'edit' && $request['id']) {

  http_response_code(200);

  $request['id'] = isset($request['id']) ? intval($request['id']) : null;

  if ($service->CheckExist($ente->table_name, $request['id'])) {

    $request['fullname'] = isset($request['fullname']) ? $request['fullname'] : '';
    $request['email'] = isset($request['email']) ? $request['email'] : '';
    $request['phone'] = isset($request['phone']) ? $request['phone'] : '';
    $request['website'] = isset($request['website']) ? $request['website'] : '';
    $request['address'] = isset($request['address']) ? $request['address'] : '';
    $request['rfc'] = isset($request['rfc']) ? $request['rfc'] : '';
    $request['razonsocial'] = isset($request['razonsocial']) ? $request['razonsocial'] : '';
    $request['fiscaladdress'] = isset($request['fiscaladdress']) ? $request['fiscaladdress'] : '';
    $request['level'] = intval($request['level']);


    $ente->setfullname($request['fullname']);
    $ente->setemail($request['email']);
    $ente->setphone($request['phone']);
    $ente->setwebsite($request['website']);
    $ente->setaddress($request['address']);
    $ente->setrfc($request['rfc']);
    $ente->setrazonsocial($request['razonsocial']);
    $ente->setfiscaladdress($request['fiscaladdress']);
    $ente->settype($request['type']);
    $ente->setlevel($request['level']);

    $ente->setmodifiedBy($_SESSION['session_user']['id']);
    $ente->setid($request['id']);

    $data = $service->Edit($ente);
  }
}

// Edit image
if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($request['action']) && $request['action'] == 'editimage' && $request['id']) {

  http_response_code(200);

  if ($service->CheckExist($ente->table_name, $request['id'])) {

    $ente->setid($request['id']);
    $ente->setimage($request['image']);
    $ente->setmodifiedBy($_SESSION['session_user']['id']);

    $data = $service->EditImage($ente);
  }
}

// GetActives
if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($request['action']) && $request['action'] == 'actives') {

  http_response_code(200);

  $data = $service->GetActives($ente->table_name);
}

// GetType
if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($request['action']) && $request['action'] == 'type') {

  http_response_code(200);

  $data = $service->GetType($ente->table_name, $request['type']);
}

// GetOne [id]
if ($_SERVER["REQUEST_METHOD"] == 'GET' && isset($request['action']) && $request['action'] == 'one' && $request['id']) {

  http_response_code(200);

  $data = $service->GetOne($ente->table_name, $request['id']);
}

// GetCountPeriod
if ($_SERVER["REQUEST_METHOD"] == 'POST' && $request['action'] == 'countperiod') {

  http_response_code(200);

  $data = $service->GetCountPeriod($ente->table_name, $request['days']);
}

// GetCountAll
if ($_SERVER["REQUEST_METHOD"] == 'POST' && $request['action'] == 'countall') {

  http_response_code(200);

  $data = $service->GetCountAll($ente->table_name);
}

// GetAll
if ($_SERVER["REQUEST_METHOD"] == 'GET' && !isset($request['action'])) {

  http_response_code(200);

  $data = $service->GetAll($ente->table_name);
}

// Delete [id]
if ($_SERVER["REQUEST_METHOD"] == 'DELETE' && $request['id']) {

  http_response_code(200);

  if ($service->CheckExist($ente->table_name, $request['id'])) {

    if ($service->HardDelete($ente->table_name, $request['id'])) {
      $data = 'Ha sido eliminado con éxito';
    }
  }
}

// response
echo json_encode($data);
