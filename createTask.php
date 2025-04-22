<?php
include('db.php');
session_start();
if(!isset($_SESSION ['admin_logged_in'])) {
    header('location: index.php');
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task = $_POST['task'];
    $team = $_POST['team'];
    $description = $_POST['description'];
    $startdate = $_POST['startdate'];
    $deadline = $_POST['deadline'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("INSERT INTO tasks  (task, team, description, startdate, deadline, status) VALUES (?,?,?,?,?,?)");
    $stmt->bind_param("ssssss", $task, $team, $description, $startdate, $deadline, $status);

    if ($stmt->execute()) {
        echo "<script>alert('Added Task Successfully'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Error Adding Task');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CreateTask</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Side-nav -->
    <div class="side-nav">
        <ul class="nav-list">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="createTask.php">Create Task</a></li>
            <li><a href="index.php">Logout</a></li>
        </ul>
    </div>

    <!-- create task -->
    
    <div class="task-form">
        <h1>Creat Task</h1>
        <form action="createTask.php" method="POST">
            <label>Task name</label>
            <input type="text" name="task" required placeholder="Task name">
            <label>Team</label>
            <input type="text" name="team" placeholder="Team">
            <label>Description</label>
            <input type="text" name="description" placeholder="Description">
            <label>Start date</label>
            <input type="date" name="startdate">
            <label>Deadline</label>
            <input type="date" name="deadline">
            <label>Status</label>
            <select name="status">
                <option value="working">working</option>
                <option value="pending">pending</option>
                <option value="finished">finished</option>
                <option value="declined">declined</option>
            </select>
            <center>
                <button type="submit">Create</button>
            </center>
        </form>
    </div>
</body>
</html>