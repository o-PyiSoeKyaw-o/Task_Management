<?php
include('db.php');
session_start();
if(!isset($_SESSION ['admin_logged_in'])) {
    header('location: index.php');
    exit();
}

$tasks = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM tasks WHERE id = ?");
    $stmt -> bind_param("i",$id);
    $stmt -> execute();
    $result = $stmt->get_result();
    $tasks = $result->fetch_assoc();
    $stmt->close();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task = $_POST['task'];
    $team = $_POST['team'];
    $description = $_POST['description'];
    $startdate = $_POST['startdate'];
    $deadline = $_POST['deadline'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE tasks SET task=?, team=?, description=?, startdate=?, deadline=?, status=? WHERE id =?");
    $stmt->bind_param("ssssssi", $task, $team, $description, $startdate, $deadline, $status,$id);

    if ($stmt->execute()) {
        echo "<script>alert('Update Task Successfully'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Error Updating Task');</script>";
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
            <li><a href="#">Logout</a></li>
        </ul>
    </div>

    <!-- create task -->
    
    <div class="task-form">
        <h1>Creat Task</h1>
        <form action="update.php?id=<?php echo $tasks['id'];?>" method="POST">
            <label>Task name</label>
            <input type="text" name="task" value="<?php echo htmlspecialchars($tasks['task'])?>" required>
            <label>Team</label>
            <input type="text" name="team" value="<?php echo htmlspecialchars($tasks['team'])?>" require>
            <label>Description</label>
            <input type="text" name="description" value="<?php echo htmlspecialchars($tasks['description'])?>" require>
            <label>Start date</label>
            <input type="date" name="startdate" value="<?php echo htmlspecialchars($tasks['startdate'])?>" require>
            <label>Deadline</label>
            <input type="date" name="deadline" value="<?php echo htmlspecialchars($tasks['deadline'])?>" require>
            <label>Status</label>
            <select name="status" value="<?php echo htmlspecialchars($tasks['status'])?>" require>
                <option value="working">working</option>
                <option value="pending">pending</option>
                <option value="finished">finished</option>
                <option value="declined">declined</option>
            </select>
            <center>
                <button type="submit">Update</button>
            </center>
        </form>
    </div>
</body>
</html>