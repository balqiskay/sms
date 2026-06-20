<?php

include("../db.php");

$query = pg_query($conn, "

    SELECT
        q.question_id,
        q.topic_id,
        q.question_text,
        q.option_a,
        q.option_b,
        q.option_c,
        q.option_d,
        q.correct_answer,
        t.topic_name

    FROM questions q

    JOIN topics t
    ON q.topic_id = t.topic_id

    ORDER BY q.question_id ASC

");

$questions = [];

while ($row = pg_fetch_assoc($query)) {
    $questions[] = $row;
}

echo json_encode($questions);

?>