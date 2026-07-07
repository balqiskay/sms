<?php

include('../db.php');

header("Content-Type: application/json");

$email =
    trim($_POST['email'] ?? '');

$password =
    $_POST['password'] ?? '';

if ($email == "" || $password == "") {

    echo json_encode([
        "status" => "error",
        "type" => "empty",
        "message" => "Please enter your email and password."
    ]);

    exit;
}

$result = pg_query_params(
    $conn,
    "SELECT * FROM users WHERE email = $1",
    [$email]
);

$user =
    pg_fetch_assoc($result);

if (!$user) {

    echo json_encode([
        "status" => "error",
        "type" => "email_not_found",
        "message" => "No account found with this email address. Please register first."
    ]);

    exit;
}

if (!password_verify($password, $user['password'])) {

    echo json_encode([
        "status" => "error",
        "type" => "wrong_password",
        "message" => "Incorrect password. Please try again."
    ]);

    exit;
}

$roleMessage =
    $user["role"] === "admin"
    ? "Login successful! Welcome back, Administrator."
    : "Login successful! Welcome back, Student.";

echo json_encode([
    "status" => "success",
    "message" => $roleMessage,
    "user_id" => $user['user_id'],
    "name" => $user['name'],
    "role" => $user['role'],
    "diagnostic_done" => $user["diagnostic_done"] ?? false
]);

?>