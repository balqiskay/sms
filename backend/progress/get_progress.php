<?php

include('../db.php');

$data = json_decode(
    file_get_contents("php://input"),
    true
);

$user_id = $data["user_id"];
$topic_id = $data["topic_id"];

$query = pg_query($conn, "

    SELECT
        last_page,
        total_pages,
        progress_percent

    FROM learning_progress

    WHERE user_id = $user_id
    AND topic_id = $topic_id

    ORDER BY last_opened DESC

    LIMIT 1

");

if (pg_num_rows($query) > 0) {

    $row = pg_fetch_assoc($query);

    echo json_encode([

        "last_page" =>
            $row["last_page"],

        "total_pages" =>
            $row["total_pages"],

        "progress_percent" =>
            $row["progress_percent"]

    ]);

} else {

    echo json_encode([

        "last_page" => 1,
        "total_pages" => 1,
        "progress_percent" => 0

    ]);
}

?>