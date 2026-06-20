<?php

include("../db.php");

// GET STUDENTS
$query = pg_query($conn, "

    SELECT

        u.user_id,
        u.name,
        u.email,

        COALESCE(
            ROUND(AVG(lp.progress_percent)),
            0
        ) AS avg_progress,

        COUNT(
            CASE
                WHEN lp.progress_percent = 100
                THEN 1
            END
        ) AS completed_topics,

        COALESCE(
            ROUND(AVG(qa.score)),
            0
        ) AS avg_score

    FROM users u

    LEFT JOIN learning_progress lp
    ON u.user_id = lp.user_id

    LEFT JOIN quiz_attempt qa
    ON u.user_id = qa.user_id

    GROUP BY
        u.user_id,
        u.name,
        u.email

    ORDER BY u.user_id ASC

");

// STORE RESULTS
$students = [];

while ($row = pg_fetch_assoc($query)) {

    $students[] = $row;
}

// RESPONSE
echo json_encode($students);

?>