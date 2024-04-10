<?php
session_start();
if (!isset($_SESSION["tipo"])) {
    $risultato = array("status" => "ko", "msg" => "");
    $risultato["status"] = "ko";
    $risultato["msg"] = "Devi prima eseguire l'accesso!";
    header("location:../index.php?status=ko&msg=" . urlencode($risultato["msg"]));
    return $risultato;
} else if ($_SESSION["tipo"] == "amministratore") {
    $nome = "homepage_admin";
} else {
    $nome = "homepage";
}
?>

<!DOCTYPE html>
<html lang="en">

<?php require "../common/header.php"; ?>

<body class="d-flex flex-column h-100">
    <main class="flex-shrink-0">
        <!-- Navigation-->
        <?php require "../common/navbar.php";

        include "../common/connection.php";
        include "../common/funzioni.php"; ?>

        <div class="container px-5">
            <?php if (isset($_GET["status"])) {
                if ($_GET["status"] == "ok") {
                    echo "<div class='alert alert-success'>\n";
                    echo $_GET["msg"];
                    echo "</div>";
                } else {
                    echo "<div class='alert alert-warning'>\n";
                    echo $_GET["msg"];
                    echo "</div>";
                }
            }
            ?>
        </div>
        <?php
        $amici = leggiAmici($cid, $_SESSION["email"]);
        $messaggi = readMessages($cid, $amici);
        ?>
        <!-- Messages Section-->
        <section class="py-5">
            <div class="container px-5 mb-5">
                <div class="text-center mb-5">
                    <h1 class="display-5 fw-bolder mb-0"><span class="text-gradient d-inline">Messaggi</span></h1>
                </div>

                <div class="row gx-5 justify-content-center">
                    <div class="col-lg-12 col-xl-10 col-xxl-9">
                        <!-- Messages -->
                        <?php
                        foreach ($messaggi as $messaggio) {
                            ?>

                            <div class="card overflow-hidden shadow rounded-4 border-0 mb-5">
                                <div class="card-body p-0">
                                    <div class="d-flex align-items-center">
                                        <div class="p-5">
                                            <div>
                                                <div style="display: flex; justify-content: space-between;">
                                                    <h2 class="fw-bolder">
                                                        <?php echo $messaggio['UtenteMessaggio']; ?>
                                                    </h2>
                                                    <h5 class="fw">
                                                        <?php echo $messaggio['Data']; ?>
                                                    </h5>
                                                    <h5 class="fw">
                                                        <?php echo $messaggio['Provincia'];
                                                        echo " " . $messaggio['Nome']; ?>
                                                    </h5>
                                                </div>
                                                <?php if ($messaggio['Tipo'] == 'testo'): ?>
                                                    <h4>
                                                        <?php echo $messaggio['Contenuto']; ?>
                                                    </h4>
                                                <?php elseif ($messaggio['Tipo'] == 'foto'): ?>
                                                    <img class="img-fluid" src="<?php echo $messaggio['Posizione']; ?>"
                                                        alt="<?php echo $messaggio['Descrizione']; ?>">
                                                    <h4>
                                                        <?php echo $messaggio['Descrizione']; ?>
                                                    </h4>
                                                <?php endif; ?>
                                                
                                                <?php
                                                $commenti = leggiCommenti($cid, $messaggio["ID"]);
                                                stampaCommenti($cid, $commenti['commenti'], $messaggio["ID"]); ?>

                                                <tr>
                                                    <div class="form mb-3">
                                                        <input class="form-control"
                                                            id="<?php echo $messaggio["ID"]; ?>Commenta" type="text"
                                                            name="Commenta" placeholder="Scrivi il tuo commento..."
                                                            value="">
                                                    </div>
                                                    <div class="form mb-3">
                                                        <input class="form-control"
                                                            id="<?php echo $messaggio["ID"]; ?>Popup" type="text"
                                                            name="Popup" placeholder="Scrivi il tuo popup (facoltativo) ..."
                                                            value="" onchange="popup(this)">
                                                    </div>
                                                    <div class="form mb-3">
                                                        <select class="form-select"
                                                            id="<?php echo $messaggio["ID"]; ?>TagUser" name="TagUser"
                                                            onchange="popup(this)"></select>
                                                    </div>
                                                    <input type="hidden" name="IDMessaggio" id="messageId"
                                                        value="<?php echo $messaggio["ID"]; ?>">
                                                    <button class="btn btn-primary"
                                                        id="comment-button<?php echo $messaggio["ID"]; ?>" name=<?php echo $messaggio["ID"]; ?>>Commenta</button>
                                                </tr>

                                                <?php $current = (date("Y-m-d H:i:s", time())); ?>
                                                <script>

                                                    document.getElementById("comment-button<?php echo $messaggio["ID"]; ?>").addEventListener("click", function () {
                                                        change(this, <?php echo $messaggio["ID"]; ?>);
                                                    }, false);

                                                </script>
                                    
                                                <!-- Lista dei commenti associati a questo messaggio -->
                                                <div id="comment-list-container-<?php echo $messaggio['ID'];  ?>"></div>
                                                <script>

                                                    function change(id) {
                                                        let id_commento = id.name + "Commenta";
                                                        console.log(id_commento);
                                                        let commentValue = document.getElementById(id_commento).value;
                                                        let selectedUserAndDate = document.getElementById(id.name + "TagUser").value;

                                                        // Dividi la stringa in utente e data solo se è stata fornita un'opzione
                                                        let userAndDateArray = selectedUserAndDate ? selectedUserAndDate.split(' - ') : [null, null];
                                                        let selectedUser = userAndDateArray[0];
                                                        console.log(selectedUser);
                                                        let selectedDate = userAndDateArray[1];
                                                        console.log(selectedDate);
                                                        let xhr = new XMLHttpRequest();
                                                        let params = "commenta=" + commentValue + "&id=" + id.name + "&popup=" + selectedUser + "&datapopup=" + selectedDate;
                                                        console.log(params); 
                                                        xhr.open('GET', '../backend/comment.php?' + params, true);
                                                        xhr.onreadystatechange = function () {
                                                            if (xhr.readyState == 4 && xhr.status == 200) {
                                                                console.log(xhr.responseText);
                                                                let result = JSON.parse(xhr.responseText);
                                                                let messageContainerId = "comment-list-container-" + id.name;
                                                                if (result.status === 'ok') {
                                                                    let messageContainer = document.getElementById(messageContainerId);
                                                                    let newRow = document.createElement('tr');
                                                                    let button_delete = document.getElementById("delete_comment");
                                                                    newRow.innerHTML = "<td>" + result["utente"] + "</td><td>" + result['commento'] + "</td><td>" + result["data"] + "</td><td>" + result["popup"] + result["datapopup"] + "</td><td>" + "</td><td><div id='comment'><form method='POST' action='../backend/deleteComment.php'>" + button_delete.outerHTML + "</form></div></td></tr>";
                                                                    messageContainer.appendChild(newRow);
                                                                    document.getElementById(id_commento).value = "";
                                                                } else {
                                                                    // Stampa il messaggio di errore
                                                                    alert(result.msg);
                                                                }
                                                            }
                                                        };
                                                        xhr.send();
                                                    }

                                                    function popup(input) {
                                                        let select = document.getElementById(input.id.replace("Popup", "TagUser"));
                                                        let userInput = input.value;
                                                        let lastLetter = userInput.charAt(userInput.length - 1);
                                                        if (!lastLetter.match(/[a-z]/i)) {
                                                            // Se l'ultima lettera inserita non è una lettera, non effettuiamo la richiesta
                                                            return;
                                                        }
                                                        let xhr = new XMLHttpRequest();
                                                        let params = "userTagged=" + userInput;
                                                        xhr.open('GET', '../backend/tag_user.php?' + params, true);
                                                        xhr.onreadystatechange = function () {
                                                            if (xhr.readyState == 4 && xhr.status == 200) {
                                                                console.log(xhr.responseText);
                                                                let users = JSON.parse(xhr.responseText);
                                                                select.innerHTML = ""; // Rimuoviamo le opzioni esistenti
                                                                users.utenti.forEach(function (user) {
                                                                    let optionText = user.Utente_popup + ' - ' + user.Data_popup;
                                                                    let option = new Option(optionText);
                                                                    select.appendChild(option);
                                                                });
                                                            }
                                                        };
                                                        xhr.send();
                                                    }

                                                    var currentComment = 0;
                                                    var currentMessage = 0;

                                                    // Funzione per aprire la finestra modale
                                                    function openModal(commentId, messageId) {
                                                        document.getElementById("myModal").style.display = "flex";
                                                        console.log("Aperta modal per il commento con ID:", commentId);
                                                        console.log("Aperta modal per il messaggio con ID:", messageId);
                                                        currentComment = commentId;
                                                        currentMessage = messageId;
                                                    }

                                                    // Funzione per chiudere la finestra modale
                                                    function closeModal() {
                                                        document.getElementById("myModal").style.display = "none";
                                                    }

                                                    function submitVote() {
                                                        let commentId = currentComment;
                                                        let messageId = currentMessage;
                                                        let vote = document.getElementById("vote").value;
                                                        let params = "id=" + messageId + "&commentId=" + commentId + "&vote=" + vote;
                                                        console.log("Button clicked", messageId, commentId, vote);
                                                        let xhr = new XMLHttpRequest();
                                                        xhr.open('GET', '../backend/vota.php?' + params, true);
                                                        xhr.onreadystatechange = function () {
                                                            if (xhr.readyState == 4 && xhr.status == 200) {
                                                                console.log(xhr.responseText);
                                                                let result = JSON.parse(xhr.responseText);
                                                                if (result.status === 'ok') {
                                                                    // Stampa il messaggio di successo
                                                                    alert(result.msg);
                                                                } else {
                                                                    // Stampa il messaggio di errore
                                                                    alert(result.msg);
                                                                }
                                                            }
                                                        };
                                                        xhr.send();
                                                        closeModal();
                                                    }

                                                </script>
                                                <div id="myModal" class="modal">
                                                    <div class="row gx-5 justify-content-center">
                                                        <div class="modal-content">
                                                            <h2>Vota il commento</h2>
                                                            <label for="vote">Voto:</label>
                                                            <select id="vote">
                                                                <option value="-3">-3</option>
                                                                <option value="-2">-2</option>
                                                                <option value="-1">-1</option>
                                                                <option value="0">0</option>
                                                                <option value="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                            </select>
                                                            <p></p>
                                                            <button class="btn btn-primary" onclick="submitVote()">Invia
                                                                voto</button>
                                                                <p></p>
                                                            <button class="btn btn-primary" onclick="closeModal()">Chiudi</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>



        </section>
        <form name="inserimento" action="../backend/homepage-exe.php" method="GET">
        </form>
    </main>

    <!-- Footer-->
    <?php require "../common/footer.php"; ?>
</body>

</html>