document.addEventListener('DOMContentLoaded', () => {
    const libraryButton = document.querySelector('.library-button');
    libraryButton.addEventListener('click', () => {
        alert('Naviga alla tua libreria personale!');
        // Aggiungi qui la logica per navigare alla libreria personale.
    });

    // Aggiungi animazione all'icona della libreria personale
    libraryButton.addEventListener('mouseenter', () => {
        libraryButton.querySelector('i').classList.add('fa-spin');
    });

    libraryButton.addEventListener('mouseleave', () => {
        libraryButton.querySelector('i').classList.remove('fa-spin');
    });
});
