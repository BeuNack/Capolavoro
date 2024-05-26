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
            if(isset($_POST['volume_id'],
                $_POST['isbn'],
                $_POST['title'],
                $_POST['authors'],
                $_POST['publisher'],
                $_POST['price']
                )){

                

                    
                    $volume_id =    $_POST['volume_id'];
                    $isbn =         $_POST['isbn'];
                    $title =        $_POST['title'];
                    $authors =      $_POST['authors'];
                    $publisher =    $_POST['publisher'];
                    $price =        $_POST['price'];
                    $email =        $_SESSION['email'];


                    // Visualizza i valori delle variabili sulla pagina web
                    echo "<p>Volume ID: " . $volume_id . "</p>";
                    echo "<p>ISBN: " . $isbn . "</p>";
                    echo "<p>Title: " . $title . "</p>";
                    echo "<p>Authors: " . $authors . "</p>";
                    echo "<p>Publisher: " . $publisher . "</p>";
                    echo "<p>Price: " . $price . "</p>";
                    
                    
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

                        // Devo controllare se l'utente già possiede il libro
                        $stmt = $conn->prepare("SELECT isbn FROM libreria WHERE isbn = ? AND email = ?");
                        $stmt->bind_param("ss", $isbn, $email);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        
                        if($result->num_rows > 0) {
                            errorRedirect("Libro già aggiunto alla libreria ", "index.php", "Torna alla pagina principale");
                    
                        }else{
                            // Posso inserirlo
                            $stmt2 = $conn->prepare("INSERT INTO libreria (isbn,email) VALUES (?, ?)");
                            $stmt2->bind_param("ss", $isbn, $email);
                            $stmt2->execute();
                            if(!$stmt2) {
                                errorRedirect("Errore nella esecuzione" , "index.php", "Torna alla pagina principale");
                            }
                            successRedirect("Inserimento avvenuto correttamente", "libreria.php", "Vai alla libreria");
                        }



                    } catch(mysqli_sql_exception $e) {
                        errorRedirect("Errore: " . htmlspecialchars($e->getMessage()), "index.php", "Torna alla pagina principale");
                    }
                    
                }else{
                    echo "Prova";
                }




        }else{
            echo "errore";
            
        }

        
    ?>
</body>
</html>

