<?php
session_start();
include_once "../common/connection.php";

$login = $_SESSION["email"];
$IDamico = $_GET["id"];
$IDcommento = $_GET["commentId"];
$voto = $_GET["vote"];

if (isset($_SESSION["logged"])) {
    $risultato = array("status" => "ok", "msg" => "");

    if ($cid == null || $cid->connect_errno) {
        $risultato["status"] = "ko";
        if (!is_null($cid))
            $risultato["msg"] = "errore nella connessione al db " . $cid->connect_error;
        else
            $risultato["msg"] = "errore nella connessione al db ";
        return $risultato;
    }

    $sql = "SELECT UtenteMessaggio, Data FROM Messaggio WHERE ID = '$IDamico'";

    $res = $cid->query($sql);

    if ($res == null) {
        $risultato["msg"] = "Problema nell'ottenere i dati del messaggio: $cid->errno: $cid->error()";
        $risultato["status"] = "ko";
        return $risultato;
    }

    $row = $res->fetch_assoc();

    $sql2 = "SELECT UtenteCommento, Data, id FROM Commento WHERE EmailMessaggio='{$row['UtenteMessaggio']}' AND DataMessaggio='{$row['Data']}' AND id='$IDcommento'";

    $res2 = $cid->query($sql2);

    if ($res2 == null) {
        $risultato["msg"] = "Problema nell'ottenere i dati del messaggio: $cid->errno: $cid->error()";
        $risultato["status"] = "ko";
        return $risultato;
    }

    $row2 = $res2->fetch_assoc();

    $sql4 = "SELECT COUNT(*) FROM Vota WHERE UtenteVotato='{$row2['UtenteCommento']}' AND DataVoto='{$row2['Data']}' AND UtenteVotante='$login'";

    $res4 = $cid->query($sql4);

    if ($res4 == null) {
        $risultato["msg"] = "Problema nell'ottenere i dati del messaggio: $cid->errno: $cid->error()";
        $risultato["status"] = "ko";
        return $risultato;
    }

    $row4 = $res4->fetch_assoc();

    $sql5 = "SELECT LivelloDiRispettabilita FROM Utente WHERE Email = '$login'";
    
    $res5 = $cid->query($sql5);

    if ($res5 == null) {
        $risultato["msg"] = "Problema nell'ottenere i dati del messaggio: $cid->errno: $cid->error()<br/>";
        $risultato["status"] = "ko";
        return $risultato;
    }

    $row5 = $res5->fetch_assoc();

    if ($row4["COUNT(*)"] == 1) {
        $risultato["msg"] = "Non puoi votare più di una volta lo stesso commento";
        $risultato["status"] = "ko";
        echo json_encode($risultato);
        return;
    } else if ($row5["LivelloDiRispettabilita"] < -1) {
        $risultato["msg"] = "L'operazione di pubblicazione di un commento è fallita poiché non puoi commentare essendo il tuo livello di rispettabilità minore di -1";
        $risultato["status"] = "ko";
        echo json_encode($risultato);
        return;
    } else {
        $sql3 = "INSERT INTO vota(UtenteVotato, DataVoto, UtenteVotante, Indice, DataVotante) VALUES('{$row2['UtenteCommento']}','{$row2['Data']}','$login',$voto,CURRENT_TIMESTAMP);";

        $res3 = $cid->query($sql3);

        if ($res3 == null) {
            $risultato["msg"] = "Problema nella votazione del commento: $cid->errno: $cid->error()";
            $risultato["status"] = "ko";
            echo json_encode($risultato);
            return;
        } else {
            $risultato["msg"] = "L'operazione di votazione di un commento si e conclusa con successo";
            $risultato["status"] = "ok";
            echo json_encode($risultato);
            return;
        }
    }

    if ($risultato["status"] == 'ok') {
        echo json_encode(array('status' => 'ok', 'msg' => $risultato["msg"]));
    } else {
        // Invia una risposta JSON con lo status e il messaggio
        echo json_encode(array('status' => 'ko', 'msg' => $risultato["msg"]));
    }
} else {
    // Invia una risposta JSON con lo status e un messaggio di errore
    echo json_encode(array('status' => 'ko', 'msg' => 'Operazione riservata ad utenti registrati. Procedi con la login'));
}

