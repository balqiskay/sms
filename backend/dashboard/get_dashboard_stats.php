<?php

include("../db.php");

// GET USER ID
$user_id = $_GET["user_id"] ?? null;

if (!$user_id) {
    echo json_encode([
        "status" => "error",
        "message" => "Missing user_id"
    ]);
    exit;
}

// TOTAL TOPICS
$total_query = pg_query($conn, "

    SELECT COUNT(*) AS total_topics

    FROM topics

");

$total_row =
    pg_fetch_assoc($total_query);

$total_topics =
    (int)$total_row['total_topics'];

// COMPLETED TOPICS
$completed_query = pg_query($conn, "

    SELECT COUNT(*) AS completed

    FROM learning_progress

    WHERE user_id = $user_id
    AND progress_percent = 100

");

$completed_row =
    pg_fetch_assoc($completed_query);

$completed_topics =
    (int)$completed_row['completed'];

// OVERALL PROGRESS
if ($total_topics > 0) {

    $overall_progress =
        round(
            ($completed_topics / $total_topics) * 100
        );

} else {

    $overall_progress = 0;
}

// RESPONSE
echo json_encode([

    "total_topics" =>
        $total_topics,

    "completed_topics" =>
        $completed_topics,

    "avg_progress" =>
        $overall_progress

]);

?>