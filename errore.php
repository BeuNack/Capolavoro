<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C. - Errore</title>
    <style>
        body {
            background-color: #c5ebc3ff;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #303245ff;
        }
        .error-container {
            background-color: #a09082ff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        .error-container h1 {
            color: #b33c86ff;
            font-size: 2em;
            margin-bottom: 10px;
        }
        .error-container p {
            color: #303245ff;
            font-size: 1.1em;
            margin-bottom: 20px;
        }
        .error-container a {
            text-decoration: none;
        }
        .error-container button {
            background-color: #303245ff;
            color: #c5ebc3ff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s;
        }
        .error-container button:hover {
            background-color: #b33c86ff;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <h1>Errore</h1>
        <?php
            if (isset($_GET["errore"]) && isset($_GET["url"]) && isset($_GET["msgBottone"]) && 
                strlen($_GET["errore"]) > 0 && strlen($_GET["url"]) > 0 && strlen($_GET["msgBottone"]) > 0) {
                
                $errore = urldecode($_GET["errore"]);
                $msgBottone = urldecode($_GET["msgBottone"]);
                $url = urldecode($_GET["url"]);
                
                echo "<p>$errore</p>
                      <a href='$url'>
                          <button>$msgBottone</button>
                      </a>";
            } else {
                echo "<p>Errore, qualcosa è andato storto</p>
                      <a href='index.php'>
                          <button>Torna al login</button>
                      </a>";
            }
        ?>
    </div>
</body>
</html>
