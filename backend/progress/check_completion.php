<?php

include("../db.php");

$data = json_decode(
    file_get_contents("php://input"),
    true
);

$user_id =
    $data["user_id"];

$topic_id =
    $data["topic_id"];

// GET PROGRESS
$progress_q = pg_query(

    $conn,

    "
    SELECT
        progress_percent

    FROM learning_progress

    WHERE user_id = $user_id
    AND topic_id = $topic_id

    ORDER BY progress_id DESC

    LIMIT 1
    "
);

$progress = 0;

if (pg_num_rows($progress_q) > 0) {

    $row =
        pg_fetch_assoc($progress_q);

    $progress =
        (int)$row["progress_percent"];
}

// GET BEST QUIZ SCORE
$quiz_q = pg_query(

    $conn,

    "
    SELECT
        MAX(score) AS best_score

    FROM quiz_attempt

    WHERE user_id = $user_id
    AND topic_id = $topic_id
    "
);

$best_score = 0;

if (pg_num_rows($quiz_q) > 0) {

    $row =
        pg_fetch_assoc($quiz_q);

    $best_score =
        (int)$row["best_score"];
}

// DETERMINE STATUS
$status = "in_progress";

if (
    $progress >= 80
    &&
    $best_score >= 70
) {

    $status = "mastered";
}

// CHECK EXISTING
$check = pg_query(

    $conn,

    "
    SELECT *
    FROM topic_completion

    WHERE user_id = $user_id
    AND topic_id = $topic_id
    "
);

// UPDATE
if (pg_num_rows($check) > 0) {

    pg_query(

        $conn,

        "
        UPDATE topic_completion

        SET status = '$status'

        WHERE user_id = $user_id
        AND topic_id = $topic_id
        "
    );
}

// INSERT
else {

    pg_query(

        $conn,

        "
        INSERT INTO topic_completion
        (
            user_id,
            topic_id,
            status
        )

        VALUES
        (
            $user_id,
            $topic_id,
            '$status'
        )
        "
    );
}

// RESPONSE
echo json_encode([

    "status" => $status,

    "progress" => $progress,

    "best_score" => $best_score
]);

?>