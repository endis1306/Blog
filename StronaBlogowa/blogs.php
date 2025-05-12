<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Strona Blogowa - Blog</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/style_comments.css">
    <style>
        .blog-frame {
            width: 50%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            text-align: center;
        }
        .nextblog{
            color: black;
        }
        .comment {
            margin-left: 40px;
        }
        .reply-marker {
            font-size: 12px;
            color: #888;
            margin-bottom: 5px;
        }
        .images-container {
        margin-top: 20px;
        text-align: center;
        }
        .images-container img {
        margin-bottom: 10px;
        max-width: 100%;
        height: auto;
        }
        .rating {
        display: inline-block;
        margin-left: 10px;
        }

        .rating span {
        color: #888;
        margin-right: 5px;
        }

        .rating .positive {
        color: green;
        }
        .rating .negative {
        color: red;
        }
    </style>
</head>
<body>
    <?php
    session_start();
    if(!isset($_SESSION["username"]))
    {
        $_SESSION['id'] = 0;
        $_SESSION['username'] = "gosc";
        $_SESSION['role'] = 'guest';
    }
    $currentBlogId = $_GET["id"];

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
        <div>
            <a href="index.php">Strona główna</a>
        </div>
    </header>
    <div class="blog-frame">
        <?php
        $mysql = new mysqli("localhost", "root", "", "stronablogowa");
        if ($mysql->connect_error) {
            die("Błąd połączenia z bazą danych: " . $mysql->connect_error);
        }

        if (isset($_SESSION["id"])) {
            $postId = $_GET["id"];
            $authorId= $_GET['author_id'];
            $sql = "SELECT posts.id, posts.title, posts.content, users.login,date FROM posts INNER JOIN users ON posts.UserID = users.ID WHERE posts.id = $postId";
            $result = $mysql->query($sql);
        }

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                echo "<h2>" . $row["title"] . "</h2>";
                echo "<p>" . $row['date'] . "</p>";
                echo "<p>Autor: " . $row["login"] . "</p>";
                if($authorId != $_SESSION['id']){
                echo "<p><a href='chat.php?author_id=$authorId' id='kontakt' style='color: black;'>Skontaktuj się z autorem</a></p>";
            }
                echo "<p>" . $row["content"] . "</p>";
        

                $postId = $row["id"];
                $imagesSql = "SELECT FilePath FROM images WHERE PostID = $postId";
                $imagesResult = $mysql->query($imagesSql);
                
                if ($imagesResult->num_rows > 0) {
                    echo "<div class='images-container'>";
                    
                    while ($imageRow = $imagesResult->fetch_assoc()) {
                        $FilePath = $imageRow["FilePath"];
                        echo "<img src='$FilePath' alt=''>";
                    }
                    
                    echo "</div>";
                }
            } else {
                echo "Nie znaleziono takiego bloga.";
            }
               $mysql->close();
            ?>
    <a href="nextblog.php?id=<?php echo $postId; ?>&direction=previous" class="nextblog"><-</a>
