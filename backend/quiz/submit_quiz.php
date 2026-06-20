<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../db.php');

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(["error" => "No JSON received"]);
    exit;
}

$user_id = $data['user_id'] ?? null;
$topic_id = $data['topic_id'] ?? null;
$answers = $data['answers'] ?? [];

if (!$user_id || !$topic_id || empty($answers)) {
    echo json_encode(["error" => "Missing data"]);
    exit;
}

$score = 0;
$total = count($answers);

$attempt = pg_query($conn, "
    INSERT INTO quiz_attempt (user_id, topic_id, score)
    VALUES ($user_id, $topic_id, 0)
    RETURNING attempt_id
");

if (!$attempt) {
    echo json_encode(["error" => "Failed to create attempt"]);
    exit;
}

$attempt_id = pg_fetch_result($attempt, 0, 'attempt_id');

//CHECK ANSWERS
foreach ($answers as $qid => $ans) {

    $q = pg_query($conn, "SELECT correct_answer FROM questions WHERE question_id = $qid");

    if (!$q || pg_num_rows($q) == 0) continue;

    $correct = pg_fetch_result($q, 0, 'correct_answer');

    $ans = strtoupper(trim($ans));
    $correct = strtoupper(trim($correct));

    $is_correct = ($ans === $correct);

    if ($is_correct) $score++;

    $is_correct_sql = $is_correct ? 'TRUE' : 'FALSE';

    pg_query($conn, "
        INSERT INTO attempt_answers (attempt_id, question_id, selected_answer, is_correct)
        VALUES ($attempt_id, $qid, '$ans', $is_correct_sql)
    ");
}

$percentage = round(($score / $total) * 100);
pg_query($conn, "
    UPDATE quiz_attempt 
    SET score = $percentage 
    WHERE attempt_id = $attempt_id
");

if ($percentage >= 80) {

    $current_level = "Strong";

} else if ($percentage >= 50) {

    $current_level = "Good";

} else {

    $current_level = "Weak";
}

pg_query($conn, "

    UPDATE users

    SET current_level = '$current_level'

    WHERE user_id = $user_id

");

echo json_encode([
    "score" => $score,
    "total" => $total
]);
?>