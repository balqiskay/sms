<?php

include("../db.php");

$data = json_decode(file_get_contents("php://input"), true);

$topic_id = $data["topic_id"];

$query = pg_query($conn, "
    DELETE FROM topics
    WHERE topic_id = $topic_id
");

if ($query) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "failed"]);
}

?>