<a href="nextblog.php?id=<?php echo $postId; ?>&direction=next" class="nextblog">-></a>

    </div>

    <div class="comments-section">
        <h3>Dodaj komentarz:</h3>
        <?php
        if (isset($_POST["submit"])) {
            $author = ($_SESSION["id"] != 0) ? $_SESSION["username"] : (isset($_POST["author"]) ? $_POST["author"] . "*" : "gość");
            $comment = $_POST["comment"];
            $postId = $_GET["id"];
            $userId = $_SESSION["id"];

            $mysql = new mysqli("localhost", "root", "", "stronablogowa");
            if ($mysql->connect_error) {
                die("Błąd połączenia z bazą danych: " . $mysql->connect_error);
            }
            $sql = "INSERT INTO comments (Content, date, PostID, UserID, Author) VALUES ('$comment', NOW(), $postId, $userId, '$author')";

            if ($mysql->query($sql) === TRUE) {
                echo "<p>Komentarz został dodany.</p>";
            } else {
                echo "Błąd dodawania komentarza: " . $mysql->error;
            }

            $mysql->close();
        }
        ?>

        <form action="" method="POST">
            <?php if (!isset($_SESSION["id"]) || $_SESSION["id"] == 0) : ?>
                <label for="author">Autor:</label>
                <input type="text" name="author" id="author" required><br>
            <?php endif; ?>
            <label for="comment">Komentarz:</label><br>
            <textarea name="comment" id="comment" rows="4" required></textarea><br>
            <input type="submit" name="submit" value="Dodaj komentarz">
        </form>

        <h3>Komentarze:</h3>
        <?php
        $mysql = new mysqli("localhost", "root", "", "stronablogowa");
        if ($mysql->connect_error) {
            die("Błąd połączenia z bazą danych: " . $mysql->connect_error);
        }
        
        $postId = $_GET["id"];
        $sql = "SELECT comments.ID, comments.Content, comments.date, comments.Author, users.login FROM comments INNER JOIN users ON comments.UserID = users.ID WHERE comments.PostID = $postId ORDER BY comments.date DESC";
        $result = $mysql->query($sql);
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $commentId = $row["ID"];
                $replyMarker = isset($row["login"]) && $_SESSION["id"] != 0 ? $row["login"] : $row["Author"];
                if ($row["Author"] !== "gość") {
                    $replyMarker .= "*";
                }
                echo "<div class='comment'>";
                echo "<p class='reply-marker'>Odpowiedź na: " . $replyMarker . "</p>";
                echo "<p><strong>" . (isset($row["login"]) && $_SESSION["id"] != 0 ? $row["login"] : $row["Author"]) . "</strong></p>";
                echo "<p>" . $row["Content"] . "</p>";
                echo "<p><em>" . $row["date"] . "</em></p>";
                echo "<button onclick='toggleReplyForm($commentId)'>Odpowiedz</button>";
                echo "<div id='replyForm_$commentId' style='display: none; margin-left: 40px;'>";
                echo "<form action='' method='POST'>";
                echo "<input type='hidden' name='commentId' value='$commentId'>";
                if (!isset($_SESSION["id"]) || $_SESSION["id"] == 0) {
                    echo "<label for='replyAuthor'>Autor:</label>";
                    echo "<input type='text' name='replyAuthor' id='replyAuthor' required><br>";
                }
                echo "<label for='replyComment'>Komentarz:</label><br>";
                echo "<textarea name='replyComment' id='replyComment' rows='2' required></textarea><br>";
                echo "<input type='submit' name='submitReply_$commentId' value='Dodaj odpowiedź'>";
                echo "</form>";
                echo "</div>";
                echo "</div>";
        
                if (isset($_POST["submitReply_$commentId"])) {
                    $replyAuthor = ($_SESSION["id"] != 0) ? $_SESSION["username"] : (isset($_POST["replyAuthor"]) ? $_POST["replyAuthor"] . "*" : "gość");
                    $replyComment = $_POST["replyComment"];
                    $commentId = $_POST["commentId"];
                    $userId = $_SESSION["id"];
        
                    $mysql = new mysqli("localhost", "root", "", "stronablogowa");
                    if ($mysql->connect_error) {
                        die("Błąd połączenia z bazą danych: " . $mysql->connect_error);
                    }
                    $sql = "INSERT INTO replies (CommentID, Content, date, UserID, Author) VALUES ($commentId, '$replyComment', NOW(), $userId, '$replyAuthor')";
        
                    if ($mysql->query($sql) === TRUE) {
                        echo "<p>Odpowiedź została dodana.</p>";
                    } else {
                        echo "Błąd dodawania odpowiedzi: " . $mysql->error;
                    }
                        }
        
                $replySql = "SELECT replies.Content, replies.date, replies.Author, users.login FROM replies INNER JOIN users ON replies.UserID = users.ID WHERE replies.CommentID = $commentId ORDER BY replies.date";
                $replyResult = $mysql->query($replySql);
        
                if ($replyResult->num_rows > 0) {
                    while ($replyRow = $replyResult->fetch_assoc()) {
                        echo "<div class='reply'>";
                        echo "<p><strong>" . (isset($replyRow["login"]) && $_SESSION["id"] != 0 ? $replyRow["login"] : $replyRow["Author"]) . "</strong></p>";
                        echo "<p>" . $replyRow["Content"] . "</p>";
                        echo "<p><em>" . $replyRow["date"] . "</em></p>";
                        echo "</div>";
                    }
                }
                echo "</div>";
            }
        } else {
            echo "Brak komentarzy.";
        }
        
        $mysql->close();
        ?>
        
        <?php
        /*
        if (isset($_POST["submitReply"])) {
            $replyAuthor = ($_SESSION["id"] != 0) ? $_SESSION["username"] : (isset($_POST["replyAuthor"]) ? $_POST["replyAuthor"] . "*" : "gość");
            $replyComment = $_POST["replyComment"];
            $commentId = $_POST["commentId"];
            $userId = $_SESSION["id"];

            $mysql = new mysqli("localhost", "root", "", "stronablogowa");
            if ($mysql->connect_error) {
                die("Błąd połączenia z bazą danych: " . $mysql->connect_error);
            }
            $sql = "INSERT INTO replies (CommentID, Content, date, UserID, Author) VALUES ($commentId, '$replyComment', NOW(), $userId, '$replyAuthor')";

            if ($mysql->query($sql) === TRUE) {
                echo "<p>Odpowiedź została dodana.</p>";
            } else {
                echo "Błąd dodawania odpowiedzi: " . $mysql->error;
            }

            $mysql->close();
        }
        */
        ?>
        
        <?php
        $mysql = new mysqli("localhost", "root", "", "stronablogowa");
        if ($mysql->connect_error) {
            die("Błąd połączenia z bazą danych: " . $mysql->connect_error);
        }

        if (isset($_SESSION["id"])) {
            $postId = $_GET["id"];
            $updateViews = "UPDATE posts SET view = view + 1 WHERE id = $postId";
            $mysql->query($updateViews);
        } else {
            echo "Niepoprawne żądanie.";
        }

        $mysql->close();
        ?>
    </div>

    <script>
        function toggleReplyForm(commentId) {
            var replyForm = document.getElementById("replyForm_" + commentId);
            if (replyForm.style.display === "none") {
                replyForm.style.display = "block";
            } else {
                replyForm.style.display = "none";
            }
        }
    </script>
    <footer>
    <p style="color: white;">Strona zrobiona przez Pawła Kulińskiego</p>

    </footer>
</body>
</html>