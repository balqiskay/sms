<?php

include("../db.php");

$query = pg_query($conn, "

    SELECT

        t.topic_id,
        t.topic_name,

        COALESCE(
            ROUND(AVG(lp.progress_percent)),
            0
        ) AS avg_progress

    FROM topics t

    LEFT JOIN learning_progress lp
    ON t.topic_id = lp.topic_id

    GROUP BY
        t.topic_id,
        t.topic_name

    ORDER BY
        t.topic_id ASC

");

$data = [];

while ($row = pg_fetch_assoc($query)) {
    $data[] = $row;
}

echo json_encode($data);

?>