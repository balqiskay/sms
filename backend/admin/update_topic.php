<?php

include("../db.php");

$data = json_decode(file_get_contents("php://input"), true);

$topic_id = $data["topic_id"];
$topic_name = pg_escape_string($conn, trim($data["topic_name"]));
$subject_id = $data["subject_id"];

if ($topic_name == "") {
    echo json_encode(["status" => "empty"]);
    exit;
}

$query = pg_query($conn, "
    UPDATE topics
    SET
        topic_name = '$topic_name',
        subject_id = $subject_id
    WHERE topic_id = $topic_id
");

if ($query) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "failed"]);
}

?>