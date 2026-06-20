<?php

include("../db.php");

$data = json_decode(file_get_contents("php://input"), true);

$section_id = $data["section_id"];
$section_no = $data["section_no"];

$title = pg_escape_string($conn, trim($data["title"]));
$explanation = pg_escape_string($conn, trim($data["explanation"]));
$example_text = pg_escape_string($conn, trim($data["example_text"]));
$tip_text = pg_escape_string($conn, trim($data["tip_text"]));
$warning_text = pg_escape_string($conn, trim($data["warning_text"]));
$activity_text = pg_escape_string($conn, trim($data["activity_text"]));

$query = pg_query($conn, "

    UPDATE lesson_sections

    SET
        section_no = $section_no,
        title = '$title',
        explanation = '$explanation',
        example_text = '$example_text',
        tip_text = '$tip_text',
        warning_text = '$warning_text',
        activity_text = '$activity_text'

    WHERE section_id = $section_id

");

if ($query) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode([
        "status" => "failed",
        "error" => pg_last_error($conn)
    ]);
}

?>