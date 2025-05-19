<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Strona Blogowa - Panel Administratora</title>
    <link rel="stylesheet" href="styles/admin.css">
</head>
<body>
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
if (isset($_SESSION['username']) && isset($_SESSION['email']) && $_SESSION['role'] == 'admin') {
    $adminUsername = $_SESSION['username'];
    echo "<h3>Panel Administratora - Witaj, $adminUsername!</h3>";
    echo "<a href='classes/logout.php'><p>Wyloguj się</p></a>";
    // Usuwanie użytkowników
    if (isset($_GET['delete_user_id'])) {
        $deleteUserID = $_GET['delete_user_id'];
        $deleteUserQuery = "DELETE FROM users WHERE ID = $deleteUserID";
        if ($mysql->query($deleteUserQuery) === TRUE) {
            echo "Użytkownik o ID $deleteUserID został pomyślnie usunięty.";
        } else {
            echo "Błąd podczas usuwania użytkownika: " . $mysql->error;
        }
    }

    // Edytowanie użytkowników
    if (isset($_POST['edit_user_id'])) {
        $editUserID = $_POST['edit_user_id'];
        $editedUsername = $_POST['edited_username'];
        $editedEmail = $_POST['edited_email'];
        $editUserQuery = "UPDATE users SET Login = '$editedUsername', Email = '$editedEmail' WHERE ID = $editUserID";
        if ($mysql->query($editUserQuery) === TRUE) {
            echo "Dane użytkownika o ID $editUserID zostały pomyślnie zaktualizowane.";
        } else {
            echo "Błąd podczas aktualizowania danych użytkownika: " . $mysql->error;
        }
    }

    // Wyświetlanie listy użytkowników
    $usersQuery = "SELECT * FROM users where id > 0";
    $usersResult = $mysql->query($usersQuery);
    if ($usersResult->num_rows > 0) {
        echo "<h4>Lista użytkowników:</h4>";
        echo "<ul>";
        while ($userRow = $usersResult->fetch_assoc()) {
            $userID = $userRow['ID'];
            $username = $userRow['Login'];
            $email = $userRow['Email'];
            echo "<li>ID: $userID | Nazwa użytkownika: $username | Email: $email";
            echo "<form action='' method='post'>";
            echo "<input type='hidden' name='edit_user_id' value='$userID'>";
            echo "Nowa nazwa użytkownika: <input type='text' name='edited_username'>";
            echo "Nowy email: <input type='text' name='edited_email'>";
            echo "<input type='submit' value='Edytuj'>";
            echo "</form>";
            echo "<a href='?delete_user_id=$userID'>Usuń</a>";
            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "Brak użytkowników.";
    }

    // Edytowanie blogów
    if (isset($_GET['edit_blog_id'])) {
        $editBlogID = $_GET['edit_blog_id'];
        $blogQuery = "SELECT * FROM posts WHERE ID = $editBlogID";
        $blogResult = $mysql->query($blogQuery);
        if ($blogResult->num_rows > 0) {
            $blogRow = $blogResult->fetch_assoc();
            $blogTitle = $blogRow['Title'];
            $blogContent = $blogRow['Content'];

            echo "<h4>Edycja bloga - ID: $editBlogID</h4>";
            echo "<form action='' method='post'>";
            echo "<input type='hidden' name='edit_blog_id' value='$editBlogID'>";
            echo "Tytuł: <input type='text' name='edited_blog_title' value='$blogTitle'><br>";
            echo "Treść:<br> <textarea name='edited_blog_content' rows='5' cols='40'>$blogContent</textarea><br>";
            echo "<input type='submit' value='Zaktualizuj'>";
            echo "</form>";
        } else {
            echo "Nie znaleziono bloga o ID: $editBlogID";
        }
    }

    if (isset($_POST['edit_blog_id'])) {
        $editBlogID = $_POST['edit_blog_id'];
        $editedBlogTitle = $_POST['edited_blog_title'];
        $editedBlogContent = $_POST['edited_blog_content'];
        $editBlogQuery = "UPDATE blogs SET Title = '$editedBlogTitle', Content = '$editedBlogContent' WHERE ID = $editBlogID";
        if ($mysql->query($editBlogQuery) === TRUE) {
            echo "Blog o ID $editBlogID został pomyślnie zaktualizowany.";
        } else {
            echo "Błąd podczas aktualizowania bloga: " . $mysql->error;
        }
    }

    // Usuwanie blogów
    if (isset($_GET['delete_blog_id'])) {
        $deleteBlogID = $_GET['delete_blog_id'];
        $deleteBlogQuery = "DELETE FROM posts WHERE ID = $deleteBlogID";
        if ($mysql->query($deleteBlogQuery) === TRUE) {
            echo "Blog o ID $deleteBlogID został pomyślnie usunięty.";
        } else {
            echo "Błąd podczas usuwania bloga: " . $mysql->error;
        }
    }

    $blogsQuery = "SELECT * FROM posts";
    $blogsResult = $mysql->query($blogsQuery);
    if ($blogsResult->num_rows > 0) {
        echo "<h4>Lista blogów:</h4>";
        echo "<ul>";
        while ($blogRow = $blogsResult->fetch_assoc()) {
            $blogID = $blogRow['ID'];
            $blogTitle = $blogRow['Title'];
            $blogContent = $blogRow['Content'];
            echo "<li>ID: $blogID | Tytuł: $blogTitle";
            echo "<a href='?edit_blog_id=$blogID'>Edytuj</a>";
            echo "<a href='admin_comments.php?post_id=$blogID'>Zobacz komentarze</a>";
            echo "<a href='?delete_blog_id=$blogID'>Usuń</a>";
            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "Brak blogów.";
    }

} else {
    echo "Brak dostępu do panelu administratora. Proszę zaloguj się jako administrator.";
}
$mysql->close();
?>
</body>
</html>