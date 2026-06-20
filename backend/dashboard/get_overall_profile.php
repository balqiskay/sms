<?php

include("../db.php");

$user_id = $_GET["user_id"];

/* SUBJECTS STUDIED */

$subjects = pg_fetch_result(

    pg_query($conn, "

        SELECT COUNT(DISTINCT subject_id)

        FROM subject_diagnostic

        WHERE user_id = $user_id

    "),

    0,
    0

);

/* TOPICS COMPLETED */

$completed = pg_fetch_result(

    pg_query($conn, "

        SELECT COUNT(*)

        FROM learning_progress

        WHERE user_id = $user_id
        AND progress_percent = 100

    "),

    0,
    0

);

/* AVERAGE QUIZ SCORE */

$avg = pg_fetch_result(

    pg_query($conn, "

        SELECT COALESCE(
            ROUND(AVG(score)),
            0
        )

        FROM quiz_attempt

        WHERE user_id = $user_id

    "),

    0,
    0

);

/* STRONGEST TOPIC */

$strong = pg_query($conn, "

    SELECT

        t.topic_name,

        ROUND(AVG(q.score)) AS avg_score

    FROM quiz_attempt q

    JOIN topics t
    ON q.topic_id = t.topic_id

    WHERE q.user_id = $user_id

    GROUP BY t.topic_name

    ORDER BY avg_score DESC

    LIMIT 1

");

$strongTopic =
    pg_num_rows($strong) > 0

    ? pg_fetch_assoc($strong)

    : [
        "topic_name" => "-",
        "avg_score" => 0
    ];

/* WEAKEST TOPIC */

$weak = pg_query($conn, "

    SELECT

        t.topic_name,

        ROUND(AVG(q.score)) AS avg_score

    FROM quiz_attempt q

    JOIN topics t
    ON q.topic_id = t.topic_id

    WHERE q.user_id = $user_id

    GROUP BY t.topic_name

    ORDER BY avg_score ASC

    LIMIT 1

");

$weakTopic =
    pg_num_rows($weak) > 0

    ? pg_fetch_assoc($weak)

    : [
        "topic_name" => "-",
        "avg_score" => 0
    ];

/* CURRENT LEVEL */

$user = pg_fetch_assoc(

    pg_query($conn, "

        SELECT current_level

        FROM users

        WHERE user_id = $user_id

    ")

);

echo json_encode([

    "subjects_studied" => $subjects,

    "topics_completed" => $completed,

    "average_score" => $avg,

    "current_level" =>
        $user["current_level"],

    "strong_topic" =>
        $strongTopic["topic_name"],

    "strong_score" =>
        $strongTopic["avg_score"],

    "weak_topic" =>
        $weakTopic["topic_name"],

    "weak_score" =>
        $weakTopic["avg_score"]

]);

?>