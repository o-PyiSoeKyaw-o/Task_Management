<?php
include('db.php');
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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

    <!-- Tasks -->
    <div class="task">
        <div class="task-list">
            <h1>Tasks</h1>
            <table>
                <tr>
                    <th>No.</th>
                    <th>Task</th>
                    <th>Team</th>
                    <th class="description">Description</th>
                    <th>Start date</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th>Checked</th>
                    <th>Actions</th>
                </tr>

                <?php
                $result = $conn->query("SELECT * FROM tasks");
                if ($result->num_rows > 0) {
                    $count = 1;
                    while ($tasks = $result->fetch_assoc()) {
                        $taskId = $tasks['id'];
                        $isChecked = $tasks['checked'] ? "checked" : "";

                        echo "<tr>
                                <th>{$count}</th>
                                <th>{$tasks['task']}</th>
                                <th>{$tasks['team']}</th>
                                <th>{$tasks['description']}</th>
                                <th>{$tasks['startdate']}</th>
                                <th>{$tasks['deadline']}</th>
                                <th>{$tasks['status']}</th>
                                <th>
                                    <input type='checkbox' class='task-checkbox' data-taskid='$taskId' $isChecked />
                                </th>
                                <th>
                                    <a href='update.php?id={$tasks['id']}'>Edit</a>
                                    <a href='delete.php?id={$tasks['id']}' onclick='return confirm(\"Are you sure you want to delete this task?\");'>Delete</a>
                                </th>
                            </tr>";
                        $count++;
                    }
                } else {
                    echo "<tr><td colspan='9'>No tasks found</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".task-checkbox").forEach(function (checkbox) {
                checkbox.addEventListener("change", function () {
                    const taskId = this.dataset.taskid;
                    const isChecked = this.checked ? 1 : 0;

                    fetch("update_checkbox.php", {
                        method: "POST",
                        headers: { "Content-Type": "application/x-www-form-urlencoded" },
                        body: `task_id=${taskId}&checked=${isChecked}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.success) {
                            alert("Failed to update checkbox state.");
                        }
                    })
                    .catch(error => console.error("Error:", error));
                });
            });
        });
    </script>

</body>
</html>
