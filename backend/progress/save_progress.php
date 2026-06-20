<?php
include('../db.php');

$data = json_decode(
    file_get_contents("php://input"),
    true
);

$user_id = $data['user_id'];
$topic_id = $data['topic_id'];
$section_no = $data['section_no'];

$total_sections = 8;

// calculate %
$progress_percent =
    round(($section_no / $total_sections) * 100);

$check = pg_query($conn, "

    SELECT *

    FROM learning_progress

    WHERE user_id = $user_id
    AND topic_id = $topic_id

");

// update learning progress
if (pg_num_rows($check) > 0) {

    $query = pg_query($conn, "

        UPDATE learning_progress

        SET

            last_section = $section_no,

            progress_percent = $progress_percent

        WHERE user_id = $user_id
        AND topic_id = $topic_id

    ");

}
else {

    $query = pg_query($conn, "

        INSERT INTO learning_progress
        (
            user_id,
            topic_id,
            last_section,
            progress_percent
        )

        VALUES
        (
            $user_id,
            $topic_id,
            $section_no,
            $progress_percent
        )

    ");

}


if ($query) {

    echo json_encode([
        "status" => "success"
    ]);

}
else {

    echo json_encode([
        "status" => "failed",
        "error" => pg_last_error($conn)
    ]);

}

?>