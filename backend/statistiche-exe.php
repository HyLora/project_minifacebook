<?php
include_once "../common/connection.php";
include_once "../common/funzioni.php";

if (!isset($_SESSION["logged"])) {
    header("Location:../index.php?status=ko&msg=" . urlencode("Operazione riservata ad utenti registrati. Procedi con la login"));
} else {
    $risultato = array("status" => "ok", "msg" => "", "contenuto" => "");

    if ($cid->connect_errno) {
        $risultato["status"] = "ko";
        $risultato["msg"] = "errore nella connessione al db " . $cid->connect_error;
        return $risultato;
    }

    // Query per trovare l'utente con più voti
    $sql_most_voted_user = "SELECT UtenteVotato, COUNT(*) AS num_votes FROM vota GROUP BY UtenteVotato ORDER BY num_votes DESC LIMIT 1";
    $res = $cid->query($sql_most_voted_user);

    if ($res->num_rows > 0) {
        $row_most_voted_user = $res->fetch_assoc();
        $most_voted_user_id = $row_most_voted_user["UtenteVotato"];
        $most_voted_user_votes = $row_most_voted_user["num_votes"];
    } else {
        $risultato["status"] = "ko";
        $risultato["msg"] = "La query per gli utenti con più voti non ha restituito risultati.";
        echo "<div class='alert alert-warning'>\n";
        echo $risultato["msg"];
        echo "</div>";
    }

    // Query per trovare l'utente con più commenti
    $sql_most_commented_user = "SELECT UtenteCommento, COUNT(*) AS num_comments FROM commento GROUP BY UtenteCommento ORDER BY num_comments DESC LIMIT 1";
    $res2 = $cid->query($sql_most_commented_user);

    if ($res2->num_rows > 0) {
        $row_most_commented_user = $res2->fetch_assoc();
        $most_commented_user_id = $row_most_commented_user["UtenteCommento"];
        $most_commented_user_comments = $row_most_commented_user["num_comments"];
    } else {
        $risultato["status"] = "ko";
        $risultato["msg"] = "La query per gli utenti con più commenti non ha restituito risultati.";
        echo "<div class='alert alert-warning'>\n";
        echo $risultato["msg"];
        echo "</div>";
    }

    // Query per trovare l'utente con più messaggi
    $sql_most_messaged_user = "SELECT UtenteMessaggio, COUNT(*) AS num_messages FROM messaggio GROUP BY UtenteMessaggio ORDER BY num_messages DESC LIMIT 1";
    $res3 = $cid->query($sql_most_messaged_user);

    if ($res3->num_rows > 0) {
        $row_most_messaged_user = $res3->fetch_assoc();
        $most_messaged_user_id = $row_most_messaged_user["UtenteMessaggio"];
        $most_messaged_user_messages = $row_most_messaged_user["num_messages"];
    } else {
        $risultato["status"] = "ko";
        $risultato["msg"] = "La query per gli utenti con più messaggi non ha restituito risultati.";
        echo "<div class='alert alert-warning'>\n";
        echo $risultato["msg"];
        echo "</div>";
    }

    // Query per trovare l'utente con più amici
    $sql_most_friends_user = "SELECT Mittente AS Utente, COUNT(*) AS num_friends FROM amicizia WHERE dataAccettazione NOT LIKE '0000-00-00 00:00:00' GROUP BY Mittente ORDER BY COUNT(*) DESC LIMIT 1;";
    $res4 = $cid->query($sql_most_friends_user);

    if ($res4->num_rows > 0) {
        $row_most_friends_user = $res4->fetch_assoc();
        $most_friends_user_id = $row_most_friends_user["Utente"];
        $most_friends_user_count = $row_most_friends_user["num_friends"];
    } else {
        $risultato["status"] = "ko";
        $risultato["msg"] = "La query per gli utenti con più amici non ha restituito risultati.";
        echo "<div class='alert alert-warning'>\n";
        echo $risultato["msg"];
        echo "</div>";
    }

    // Query per ottenere il numero totale di commenti
    $sql_total_comments = "SELECT COUNT(*) AS total_comments FROM commento";
    $res_total_comments = $cid->query($sql_total_comments);
    if ($res_total_comments) {
        $row_total_comments = $res_total_comments->fetch_assoc();
        $total_comments = $row_total_comments['total_comments'];
    } else {
        $total_comments = 0; // Imposta il numero totale di utenti a 0
    }

    // Query per ottenere il numero totale di messaggi
    $sql_total_messages = "SELECT COUNT(*) AS total_messages FROM messaggio";
    $res_total_messages = $cid->query($sql_total_messages);
    if ($res_total_messages) {
        $row_total_messages = $res_total_messages->fetch_assoc();
        $total_messages = $row_total_messages['total_messages'];
    } else {
        $total_messages = 0; // Imposta il numero totale di messaggi a 0
    }

    // Query per ottenere il numero totale di amici
    $sql_total_friends = "SELECT Utente, SUM(total_friends) as total_friends
    FROM (
        SELECT Mittente as Utente, COUNT(*) as total_friends 
        FROM amicizia  
        WHERE dataAccettazione NOT LIKE '0000-00-00 00:00:00' 
        GROUP BY Mittente
        UNION 
        SELECT Destinatario as Utente, COUNT(*) as total_friends 
        FROM amicizia 
        WHERE dataAccettazione NOT LIKE '0000-00-00 00:00:00' 
        GROUP BY Destinatario
    ) AS subquery
    GROUP BY Utente;
    ";

    
    $friends_labels = [];
    $friend_counts = [];
    $res_total_friends = $cid->query($sql_total_friends);
    if ($res_total_friends) {
        while ($row_total_friends = $res_total_friends->fetch_assoc()) {
            $friends_labels[] = $row_total_friends['Utente'];
            $friend_counts[] = $row_total_friends['total_friends'];
        }
    } else {
        $total_friends = 0;
    }

    $sql_messages_per_user = "SELECT UtenteMessaggio, COUNT(*) AS num_messages FROM messaggio GROUP BY UtenteMessaggio";
    $res_messages_per_user = $cid->query($sql_messages_per_user);

    $user_labels = [];
    $message_counts = [];

    while ($row = $res_messages_per_user->fetch_assoc()) {
        $user_labels[] = $row['UtenteMessaggio'];
        $message_counts[] = $row['num_messages'];
    }

    // Query per ottenere i 5 utenti più rispettati
    $sql_best_users = "SELECT email, LivelloDiRispettabilita FROM utente ORDER BY LivelloDiRispettabilita DESC LIMIT 6";
    $res_best_users = $cid->query($sql_best_users);
    if ($res_best_users) {
        $row_best_users = $res_best_users->fetch_assoc();
    } else {
        $risultato["status"] = "ko";
        $risultato["msg"] = "La query per gli utenti con più amici non ha restituito risultati.";
        echo "<div class='alert alert-warning'>\n";
        echo $risultato["msg"];
        echo "</div>";
    }

    function getMessagesStatistics() {
        global $cid;
    
        $messagesStatistics = array();
    
        // Query per ottenere il numero minimo, massimo e medio dei messaggi per ciascun utente nell'ultima settimana
        $sql = "SELECT UtenteMessaggio, 
                       MIN(num_messages) AS min_messages, 
                       MAX(num_messages) AS max_messages, 
                       AVG(num_messages) AS avg_messages
                FROM (
                    SELECT UtenteMessaggio, 
                           COUNT(*) AS num_messages
                    FROM messaggio
                    WHERE data >= CURDATE() - INTERVAL 7 DAY
                    GROUP BY UtenteMessaggio
                ) AS message_counts
                GROUP BY UtenteMessaggio";
    
        $result = $cid->query($sql);
    
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $user = $row['UtenteMessaggio'];
                $messagesStatistics[$user] = array(
                    'min_messages' => $row['min_messages'],
                    'max_messages' => $row['max_messages'],
                    'avg_messages' => $row['avg_messages']
                );
            }
        }
    
        return $messagesStatistics;
    }
    
    // Eseguire la funzione per ottenere le statistiche dei messaggi e restituire i risultati come JSON
    $messagesStatistics = getMessagesStatistics();
    //echo json_encode($messagesStatistics);
}