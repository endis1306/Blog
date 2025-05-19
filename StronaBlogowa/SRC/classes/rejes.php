<?php
$mysqli = new mysqli("localhost","root","","stronablogowa");
if ($mysqli->connect_error) {
    die("Błąd połączenia z bazą danych: " . $mysqli->connect_error);
}

$email = $_POST['email'];
$login = $_POST['login'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirmPassword'];

if ($password !== $confirmPassword) {
    header("Location: rej.php?error=haslo");
    exit();
}

$sql = "SELECT * FROM users WHERE email = '$email' OR login = '$login'";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    header("Location: rej.php?error=uzytkownik");
    exit();
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (email, login, password) VALUES ('$email', '$login', '$hashedPassword')";

if ($mysqli->query($sql) === TRUE) {
    header("Location: ../log.php");
    exit();
} else {
    echo "Błąd podczas rejestracji użytkownika: " . $mysqli->error;
}

$mysqli->close();
?>
