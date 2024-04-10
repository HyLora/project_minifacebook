<?php
session_start();
include_once "../common/connection.php";
include_once "../common/funzioni.php";

if (isset($_SESSION["logged"])){
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $tipo = $_POST["Tipo"];

        if ($tipo === "foto") {

            $nomeutente = (!empty($_SESSION["email"])) ? explode('@', $_SESSION["email"])[0] : NULL;
            $userFolder = "../images/images_" . $nomeutente;
            if (!file_exists($userFolder)) {
                //permessi 0777 (concedono tutti permessi (per proprietario, gruppo e altri utenti)
                //true specifica che creazione deve essere ricorsiva ==> create anche le directory padre necessarie
                mkdir($userFolder, 0777, true);
            }

            $descrizione = isset($_POST["Descrizione"]) ? $_POST["Descrizione"] : "";


            // Processa la descrizione della foto
            echo "Hai creato un post con foto e descrizione: " . $descrizione;
        } elseif ($tipo === "testo") {
            $contenuto = isset($_POST["Contenuto"]) ? $_POST["Contenuto"] : "";
            // Processa il contenuto del post di testo
            echo "Hai creato un post di testo con contenuto: " . $contenuto;
        } else {
            // Gestisci eventuali altri tipi di post
            echo "Tipo di post non supportato";
        }
    }
    $login = $_SESSION["email"];
	$ris= createPost($cid, $login, $tipo, $descrizione, $contenuto);

		if ($ris["status"]=='ok')
		{
			header("location: ../frontend/myaccount.php?status=ok&msg=" . urlencode($ris["msg"]));
		}
		else
		{	header('location: ../frontend/myaccount.php?status=ko&msg='.  urlencode($ris["msg"]));}
	}
	else
	{
		header("Location:../index.php?status=ko&msg=". urlencode("Operazione riservata ad utenti registrati. Procedi con la login"));    
}