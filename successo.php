<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/successo.css">
    <title>C. - Successo</title>
</head>
<body>
    <div class="success-container">
        <h1>Successo</h1>
        <?php
            if (isset($_GET["successo"]) && isset($_GET["url"]) && isset($_GET["msgBottone"])) {
                
                $successo = urldecode($_GET["successo"]);
                $msgBottone = urldecode($_GET["msgBottone"]);
                $url = urldecode($_GET["url"]);
                
                echo "<p>$successo</p>
                      <a href='$url'>
                          <button>$msgBottone</button>
                      </a>";
            } else {
                echo "<p>Operazione completata con successo</p>
                      <a href='index.php'>
                          <button>Torna alla $msgBottone </button>
                      </a>";
            }
        ?>
    </div>
</body>
</html>
