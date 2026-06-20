<?php

include("../db.php");

$topic_id = $_GET["topic_id"];

$query = pg_query($conn, "

    SELECT subject_id
    FROM topics
    WHERE topic_id = $topic_id

");

$row = pg_fetch_assoc($query);

echo json_encode($row);

?>