<?php

include("../db.php");

$data = json_decode(file_get_contents("php://input"), true);

$subject_id = $data["subject_id"];

$query = pg_query($conn, "
    DELETE FROM subjects
    WHERE subject_id = $subject_id
");

if ($query) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "failed"]);
}

?>