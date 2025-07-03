<?php
header("Content-Type: application/json");
include_once '../../config/database.php';
include_once '../../models/User.php';

$data = json_decode(file_get_content("php://input"));

if(empty($data->name) || empty($data->email) || empty($data->phone) || empty($data->pwd)) {
    http_response_code(400);
    echo json_encode(["message" => "All fields are required"]);
    exit;
}

$db = (new Database())->connect();
$user = new User($db);

$user->name = $data->name;
$user->email = $data->email;
$user->phone =$data->phone;
$user->pwd =$data->pwd;
$user->role =$data->role ?? "user";

if($user->register()) {
    echo json_encode(["message" => "Registration successful", "user_id" => $user->id]);
} else{
    http_response_code(500);
    echo json_encode(["message" => "Something went wrong"]);
}