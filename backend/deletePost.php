<?php
 session_start();
 include_once "../common/connection.php";
 include_once "../common/funzioni.php";

 $utente = $_SESSION["email"];
 $id_message = $_POST["elimina"];
 
 if (isset($_SESSION["logged"]))
{
    $ris=cancellaMessaggio($cid, $utente, $id_message);

    if ($ris["status"]=='ok')
    {
        header("location: ../frontend/myaccount.php?&status=ok&msg=" . urlencode($ris["msg"]));
    }
    else
    {	header('location: ../frontend/myaccount.php?status=ko&msg='.  urlencode($ris["msg"]));}
}
else
{
	header("Location:../index.php?status=ko&msg=". urlencode("Operazione riservata ad utenti registrati. Procedi con la login"));
} 
?>