<?php
session_start();
require_once("config-function/config.php");

if (!isset($_SESSION['username'])) {
    echo "<p>Devi effettuare il login per vedere la tua libreria.</p>";
    echo "<a href='login/login.php'><button>Login</button></a>";
    exit();
}

$conn = new mysqli($dati_conn["mysql_host"],$dati_conn["mysql_user"],$dati_conn["mysql_password"],$dati_conn["mysql_db"]);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

$username = $_SESSION['nome'];
$query = "SELECT ISBN, StatoLettura FROM Libro WHERE Username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

$books = [];
while ($row = $result->fetch_assoc()) {
    $isbn = $row['ISBN'];
    $statoLettura = $row['StatoLettura'];
    
    // Fetch book details from Google Books API
    $url = "https://www.googleapis.com/books/v1/volumes?q=isbn:" . $isbn;
    $bookData = file_get_contents($url);
    $bookData = json_decode($bookData, true);
    
    if (isset($bookData['items'][0])) {
        $bookInfo = $bookData['items'][0]['volumeInfo'];
        $title = $bookInfo['title'] ?? 'Titolo non disponibile';
        $authors = isset($bookInfo['authors']) ? implode(', ', $bookInfo['authors']) : 'Autore non disponibile';
        $thumbnail = $bookInfo['imageLinks']['thumbnail'] ?? 'Nessuna immagine disponibile';

        $books[] = [
            'title' => $title,
            'authors' => $authors,
            'thumbnail' => $thumbnail,
            'statoLettura' => $statoLettura,
            'isbn' => $isbn
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Mia Libreria</title>
    <link rel="stylesheet" type="text/css" href="css/libreria.css">
</head>
<body>
    <div class="container">
        <h1>La Mia Libreria</h1>
        <div class="book-list">
            <?php if (count($books) > 0): ?>
                <?php foreach ($books as $book): ?>
                    <div class="book-item">
                        <img src="<?= $book['thumbnail'] ?>" alt="Copertina di <?= htmlspecialchars($book['title']) ?>">
                        <div class="book-details">
                            <h2><?= htmlspecialchars($book['title']) ?></h2>
                            <p><strong>Autore:</strong> <?= htmlspecialchars($book['authors']) ?></p>
                            <p><strong>Stato di lettura:</strong> <?= htmlspecialchars($book['statoLettura']) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Nessun libro trovato nella tua libreria.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>