<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Strona Blogowa</title>
    <link rel="stylesheet" href="styles/passwordstyle.css">
</head>
<body>
<?php
session_start();

$mysql = new mysqli("localhost", "root", "", "stronablogowa");
if ($mysql->connect_error) {
    die("Błąd połączenia z bazą danych: " . $mysql->connect_error);
}

if (isset($_SESSION['username']) && isset($_SESSION['email'])) {
    $userID = $_SESSION['id'];

    if (isset($_POST['change_password'])) {
        $currentPassword = trim($_POST['current_password']);
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];
        $getUserQuery = "SELECT * FROM users WHERE ID = $userID";
        $getUserResult = $mysql->query($getUserQuery);
        if ($getUserResult->num_rows > 0) {
            $userRow = $getUserResult->fetch_assoc();
            $hashedPassword = $userRow['Password'];
            if (password_verify(trim($currentPassword), $hashedPassword)) {
                if ($newPassword === $confirmPassword) {
                    $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                    $updatePasswordQuery = "UPDATE users SET Password = '$hashedNewPassword' WHERE id = $userID";
                    if ($mysql->query($updatePasswordQuery) === TRUE) {
                        echo "Twoje hasło zostało pomyślnie zmienione.";
                    } else {
                        echo "Błąd podczas zmiany hasła: " . $mysql->error;
                    }
                } else {
                    echo "Nowe hasło i potwierdzenie hasła nie są identyczne.";
                }
            } else {
                echo "Podane hasło nie zgadza się z Twoim aktualnym hasłem.";
            }
        } else {
            echo "Nie znaleziono użytkownika o ID: $userID";
        }
    }
    echo "<h3>Zmiana hasła</h3>";
    echo "<a href='index.php'>Strona główna</a>";
    echo "<form action='' method='post'>";
    echo "Aktualne hasło: <input type='password' name='current_password'><br>";
    echo "Nowe hasło: <input type='password' name='new_password'><br>";
    echo "Potwierdź nowe hasło: <input type='password' name='confirm_password'><br>";
    echo "<input type='submit' name='change_password' value='Zmień hasło'>";
    echo "</form>";
} else {
    echo "Brak dostępu. Proszę zaloguj się.";
}

$mysql->close();
?>
<footer><p>Strona stworzona przez Pawła Kulińskiego</p></footer>
</body>
</html>
