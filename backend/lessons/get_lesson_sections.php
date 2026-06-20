<?php

include("../db.php");

$topic_id = $_GET["topic_id"];

$query = pg_query($conn, "

    SELECT *
    FROM lesson_sections
    WHERE topic_id = $topic_id
    ORDER BY section_no ASC

");

$sections = [];

while ($row = pg_fetch_assoc($query)) {
    $sections[] = $row;
}

echo json_encode($sections);

?>