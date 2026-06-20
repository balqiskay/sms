<?php

include("../db.php");

$query = pg_query($conn, "

    SELECT
        n.note_id,
        n.topic_id,
        t.topic_name

    FROM notes n

    JOIN topics t
    ON n.topic_id = t.topic_id

    WHERE n.file_data IS NOT NULL

    ORDER BY n.note_id ASC

");

$notes = [];

while ($row = pg_fetch_assoc($query)) {
    $notes[] = $row;
}

echo json_encode($notes);

?>