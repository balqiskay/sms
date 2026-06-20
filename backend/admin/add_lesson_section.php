<?php

include("../db.php");

$data = json_decode(file_get_contents("php://input"), true);

$topic_id = $data["topic_id"];
$section_no = $data["section_no"];
$title = pg_escape_string($conn, $data["title"]);
$explanation = pg_escape_string($conn, $data["explanation"]);
$example_text = pg_escape_string($conn, $data["example_text"]);
$tip_text = pg_escape_string($conn, $data["tip_text"]);
$warning_text = pg_escape_string($conn, $data["warning_text"]);
$activity_text = pg_escape_string($conn, $data["activity_text"]);

$query = pg_query($conn, "
    INSERT INTO lesson_sections
    (
        topic_id,
        section_no,
        title,
        explanation,
        example_text,
        tip_text,
        warning_text,
        activity_text
    )
    VALUES
    (
        $topic_id,
        $section_no,
        '$title',
        '$explanation',
        '$example_text',
        '$tip_text',
        '$warning_text',
        '$activity_text'
    )
");

if ($query) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "failed"]);
}

?>