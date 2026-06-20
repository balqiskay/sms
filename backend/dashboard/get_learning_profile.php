<?php

include("../db.php");

$user_id = $_GET["user_id"];

/* GET CURRENT LEVEL */
$userQuery = pg_query($conn, "
    SELECT current_level
    FROM users
    WHERE user_id = $user_id
");

$user = pg_fetch_assoc($userQuery);

/* GET LATEST DIAGNOSTIC */
$diag = pg_query($conn, "
    SELECT
        sd.subject_id,
        sd.level,
        sd.score,
        sd.total,
        sd.recommended_topic_id,
        sd.completed_at,
        s.subject_name,
        t.topic_name
    FROM subject_diagnostic sd

    JOIN subjects s
    ON sd.subject_id = s.subject_id

    LEFT JOIN topics t
    ON sd.recommended_topic_id = t.topic_id

    WHERE sd.user_id = $user_id

    ORDER BY sd.completed_at DESC

    LIMIT 1
");

if (pg_num_rows($diag) == 0) {

    echo json_encode([
        "has_diagnostic" => false
    ]);

    exit;
}

$diagRow = pg_fetch_assoc($diag);

/* DEFAULT VALUES */
$recommended_topic_id =
    $diagRow["recommended_topic_id"];

$recommended_topic =
    $diagRow["topic_name"] ?? "No recommendation";

$recommended_subject =
    $diagRow["subject_name"];

$recommendation_source =
    "Diagnostic Assessment";

$recommendation_reason =
    "This topic is recommended based on your latest diagnostic assessment.";

/* COUNT ATTEMPTED TOPICS */
$attemptedTopicQuery = pg_query($conn, "
    SELECT COUNT(DISTINCT topic_id) AS total
    FROM quiz_attempt
    WHERE user_id = $user_id
");

$attemptedTopicRow =
    pg_fetch_assoc($attemptedTopicQuery);

$attempted_topics =
    (int)$attemptedTopicRow["total"];

/* PRIORITY 1: WEAKEST QUIZ TOPIC */
/* Only use this if student attempted at least 2 topics */
if ($attempted_topics >= 2) {

    $weakQuery = pg_query($conn, "
        SELECT
            t.topic_id,
            t.topic_name,
            s.subject_name,
            ROUND(AVG(qa.score)) AS avg_score

        FROM quiz_attempt qa

        JOIN topics t
        ON qa.topic_id = t.topic_id

        JOIN subjects s
        ON t.subject_id = s.subject_id

        WHERE qa.user_id = $user_id

        GROUP BY
            t.topic_id,
            t.topic_name,
            s.subject_name

        ORDER BY avg_score ASC

        LIMIT 1
    ");

    if ($weakQuery && pg_num_rows($weakQuery) > 0) {

        $weakRow =
            pg_fetch_assoc($weakQuery);

        $recommended_topic_id =
            $weakRow["topic_id"];

        $recommended_topic =
            $weakRow["topic_name"];

        $recommended_subject =
            $weakRow["subject_name"];

        $recommendation_source =
            "Quiz Performance";

        $recommendation_reason =
            "Your average quiz score for this topic is " .
            $weakRow["avg_score"] .
            "%, so this topic needs more practice.";
    }
}

/* PRIORITY 2: NEXT UNCOMPLETED TOPIC */
/* If not enough quiz comparison data, recommend next topic not completed */
else {

    $nextTopicQuery = pg_query($conn, "
        SELECT
            t.topic_id,
            t.topic_name,
            s.subject_name

        FROM topics t

        JOIN subjects s
        ON t.subject_id = s.subject_id

        LEFT JOIN learning_progress lp
        ON t.topic_id = lp.topic_id
        AND lp.user_id = $user_id

        WHERE
            COALESCE(lp.progress_percent, 0) < 100

        ORDER BY
            t.subject_id ASC,
            t.topic_id ASC

        LIMIT 1
    ");

    if ($nextTopicQuery && pg_num_rows($nextTopicQuery) > 0) {

        $nextRow =
            pg_fetch_assoc($nextTopicQuery);

        $recommended_topic_id =
            $nextRow["topic_id"];

        $recommended_topic =
            $nextRow["topic_name"];

        $recommended_subject =
            $nextRow["subject_name"];

        $recommendation_source =
            "Learning Progression";

        $recommendation_reason =
            "You still have uncompleted topics. Continue with this topic to broaden your learning progress.";
    }

    /* PRIORITY 3: REVISION TOPIC */
    else {

        $revisionQuery = pg_query($conn, "
            SELECT
                t.topic_id,
                t.topic_name,
                s.subject_name,
                ROUND(AVG(qa.score)) AS avg_score

            FROM quiz_attempt qa

            JOIN topics t
            ON qa.topic_id = t.topic_id

            JOIN subjects s
            ON t.subject_id = s.subject_id

            WHERE qa.user_id = $user_id

            GROUP BY
                t.topic_id,
                t.topic_name,
                s.subject_name

            ORDER BY avg_score ASC

            LIMIT 1
        ");

        if ($revisionQuery && pg_num_rows($revisionQuery) > 0) {

            $revisionRow =
                pg_fetch_assoc($revisionQuery);

            $recommended_topic_id =
                $revisionRow["topic_id"];

            $recommended_topic =
                $revisionRow["topic_name"];

            $recommended_subject =
                $revisionRow["subject_name"];

            $recommendation_source =
                "Revision Recommendation";

            $recommendation_reason =
                "You have completed all available topics. Review this topic to maintain mastery and improve long-term understanding.";
        }
    }
}

/* RESPONSE */
echo json_encode([

    "has_diagnostic" => true,

    "subject_id" =>
        $diagRow["subject_id"],

    "subject_name" =>
        $diagRow["subject_name"],

    "diagnostic_level" =>
        $diagRow["level"],

    "diagnostic_score" =>
        $diagRow["score"],

    "diagnostic_total" =>
        $diagRow["total"],

    "current_level" =>
        $user["current_level"],

    "recommended_topic" =>
        $recommended_topic,

    "recommended_subject" =>
        $recommended_subject,

    "recommended_topic_id" =>
        $recommended_topic_id,

    "recommendation_source" =>
        $recommendation_source,

    "recommendation_reason" =>
        $recommendation_reason,

    "attempted_topics" =>
        $attempted_topics

]);

?>