<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Strona Blogowa - Panel Administratora - Komentarze</title>
    <link rel="stylesheet" href="styles/admin.css">
</head>
<body>
<?php
session_start();
$mysql = new mysqli("localhost", "root", "", "stronablogowa");
if ($mysql->connect_error) {
    die("Błąd połączenia z bazą danych: " . $mysql->connect_error);
}

if (isset($_SESSION['username']) && isset($_SESSION['email']) && $_SESSION['role'] == 'admin') {
    $adminUsername = $_SESSION['username'];
    echo "<h3>Panel Administratora - Witaj, $adminUsername!</h3>";
    echo "<a href='classes/logout.php'><p>Wyloguj się</p></a>";

    if (isset($_GET['post_id'])) {
        $postID = $_GET['post_id'];
        
        // Usuwanie komentarzy
        if (isset($_GET['delete_comment_id'])) {
            $deleteCommentID = $_GET['delete_comment_id'];
            $deleteCommentQuery = "DELETE FROM comments WHERE ID = $deleteCommentID";
            if ($mysql->query($deleteCommentQuery) === TRUE) {
                echo "Komentarz o ID $deleteCommentID został pomyślnie usunięty.";
            } else {
                echo "Błąd podczas usuwania komentarza: " . $mysql->error;
            }
        }

        // Wyświetlanie komentarzy
        $commentsQuery = "SELECT * FROM comments WHERE PostID = $postID";
        $commentsResult = $mysql->query($commentsQuery);
        
        if ($commentsResult->num_rows > 0) {
            echo "<h4>Komentarze do posta o ID: $postID</h4>";
            echo "<ul>";
            while ($commentRow = $commentsResult->fetch_assoc()) {
                $commentID = $commentRow['ID'];
                $commentContent = $commentRow['Content'];
                $commentAuthor = $commentRow['Author'];
                echo "<li>ID: $commentID | Autor: $commentAuthor | Treść: $commentContent";
                echo "<a href='comments.php?post_id=$postID&delete_comment_id=$commentID'>Usuń</a>";
                echo "</li>";
            }
            echo "</ul>";
        } else {
            echo "Brak komentarzy do tego posta.";
        }
    } else {
        echo "Nieprawidłowe.";
    }
}
?>
</body>
</html>