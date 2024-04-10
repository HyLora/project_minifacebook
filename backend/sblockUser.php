 <?php
 session_start();
 include_once "../common/connection.php";
 include_once "../common/funzioni.php";

 $admin = $_SESSION["email"];
 $utente = $_POST["sblocca"];
 
 if (isset($_SESSION["logged"]))
{
    $ris=sbloccaUtente($cid, $admin, $utente);

    if ($ris["status"]=='ok')
    {
        header("location: ../frontend/gestisci_utenti.php?&status=ok&msg=" . urlencode($ris["msg"]));
    }
    else
    {	header('location: ../frontend/gestisci_utenti.php?status=ko&msg='.  urlencode($ris["msg"]));}
}
else
{
	header("Location:../index.php?status=ko&msg=". urlencode("Operazione riservata ad utenti registrati. Procedi con la login"));
} 