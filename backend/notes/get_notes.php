<?php
include('../db.php');

$topic_id = $_GET['topic_id'];

$result = pg_query($conn, "
    SELECT * FROM notes 
    WHERE topic_id = $topic_id 
    ORDER BY section_no
");

$data = [];

while ($row = pg_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data);
?>