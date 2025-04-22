<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $taskId = $_POST['task_id'];
    $checked = $_POST['checked'] == "1" ? 1 : 0;

    $stmt = $conn->prepare("UPDATE tasks SET checked = ? WHERE id = ?");
    $stmt->bind_param("ii", $checked, $taskId);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
