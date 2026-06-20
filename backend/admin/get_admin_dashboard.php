<?php

include("../db.php");

// TOTAL STUDENTS
$students_query = pg_query($conn, "

    SELECT COUNT(*) AS total_students

    FROM users

");

$students =
    pg_fetch_assoc($students_query);

// TOTAL SUBJECTS
$subjects_query = pg_query($conn, "

    SELECT COUNT(*) AS total_subjects

    FROM subjects

");

$subjects =
    pg_fetch_assoc($subjects_query);

// TOTAL TOPICS
$topics_query = pg_query($conn, "

    SELECT COUNT(*) AS total_topics

    FROM topics

");

$topics =
    pg_fetch_assoc($topics_query);

// TOTAL QUIZ ATTEMPTS
$attempts_query = pg_query($conn, "

    SELECT COUNT(*) AS total_attempts

    FROM quiz_attempt

");

$attempts =
    pg_fetch_assoc($attempts_query);

// AVERAGE SCORE
$avg_query = pg_query($conn, "

    SELECT AVG(score) AS avg_score

    FROM quiz_attempt

");

$avg =
    pg_fetch_assoc($avg_query);

// WEAK TOPIC
$weak_query = pg_query($conn, "

    SELECT
        t.topic_name,
        AVG(q.score) AS avg_score

    FROM quiz_attempt q

    JOIN topics t
    ON q.topic_id = t.topic_id

    GROUP BY t.topic_name

    ORDER BY avg_score ASC

    LIMIT 1

");

$weak_topic =
    pg_fetch_assoc($weak_query);

// TOP TOPIC
$top_query = pg_query($conn, "

    SELECT
        t.topic_name,
        AVG(q.score) AS avg_score

    FROM quiz_attempt q

    JOIN topics t
    ON q.topic_id = t.topic_id

    GROUP BY t.topic_name

    ORDER BY avg_score DESC

    LIMIT 1

");

$top_topic =
    pg_fetch_assoc($top_query);

// RESPONSE
echo json_encode([

    "total_students" =>
        $students["total_students"],

    "total_subjects" =>
        $subjects["total_subjects"],

    "total_topics" =>
        $topics["total_topics"],

    "total_attempts" =>
        $attempts["total_attempts"],

    "avg_score" =>
        round($avg["avg_score"] ?? 0),

    "weak_topic" =>
        $weak_topic,

    "top_topic" =>
        $top_topic

]);

?>