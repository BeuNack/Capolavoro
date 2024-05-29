<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C. - Aggiungi Libro</title>
</head>
<body>
    
    <?php
        require_once("../config-function/config.php");
        require_once("../config-function/function.php");

        session_start();

        //Controllo se è loggato
        if(!isset($_SESSION["email"])){
            header("Location: ../login/login.php");
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if(isset($_POST['isbn']
                )){

                    $isbn =         $_POST['isbn'];
                    $email =        $_SESSION['email'];
                    
                    
                    //Connessione al DB
                    try {
                        $conn = new mysqli($dati_conn["mysql_host"], $dati_conn["mysql_user"], $dati_conn["mysql_password"], $dati_conn["mysql_db"]);
                        if($conn->connect_error) {
                            errorRedirect("Connessione con il DB non riuscita, errore: " . htmlspecialchars($conn->connect_error), "index.php", "Torna alla pagina principale");
                        }
                    } catch(mysqli_sql_exception $e) {
                        errorRedirect("Connessione con il DB non riuscita, errore: " . htmlspecialchars($e->getMessage()), "index.php", "Torna alla home");
                    }

                    try {

                        // Elimino il libro
                        $stmt = $conn->prepare("DELETE from libreria WHERE isbn = ? AND email = ?");
                        $stmt->bind_param("ss", $isbn, $email);
                        $stmt->execute();
                        
                        if(!$stmt){
                            errorRedirect("Errore rimozione del libro" , "index.php", "Torna alla pagina principale");   
                        }else{
                            successRedirect("Rimozione avvenuto correttamente", "libreria.php", "Vai alla libreria");
                        
                        }

                    } catch(mysqli_sql_exception $e) {
                        errorRedirect("Errore: " . htmlspecialchars($e->getMessage()), "index.php", "Torna alla pagina principale");
                    }
                    
                }else{
                    errorRedirect("Errore rimozione del libro" , "index.php", "Torna alla pagina principale");   
                }




        }else{
            errorRedirect("Errore rimozione del libro" , "index.php", "Torna alla pagina principale");               
        }

        
    ?>
</body>
</html>

