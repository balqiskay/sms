<?php
include('../db.php');

// total attempts
$total_attempts = pg_fetch_result(
    pg_query($conn, "SELECT COUNT(*) FROM quiz_attempt"), 
    0, 0
);

// average score
$avg_score = pg_fetch_result(
    pg_query($conn, "SELECT AVG(score) FROM quiz_attempt"), 
    0, 0
);

// top topic (JOIN to get name)
$top_topic = pg_query($conn, "
    SELECT t.topic_name, COUNT(*) as total 
    FROM quiz_attempt qa
    JOIN topics t ON qa.topic_id = t.topic_id
    GROUP BY t.topic_name
    ORDER BY total DESC 
    LIMIT 1
");

$top = pg_fetch_assoc($top_topic);

// weak topics
$weak = pg_query($conn, "
    SELECT t.topic_name, AVG(qa.score) as avg_score
    FROM quiz_attempt qa
    JOIN topics t ON qa.topic_id = t.topic_id
    GROUP BY t.topic_name
    ORDER BY avg_score ASC
    LIMIT 3
");

$weak_topics = [];

while ($row = pg_fetch_assoc($weak)) {
    $weak_topics[] = $row;
}

echo json_encode([
    "total_attempts" => $total_attempts,
    "avg_score" => round($avg_score,2),
    "top_topic" => $top,
    "weak_topics" => $weak_topics
]);
?>