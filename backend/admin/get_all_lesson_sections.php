<?php

include("../db.php");

$query = pg_query($conn, "

    SELECT
        ls.section_id,
        ls.topic_id,
        ls.section_no,
        ls.title,
        ls.explanation,
        ls.example_text,
        ls.tip_text,
        ls.warning_text,
        ls.activity_text,
        t.topic_name

    FROM lesson_sections ls

    JOIN topics t
    ON ls.topic_id = t.topic_id

    ORDER BY ls.topic_id ASC, ls.section_no ASC

");

$sections = [];

while ($row = pg_fetch_assoc($query)) {
    $sections[] = $row;
}

echo json_encode($sections);

?>