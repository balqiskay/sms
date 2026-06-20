<?php

include("../db.php");

$data = json_decode(
    file_get_contents("php://input"),
    true
);

// GET DATA
$topic_id =
    $data["topic_id"];

$question =
    pg_escape_string(
        $conn,
        $data["question_text"]
    );

$option_a =
    pg_escape_string(
        $conn,
        $data["option_a"]
    );

$option_b =
    pg_escape_string(
        $conn,
        $data["option_b"]
    );

$option_c =
    pg_escape_string(
        $conn,
        $data["option_c"]
    );

$option_d =
    pg_escape_string(
        $conn,
        $data["option_d"]
    );

$correct =
    strtoupper(
        $data["correct_answer"]
    );

$is_diagnostic =
    !empty($data["is_diagnostic"])
    ? "TRUE"
    : "FALSE";

// INSERT
$query = pg_query($conn, "

    INSERT INTO questions

    (
        topic_id,
        question_text,
        option_a,
        option_b,
        option_c,
        option_d,
        correct_answer,
        is_diagnostic
    )

    VALUES

    (
        $topic_id,

        '$question',

        '$option_a',
        '$option_b',
        '$option_c',
        '$option_d',

        '$correct',

        $is_diagnostic
    )

");

// RESPONSE
if ($query) {

    echo json_encode([
        "status" => "success"
    ]);

} else {

    echo json_encode([
        "status" => "failed",
        "error" => pg_last_error($conn)
    ]);
}

?>