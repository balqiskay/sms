<?php

include("../db.php");

$user_id = $_GET["user_id"];
$subject_id = $_GET["subject_id"];

$query = pg_query($conn, "

    SELECT *
    FROM subject_diagnostic
    WHERE user_id = $user_id
    AND subject_id = $subject_id

");

if (pg_num_rows($query) > 0) {

    echo json_encode([
        "done" => true
    ]);

} else {

    echo json_encode([
        "done" => false
    ]);
}

?>