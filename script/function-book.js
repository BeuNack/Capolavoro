
let startIndex = 0;
const maxResults = 20;

document.getElementById("search-form").addEventListener("submit", function(event) {
    event.preventDefault();
    startIndex = 0;
    let searchQuery = document.getElementById("search-input").value;
    searchBooks(searchQuery, startIndex);
});

function searchBooks(query, startIndex) {
    let isISBN = /^[0-9]{10}([0-9]{3})?$/.test(query);
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
                updatePageCounter(data.totalItems);
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
        let isbn = null;
        if (book.volumeInfo.industryIdentifiers) {
            book.volumeInfo.industryIdentifiers.forEach(identifier => {
                if (identifier.type === "ISBN_13") {
                    isbn = identifier.identifier;
                }
            });
        }

         // Se non c'è ISBN, non visualizzare il libro
         if (!isbn) {
            return;
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
                        <p class="data-isbn"><strong>ISBN:</strong> ${isbn}</p>
                    </div>
                    <form class="add-to-library-form" action="action/aggiungiLibro.php" method="POST">
                        <input type="hidden" name="volume_id" value="${volume_id}">
                        <input type="hidden" name="isbn" value="${isbn}">
                        <input type="hidden" name="title" value="${title}">
                        <input type="hidden" name="authors" value="${authors}">
                        <input type="hidden" name="publisher" value="${publisher}">
                        <input type="hidden" name="price" value="${price}">
                        <input type="hidden" name="thumbnail" value="${thumbnail}">
                        <button class="add-to-library-button" type="submit">Aggiungi alla Libreria</button>
                    </form>
                </div>
            </div>
        `;
        bookList.innerHTML += bookItem;
    });
}

function updatePageCounter(totalItems) {
    let pageCounter = document.getElementById("page-counter");
    let totalPages = Math.ceil(totalItems / maxResults);
    let currentPage = Math.min(Math.ceil(startIndex / maxResults) + 1, totalPages);
    pageCounter.textContent = `${currentPage}/${totalPages}`;
}

document.getElementById("next-button").addEventListener("click", function() {
    startIndex += maxResults;
    let searchQuery = document.getElementById("search-input").value;
    searchBooks(searchQuery, startIndex);
    window.scrollTo({ top: 0, behavior: 'smooth' });
});

document.getElementById("prev-button").addEventListener("click", function() {
    startIndex -= maxResults;
    startIndex = Math.max(startIndex, 0); // Assicura che startIndex non sia inferiore a 0
    let searchQuery = document.getElementById("search-input").value;
    searchBooks(searchQuery, startIndex);
    window.scrollTo({ top: 0, behavior: 'smooth' });
});

