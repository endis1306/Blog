<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Wszyscy użytkownicy</title>
    <link rel="stylesheet" href="styles/usersstyle.css">
</head>
<body>
<header>
    <h1>Wszyscy użytkownicy</h1>
    <a href="index.php" id="mainpage" style="text-align: center;">Strona główna</a><br>
</header>
<div>
    <?php
    session_start();

    $mysql= new mysqli(
        getenv("DB_HOST"),
        getenv("DB_USER"),
        getenv("DB_PASS"),
        getenv("DB_NAME")
    );

    if ($mysql->connect_error) {
        die("Błąd połączenia z bazą danych: " . $mysql->connect_error);
    }
    $user = $_SESSION['username'];
    $sql = "SELECT * FROM users where Role = 'user' and Login != '$user'";
    $result = $mysql->query($sql);
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $userID = $row['ID'];
            $username = $row['Login'];
            $email = $row['Email'];
            
            echo "<a href='profil.php?userID=$userID'>Użytkownik: $username - Email: $email</a><br>";
        }
    } else {
        echo "Brak użytkowników.";
    }
    
    $mysql->close();
    ?>
</div>
<footer>
<p style="color: white;">Strona zrobiona przez Pawła Kulińskiego</p>
</footer>
</body>
</html>