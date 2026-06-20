<?php
include('../db.php');

$topic_id = $_GET['topic_id'];

$result = pg_query($conn, "
    SELECT question_id, question_text, option_a, option_b, option_c, option_d 
    FROM questions 
    WHERE topic_id = $topic_id
");

$data = [];

while ($row = pg_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data);
?>