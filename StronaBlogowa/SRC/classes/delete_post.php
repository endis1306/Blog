<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../log.html");
    exit();
}

$blogID = $_GET['blogID'];

$mysql = new mysqli("localhost", "root", "", "stronablogowa");
if ($mysql->connect_error) {
    die("Błąd połączenia z bazą danych: " . $mysql->connect_error);
}

$deleteImagesSql = "DELETE FROM images WHERE PostID = '$blogID'";
if ($mysql->query($deleteImagesSql) === TRUE) {
    $deletePostSql = "DELETE FROM posts WHERE ID = '$blogID'";
    if ($mysql->query($deletePostSql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Błąd: " . $deletePostSql . "<br>" . $mysql->error;
    }
} else {
    echo "Błąd: " . $deleteImagesSql . "<br>" . $mysql->error;
}

$mysql->close();
?>
