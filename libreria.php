<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C. - Libreria</title>
    <link rel="stylesheet" type="text/css" href="css/library.css">
    
</head>
<body>

    <div style="text-align: center; margin-top: 10px;">
        <a href="index.php">
            <button style="
                background-color: #4CAF50; 
                color: white; 
                border: none; 
                padding: 15px 32px; 
                text-decoration: none; 
                display: inline-block; 
                font-size: 16px; 
                margin: 4px 2px; 
                cursor: pointer;
                transition: background-color 0.3s ease;">
                Torna alla Home
            </button>
        </a>
    </div>


    <?php
        require_once("config-function/config.php");
        require_once("config-function/function.php");

        session_start();

        //Controllo se si vuole sloggare
        if(isset($_POST["logOut"])){
            session_close();
            header("Location: index.php");
        }

        //Controllo se è loggato
        if(!isset($_SESSION["email"])){
            errorRedirect("Non sei loggato " . htmlspecialchars($conn->connect_error), "login/login.php", "Accedi con il tuo account");
        }

         // Connessione al DB
        try {
            $conn = new mysqli($dati_conn["mysql_host"], $dati_conn["mysql_user"], $dati_conn["mysql_password"], $dati_conn["mysql_db"]);
            if($conn->connect_error) {
                errorRedirect("Connessione non riuscita, errore: " . htmlspecialchars($conn->connect_error), "login/registrazione.php", "Torna alla registrazione");
            }
        } catch(mysqli_sql_exception $e) {
            errorRedirect("Connessione non riuscita, errore: " . htmlspecialchars($e->getMessage()), "login/registrazione.php", "Torna alla registrazione");
        }

        try {

            //PRENDERE TUTTI I DATI DI X UTENTE ( X E' QUELLO CON LA SESSIONE)
            
            $email = $_SESSION["email"];

            $stmt = $conn->prepare("SELECT isbn FROM libreria WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();

            $result = $stmt->get_result();

            $isbns = [];

            if ($result->num_rows > 0) {
                // L'utente ha libri nella libreria
                echo "<h1>I tuoi libri:</h1>";

                // Itera sui risultati della query e salva gli ISBN
                while ($row = $result->fetch_assoc()) {
                    $isbns[] = $row["isbn"];
                }
            } else {
                // L'utente non ha libri nella libreria
                echo "<div style='display: flex; justify-content: center; align-items: center;margin-top:20px'>
                        <h2 style='margin: 0;'>NON HAI LIBRI NELLA TUA LIBRERIA</h2>
                    </div>";
            }

            // Passa gli ISBN a JavaScript
            echo "<script>var isbns = " . json_encode($isbns) . ";</script>";




        }catch(mysqli_sql_exception $e) {
            errorRedirect("Errore: " . htmlspecialchars($e->getMessage()), "index.php", "Torna alla pagina principale");
        }



    ?>


    <div id="book-list"></div>

    <form action="libreria.php" method="post">
        <input type="hidden" name="logOut">
        <button type="submit" style="color: black; border: 2px solid black; padding: 10px 20px; cursor: pointer; outline: none; margin-top:10px">Log Out</button>
    </form>

        
    
</body>
<script src="script/display-library.js"></script>
</html>