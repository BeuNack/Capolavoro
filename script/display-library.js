document.addEventListener("DOMContentLoaded", function() {
    if (typeof isbns !== "undefined" && isbns.length > 0) {
        isbns.forEach(isbn => {
            fetchBookDetails(isbn);
        });
    }
});

function fetchBookDetails(isbn) {
    let url = `https://www.googleapis.com/books/v1/volumes?q=isbn:${isbn}`;

    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.totalItems > 0) {
                let book = data.items[0];
                let volume_id = book.id;
                let title = book.volumeInfo.title || "Sconosciuto";
                let authors = book.volumeInfo.authors ? book.volumeInfo.authors.join(", ") : "Sconosciuto";
                let publisher = book.volumeInfo.publisher || "Sconosciuto";
                let thumbnail = book.volumeInfo.imageLinks ? book.volumeInfo.imageLinks.thumbnail : "Nessuna immagine disponibile";
                let price = "NON IN VENDITA";

                if (book.saleInfo && book.saleInfo.listPrice && book.saleInfo.listPrice.amount) {
                    price = `${book.saleInfo.listPrice.amount} ${book.saleInfo.listPrice.currencyCode}`;
                }

                updateBookList(volume_id, isbn, title, authors, publisher, thumbnail, price);
            } else {
                updateBookList(null, isbn, "Informazioni non trovate", "", "", "", "");
            }
        })
        .catch(error => {
            console.error("Errore nel recupero del libro:", error);
            updateBookList(null, isbn, "Errore nel recupero", "", "", "", "");
        });
}

function updateBookList(volume_id, isbn, title, authors, publisher, thumbnail, price) {
    let bookList = document.getElementById("book-list");
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
                <form class="add-to-library-form" action="../action/rimuoviLibro.php" method="POST">
                    <input type="hidden" name="volume_id" value="${volume_id}">
                    <input type="hidden" name="isbn" value="${isbn}">
                    <input type="hidden" name="title" value="${title}">
                    <input type="hidden" name="authors" value="${authors}">
                    <input type="hidden" name="publisher" value="${publisher}">
                    <input type="hidden" name="price" value="${price}">
                    <input type="hidden" name="thumbnail" value="${thumbnail}">
                    <button class="add-to-library-button" type="submit">Rimuovi dalla Libreria</button>
                </form>
            </div>
        </div>
    `;
    bookList.innerHTML += bookItem;
}
