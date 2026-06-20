<?php

include("../db.php");

$user_id = $_GET["user_id"];

$query = pg_query($conn, "

    SELECT
        s.subject_id,
        s.subject_name,

        COUNT(t.topic_id) AS total_topics,

        COALESCE(
            SUM(
                CASE
                    WHEN lp.progress_percent = 100 THEN 1
                    ELSE 0
                END
            ),
            0
        ) AS completed_topics

    FROM subjects s

    LEFT JOIN topics t
    ON s.subject_id = t.subject_id

    LEFT JOIN learning_progress lp
    ON t.topic_id = lp.topic_id
    AND lp.user_id = $user_id

    GROUP BY s.subject_id, s.subject_name

    ORDER BY s.subject_id ASC

");

$data = [];

while ($row = pg_fetch_assoc($query)) {

    $total = (int)$row["total_topics"];
    $completed = (int)$row["completed_topics"];

    if ($total > 0) {
        $progress = round(($completed / $total) * 100);
    } else {
        $progress = 0;
    }

    $row["progress_percent"] = $progress;

    $data[] = $row;
}

echo json_encode($data);

?>