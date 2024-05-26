<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C. - Successo</title>
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
        .success-container {
            background-color: #a09082ff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        .success-container h1 {
            color: #4caf50; /* Verde per indicare successo */
            font-size: 2em;
            margin-bottom: 10px;
        }
        .success-container p {
            color: #303245ff;
            font-size: 1.1em;
            margin-bottom: 20px;
        }
        .success-container a {
            text-decoration: none;
        }
        .success-container button {
            background-color: #303245ff;
            color: #c5ebc3ff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s;
        }
        .success-container button:hover {
            background-color: #4caf50;
        }
    </style>
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
