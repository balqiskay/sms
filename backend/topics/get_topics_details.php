<?php

include("../db.php");

// GET TOPIC ID
$topic_id =
    $_GET["topic_id"];

// QUERY
$query = pg_query($conn, "

    SELECT *

    FROM topics

    WHERE topic_id = $topic_id

");

// RESPONSE
if ($row = pg_fetch_assoc($query)) {

    echo json_encode($row);

} else {

    echo json_encode([
        "status" => "not_found"
    ]);
}

?>