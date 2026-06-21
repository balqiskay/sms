<?php

include("../db.php");

$data = json_decode(file_get_contents("php://input"), true);

$user_id =
    $data["user_id"];

$subject_id =
    $data["subject_id"];

$answers =
    $data["answers"];

$score = 0;

$total =
    count($answers);

$topic_scores = [];

foreach ($answers as $item) {

    $question_id =
        $item["question_id"];

    $selected =
        strtoupper(
            trim($item["answer"])
        );

    $q = pg_query($conn, "

        SELECT
            q.topic_id,
            q.correct_answer

        FROM questions q

        JOIN topics t
        ON q.topic_id = t.topic_id

        WHERE q.question_id = $question_id
        AND t.subject_id = $subject_id

    ");

    if (!$q || pg_num_rows($q) == 0) {
        continue;
    }

    $row =
        pg_fetch_assoc($q);

    $topic_id =
        $row["topic_id"];

    $correct =
        strtoupper(
            trim($row["correct_answer"])
        );

    if (!isset($topic_scores[$topic_id])) {

        $topic_scores[$topic_id] = [
            "correct" => 0,
            "total" => 0
        ];
    }

    $topic_scores[$topic_id]["total"]++;

    if ($selected === $correct) {

        $score++;

        $topic_scores[$topic_id]["correct"]++;
    }
}

// FIND WEAKEST TOPIC
$recommended_topic_id = null;

$lowest_percentage = 101;

foreach ($topic_scores as $topic_id => $result) {

    $topic_percentage =
        ($result["correct"] / $result["total"]) * 100;

    if ($topic_percentage < $lowest_percentage) {

        $lowest_percentage =
            $topic_percentage;

        $recommended_topic_id =
            $topic_id;
    }
}

// IF FULL MARKS, NO WEAK TOPIC
if ($score == $total) {

    $recommended_topic_id = null;
}

// LEVEL
$percentage =
    round(($score / $total) * 100);

if ($percentage >= 80) {

    $level = "Strong";

} else if ($percentage >= 50) {

    $level = "Good";

} else {

    $level = "Weak";
}

// HANDLE NULL RECOMMENDED TOPIC
if ($recommended_topic_id === null) {

    $recommended_topic_id_sql = "NULL";

} else {

    $recommended_topic_id_sql =
        $recommended_topic_id;
}

// DELETE OLD RECORD FOR SAME USER + SUBJECT
pg_query($conn, "

    DELETE FROM subject_diagnostic

    WHERE user_id = $user_id
    AND subject_id = $subject_id

");

// INSERT SUBJECT DIAGNOSTIC RESULT
$query = pg_query($conn, "

    INSERT INTO subject_diagnostic
    (
        user_id,
        subject_id,
        score,
        total,
        level,
        recommended_topic_id
    )

    VALUES
    (
        $user_id,
        $subject_id,
        $score,
        $total,
        '$level',
        $recommended_topic_id_sql
    )

");

$query = pg_query($conn, "

    INSERT INTO subject_diagnostic
    (
        user_id,
        subject_id,
        score,
        total,
        level,
        recommended_topic_id
    )

    VALUES
    (
        $user_id,
        $subject_id,
        $score,
        $total,
        '$level',
        $recommended_topic_id_sql
    )

");

if ($query) {

    echo json_encode([

        "status" => "success",
        "score" => $score,
        "total" => $total,
        "level" => $level,
        "recommended_topic_id" => $recommended_topic_id

    ]);

} else {

    echo json_encode([

        "status" => "failed",
        "error" => pg_last_error($conn)

    ]);
}

?>