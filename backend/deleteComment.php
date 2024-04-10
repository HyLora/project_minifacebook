<?php
 session_start();
 include_once "../common/connection.php";
 include_once "../common/funzioni.php";

 $utente = $_SESSION["email"];
 $id_comment = $_POST["elimina"];
 
 if (isset($_SESSION["logged"]))
{
    $ris=cancellaCommento($cid, $utente, $id_comment);

    if ($ris["status"]=='ok')
    {
        header("location: ../frontend/homepage.php?&status=ok&msg=" . urlencode($ris["msg"]));
    }
    else
    {	header('location: ../frontend/homepage.php?status=ko&msg='.  urlencode($ris["msg"]));}
}
else
{
	header("Location:../index.php?status=ko&msg=". urlencode("Operazione riservata ad utenti registrati. Procedi con la login"));
} 
?>