<?php

include("../db.php");

$data = json_decode(file_get_contents("php://input"), true);

$question_id = $data["question_id"];

// Delete related answers first
pg_query($conn, "
    DELETE FROM attempt_answers
    WHERE question_id = $question_id
");

// Then delete question
$query = pg_query($conn, "
    DELETE FROM questions
    WHERE question_id = $question_id
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