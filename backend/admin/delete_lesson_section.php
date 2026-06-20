<?php

include("../db.php");

$data = json_decode(file_get_contents("php://input"), true);

$section_id = $data["section_id"];

$query = pg_query($conn, "

    DELETE FROM lesson_sections
    WHERE section_id = $section_id

");

if ($query) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode([
        "status" => "failed",
        "error" => pg_last_error($conn)
    ]);
}

?>