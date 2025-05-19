<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <title>Profil</title>
    <link rel="stylesheet" href="styles/styleprofil.css">
</head>
<body>
<?php
// session_start();
?>
<?php
$mysql = new mysqli("localhost", "root", "", "stronablogowa");
if ($mysql->connect_error) {
    die("Błąd połączenia z bazą danych: " . $mysql->connect_error);
}
$userID = $_GET['userID'];        
$sql = "SELECT * FROM users WHERE ID = '$userID';";
$result = $mysql->query($sql);   
if ($result->num_rows == 1) {
    while ($row = $result->fetch_assoc()) {
        echo "<header>";
        echo "<h1 style='text-align: center;'>" . $row['Login'] . "</h1>" . "<br>";
        echo "<a style='text-align: center;' href='index.php'><p style='text-align: center;'>strona główna</a></p>";
        echo "</header>";
        echo "<div>";
        echo "<p style='text-align: center;'>" . $row['Email'] . "</p><br>";
        echo "<p style='text-align: center;'>" . $row['Role'] . "</p><br>";
        if($_SESSION['id'] = $userID){
            echo "<a href='change_password.php' style='color: black;'><p style='text-align: center;' id='change'>Zmień hasło</p></a><br>";
        }
        // echo "<p style='text-align: center;'>" . $row['Popularnosc'] . "</p><br>";
        echo "</div>";
        
        echo "<h2>Blogi użytkownika</h2>";
        $sql="SELECT users.id AS author_id,login,title,view,posts.ID AS posts_id FROM posts INNER JOIN users ON users.ID = posts.UserID where users.id = $userID order by date DESC;";
        $result = $mysql->query($sql);
        if($result->num_rows>0){
            while($row = $result->fetch_assoc()){
                $authorID = $row["author_id"];
                $postId = $row["posts_id"];
                $author = $row["login"];
                $title = $row["title"];
                $views = $row["view"];
                echo "<a style='color:black;' href='blogs.php?id=$postId&author=$author&author_id=$authorID' id='blog'><p style='text-align: center;' id='blogs'>Nazwa użytkownika: " . $author . " - Tytuł bloga: " . $title . " - Liczba odwiedzin: " . $views . "</a> . <a style='color:black;' href='editpost.php?blogID=$postId'> Edytuj</a> . <a style='color:black;' href='delete_post.php?blogID=$postId'> Usuń</a></p><br>";
            }
        } else {
            echo "Użytkownik nie ma jeszcze żadnych blogów.";
        }
    }
} else {
    echo "Nie znaleziono użytkownika.";
}
$mysql->close();
?>
<footer>
<p style="color: white;">Strona zrobiona przez Pawła Kulińskiego</p>
</footer>
</body>
</html>