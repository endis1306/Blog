<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Strona Blogowa - Wyniki wyszukiwania</title>
    <link rel="stylesheet" href="styles/style.css">
    <style>
        .blog-frame {
            width: 50%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php
    session_start();
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
    </header>
    <div class="blog-frame">
        <a href="index.php" id="sg" style= 'color: black;'>Strona główna</a>
        <h2>Wyniki wyszukiwania</h2>
        <?php
        
        $mysql= new mysqli(
            getenv("DB_HOST"),
            getenv("DB_USER"),
            getenv("DB_PASS"),
            getenv("DB_NAME")
        );

        if ($mysql->connect_error) {
            die("Błąd połączenia z bazą danych: " . $mysql->connect_error);
        }

        if (isset($_GET["search"])) {
            $search = $_GET["search"];

            $sql = "SELECT users.id as author_id,posts.id, posts.title, users.login FROM posts INNER JOIN users ON posts.UserID = users.ID WHERE posts.title LIKE '%$search%'";
            $result = $mysql->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<h3>" . $row["title"] . "</h3>";
                    echo "<p>Autor: " . $row["login"] . "</p>";
                    echo "<a href='blogs.php?id=" . $row["id"] . "&author_id= " . $row["author_id"] . "' style='color: black;'>Przejdź do bloga</a>";
                    echo "<hr>";
                }
            } else {
                echo "Brak wyników dla wyszukiwania: " . $search;
            }
        } else {
            echo "Niepoprawne żądanie.";
        }

        $mysql->close();
        ?>
    </div>
    <footer>
    <p style="color: white;">Strona zrobiona przez Pawła Kulińskiego</p>
    </footer>
</body>
</html>