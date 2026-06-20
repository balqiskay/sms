<?php
include('../db.php');

$name = $_POST['name'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// check if email exists
$check = pg_query($conn, "SELECT * FROM users WHERE email='$email'");

if (pg_num_rows($check) > 0) {
    echo json_encode(["status"=>"error","message"=>"Email already exists"]);
    exit;
}

// insert user
$query = "INSERT INTO users (name, email, password, role) 
          VALUES ('$name', '$email', '$password', 'student')";

$result = pg_query($conn, $query);

if ($result) {
    echo json_encode(["status"=>"success"]);
} else {
    echo json_encode(["status"=>"error"]);
}
?>