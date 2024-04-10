<?php
session_start();
include_once "../common/connection.php";

$utente = $_SESSION["email"];
$IDamico = $_GET["id"];
$commento = $_GET['commenta'];
$commento = str_replace("'","\\'", $commento);
$popup = isset($_GET['popup']) ? $_GET['popup'] : NULL;
$data_popup = isset($_GET['datapopup']) ? $_GET['datapopup'] : NULL;

if (isset($_SESSION["logged"])) {
    $current = date("Y-m-d H:i:s", time());
    $risultato = array("status" => "ok", "msg" => "",  "utente" => "", "commento" => "", "data" => "", "popup" => "", "datapopup" => "");

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
        $risultato["msg"] = "Problema nell'ottenere i dati del messaggio: $cid->errno: $cid->error()<br/>";
        $risultato["status"] = "ko";
        return $risultato;
    }

    $row = $res->fetch_assoc();

    $sql3 = "SELECT COUNT(UtenteCommento) as NumeroCommenti FROM commento WHERE EmailMessaggio = '{$row["UtenteMessaggio"]}' AND DataMessaggio = '{$row["Data"]}' AND UtenteCommento = '$utente'";
    
    $res3 = $cid->query($sql3);

    if ($res3 == null) {
        $risultato["msg"] = "Problema nell'ottenere i dati del messaggio: $cid->errno: $cid->error()<br/>";
        $risultato["status"] = "ko";
        return $risultato;
    }

    $row3 = $res3->fetch_assoc();

	$sql4 = "SELECT LivelloDiRispettabilita FROM Utente WHERE Email = '$utente'";
    
    $res4 = $cid->query($sql4);

    if ($res4 == null) {
        $risultato["msg"] = "Problema nell'ottenere i dati del messaggio: $cid->errno: $cid->error()<br/>";
        $risultato["status"] = "ko";
        return $risultato;
    }

    $row4 = $res4->fetch_assoc();

    if ($row3["NumeroCommenti"]>=5) {
        $risultato["msg"] = "L'operazione di pubblicazione di un commento è fallita poiché puoi commentare fino a un massimo di 5 volte";
        $risultato["status"] = "ko";
        echo json_encode($risultato);
        return;
    } else if ($row4["LivelloDiRispettabilita"] < -1) {
        $risultato["msg"] = "L'operazione di pubblicazione di un commento è fallita poiché non puoi commentare essendo il tuo livello di rispettabilità minore di -1";
        $risultato["status"] = "ko";
        echo json_encode($risultato);
        return;
    } else if ($popup == 'null'){
        $sql2 = "INSERT INTO commento(UtenteCommento, Data, Testo, EmailMessaggio, DataMessaggio, popup, datapopup) VALUES ('$utente', CURRENT_TIMESTAMP, '$commento', '{$row['UtenteMessaggio']}', '{$row['Data']}', NULL, NULL)";
        $res2 = $cid->query($sql2);

        if ($res2 == null) {
            $risultato["msg"] = "Problema nella pubblicazione del commento nel database: $cid->errno: $cid->error()<br/>";
            $risultato["status"] = "ko";
        } else {
            $risultato["msg"] = "L'operazione di pubblicazione di un commento si è conclusa con successo";
            $risultato["status"] = "ok";
            $risultato["utente"] = $utente;
            $risultato["commento"] = $_GET['commenta'];
            $risultato["data"] = $current;
            $risultato["popup"] = "";
            $risultato["datapopup"] = "";
            echo json_encode($risultato);
            return;
        }
    } else {
        $sql2 = "INSERT INTO commento(UtenteCommento, Data, Testo, EmailMessaggio, DataMessaggio, popup, datapopup) VALUES ('$utente', CURRENT_TIMESTAMP, '$commento', '{$row['UtenteMessaggio']}', '{$row['Data']}', '$popup', '$data_popup')";
        $res2 = $cid->query($sql2);

        if ($res2 == null) {
            $risultato["msg"] = "Problema nella pubblicazione del commento nel database: $cid->errno: $cid->error()<br/>";
            $risultato["status"] = "ko";
        } else {
            $risultato["msg"] = "L'operazione di pubblicazione di un commento si è conclusa con successo";
            $risultato["status"] = "ok";
            $risultato["utente"] = $utente;
            $risultato["commento"] = $_GET['commenta'];
            $risultato["data"] = $current;
            $risultato["popup"] = $popup;
            $risultato["datapopup"] = $data_popup;
            echo json_encode($risultato);
            return;
        }
    }

    if ($risultato["status"] == 'ok') {
        echo json_encode(array('status' => 'ok', 'msg' => $risultato["msg"], 'commento' => $risultato["commento"], 'utente' => $risultato["utente"], 'data' => $risultato["data"]));
    } else {
        // Invia una risposta JSON con lo status e il messaggio
        echo json_encode(array('status' => 'ko', 'msg' => $risultato["msg"]));
    }
} else {
    // Invia una risposta JSON con lo status e un messaggio di errore
    echo json_encode(array('status' => 'ko', 'msg' => 'Operazione riservata ad utenti registrati. Procedi con la login'));
}