<?php
session_start();
include("phpMyAdmin.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM TaiKhoan WHERE tenDangNhap = '$username' AND matKhau = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Login successful
        $_SESSION["username"] = $username;

        header("Location: ../views/home_page.php"); // Redirect to the home page
        exit();
    } else {
        // Login failed
        echo "Invalid username or password";
    }
}

// Close the database connection
$conn->close();
?>
