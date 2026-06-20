<?php

include('../db.php');

$subject_id = $_GET['subject_id'];
$user_id = $_GET['user_id'];

$result = pg_query($conn, "

    SELECT

        t.*,

        COALESCE(
            lp.progress_percent,
            0
        ) AS progress_percent

    FROM topics t

    LEFT JOIN learning_progress lp
    ON t.topic_id = lp.topic_id
    AND lp.user_id = $user_id

    WHERE t.subject_id = $subject_id

    ORDER BY t.topic_id

");

$data = [];

while ($row = pg_fetch_assoc($result)) {

    $data[] = $row;
}

echo json_encode($data);

?>