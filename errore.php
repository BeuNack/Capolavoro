<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Errore</title>
</head>
<body>
    <h1>Errore</h1>
    
    <?php
    

        if(isset($_GET["errore"]) && isset($_GET["url"]) && isset($_GET["msgBottone"]) && 
           strlen($_GET["errore"]) > 0 && strlen($_GET["url"]) > 0 && strlen($_GET["msgBottone"]) > 0
        ){

            $errore = urldecode($_GET["errore"]);
            $msgBottone = urldecode($_GET["msgBottone"]);
            $url = urldecode($_GET["url"]);
            echo "<p>$errore</p>
            <a href='$url'>
            <button>$msgBottone</button>
            </a>";

        }else{
            echo "<p>errore, qualcosa è andato storto</p>
            <a href='index.php'>
            <button>torna al login</button>
            </a>";
        }
    
    
    ?>
    
</body>
</html>