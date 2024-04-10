<?php
 session_start();
 include_once "../common/connection.php";
 include_once "../common/funzioni.php";

 $utente = $_SESSION["email"];
 $amico = $_POST["accetta"];
 
if (isset($_SESSION["logged"]))
{
    $ris=accettaAmico($cid, $utente, $amico);

    if ($ris["status"]=='ok')
    {
        header("location: ../frontend/friends.php?&status=ok&msg=" . urlencode($ris["msg"]));
    }
    else
    {	header('location: ../frontend/friends.php?status=ko&msg='.  urlencode($ris["msg"]));}
}
else
{
	header("Location:../index.php?status=ko&msg=". urlencode("Operazione riservata ad utenti registrati. Procedi con la login"));
} 