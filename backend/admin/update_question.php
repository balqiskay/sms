<?php

include("../db.php");

$data = json_decode(file_get_contents("php://input"), true);

$question_id = $data["question_id"];

$question_text = pg_escape_string($conn, trim($data["question_text"]));
$option_a = pg_escape_string($conn, trim($data["option_a"]));
$option_b = pg_escape_string($conn, trim($data["option_b"]));
$option_c = pg_escape_string($conn, trim($data["option_c"]));
$option_d = pg_escape_string($conn, trim($data["option_d"]));
$correct_answer = strtoupper(trim($data["correct_answer"]));

$query = pg_query($conn, "

    UPDATE questions

    SET
        question_text = '$question_text',
        option_a = '$option_a',
        option_b = '$option_b',
        option_c = '$option_c',
        option_d = '$option_d',
        correct_answer = '$correct_answer'

    WHERE question_id = $question_id

");

if ($query) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "failed"]);
}

?>