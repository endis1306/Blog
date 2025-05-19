<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <title>Edycja bloga</title>
    <link rel="stylesheet" href="styles/editstyle.css">
</head>
<body>
<header>
    <h1>Edycja bloga</h1>
    <a href="index.php">Strona główna</a>
</header>

<div id="edit-blog-container">
    <?php
    $mysql = new mysqli("localhost", "root", "", "stronablogowa");
    if ($mysql->connect_error) {
        die("Błąd połączenia z bazą danych: " . $mysql->connect_error);
    }

    $blogID = $_GET['blogID'];
    $sql = "SELECT * FROM posts WHERE ID = '$blogID';";
    $result = $mysql->query($sql);
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $title = $row['Title'];
        $content = $row['Content'];
        ?>
        <form id="edit-blog-form" action="classes/update_post.php" method="post">
            <input type="hidden" name="blogID" value="<?php echo $blogID; ?>">
            <label for="title">Tytuł:</label>
            <input type="text" name="title" id="title" value="<?php echo $title; ?>" required>
            <label for="content">Treść:</label>
            <textarea name="content" id="content" required><?php echo $content; ?></textarea>
            <button type="submit">Zapisz zmiany</button>
        </form>
        <?php
    } else {
        echo "Nie znaleziono bloga.";
    }

    $mysql->close();
    ?>
</div>

</body>
</html>