<?php

include("../db.php");

$data = json_decode(
    file_get_contents("php://input"),
    true
);

// GET DATA
$subject_id =
    $data["subject_id"];

$topic_name =
    trim($data["topic_name"]);

// VALIDATION
if ($topic_name == "") {

    echo json_encode([
        "status" => "empty"
    ]);

    exit;
}

// INSERT
$query = pg_query($conn, "

    INSERT INTO topics
    (
        subject_id,
        topic_name
    )

    VALUES

    (
        $subject_id,
        '$topic_name'
    )

");

// RESPONSE
if ($query) {

    echo json_encode([
        "status" => "success"
    ]);

} else {

    echo json_encode([
        "status" => "failed"
    ]);
}

?>