<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Strona blogowa</title>
    <link rel="stylesheet" href="styles/rejstyle.css">
</head>
<body>
    <header>
        <h1 id="rejh">Rejestracja</h1>
        <a href="index.php">Strona główna</a>
    </header>
    <?php
    session_start();
    if (isset($_GET['error'])) {
        $error = $_GET['error'];
        if ($error === "haslo") {
            echo "<p>Hasło i powtórzone hasło nie są identyczne.</p>";
        } elseif ($error === "uzytkownik") {
            echo "<p>Podany email lub login już istnieje. Wybierz inny.</p>";
        }
    }
    ?>
    <div>
        <form action="classes/rejes.php" method="POST">
            <label for="email">Email: </label>
            <input type="email" required id="email" name="email"><br>
            <label for="login">Login: </label>
            <input type="login" required id="login" name="login"><br>
            <label for="password">Hasło: </label>
            <input type="password" id="password" name="password" required><br>
            <label for="confirmPassword">Powtórz hasło: </label>
            <input type="password" id="confirmPassword" name="confirmPassword" required><br>
            <button>Zajerestruj się</button>
        </form>
    </div>
    <footer>
    <p style="color: white;">Strona zrobiona przez Pawła Kulińskiego</p>
    </footer>
</body>
</html>