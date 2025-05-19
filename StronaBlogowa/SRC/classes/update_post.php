<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../log.html");
    exit();
}

$blogID = $_POST['blogID'];
$title = $_POST['title'];
$content = $_POST['content'];

$mysql= new mysqli(
    getenv("DB_HOST"),
    getenv("DB_USER"),
    getenv("DB_PASS"),
    getenv("DB_NAME")
);

if ($mysql->connect_error) {
    die("Błąd połączenia z bazą danych: " . $mysql->connect_error);
}
$sql = "SELECT * FROM posts WHERE ID = '$blogID' AND UserID = '{$_SESSION['id']}'";
$result = $mysql->query($sql);

if ($result->num_rows == 1) {
    $updateSql = "UPDATE posts SET title = '$title', content = '$content' WHERE ID = '$blogID'";
    if ($mysql->query($updateSql) === TRUE) {
        header("Location: blogs.php?id=$blogID");
        exit();
    } else {
        echo "Błąd: " . $updateSql . "<br>" . $mysql->error;
    }
} else {
    echo "Nie masz uprawnień do edycji tego bloga.";
}

$mysql->close();
?>
