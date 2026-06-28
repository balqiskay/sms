<?php

include('../db.php');

header("Content-Type: application/json");

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password_raw = $_POST['password'] ?? '';

if ($name == "" || $email == "" || $password_raw == "") {
    echo json_encode([
        "status" => "error",
        "message" => "Please fill in all required fields."
    ]);
    exit;
}

$password = password_hash($password_raw, PASSWORD_DEFAULT);

// CHECK IF EMAIL EXISTS
$check = pg_query_params(
    $conn,
    "SELECT user_id FROM users WHERE email = $1",
    [$email]
);

if (pg_num_rows($check) > 0) {
    echo json_encode([
        "status" => "error",
        "message" => "Email already exists. Please use another email."
    ]);
    exit;
}

// INSERT USER
$result = pg_query_params(
    $conn,
    "INSERT INTO users (name, email, password, role)
     VALUES ($1, $2, $3, 'student')",
    [$name, $email, $password]
);

if ($result) {
    echo json_encode([
        "status" => "success",
        "message" => "Registration successful!"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Registration failed. Please try again."
    ]);
}

?>