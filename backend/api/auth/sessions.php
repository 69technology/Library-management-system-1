<?php

if ($_SESSION["user"]["role"] !== "admin") {
    http_response_code(403);
    echo json_encode(["message" => "Admins only"]);
    exit;
}
