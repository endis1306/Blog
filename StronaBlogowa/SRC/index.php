<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Strona Blogowa</title>
    <link rel="stylesheet" href="styles/style.css">
    <style>
        body {
            filter: none;
        }
        #cookieBanner {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        #cookieBanner form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #cookieBanner.formHidden {
            display: none;
        }
        #cookieBanner {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.8);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 9999;
        }

        #cookieFormContainer {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
<?php
session_start();
// if (!isset($_COOKIE['acceptedCookie'])) {
//     echo '<style>body { filter: blur(4px); }</style>';
// } else {
//     echo '<style>body { filter: none; }</style>';
// }
function setCookieValue($name, $value, $expiration) {
    $cookieName = urlencode($name);
    $cookieValue = urlencode($value);
    $cookieExpiration = time() + ($expiration * 60 * 60); 

    setcookie($cookieName, $cookieValue, $cookieExpiration, '/');
}
//  unset($_COOKIE['acceptedCookie']);
// if (isset($_COOKIE['acceptedCookie'])) {
//     echo "Ciasteczko istnieje.";
// } else {
//     echo "Ciasteczko nie istnieje.";
// }
if (isset($_POST['acceptCookie'])) {
    setCookieValue('acceptedCookie', 'true', 2); 
}

$mysql = new mysqli("localhost","root","","stronablogowa");
if ($mysql->connect_error) {
    die("Błąd połączenia z bazą danych: " . $mysql->connect_error);
}
if (isset($_POST["email"]) && isset($_POST["password"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

$sql = "SELECT * FROM users WHERE Email = '$email';";
$result = $mysql->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $hashedPassword = $row['Password'];

    if (password_verify($password, $hashedPassword)) {
        $_SESSION['id'] = $row['ID'];
        $_SESSION['username'] = $row['Login'];
        $_SESSION['email'] = $email;
        $_SESSION['role'] = $row['Role'];
        $_SESSION['popularnosc'] = $row['Popularnosc'];

        echo "Zalogowano się.";
    } else {
        echo "Nieprawidłowy email lub hasło.";
    }
} else {
    echo "Nieprawidłowy email lub hasło.";
}
}
$mysql->close();
?>
    <header id="mainpageheader">
        <div id="title">
            <h1>Strona blogowa</h1>
        </div>
        <div id="search">
            <form action="searchblogs.php" method="GET">
                <input type="text" name="search" id="search_b" placeholder="Szukaj..">
                <button>Wyszukaj</button>
            </form>
        </div>
        <?php
        if (isset($_SESSION["username"]) && $_SESSION["role"] == "admin"){
            header("location: admin.php");
        }
        if(isset($_SESSION['username']) && isset($_SESSION['email'])){
        $userID = $_SESSION['id'];
        echo "<div id='profil'>";
        echo     "<a href='profil.php?userID=$userID'>Wyświetl profil</a>";
        echo "</div>";
        }
        ?>
        <div>
        <?php
        if(isset($_SESSION['username']) && isset($_SESSION['email'])){
        echo $_SESSION['username'];
        }
        ?>
        </div>
        <div id="wyl">
            <?php
            if(isset($_SESSION['username']) && isset($_SESSION['email'])){
            echo "<a href='classes/logout.php' name='logout'>Wyloguj się</a>";
            }
            ?>
        </div>
        <div>
            <?php
            if(isset($_SESSION['username']) && isset($_SESSION['email'])){
            echo "<a href='add_post.php'>Napisz bloga</a>";
            }
            ?>
        </div>
        <?php
        if(!isset($_SESSION['username']) || !isset($_SESSION['email'])){
        echo "<div id='log'>";
        echo    "<a href='log.php' id='zaloguj'>Zaloguj się</a>";
        echo "</div>";
        }
        ?>
        <div>
            <a href="all_users.php">Wszyscy użytkownicy</a>
        </div>
    </header>
    <div id="cookieBanner" <?php if (isset($_COOKIE['acceptedCookie'])) { echo 'class="formHidden"'; } ?>>
    <div id="cookieFormContainer">
        <p>Ta strona wykorzystuje pliki cookie. Kliknij poniżej, aby zaakceptować.</p>
        <form method="post">
            <input type="submit" name="acceptCookie" value="Akceptuj">
        </form>
    </div>
</div>

</div>
    </div>
    <div id="center">
        <h2>Najpopularniejsze blogi</h2>
        <?php
        $mysql = new mysqli("localhost","root","","stronablogowa");
        $sql="SELECT users.id AS author_id,login,title,view,posts.ID AS posts_id,email FROM posts INNER JOIN users ON users.ID = posts.UserID ORDER BY view DESC LIMIT 10;";
        $result = $mysql->query($sql);
        if($result->num_rows>0){
            while($row = $result->fetch_assoc()){
                $authorID = $row["author_id"];
                $postId = $row["posts_id"];
                $author = $row["login"];
                $title = $row["title"];
                $views = $row["view"];
                echo "<a style='color:black;' href='blogs.php?id=$postId&author=$author&author_id=$authorID'>Nazwa użytkownika: " . $author . " - Tytuł bloga: " . $title . " - Liczba odwiedzin: " . $views . "</a><br>";
            }
        }
        else{
            echo "Brak wyników.";
        }
        ?>
    </div>
    <div id="right">
        <h2>Ostatnio dodane blogi:</h2>
        <?php
        $mysql = new mysqli("localhost","root","","stronablogowa");
        $sql="SELECT users.id AS author_id,login,title,view,posts.ID AS posts_id,date,email FROM posts INNER JOIN users ON users.ID = posts.UserID ORDER BY date DESC LIMIT 10;";
        $result = $mysql->query($sql);
        if($result->num_rows>0){
            while($row = $result->fetch_assoc()){
                $authorID = $row["author_id"];
                $postId = $row["posts_id"];
                $author = $row["login"];
                $title = $row["title"];
                $date = $row["date"];
                echo "<a style='color:black;' href='blogs.php?id=$postId&author=$author&author_id=$authorID'>Nazwa użytkownika: " . $author . " - Tytuł bloga: " . $title . " - data dodania: " . $date . "</a><br>";
            }
        }
        else{
            echo "Brak wyników.";
        }
        ?>
    </div>
    <footer>
        <p style="color: white;">Strona zrobiona przez Pała Kulińskiego</p>
    </footer>
</body>
</html>
