<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <title>C - Cerca Libri</title>
</head>
<body>
    
    <h1>Cerca Libri</h1>
    <form id="search-form">
        <input type="text" id="search-input" placeholder="Inserisci il titolo, autore o ISBN del libro">
        <button type="submit">Cerca</button>
    </form>
    <div id="book-list"></div>
    <div id="pagination" style="display: none;">
        <button id="prev-button">Indietro</button>
        <span id="page-counter">1/1</span>
        <button id="next-button">Avanti</button>
    </div>

    <script>
        document.getElementById("search-form").addEventListener("submit", function(event) {
            event.preventDefault();
            startIndex = 0; // Resetta l'indice di inizio quando si esegue una nuova ricerca
            let searchQuery = document.getElementById("search-input").value;
            searchBooks(searchQuery);
        });

        // Variabili globali per tenere traccia della paginazione
        let startIndex = 0;
        let maxResults = 20;

        function searchBooks(query) {
            let url = `https://www.googleapis.com/books/v1/volumes?q=${encodeURIComponent(query)}&startIndex=${startIndex}&maxResults=${maxResults}`;

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
                let title = book.volumeInfo.title;
                let authors = book.volumeInfo.authors ? book.volumeInfo.authors.join(", ") : "Sconosciuto";
                let thumbnail = book.volumeInfo.imageLinks ? book.volumeInfo.imageLinks.thumbnail : "Nessuna immagine disponibile";
                let price = "NON IN VENDITA"; // Imposta il prezzo predefinito

                // Aggiungi il prezzo se disponibile
                if (book.saleInfo && book.saleInfo.listPrice && book.saleInfo.listPrice.amount) {
                    price = `${book.saleInfo.listPrice.amount} ${book.saleInfo.listPrice.currencyCode}`;
                }

                let bookItem = `
                    <div class="book-item">
                        <img src="${thumbnail}" alt="${title}">
                        <h2 class="title">${title}</h2>
                        <p><strong>Autore:</strong> ${authors}</p>
                        <p><strong>Prezzo:</strong> ${price}</p>
                        <button class="add-to-library-button">Aggiungi alla Libreria</button>
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

        // Gestione dei pulsanti "Avanti" e "Indietro"
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
    </script>
</body>
</html>
