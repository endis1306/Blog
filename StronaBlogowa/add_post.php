<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

$mysql = new mysqli("localhost", "root", "", "stronablogowa");
if ($mysql->connect_error) {
    die("Błąd połączenia z bazą danych: " . $mysql->connect_error);
}

if (isset($_POST['title']) && isset($_POST['content'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $userId = $_SESSION['id'];
    
    $fileCount = count($_FILES['images']['name']);
    $filePaths = array();
    
    for ($i = 0; $i < $fileCount; $i++) {
        $fileName = $_FILES['images']['name'][$i];
        $fileTmp = $_FILES['images']['tmp_name'][$i];
        $fileType = $_FILES['images']['type'][$i];
        
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $newFileName = uniqid() . '.' . $fileExtension;
        $uploadPath = 'uploads/' . $newFileName;
        move_uploaded_file($fileTmp, $uploadPath);
        $filePaths[] = $uploadPath;
    }
    
    $stmt = $mysql->prepare("INSERT INTO posts (title, content, UserID) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $title, $content, $userId);
    
    if ($stmt->execute()) {
        $postId = $stmt->insert_id;
        
        foreach ($filePaths as $filePath) {
            $stmt = $mysql->prepare("INSERT INTO images (PostID, FilePath) VALUES (?, ?)");
            $stmt->bind_param("is", $postId, $filePath);
            $stmt->execute();
        }
        
        echo "<p style='text-align: center;'>Wpis został dodany pomyślnie.</p>";
    } else {
        echo "<p style='text-align: center;'>Wystąpił błąd podczas dodawania wpisu.</p>";
    }
    
    $stmt->close();
}

$mysql->close();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Blog</title>
    <link rel="stylesheet" href="styles/styleblog.css">
</head>
<body>
    <h2>Dodaj nowy wpis</h2>
    <a href="index.php">Strona główna</a>
    <form action="add_post.php" method="post" enctype="multipart/form-data">
        <label for="title">Tytuł:</label>
        <input type="text" id="title" name="title" required><br><br>
        <label for="content">Treść:</label><br>
        <textarea id="content" name="content" rows="4" cols="50" required></textarea><br><br>
        <label for="images">Obrazki:</label>
        <input type="file" id="images" name="images[]" multiple><br><br>
        <input type="submit" value="Dodaj wpis">
    </form>
</body>
</html>