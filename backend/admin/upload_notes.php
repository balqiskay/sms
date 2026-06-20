<?php

include("../db.php");

// GET DATA
$topic_id =
    $_POST["topic_id"];

// CHECK FILE
if (!isset($_FILES["pdf"])) {

    echo json_encode([
        "status" => "no_file"
    ]);

    exit;
}

// FILE DATA
$pdfData =
    file_get_contents(
        $_FILES["pdf"]["tmp_name"]
    );

// ESCAPE BYTEA
$pdfData =
    pg_escape_bytea($pdfData);

// CHECK EXISTING
$check = pg_query($conn, "

    SELECT note_id

    FROM notes

    WHERE topic_id = $topic_id

");

// UPDATE EXISTING
if (pg_num_rows($check) > 0) {

    $query = pg_query($conn, "

        UPDATE notes

        SET file_data = '$pdfData'

        WHERE topic_id = $topic_id

    ");

}

// INSERT NEW
else {

    $query = pg_query($conn, "

        INSERT INTO notes

        (
            topic_id,
            file_data
        )

        VALUES

        (
            $topic_id,
            '$pdfData'
        )

    ");
}

// RESPONSE
if ($query) {

    echo json_encode([
        "status" => "success"
    ]);

} else {

    echo json_encode([
        "status" => "failed"
    ]);
}

?>