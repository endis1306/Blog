<?php
$mysql= new mysqli(
    getenv("DB_HOST"),
    getenv("DB_USER"),
    getenv("DB_PASS"),
    getenv("DB_NAME")
);
if ($mysql->connect_error) {
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
$result = $mysql->query($sql);

if ($result->num_rows > 0) {
    header("Location: rej.php?error=uzytkownik");
    exit();
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (email, login, password) VALUES ('$email', '$login', '$hashedPassword')";

if ($mysql->query($sql) === TRUE) {
    header("Location: ../log.php");
    exit();
} else {
    echo "Błąd podczas rejestracji użytkownika: " . $mysql->error;
}

$mysql->close();
?>
