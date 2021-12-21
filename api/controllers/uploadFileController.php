<?php

header("Access-Control-Allow-Origin: *");

header("Content-Type: application/json; charset=UTF-8");

header("Access-Control-Allow-Methods: POST, FILES");

header("Access-Control-Max-Age: 3600");

header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/security.php';

$data = null;

http_response_code(404);

if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['id'])) {

    http_response_code(200);

    $id = intval($_POST['id']);

    $module = (!empty($_POST['module'])) ? $_POST['module'] . '/' : '';

    $category = (!empty($_POST['category'])) ? $_POST['category'] . '/' : '';

    $path = 'img/' . $module . $category;

    $location = '../../img/' . $module . $category;

    $imageFileType  = pathinfo(basename($_FILES["file"]["name"]), PATHINFO_EXTENSION);

    $filename = $id . "_" . time() . "." . $imageFileType;

    if (!file_exists($location)) mkdir($location, 0777, true);

    if (move_uploaded_file($_FILES['file']['tmp_name'], $location . $filename)) $data = $path . $filename;
}

echo json_encode($data);
