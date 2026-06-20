<?php

include("../db.php");

$data = json_decode(file_get_contents("php://input"), true);

$subject_id = $data["subject_id"];
$subject_name = pg_escape_string($conn, trim($data["subject_name"]));

if ($subject_name == "") {
    echo json_encode(["status" => "empty"]);
    exit;
}

$query = pg_query($conn, "
    UPDATE subjects
    SET subject_name = '$subject_name'
    WHERE subject_id = $subject_id
");

if ($query) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "failed"]);
}

?>