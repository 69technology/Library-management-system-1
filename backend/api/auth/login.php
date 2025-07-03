<?php

header("Content-Type: application/json");
include_once '../../config/database.php';
include_once '../../models/User.php';

$data = json_decode(file_get_content("php://input"));

if (empty($data->name) || empty($data->pwd)) {
    http_response_code(400);
    echo json_decode(["message" => "Name and password required"]);
    exit;
}

$db = (new Database())->connect();
$user = new User($db);

$user->name = $data->name;
$row = $user->login();

if ($row && password_verify($data->pwd, $row['pwd'])) {
    echo json_encode([
        "message" => "Login successful",
        "user" => [
            "id" => $row["id"],
            "name" => $row["name"],
            "email" => $row["email"],
            "phone" => $row["phone"],
            "role" => $row["role"],
            "created_at" => $row["created_at"]
        ]
        ]);
} else {
    http_response_code(401);
    echo json_encode(["message" => "Invalid credentials"]);
}



