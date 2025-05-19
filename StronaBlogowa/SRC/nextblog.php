<?php
session_start();
if (!isset($_SESSION["username"])) {
    $_SESSION['id'] = 0;
    $_SESSION['username'] = "gosc";
    $_SESSION['role'] = 'guest';
}

$mysql = new mysqli("localhost", "root", "", "stronablogowa");
if ($mysql->connect_error) {
    die("Błąd połączenia z bazą danych: " . $mysql->connect_error);
}

$blogId = $_GET["id"];
$direction = $_GET["direction"];

if ($direction == "previous") {
    $sql = "SELECT id FROM posts WHERE date < (SELECT date FROM posts WHERE id = $blogId) ORDER BY date DESC LIMIT 1";
} else {
    $sql = "SELECT id FROM posts WHERE date > (SELECT date FROM posts WHERE id = $blogId) ORDER BY date ASC LIMIT 1";
}

$result = $mysql->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $nextBlogId = $row["id"];
    $authorID = $row["author_id"];
    $postId = $row["posts_id"];
    $author = $row["login"];
    $title = $row["title"];
    $date = $row["date"];
    header("Location: blogs.php?id=$nextBlogId&author=$author&author_id=$authorID'");
} else {
    header("location: index.php");
}

$mysql->close();
?>
