<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include("db_connection.php");

    $email = $_POST["email"];
    $password = $_POST["password"];

    $query = "SELECT id, email FROM users WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($user_id, $email);
        $stmt->fetch();

        $_SESSION["user_id"] = $user_id;
        $_SESSION["email"] = $email;

        header("Location: home.php");
        exit;
    } else {
        $error = "Invalid email or password.";
    }

    $stmt->close();
    $conn->close();
}
?>
