<?php


    function errorRedirect($msgErrore,$urlButton,$msgButton){
        $errore = urlencode($msgErrore);
        $url = urlencode($urlButton);
        $msgBottone = urlencode($msgButton);
        header("location:../errore.php?errore=$errore&url=$url&msgBottone=$msgBottone");
        exit;
    }

    
    function session_close(){
        $_SESSION = array();
        session_destroy();
    }

?>