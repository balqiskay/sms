<?php

include("../db.php");

$subject_id = $_GET["subject_id"];

$query = pg_query($conn, "

    SELECT
        topic_id,
        topic_name

    FROM topics

    WHERE subject_id = $subject_id

    ORDER BY topic_id ASC

");

$topics = [];

while ($row = pg_fetch_assoc($query)) {
    $topics[] = $row;
}

echo json_encode($topics);

?>