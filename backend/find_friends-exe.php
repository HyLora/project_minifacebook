<?php
session_start();

$nome = "find_friends"; // Imposto un valore predefinito per $nome

if ($_SESSION["tipo"] == "amministratore") {
	$nome = "find_admin_exe";
} else {
	$nome = "find_exe";
}

include_once("../common/connection.php");
include_once("../common/funzioni.php");
include_once("../common/navbar.php");
include_once("../common/header.php");

if (isset($_SESSION["logged"])){
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $login = $_POST["email"];
        $nome = $_POST["nome"];
        $cognome = $_POST["cognome"];
        $orientamento = $_POST["sex"];
        $hobby = $_POST["hobby"];
        $citta = $_POST["Citta"];
        $provincia = $_POST["Provincia"];
        $stato = $_POST["Stato"];
        $luogoDiNascita = $_POST["luogoNascita"];

        $ris= findFriends($cid, $login, $nome, $cognome, $orientamento, $hobby, $citta, $provincia, $stato, $luogoDiNascita);

        if (isset($ris["status"]))
            {
                if ($ris["status"] == "ko")
                    {
                        echo "<div class='alert alert-warning'>\n";
                        echo $ris["msg"];
                        echo "</div>";
                    } else {
                        echo "<div class='alert alert-success'>\n";
                        echo $ris["msg"];
                        echo "</div>";
                    }
            }
        printSearch($ris["contenuto"]);
    } else {
        echo "<script>window.location.href = '../frontend/find_friends.php?status=ko&msg=Per favore rieffettua la ricerca';</script>";
        exit();
    }
}
include_once("../common/footer.php");