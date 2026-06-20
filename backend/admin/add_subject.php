<?php

include("../db.php");

$data = json_decode(
    file_get_contents("php://input"),
    true
);

// GET DATA
$subject_name =
    trim($data["subject_name"]);

// VALIDATION
if ($subject_name == "") {

    echo json_encode([
        "status" => "empty"
    ]);

    exit;
}

// INSERT
$query = pg_query($conn, "

    INSERT INTO subjects
    (
        subject_name
    )

    VALUES

    (
        '$subject_name'
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