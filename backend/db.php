<?php

$host = getenv("PGHOST") ?: "localhost";
$dbname = getenv("PGDATABASE") ?: "sms";
$user = getenv("PGUSER") ?: "postgres";
$password = getenv("PGPASSWORD") ?: "postgres123";
$port = getenv("PGPORT") ?: "5432";

$conn = pg_connect("
    host=$host
    port=$port
    dbname=$dbname
    user=$user
    password=$password
");

if (!$conn) {
    die(json_encode([
        "status" => "error",
        "message" => "Database connection failed"
    ]));
}
?>