<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Blog</title>
    <link rel="stylesheet" href="styles/styleblog.css">
</head>
<body>
    <?php
    session_start();
    ?>
    <h2>Dodaj nowy wpis</h2>
    <a href="index.php" style="text-align: center;">strona główna</a>
    <?php
    echo "<form action='add_post.php' method='post' enctype='multipart/form-data'>";
    echo   "<label for='title'>Tytuł:</label>";
    echo   "<input type='text' id='title' name='title' required><br><br>";
    echo   "<label for='content'>Treść:</label><br>";
    echo   "<textarea id='content' name='content' rows='4' cols='50' required></textarea><br><br>";
    echo   "<label for='images'>Obrazki:</label>";
    echo   "<input type='file' id='images' name='images[]' multiple><br><br>";
    echo  "<input type='submit' value='Dodaj wpis'>";
    echo "</form>";
   ?>
   <footer>
   <p style="color: white;">Strona zrobiona przez Pawła Kulińskiego</p>
   </footer>
</body>
</html>
