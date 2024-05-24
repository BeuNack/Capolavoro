<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <title>Cerca Libri</title>
</head>
<body>

    <h1>Cerca Libri</h1>
    <div class="navbar">
        <form id="search-form">
            <input type="text" id="search-input" placeholder="Inserisci il titolo, autore o ISBN del libro">
            <button type="submit">Cerca</button>
        </form>
        <div class="user">
            <?php
                require_once("config-function/config.php");
                require_once("config-function/function.php");

                //Se l'utente è collegato lo mando sul suo profilo
                session_start();

                if(isset($_SESSION["nome"])){
                    $email = $_SESSION["nome"];
                    echo "Ciao " . $email;
                    echo "<a href='libreria.php'>";

                }else{
                    //Se la sessione non è attiva, lo mando alla pagina di registrazione
                    echo "nah bro";
                    echo "<a href='login/login.php'>";
                }

                
            ?>
            <img src="images/user.png" id="u-profile"><?php echo "</a>"?>
            <img src="images/books.png" id="u-bookshelf">    
        </div>
    </div>
    <div id="book-list"></div>
    <div id="pagination" style="display: none;">
        <button id="prev-button">Indietro</button>
        <span id="page-counter">1/1</span>
        <button id="next-button">Avanti</button>
    </div>

    <form id="add-to-library-form" action="aggiungiLibro.php" method="post">
        <input type="hidden" id="title" name="title" value="">
        <input type="hidden" id="authors" name="authors" value="">
        <input type="hidden" id="publisher" name="publisher" value="">
        <input type="hidden" id="reviews" name="reviews" value="">
        <input type="hidden" id="price" name="price" value="">
    </form>

    <script>
        document.getElementById("search-form").addEventListener("submit", function(event) {
            event.preventDefault();
            startIndex = 0;
            let searchQuery = document.getElementById("search-input").value;
            searchBooks(searchQuery);
        });

        let startIndex = 0;
        let maxResults = 20;

        function searchBooks(query) {
            let isISBN = /^[0-9]{10}([0-9]{3})?$/.test(query); // Verifica se la query è un ISBN di 10 o 13 cifre
            let url;

            if (isISBN) {
                url = `https://www.googleapis.com/books/v1/volumes?q=isbn:${encodeURIComponent(query)}&startIndex=${startIndex}&maxResults=${maxResults}`;
            } else {
                url = `https://www.googleapis.com/books/v1/volumes?q=${encodeURIComponent(query)}&startIndex=${startIndex}&maxResults=${maxResults}`;
            }

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    displayBooks(data.items);
                    if (data.items.length > 0) {
                        document.getElementById("pagination").style.display = "block";
                        updatePageCounter(data);
                        console.log(data);
                    } else {
                        document.getElementById("pagination").style.display = "none";
                    }
                })
                .catch(error => console.error("Errore nella ricerca:", error));
        }


        function displayBooks(books) {
            let bookList = document.getElementById("book-list");
            bookList.innerHTML = "";

            if (books.length === 0) {
                bookList.innerHTML = "Nessun risultato trovato.";
                return;
            }

            books.forEach(book => {
                let volume_id = book.id; // Utilizza l'ID del volume di Google Books
                let title = book.volumeInfo.title;
                let authors = book.volumeInfo.authors ? book.volumeInfo.authors.join(", ") : "Sconosciuto";
                let publisher = book.volumeInfo.publisher ? book.volumeInfo.publisher : "Sconosciuto";
                let thumbnail = book.volumeInfo.imageLinks ? book.volumeInfo.imageLinks.thumbnail : "Nessuna immagine disponibile";
                let price = "NON IN VENDITA"; 

                if (book.saleInfo && book.saleInfo.listPrice && book.saleInfo.listPrice.amount) {
                    price = `${book.saleInfo.listPrice.amount} ${book.saleInfo.listPrice.currencyCode}`;
                }

                // Estrarre l'ISBN
                let isbn = "N/A";
                if (book.volumeInfo.industryIdentifiers) {
                    book.volumeInfo.industryIdentifiers.forEach(identifier => {
                        if (identifier.type === "ISBN_13") {
                            isbn = identifier.identifier;
                        }
                    });
                }

                let bookItem = `
                    <div class="book-item" data-volume-id="${volume_id}" data-isbn="${isbn}">
                        <img src="${thumbnail}" alt="${title}">
                        <div class="book-item-details">
                            <h2 class="title">${title}</h2>
                            <div class="book-info">
                                <p><strong>Autore:</strong> ${authors}</p>
                                <p><strong>Editore:</strong> ${publisher}</p>
                                <p><strong>Prezzo:</strong> ${price}</p>
                                <p><strong>ISBN:</strong> ${isbn}</p>
                            </div>
                            <button class="add-to-library-button" onclick="addToLibrary(this)">Aggiungi alla Libreria</button>
                        </div>
                    </div>
                `;
                bookList.innerHTML += bookItem;
            });
        }


        function updatePageCounter(data) {
            let pageCounter = document.getElementById("page-counter");
            let currentPage = Math.floor(startIndex / maxResults) + 1;
            let totalPages = Math.ceil(data.totalItems / maxResults);
            pageCounter.textContent = `${currentPage}/${totalPages}`;
        }

        document.getElementById("next-button").addEventListener("click", function() {
            startIndex += maxResults;
            let searchQuery = document.getElementById("search-input").value;
            searchBooks(searchQuery);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        document.getElementById("prev-button").addEventListener("click", function() {
            startIndex -= maxResults;
            if (startIndex < 0) {
                startIndex = 0;
            }
            let searchQuery = document.getElementById("search-input").value;
            searchBooks(searchQuery);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        function addToLibrary(button) {
            let bookItem = button.closest(".book-item");
            let volume_id = bookItem.getAttribute("data-volume-id"); // Utilizza l'ID del volume di Google Books
            let isbn = bookItem.getAttribute("data-isbn"); // Assicurati di avere un attributo data-isbn nel div del libro
            let title = bookItem.querySelector(".title").textContent;
            let authors = bookItem.querySelector(".book-info").children[0].textContent.split(": ")[1];
            let publisher = bookItem.querySelector(".book-info").children[1].textContent.split(": ")[1];
            let price = bookItem.querySelector(".book-info").children[2].textContent.split(": ")[1];
            let url = "../libreria.php";

            let bookData = {
                volume_id: volume_id,
                isbn: isbn,
                title: title,
                authors: authors,
                publisher: publisher,
                price: price,
                url : url
            };

            $.post("action/aggiungiLibro.php", bookData)
                .done(function(response) {
                    // Handle response from server, if needed
                    console.log("Response:", response);
                    // Naviga verso un'altra pagina
                    window.location.href = "action/aggiungiLibro.php";

                })
                .fail(function(error) {
                    // Handle error, if any
                    console.error("Error:", error);
                });

                    }




    </script>
</body>
</html>
