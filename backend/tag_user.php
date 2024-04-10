<?php
session_start();
include_once "../common/connection.php";

$utente = $_SESSION["email"];
$tag = $_GET["userTagged"];

if (isset($_SESSION["logged"])) {
    $risultato = array("status" => "ok", "msg" => "",  "utenti" => "");

    if ($cid == null || $cid->connect_errno) {
        $risultato["status"] = "ko";
        if (!is_null($cid))
            $risultato["msg"] = "errore nella connessione al db " . $cid->connect_error;
        else
            $risultato["msg"] = "errore nella connessione al db ";
        return $risultato;
    }

    $sql = "SELECT Email FROM Utente WHERE email LIKE '{$tag}%'";
    $res = $cid->query($sql);

    if ($res == null) {
        $risultato["msg"] = "Problema nell'ottenere i dati del messaggio: $cid->errno: $cid->error()<br/>";
        $risultato["status"] = "ko";
        return $risultato;
    }

    $row = $res -> fetch_assoc();

    $sql2 = "SELECT UtenteMessaggio, Data FROM Messaggio WHERE UtenteMessaggio = '{$row["Email"]}'";
    $res2 = $cid->query($sql2);

    if ($res2 == null) {
        $risultato["msg"] = "Problema nell'ottenere i dati del messaggio: $cid->errno: $cid->error()<br/>";
        $risultato["status"] = "ko";
        return $risultato;
    }

    $utenti = array();

    while ($row2 = $res2 -> fetch_assoc()) {
            $utenti[] = array(
                'Utente_popup' => $row2['UtenteMessaggio'],
                'Data_popup' => $row2['Data']
            );
    }
    $risultato["msg"] = "Ecco gli utenti possibili";
    $risultato["status"] = "ok";
    $risultato["utenti"] = $utenti;
    echo json_encode($risultato);
    return;
} else {
    echo json_encode(array('status' => 'ko', 'msg' => 'Operazione riservata ad utenti registrati. Procedi con la login'));
}
