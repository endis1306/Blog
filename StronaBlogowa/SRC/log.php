<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Strona blogowa</title>
    <link rel="stylesheet" href="styles/logstyle.css">
</head>
<body>
    <?php
    Session_start();
    ?>
    <header>
        <h1 id="logh">Zaloguj się</h1>
        <a class="home-link" href="Index.php">Strona Główna</a>
    </header>
    <div>
        <form action="index.php" method="POST">
            <label for="email">Email: </label>
            <input type="email" required id="email" name="email"><br>
            <label for="password">Hasło: </label>
            <input type="password" id="password" name="password" required><br>
            <button>Zaloguj</button>
        </form>
    </div>
    <div id="rej">
        <p>Nie masz konta? </p>
        <a href="rej.php">Zajerestruj się!</a>
    </div>
    <footer>
    </footer>
</body>
</html>
