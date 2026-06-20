<?php

include("../db.php");

$query = pg_query($conn, "

    SELECT

        t.topic_id,
        t.topic_name,
        t.subject_id,

        s.subject_name

    FROM topics t

    JOIN subjects s
    ON t.subject_id = s.subject_id

    ORDER BY t.topic_id ASC

");

$topics = [];

while ($row = pg_fetch_assoc($query)) {

    $topics[] = $row;
}

echo json_encode($topics);

?>