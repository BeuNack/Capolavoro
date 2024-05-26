<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        </div>
    </div>
    <div id="book-list"></div>
    <div id="pagination" style="display: none;">
        <button id="prev-button">Indietro</button>
        <span id="page-counter">1/1</span>
        <button id="next-button">Avanti</button>
    </div>


</body>
<script src="script/function-book.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
</html>
