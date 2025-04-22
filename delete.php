<?php 
include('db.php');
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: index.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM tasks WHERE id=?");
    $stmt->bind_param("i",$id);

    if ($stmt->execute()) {
        echo "<script>alert('Task deleted successfully!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Failed to delete task!');</script>";
    }

    $stmt->close();
}
$conn->close();
?>