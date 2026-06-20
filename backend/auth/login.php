<?php
include('../db.php');

$email = $_POST['email'];
$password = $_POST['password'];

$result = pg_query($conn, "SELECT * FROM users WHERE email='$email'");

$user = pg_fetch_assoc($result);

if ($user && password_verify($password, $user['password'])) {

    echo json_encode([
        "status"=>"success",
        "user_id"=>$user['user_id'],
        "name"=>$user['name'],
        "role" =>$user['role'],
        "diagnostic_done" =>$user["diagnostic_done"]
    ]);

} else {
    echo json_encode(["status"=>"error","message"=>"Invalid login"]);
}
?>