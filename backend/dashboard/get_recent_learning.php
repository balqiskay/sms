<?php

include("../db.php");

$user_id = $_GET["user_id"];
$days = $_GET["days"] ?? 0;

// FILTER CONDITION
$filter = "";

if ($days > 0) {

    $filter = "
        AND lp.last_opened >=
        CURRENT_TIMESTAMP - INTERVAL '$days days'
    ";
}

$query = pg_query($conn, "

    SELECT

        lp.topic_id,
        lp.progress_percent,
        lp.last_opened,

        t.topic_name,

        s.subject_name

    FROM learning_progress lp

    JOIN topics t
    ON lp.topic_id = t.topic_id

    JOIN subjects s
    ON t.subject_id = s.subject_id

    WHERE lp.user_id = $user_id

    $filter

    ORDER BY lp.last_opened DESC

");

$recent = [];

while ($row = pg_fetch_assoc($query)) {

    $recent[] = $row;
}

echo json_encode($recent);

?>