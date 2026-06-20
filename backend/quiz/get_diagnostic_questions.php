<?php

include("../db.php");

$subject_id =
    $_GET["subject_id"];

// GET DIAGNOSTIC QUESTIONS
$query = pg_query($conn, "

    SELECT

        q.question_id,
        q.topic_id,

        q.question_text,

        q.option_a,
        q.option_b,
        q.option_c,
        q.option_d

    FROM questions q

    JOIN topics t
    ON q.topic_id = t.topic_id

    WHERE
        q.is_diagnostic = TRUE
        AND t.subject_id = $subject_id

    ORDER BY RANDOM()

    LIMIT 10

");

$questions = [];

while ($row = pg_fetch_assoc($query)) {

    $questions[] = $row;
}

echo json_encode($questions);

?>