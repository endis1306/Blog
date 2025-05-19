<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Strona Blogowa - Czat z Autorem</title>
    <style>
        body, h1, h2, h3, h4, h5, h6, p, ul, ol, li {
    margin: 0;
    padding: 0;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
}

.chat-container {
    width: 500px;
    margin: 0 auto;
    background-color: #fff;
    padding: 20px;
    margin-top: 20px;
}

.chat-container h2 {
    font-size: 24px;
    margin-bottom: 10px;
}

.chat-message {
    margin-bottom: 10px;
}

.chat-message strong {
    color: blue;
}

.chat-form {
    margin-top: 10px;
}

.chat-form input[type="text"] {
    padding: 5px;
    border-radius: 5px;
    border: none;
}

.chat-form input[type="submit"] {
    padding: 5px 10px;
    border-radius: 5px;
    background-color: #555;
    border: none;
    color: #fff;
    cursor: pointer;
}
a{
    text-decoration: none;
    color: black;
}
footer {
    background-color: #333;
    color: #fff;
    padding: 20px;
    text-align: center;
    font-size: 14px;
}
    </style>
</head>
<body>
    <div class="chat-container">
        <h2>Czat z Autorem</h2>
        <a href="index.php">Strona główna</a>
        <div class="chat-messages">
            <?php
            session_start();
            if (isset($_GET['author_id'])) {
                $_SESSION['author_id'] = $_GET['author_id'];
            }
            $conn= new mysqli(
                getenv("DB_HOST"),
                getenv("DB_USER"),
                getenv("DB_PASS"),
                getenv("DB_NAME")
            );
            if ($conn->connect_error) {
                die("Nieudane połączenie: " . $conn->connect_error);
            }
            ?>
        </div>

        <form class="chat-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="text" name="message" placeholder="Wiadomość" required>
            <input type="hidden" name="author_id" value="<?php echo $_SESSION['author_id']; ?>">
            <input type="submit" value="Wyślij">
        </form>

        <?php
            $user_id = $_SESSION['id'];        
            $author_id = $_SESSION['author_id'];
            if(isset($_POST['message'])){
            $message = $_POST['message'];

            $insert_query = "INSERT INTO messages (user_id, author_id, message, timestamp) VALUES ('$user_id', '$author_id', '$message', NOW())";
            if ($conn->query($insert_query) === TRUE) {
                echo "<p>Wiadomość została wysłana</p>";
            } else {
                echo "Błąd podczas wysyłania wiadomości: " . $conn->error;
            }
         }
        $select_query = "SELECT * FROM messages inner join users on messages.user_id = users.ID where (user_id = $user_id and author_id = $author_id) or (user_id = $author_id and author_id = $user_id)  ORDER BY timestamp DESC";
            $result = $conn->query($select_query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='chat-message'>";
                    echo "<strong>" . $row["Login"] . ":</strong> " . $row["message"];
                    echo "</div>";
                }
            } else {
                echo "Brak wiadomości";
            }
        $conn->close();
        ?>
    </div>
    <footer>
        <p>Strona napisana przez Pawła Kulińskiego</p>
    </footer>
</body>
</html>