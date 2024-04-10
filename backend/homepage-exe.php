<?php
session_start();
include_once "../common/connection.php";
include_once "../common/funzioni.php";

if (isset($_SESSION["logged"])){
    $ris2 = readMessages($cid, $amici);

    if ($ris2["status"] == 'ok') {
        header("location: ../index.php?op=homepage&status=ok&msg=" . urlencode($ris2["msg"]));
    } else {
        header('location: ../index.php?status=ko&msg=' . urlencode($ris2["msg"]));
    }
} else {
    header("Location:../index.php?status=ko&msg=" . urlencode("Operazione riservata ad utenti registrati. Procedi con la login"));
}


$login = $_SESSION["email"];
$amico = $_POST["utente_amico"];
$voto = $_POST["vote"];

$risultato = array("status" => "ok", "msg" => "", "contenuto" => "");

if ($cid == null || $cid->connect_errno) {
    $risultato["status"] = "ko";
    if (!is_null($cid))
        $risultato["msg"] = "errore nella connessione al db " . $cid->connect_error;
    else
        $risultato["msg"] = "errore nella connessione al db ";
    return $risultato;
}

$sql = "INSERT INTO vota(UtenteVotato, DataVoto, UtenteVotante, Indice) VALUES('$amico',CURRENT_TIMESTAMP,'$login',$voto);";
$res = $cid->query($sql);

if ($res == null) {
    $risultato["msg"] = "Problema nella votazione del commento: $cid->errno: $cid->error()<br/>";
    $risultato["status"] = "ko";
    return $risultato;
} else {
    $risultato["msg"] = "L'operazione di votazione di un commento si e conclusa con successo";
    $risultato["status"] = "ok";
    echo json_encode($risultato);
    return;
}