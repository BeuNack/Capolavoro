<?php

    require("../config-function/config.php");
    require("../config-function/function.php");




    //Se reg = y si sta registrando
    if(isset($_POST["nome"]) && isset($_POST["cognome"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_GET["reg"]) && $_GET["reg"] == "y") {
        // Sanificazione dell'input
        $nome = htmlspecialchars($_POST["nome"]);
        $cognome = htmlspecialchars($_POST["cognome"]);
        $email = htmlspecialchars($_POST["email"]);
        $psw = password_hash($_POST["password"], PASSWORD_DEFAULT); // Usa password_hash per una maggiore sicurezza
    
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
            $stmt = $conn->prepare("SELECT email FROM utenti WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
    
            $result = $stmt->get_result();
    
            // Controllo se l'email è già in uso
            if($result->num_rows > 0) {
                errorRedirect("Email già in uso", "login/registrazione.php", "Torna alla registrazione");
            } else {
                // Inserisco nel DB
                $stmt2 = $conn->prepare("INSERT INTO utenti (nome, cognome, email, password) VALUES (?, ?, ?, ?)");
                $stmt2->bind_param("ssss", $nome, $cognome, $email, $psw);
                $stmt2->execute();
                if(!$stmt2) {
                    errorRedirect("Errore nella esecuzione", "errore.php", "Torna alla registrazione");
                } else {
                    // Inserimento riuscito, mando l'utente alla home
                    session_start();
                    $_SESSION["nome"] = $nome;
                    $_SESSION["cognome"] = $cognome;
                    $_SESSION["email"] = $email;
                    header("Location: ../main/index.php");
                    exit();
                }
            }
    
            $stmt->close();
            $stmt2->close();
            $conn->close(); // Chiusura della connessione
        } catch(mysqli_sql_exception $e) {
            errorRedirect("Errore: " . htmlspecialchars($e->getMessage()), "errore.php", "Torna alla registrazione");
        }
    }

    // Se reg = n sta accedendo
if(isset($_POST["email"]) && isset($_POST["password"]) && isset($_GET["reg"]) && $_GET["reg"] == "n") {
    
    // Recupero i dati
    $email = htmlspecialchars($_POST["email"]);
    $psw = $_POST["password"];

    // Connessione al DB
    try {
        $conn = new mysqli($dati_conn["mysql_host"], $dati_conn["mysql_user"], $dati_conn["mysql_password"], $dati_conn["mysql_db"]);
        if($conn->connect_error) {
            errorRedirect("Connessione non riuscita, errore: " . htmlspecialchars($conn->connect_error), "login/login.php", "Torna al login");
        }
    } catch(mysqli_sql_exception $e) {
        errorRedirect("Connessione non riuscita, errore: " . htmlspecialchars($e->getMessage()), "login/login.php", "Torna al login");
    }

    try {
        $stmt = $conn->prepare("SELECT nome, cognome, password FROM utenti WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if(password_verify($psw, $row['password'])) {
                // Login riuscito, avviare la sessione
                session_start();
                $_SESSION["nome"] = $row["nome"];
                $_SESSION["cognome"] = $row["cognome"];
                $_SESSION["email"] = $email;
                header("Location: ../main/index.php");
                exit();
            } else {
                errorRedirect("Password errata", "login/login.php", "Torna al login");
            }
        } else {
            errorRedirect("Email non trovata", "login/login.php", "Torna al login");
        }

        $stmt->close();
        $conn->close();
    } catch(mysqli_sql_exception $e) {
        errorRedirect("Errore: " . htmlspecialchars($e->getMessage()), "errore.php", "Torna al login");
    }
}



    





?>