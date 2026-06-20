<?php

include("../db.php");

$data = json_decode(file_get_contents("php://input"), true);

$user_id = $data["user_id"];
$topic_id = $data["topic_id"];

// Check if progress row exists
$check = pg_query($conn, "
    SELECT progress_id
    FROM learning_progress
    WHERE user_id = $user_id
    AND topic_id = $topic_id
");

if (pg_num_rows($check) > 0) {

    $query = pg_query($conn, "
        UPDATE learning_progress
        SET last_opened = CURRENT_TIMESTAMP
        WHERE user_id = $user_id
        AND topic_id = $topic_id
    ");

} else {

    $query = pg_query($conn, "
        INSERT INTO learning_progress
        (
            user_id,
            topic_id,
            last_section,
            progress_percent,
            last_opened
        )
        VALUES
        (
            $user_id,
            $topic_id,
            0,
            0,
            CURRENT_TIMESTAMP
        )
    ");
}

if ($query) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "failed"]);
}

?>