<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C. - Errore</title>
    <link rel="stylesheet" type="text/css" href="css/errore.css">
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
