<?php
include('../db.php');

$result = pg_query($conn, "SELECT * FROM subjects ORDER BY subject_id");

$data = [];

while ($row = pg_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data);
?>