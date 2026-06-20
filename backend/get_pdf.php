<?php
include('db.php');

$topic_id = $_GET['topic_id'] ?? 0;

$q = pg_query($conn, "
    SELECT file_data 
    FROM notes 
    WHERE topic_id = $topic_id 
    AND file_data IS NOT NULL
    LIMIT 1
");

if (!$q) {
    echo "Query failed";
    exit;
}

$row = pg_fetch_assoc($q);

if (!$row || !$row['file_data']) {
    echo "No PDF found";
    exit;
}

// IMPORTANT HEADERS
header("Content-Type: application/pdf");
header("Content-Disposition: inline; filename=notes.pdf");

echo pg_unescape_bytea($row['file_data']);
?>