<?php

include("../db.php");

function getCount($conn, $sql) {

    $query = pg_query($conn, $sql);

    if (!$query) {
        return 0;
    }

    $row = pg_fetch_assoc($query);

    return (int)$row["total"];
}

// COUNTS
$students = getCount($conn, "
    SELECT COUNT(*) AS total
    FROM users
    WHERE role = 'student'
");

$subjects = getCount($conn, "
    SELECT COUNT(*) AS total
    FROM subjects
");

$topics = getCount($conn, "
    SELECT COUNT(*) AS total
    FROM topics
");

$sections = getCount($conn, "
    SELECT COUNT(*) AS total
    FROM lesson_sections
");

$questions = getCount($conn, "
    SELECT COUNT(*) AS total
    FROM questions
");

$diagnostic_questions = getCount($conn, "
    SELECT COUNT(*) AS total
    FROM questions
    WHERE is_diagnostic = TRUE
");

$attempts = getCount($conn, "
    SELECT COUNT(*) AS total
    FROM quiz_attempt
");

$pdf_notes = getCount($conn, "
    SELECT COUNT(*) AS total
    FROM notes
");

// AVERAGE PROGRESS
$progress_query = pg_query($conn, "
    SELECT AVG(progress_percent) AS avg_progress
    FROM learning_progress
");

$progress_row = pg_fetch_assoc($progress_query);

$avg_progress =
    round($progress_row["avg_progress"] ?? 0);

// AVERAGE SCORE
$score_query = pg_query($conn, "
    SELECT AVG(score) AS avg_score
    FROM quiz_attempt
");

$score_row = pg_fetch_assoc($score_query);

$avg_score =
    round($score_row["avg_score"] ?? 0);

// COUNT TOPICS WITH QUIZ ATTEMPTS
$topic_attempt_count_query = pg_query($conn, "

    SELECT COUNT(*) AS total

    FROM (

        SELECT topic_id

        FROM quiz_attempt

        GROUP BY topic_id

        HAVING COUNT(*) >= 3

    ) AS attempted_topics

");

$topic_attempt_count_row =
    pg_fetch_assoc($topic_attempt_count_query);

$topics_with_enough_attempts =
    (int)$topic_attempt_count_row["total"];

// BEST TOPIC
$best_query = pg_query($conn, "

    SELECT
        t.topic_name,
        AVG(qa.score) AS avg_score,
        COUNT(*) AS total_attempts

    FROM quiz_attempt qa

    JOIN topics t
    ON qa.topic_id = t.topic_id

    GROUP BY t.topic_name

    HAVING COUNT(*) >= 3

    ORDER BY avg_score DESC

    LIMIT 1

");

// DEFAULT VALUES
$best_topic =
    "Insufficient data";

$weak_topic =
    "Insufficient data";

// ONLY COMPARE IF AT LEAST 2 TOPICS HAVE ENOUGH ATTEMPTS
if ($topics_with_enough_attempts >= 2) {

    // BEST TOPIC
    $best_query = pg_query($conn, "

        SELECT
            t.topic_name,
            AVG(qa.score) AS avg_score,
            COUNT(*) AS total_attempts

        FROM quiz_attempt qa

        JOIN topics t
        ON qa.topic_id = t.topic_id

        GROUP BY t.topic_name

        HAVING COUNT(*) >= 3

        ORDER BY avg_score DESC

        LIMIT 1

    ");

    if ($best_query && pg_num_rows($best_query) > 0) {

        $best_topic =
            pg_fetch_assoc($best_query)["topic_name"];
    }

    // WEAKEST TOPIC
    $weak_query = pg_query($conn, "

        SELECT
            t.topic_name,
            AVG(qa.score) AS avg_score,
            COUNT(*) AS total_attempts

        FROM quiz_attempt qa

        JOIN topics t
        ON qa.topic_id = t.topic_id

        GROUP BY t.topic_name

        HAVING COUNT(*) >= 3

        ORDER BY avg_score ASC

        LIMIT 1

    ");

    if ($weak_query && pg_num_rows($weak_query) > 0) {

        $weak_topic =
            pg_fetch_assoc($weak_query)["topic_name"];
    }
}

echo json_encode([

    "students" => $students,
    "subjects" => $subjects,
    "topics" => $topics,
    "topics_with_enough_attempts" => $topics_with_enough_attempts,
    "sections" => $sections,
    "questions" => $questions,
    "diagnostic_questions" => $diagnostic_questions,
    "pdf_notes" => $pdf_notes,
    "attempts" => $attempts,
    "avg_progress" => $avg_progress,
    "avg_score" => $avg_score,
    "best_topic" => $best_topic,
    "weak_topic" => $weak_topic
    
]);

?>