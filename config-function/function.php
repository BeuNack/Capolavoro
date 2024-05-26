<?php


    function errorRedirect($msgErrore,$urlButton,$msgButton){
        $errore = urlencode($msgErrore);
        $url = urlencode($urlButton);
        $msgBottone = urlencode($msgButton);
        header("location:../errore.php?errore=$errore&url=$url&msgBottone=$msgBottone");
        exit;
    }

    function successRedirect($msgSuccesso,$urlButton,$msgButton){
        $successo = urlencode($msgSuccesso);
        $url = urlencode($urlButton);
        $msgBottone = urlencode($msgButton);
        header("location:../successo.php?successo=$successo&url=$url&msgBottone=$msgBottone");
        exit;
    }

    
    function session_close(){
        $_SESSION = array();
        session_destroy();
    }

?>