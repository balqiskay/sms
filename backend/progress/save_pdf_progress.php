<?php

include("../db.php");

$data = json_decode(file_get_contents("php://input"), true);

$user_id = $data["user_id"];
$topic_id = $data["topic_id"];

$last_page = $data["last_page"];
$total_pages = $data["total_pages"];

// CHECK EXISTING
$check = pg_query($conn, "

    SELECT
        highest_page

    FROM learning_progress

    WHERE user_id = $user_id
    AND topic_id = $topic_id

");

if (pg_num_rows($check) > 0) {

    $row = pg_fetch_assoc($check);

    $highest_page =
        max(
            $last_page,
            $row["highest_page"]
        );

} else {

    $highest_page = $last_page;
}

// CALCULATE PROGRESS
$progress_percent = round(
    ($highest_page / $total_pages) * 100
);

// UPDATE EXISTING
if (pg_num_rows($check) > 0) {

    $query = pg_query($conn, "

        UPDATE learning_progress

        SET

            last_page = $last_page,

            highest_page = $highest_page,

            total_pages = $total_pages,

            progress_percent = $progress_percent,

            last_opened = CURRENT_TIMESTAMP

        WHERE user_id = $user_id
        AND topic_id = $topic_id

    ");

}

// INSERT NEW
else {

    $query = pg_query($conn, "

        INSERT INTO learning_progress
        (
            user_id,
            topic_id,
            last_section,
            progress_percent,
            last_page,
            highest_page,
            total_pages,
            last_opened
        )

        VALUES
        (
            $user_id,
            $topic_id,
            0,
            $progress_percent,
            $last_page,
            $highest_page,
            $total_pages,
            CURRENT_TIMESTAMP
        )

    ");
}

if ($query) {

    echo json_encode([
        "status" => "success"
    ]);

} else {

    echo json_encode([
        "status" => "failed",
        "error" => pg_last_error($conn)
    ]);
}

?>