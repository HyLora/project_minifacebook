<?php

/* Funzioni relative alla gestione degli utenti */

function isUser($cid, $login, $pwd)
{
	$risultato = array("msg" => "", "status" => "ok", "tipo" => "");

	if ($cid == null || $cid->connect_errno) {
		$risultato["status"] = "ko";
		if (!is_null($cid))
			$risultato["msg"] = "errore nella connessione al db " . $cid->connect_error;
		else
			$risultato["msg"] = "errore nella connessione al db ";
		return $risultato;
	}

	$sql = "SELECT email, password, tipo FROM utente where email = '$login' and password = '$pwd'";

	$res = $cid->query($sql);
	if ($res == null) {
		$msg = "Si sono verificati i seguenti errori:<br/>"
			. $res->error;
		$risultato["status"] = "ko";
		$risultato["msg"] = $msg;
	} elseif ($res->num_rows == 0 || $res->num_rows > 1) {
		$msg = "Login o password sbagliate";
		$risultato["status"] = "ko";
		$risultato["msg"] = $msg;
	} elseif ($res->num_rows == 1) {
		$row = $res->fetch_assoc();
		$msg = "Login effettuato con successo";
		$risultato["status"] = "ok";
		$risultato["msg"] = $msg;
		$risultato["tipo"] = $row["tipo"]; // Assegna il valore dell'attributo 'tipo' dal database
	}
	return $risultato;
}

function leggiUtenti($cid)
{
	$utenti = array();
	$risultato = array("status" => "ok", "msg" => "", "contenuto" => "");

	if ($cid == null || $cid->connect_errno) {
		$risultato["status"] = "ko";
		if (!is_null($cid))
			$risultato["msg"] = "errore nella connessione al db " . $cid->connect_error;
		else
			$risultato["msg"] = "errore nella connessione al db ";
		return $risultato;
	}

	if ($cid->connect_errno) {
		$risultato["status"] = "ko";
		$risultato["msg"] = "errore nella connessione al db " . $cid->connect_error;
		return $risultato;
	}
	$sql = "SELECT email, livelloDiRispettabilita, utente_bloccante FROM utente;";
	$res = $cid->query($sql);
	if ($res == null) {
		$risultato["status"] = "ko";
		$risultato["msg"] = "errore nella esecuzione della interrogazione " . $cid->error;
		return $risultato;
	}
	while ($row = $res->fetch_row()) {
		$utenti[$row[0]] = $row[1];
	}
	$risultato["contenuto"] = $utenti;
	return $risultato;
}

// Funzione per verificare se sono passati 30 giorni dall'ultima esecuzione
function sonoPassatiTrentaGiorni($ultimaEsecuzione)
{
	$ultimaEsecuzioneTimestamp = strtotime($ultimaEsecuzione);
	$oggiTimestamp = strtotime(date('Y-m-d'));

	// Calcola la differenza in giorni tra le due date
	$differenzaGiorni = ($oggiTimestamp - $ultimaEsecuzioneTimestamp) / (60 * 60 * 24);

	return $differenzaGiorni >= 30;
}

// Funzione per stampare gli utenti
function stampaUtenti($cid, $utenti, $ultimaEsecuzione)
{
	echo "<div class=\"table-responsive\">
          <table class=\"table text-center\">
          <tr><th class=\"text-center\">Utente</th>
              <th class=\"text-center\">Livello di Rispettabilità</th>
              <th class=\"text-center\">Operazione</th>
              </tr>";

	// Verifica se sono passati 30 giorni dall'ultima esecuzione
	if (sonoPassatiTrentaGiorni($ultimaEsecuzione)) {
		foreach ($utenti as $utente => $LivelloDiRispettabilita) {
			$ris = calcola_rispettabilita($cid, $utente);
			$sql = "SELECT utente_bloccante, email FROM utente WHERE Email = '$utente'";
			$res = $cid->query($sql);
			$row = $res->fetch_assoc();
			if ($row["utente_bloccante"] == NULL && $row["email"] != $_SESSION["email"]) {
				echo "<tr><td>$utente</td>
                    <td>$ris</td>
                    <form method='POST' action='../backend/blockUser.php'>
                    <td><button type='submit' class=\"btn btn-danger\" name = 'blocca' value='$utente'>Blocca</td>
                    </form>";
			} else if ($row["utente_bloccante"] != NULL && $row["email"] != $_SESSION["email"]) {
				echo "<tr><td>$utente</td>
                <td>$ris</td>
                <form method='POST' action='../backend/sblockUser.php'>
                <td><button type='submit' class=\"btn btn-success\" name = 'sblocca' value='$utente'>Sblocca</td>
                </form>";
			}
		}
		// Aggiorna la data dell'ultima esecuzione con la data attuale ESTERNAMENTE alla funzione
		$ultimaEsecuzione = date('Y-m-d');
		$configArray['ultima_esecuzione'] = $ultimaEsecuzione;

		// Converti l'array modificato in formato JSON
		$newConfigData = json_encode($configArray);

		// Sovrascrivi il contenuto del file JSON con il nuovo JSON
		$configFile = '../json/config.json';
		file_put_contents($configFile, $newConfigData);
	} else {
		// Non è ancora passato un mese dall'ultima esecuzione, quindi non fare nulla
		foreach ($utenti as $utente => $LivelloDiRispettabilita) {
			$sql = "SELECT utente_bloccante, email FROM utente WHERE Email = '$utente'";
			$res = $cid->query($sql);
			$row = $res->fetch_assoc();
			if ($row["utente_bloccante"] == NULL && $row["email"] != $_SESSION["email"]) {
				echo "<tr><td>$utente</td>
                    <td>$LivelloDiRispettabilita</td>
                    <form method='POST' action='../backend/blockUser.php'>
                    <td><button type='submit' class=\"btn btn-danger\" name = 'blocca' value='$utente'>Blocca</td>
                    </form>";
			} else if ($row["utente_bloccante"] != NULL && $row["email"] != $_SESSION["email"]) {
				echo "<tr><td>$utente</td>
                <td>$LivelloDiRispettabilita</td>
                <form method='POST' action='../backend/sblockUser.php'>
                <td><button type='submit' class=\"btn btn-success\" name = 'sblocca' value='$utente'>Sblocca</td>
                </form>";
			}
		}
	}
	echo "</table>";
	echo "</div>";
}


function calcola_rispettabilita($cid, $utente)
{
	$vmin = -3;
	$vmax = 3;
	$lmin = -2;
	$lmax = 10;

	$sql = "SELECT CAST(Indice as DECIMAL) FROM Vota WHERE UtenteVotato = '$utente' AND DATEDIFF(CURRENT_TIMESTAMP, DataVotante) < 30;";

	$res = $cid->query($sql);

	$row = $res->fetch_assoc();

	$sql2 = "SELECT LivelloDiRispettabilita FROM Utente WHERE Email = '$utente';";

	$res2 = $cid->query($sql2);

	$media = 0;
	$sum = 0;
	$len = 0;

	$flag = false;
	if ($res === false || $res2 === false || empty($row)) {
		$flag = true;
	} else {
		foreach ($res as $indice) {

			$media = array_sum($indice) / count($indice);
		}

		$livello = (($media - $vmin) / ($vmax - $vmin)) * ($lmax - $lmin) + $lmin;

		$row2 = $res2->fetch_assoc();
		$current_liv = $row2['LivelloDiRispettabilita'];
		$nuovo_livello = ($current_liv + $livello) / 2;

		if ($nuovo_livello <= -1) {
			$ris = bloccaUtente($cid, $_SESSION["email"], $utente);
		} else if ($nuovo_livello >= 10) {
			$nuovo_livello = 10;
		}
	}

	if ($flag === true) {
		$row2 = $res2->fetch_assoc();
		$nuovo_livello = $row2['LivelloDiRispettabilita'];
	} else {
		$sql3 = "UPDATE Utente SET LivelloDiRispettabilita = $nuovo_livello WHERE Email = '$utente';";

		$res3 = $cid->query($sql3);
		if ($res3 === false) {
			$risultato["msg"] = "Si è verificato il seguente errore: " . $cid->errno . ": " . $cid->error . "<br/>";
			$risultato["status"] = "ko";
			return $risultato;
		}
	}
	return $nuovo_livello;
}


function bloccaUtente($cid, $admin, $utente)
{
	$risultato = array("status" => "ok", "msg" => "", "contenuto" => "");

	if ($cid == null || $cid->connect_errno) {
		$risultato["status"] = "ko";
		if (!is_null($cid))
			$risultato["msg"] = "errore nella connessione al db " . $cid->connect_error;
		else
			$risultato["msg"] = "errore nella connessione al db ";
		return $risultato;
	}

	$sql = "UPDATE utente SET utente_bloccante='$admin' WHERE Email = '$utente'";

	$res = $cid->query($sql);

	if ($res == null) {
		$risultato["msg"] = "Si è riscontrato un problema nel bloccare l'utente $utente: $cid->errno: $cid->error()<br/>";
		$risultato["status"] = "ko";
	} else if ($res) {
		$risultato["msg"] = "L'utente è stato bloccato con successo";
		$risultato["status"] = "ok";
	}
	return $risultato;
}

function sbloccaUtente($cid, $admin, $utente)
{
	$risultato = array("status" => "ok", "msg" => "", "contenuto" => "");

	if ($cid == null || $cid->connect_errno) {
		$risultato["status"] = "ko";
		if (!is_null($cid))
			$risultato["msg"] = "errore nella connessione al db " . $cid->connect_error;
		else
			$risultato["msg"] = "errore nella connessione al db ";
		return $risultato;
	}

	$sql = "UPDATE utente SET utente_bloccante=NULL WHERE Email = '$utente'";

	$res = $cid->query($sql);

	if ($res == null) {
		$risultato["msg"] = "Si è riscontrato un problema nello sbloccare l'utente $utente: $cid->errno: $cid->error()<br/>";
		$risultato["status"] = "ko";
	} else if ($res) {
		$risultato["msg"] = "L'utente è stato sbloccato con successo";
		$risultato["status"] = "ok";
	}
	return $risultato;
}

/* funzioni relative alla gestione degli amici */

function leggiAmici($cid, $utente)
{
	$amici = array();
	$risultato = array("status" => "ok", "msg" => "", "contenuto" => "");

	if ($cid == null || $cid->connect_errno) {
		$risultato["status"] = "ko";
		if (!is_null($cid))
			$risultato["msg"] = "errore nella connessione al db " . $cid->connect_error;
		else
			$risultato["msg"] = "errore nella connessione al db ";
		return $risultato;
	}

	if ($cid->connect_errno) {
		$risultato["status"] = "ko";
		$risultato["msg"] = "errore nella connessione al db " . $cid->connect_error;
		return $risultato;
	}
	$sql = "SELECT Mittente AS Amico, dataAccettazione AS DataAccettazione FROM amicizia WHERE Destinatario = '$utente' AND dataAccettazione NOT LIKE '0000-00-00 00:00:00' 
	UNION SELECT Destinatario AS Amico, dataAccettazione AS DataAccettazione 
	FROM amicizia WHERE Mittente = '$utente' AND dataAccettazione NOT LIKE '0000-00-00 00:00:00'";
	$res = $cid->query($sql);

	if ($res == null) {
		$risultato["status"] = "ko";
		$risultato["msg"] = "errore nella esecuzione della interrogazione " . $cid->error;
		return $risultato;
	}
	while ($row = $res->fetch_row()) {
		$amici[$row[1]] = $row[0];
	}
	$risultato["contenuto"] = $amici;
	return $risultato;
}

function leggiRichieste($cid, $utente)
{
	$richieste = array();
	$risultato = array("status" => "ok", "msg" => "", "contenuto" => "");

	if ($cid == null || $cid->connect_errno) {
		$risultato["status"] = "ko";
		if (!is_null($cid))
			$risultato["msg"] = "errore nella connessione al db " . $cid->connect_error;
		else
			$risultato["msg"] = "errore nella connessione al db ";
		return $risultato;
	}

	if ($cid->connect_errno) {
		$risultato["status"] = "ko";
		$risultato["msg"] = "errore nella connessione al db " . $cid->connect_error;
		return $risultato;
	}
	$sql = "SELECT Mittente AS Amico FROM amicizia WHERE Destinatario = '$utente' AND dataAccettazione LIKE '0000-00-00 00:00:00'";
	$res = $cid->query($sql);

	if ($res == null) {
		$risultato["status"] = "ko";
		$risultato["msg"] = "errore nella esecuzione della interrogazione " . $cid->error;
		return $risultato;
	}
	while ($row = $res->fetch_row()) {
		array_push($richieste, $row[0]);
	}
	$risultato["contenuto"] = $richieste;
	return $risultato;
}

function stampaAmici($amici)
{
	echo "<div class=\"table-responsive\">
	 	  <table class=\"table text-center\">
	 	  <tr><th class=\"text-center\">Amico</th>
			  <th class=\"text-center\">DataAccettazione</th>
			  <th class=\"text-center\">Elimina</th>
			  </tr>";
	foreach ($amici as $dataAccettazione => $amico) {
		echo "<tr><td>$amico</td>
			  <td>$dataAccettazione</td>
			  <form method='POST' action='../backend/deleteFriend.php'>
				<td><button type='submit' class=\"btn btn-danger\" name = 'elimina' value='$amico'>Elimina</td>
			  </form>";
	}
	echo "</table>";
	echo "</div>";
}

function accettaAmico($cid, $login, $amico)
{
	$risultato = array("status" => "ok", "msg" => "", "contenuto" => "");

	if ($cid == null || $cid->connect_errno) {
		$risultato["status"] = "ko";
		if (!is_null($cid))
			$risultato["msg"] = "errore nella connessione al db " . $cid->connect_error;
		else
			$risultato["msg"] = "errore nella connessione al db ";
		return $risultato;
	}

	$sql = "UPDATE amicizia SET dataAccettazione=CURRENT_TIMESTAMP WHERE Mittente='$amico' AND Destinatario='$login'";

	$res = $cid->query($sql);

	if ($res == null) {
		$risultato["msg"] = "Problema nella accettazione dell'amicizia nel database: $cid->errno: $cid->error()<br/>";
		$risultato["status"] = "ko";
	} else {
		$risultato["msg"] = "L'operazione di accettazione di un amico si &egrave; conclusa con successo";
		$risultato["status"] = "ok";
	}
	return $risultato;
}

function cancellaAmico($cid, $login, $amico)
{
	$risultato = array("status" => "ok", "msg" => "", "contenuto" => "");

	if ($cid == null || $cid->connect_errno) {
		$risultato["status"] = "ko";
		if (!is_null($cid))
			$risultato["msg"] = "errore nella connessione al db " . $cid->connect_error;
		else
			$risultato["msg"] = "errore nella connessione al db ";
		return $risultato;
	}

	$sql = "DELETE FROM amicizia WHERE (Mittente = '$amico' AND Destinatario = '$login') OR (Mittente = '$login' AND Destinatario = '$amico')";

	$res = $cid->query($sql);

	if ($res == null) {
		$risultato["msg"] = "Problema nella cancellazione di un amico nel database: $cid->errno: $cid->error()<br/>";
		$risultato["status"] = "ko";
	} else if ($res) {
		$risultato["msg"] = "L'operazione di cancellazione di un amico si &egrave; conclusa con successo";
		$risultato["status"] = "ok";
	}
	return $risultato;
}

function stampaRichieste($amici_richiesti)
{
	echo "<div class=\"table-responsive\">
		  <table class=\"table text-center\">
		  <tr><th class=\"text-center\">Amico</th>
			  <th class=\"text-center\">Accetta</th>
			  <th class=\"text-center\">Rifiuta</th>
			  </tr>";
	foreach ($amici_richiesti as $richiesta) {
		echo "<tr><td>$richiesta</td>
		<form method='POST' action='../backend/acceptFriend.php'>
			<td><button type='submit' class=\"btn btn-success\" name = 'accetta' value='$richiesta'>Accetta</td>
		</form>
		<form method='POST' action='../backend/deleteFriend.php'>
			<td><button type='submit' class=\"btn btn-danger\" name = 'elimina' value='$richiesta'>Rifiuta</td>
		</form>";
	}
	echo "</table>";
	echo "</div>";
}

function findFriends($cid, $utente, $name, $cognome, $orientamento, $hobby, $citta, $provincia, $stato, $luogoDiNascita)
{
	$users = array();
	$login = $_SESSION["email"];
	$risultato = array("status" => "ok", "msg" => "", "contenuto" => "");

	if ($cid->connect_errno) {
		$risultato["status"] = "ko";
		$risultato["msg"] = "errore nella connessione al db " . $cid->connect_error;
		return $risultato;
	}
	$sql = "SELECT DISTINCT email from utente join possiede on utente.Email = possiede.HobbyUtente where (nome = '$name' or cognome = '$cognome' 
	or OrientamentoSessuale = '$orientamento' or LuogoDiNascita = '$luogoDiNascita' or NomeCitta = '$citta' or email ='$utente' or possiede.TipoHobby = '$hobby') and email != '$login' ";
	$res = $cid->query($sql);

	if ($res == null) {
		$msg = "Si sono verificati i seguenti errori:<br/>"
			. $res->error;
		$risultato["status"] = "ko";
		$risultato["msg"] = $msg;
	} elseif (($name == null) && ($cognome == null) && ($orientamento == "") && ($citta == "nessuna") && ($provincia == "nessuna") && ($luogoDiNascita == null) && ($utente == null) && ($hobby == null) && ($stato == "nessuna")) {

		$msg = "Poichè non sono stati inseriti dei parametri di ricerca vengono restituiti tutti gli utenti registrati";
		$risultato["status"] = "ok";
		$risultato["msg"] = $msg;
		$email = $_SESSION['email'];
		$sql = "SELECT DISTINCT email from utente WHERE email!='$email'";
		$res = $cid->query($sql);
		while ($row = $res->fetch_assoc()) {
			//html card image
			$users[] = array("Utente" => $row["email"]);
		}
		$risultato["contenuto"] = $users;
	} else { // L'interrogazione è andata a buon fine e posso leggere le tuple risultato		
		$msg = "Gli utenti registrati che corrispondo ai parametri di ricerca sono i seguenti:";
		$risultato["status"] = "ok";
		$risultato["msg"] = $msg;
		while ($row = $res->fetch_assoc()) {
			//html card image
			$users[] = array("Utente" => $row["email"]);
		}
		$risultato["contenuto"] = $users;
	}
	return $risultato;
}

function printSearch($users)
{
	echo "<div class=\"table-responsive\">";
	echo "<table class=\"table text-center\">";
	echo "<tr><th class=\"text-center\">User</th>
			  <th class=\"text-center\">Request</th>
			  </tr>";
	foreach ($users as $user) {
		$username = $user["Utente"];
		echo "<tr>
				<td>$username</td> 
				<td>
					<form action=\"../backend/add_friend-exe.php\" method=\"GET\">
						<input type=\"hidden\" name=\"nuovo_amico\" value=\"$username\">
						<button type=\"submit\" class=\"btn btn-primary\">
							Add Friend
						</button>
					</form>
				</td>
				</tr>";
	}
	echo "</table>";
	echo "</div>";
}

function richiediAmicizia($cid, $mittente, $destinatario, $dataAcc)
{
	$amici_richiesti = array();
	$risultato = array("status" => "ok", "msg" => "", "contenuto" => "");

	$ris = leggiAmici($cid, $mittente);
	$result = $ris["contenuto"];
	if (in_array($destinatario, $result)) {
		$risultato["status"] = "ko";
		$risultato["msg"] = " L'utente $destinatario è già presente nei tuoi amici c:";
		return $risultato;
	}

	if ($cid->connect_errno) {
		$risultato["status"] = "ko";
		$risultato["msg"] = "errore nella connessione al db " . $cid->connect_error;
		return $risultato;
	} else {
		$sql = "INSERT INTO amicizia (mittente, destinatario, dataAccettazione, dataRichiesta) VALUES ('$mittente','$destinatario', '$dataAcc', CURRENT_TIMESTAMP)";
		$res = $cid->query($sql);
		if ($res == null) {
			$msg = "Problema durante la richiesta di amicizia! L'utente non esiste<br/>"
				. $res->error;
			$risultato["status"] = "ko";
			$risultato["msg"] = $msg;
		} else { // L'interrogazione è andata a buon fine e posso leggere le tuple risultato
			$risultato["status"] = "ok";
			$risultato["msg"] = "La richiesta di amicizia è stata inviata con successo";
			array_push($amici_richiesti, $destinatario);
			$risultato["contenuto"] = $amici_richiesti;
		}
	}
	return $risultato;
}

/* funzioni relative alla gestione dei post */

function readMyPosts($cid)
{
	$post = array();
	$risultato = array("status" => "ok", "msg" => "", "contenuto" => "");

	if ($cid->connect_errno) {
		$risultato["status"] = "ko";
		$risultato["msg"] = "errore nella connessione al db " . $cid->connect_error;
		return $risultato;
	}

	$email = $_SESSION["email"];
	$sql = "SELECT m.*, s.Nome, s.Provincia FROM messaggio m LEFT JOIN scattata s ON m.UtenteMessaggio = s.EmailFoto AND m.Data = s.DataScatto where UtenteMessaggio = '$email' ORDER BY m.Data DESC;";
	$res = $cid->query($sql);

	if ($res == null) {
		$msg = "Si sono verificati i seguenti errori:<br/>"
			. $res->error;
		$risultato["status"] = "ko";
		$risultato["msg"] = $msg;
	} elseif ($res->num_rows == 0) {
		$msg = "La tabella non contiene tuple";
		$risultato["status"] = "ko";
		$risultato["msg"] = $msg;
	} else { // L'interrogazione è andata a buon fine e posso leggere le tuple risultato		
		?>
		<!-- Messages Section-->
		<section class="py-5">
			<div class="container px-5 mb-5">
				<div class="text-center mb-5">
					<h1 class="display-5 fw-bolder mb-0"><span class="text-gradient d-inline">Messaggi</span></h1>
				</div>

				<div class="row gx-5 justify-content-center">
					<div class="col-lg-11 col-xl-9 col-xxl-8">
						<?php
						while ($row = $res->fetch_assoc()) {
							$post[] = array(
								"UtenteMessaggio" => $row["UtenteMessaggio"],
								"Data" => $row["Data"],
								"Tipo" => $row["Tipo"],
								"Descrizione" => $row["Descrizione"],
								"Contenuto" => $row["Contenuto"],
								"Posizione" => $row["Posizione"],
								"ID" => $row["ID"],
								"Nome" => $row["Nome"],
								"Provincia" => $row["Provincia"],
							);
							?>
							<!-- Messages -->
							<div class="card overflow-hidden shadow rounded-4 border-0 mb-5">
								<div class="card-body p-0">
									<div class="d-flex align-items-center">
										<div class="p-5">
											<div style="display: flex; justify-content: space-between;">
												<h2 class="fw-bolder">
													<?php echo $row['UtenteMessaggio']; ?>
												</h2>
												<h5 class="fw">
													<?php echo $row['Data']; ?>
												</h5>
												<h5 class="fw">
													<?php echo $row['Provincia'];
													echo " " . $row['Nome']; ?>
												</h5>
											</div>
											<?php if ($row['Tipo'] == 'testo') {
												echo "<h4>" . $row['Contenuto'] . "</h4>";
											} else if ($row['Tipo'] == 'foto') {
												echo "<img class=\"img-fluid\" src='" . $row['Posizione'] . "' alt='" . $row['Descrizione'] . "'>";
												echo "<h4>" . $row['Descrizione'] . "</h4>";
											}
											?>
											</p>
											<form method='POST' action='../backend/deletePost.php'>
												<button type='submit' class="btn btn-danger" name='elimina' value='<?php echo $row["ID"]; ?>'>Delete</button>
											</form>
										</div>
									</div>
								</div>
							</div>
							<?php
						}
	}
	?>
	</section>
	<?php
	$risultato["contenuto"] = $post;
	return $risultato;
}

function readMessages($cid, $amici)
{
	$sql = "SELECT m.*, s.Nome, s.Provincia FROM messaggio m LEFT JOIN scattata s ON m.UtenteMessaggio = s.EmailFoto AND m.Data = s.DataScatto ORDER BY m.Data DESC;";
	$res = $cid->query($sql);
	$post = array();

	if ($res == null) {
		$msg = "Si sono verificati i seguenti errori:<br/>" . $res->error;
		$risultato["status"] = "ko";
		$risultato["msg"] = $msg;
	} elseif ($res->num_rows == 0) {
		$msg = "La tabella non contiene tuple";
		$risultato["status"] = "ko";
		$risultato["msg"] = $msg;
	} else {
		while ($row = $res->fetch_assoc()) {
			if (in_array($row["UtenteMessaggio"], $amici["contenuto"])) {
				$post[] = array(
					"UtenteMessaggio" => $row["UtenteMessaggio"],
					"Data" => $row["Data"],
					"Tipo" => $row["Tipo"],
					"Descrizione" => $row["Descrizione"],
					"Contenuto" => $row["Contenuto"],
					"Posizione" => $row["Posizione"],
					"ID" => $row["ID"],
					"Nome" => $row["Nome"],
					"Provincia" => $row["Provincia"]
				);
			}
		}
		return $post;
	}
	return $risultato;
}


function createPost($cid, $login, $tipo, $descrizione, $contenuto)
{
	$risultato = array("status" => "ok", "msg" => "", "contenuto" => "");

	if ($cid->connect_errno) {
		$risultato["status"] = "ko";
		$risultato["msg"] = "errore nella connessione al db " . $cid->connect_error;
		return $risultato;
	}

	$nomeutente = (!empty($login)) ? explode('@', $login)[0] : NULL;
	$contenuto = (!empty($contenuto)) ? $contenuto : NULL;
	$descrizione = (!empty($descrizione)) ? $descrizione : NULL;

	// Create a folder for each user if it doesn't exist
	$userFolder = "../images/images_" . $nomeutente;
	if (!file_exists($userFolder)) {
		mkdir($userFolder, 0777, true);
	}
	$posizione = $userFolder;

	// Ottenere il timestamp corrente
	$timestamp = time(); // oppure $timestamp = strtotime("now");

	// Formattare il timestamp
	$formattedDate = date("Y-m-d H:i:s", $timestamp);

	$values = array(
		'UtenteMessaggio' => $login,
		'Data' => $formattedDate,
		'Tipo' => $tipo,
		'Posizione' => $posizione,
		'Contenuto' => $contenuto,
		'Descrizione' => $descrizione,
		'NomeFile' => NULL // lasciare il NomeFile come NULL inizialmente
	);

	// Rimuovi i valori nulli dall'array
	$values = array_filter($values, function ($value) {
		return !is_null($value);
	});
	// Crea la parte di query con i nomi delle colonne
	$columns = implode(', ', array_keys($values));

	// Crea la parte di query con i valori
	$escapedValues = array_map(function ($value) use ($cid) {
		return $cid->real_escape_string($value);
	}, array_values($values));
	$valuesString = "'" . implode("', '", $escapedValues) . "'";
	// Esegui l'inserimento

	$sql2 = "SELECT LivelloDiRispettabilita FROM Utente WHERE Email = '$login'";

	$res2 = $cid->query($sql2);

	if ($res2 == null) {
		$msg = "Si sono verificati i seguenti errori:<br/>" . $cid->error;
		$risultato["status"] = "ko";
		$risultato["msg"] = $msg;
	} else {
		$row2 = $res2->fetch_assoc();
	}

	if ($row2["LivelloDiRispettabilita"] > -1) {

		$sql = "INSERT INTO Messaggio ($columns) VALUES ($valuesString)";
		$res = $cid->query($sql);

		if ($res == null) {
			$msg = "Si sono verificati i seguenti errori:<br/>" . $cid->error;
			$risultato["status"] = "ko";
			$risultato["msg"] = $msg;
		} else {
			// Ottieni l'ultimo ID inserito
			$lastInsertedID = $cid->insert_id;
			// Aggiorna il NomeFile con l'ID
			$nomefile = $nomeutente . $lastInsertedID . ".jpeg";
			$posizione = $posizione . "/" . $nomefile;

			if (move_uploaded_file($_FILES["Immagine"]["tmp_name"], $posizione)) {
				echo "Immagine caricata con successo.";
			} else {
				echo "Errore durante il caricamento dell'immagine.";
			}

			// Aggiorna il record nel database con il nuovo NomeFile
			$updateSql = "UPDATE Messaggio SET NomeFile = '$nomefile' WHERE ID = $lastInsertedID";
			$updateRes = $cid->query($updateSql);
			$updateSql2 = "UPDATE Messaggio SET Posizione = '$posizione' WHERE ID = $lastInsertedID";
			$updateRes2 = $cid->query($updateSql2);

			if (!$updateRes || !$updateRes2) {
				// Gestisci eventuali errori nell'aggiornamento
				$risultato["status"] = "ko";
				$risultato["msg"] = "Errore nell'aggiornamento del NomeFile: " . $cid->error;
			} else {
				$msg = "L'operazione è andata a buon fine<br/>";
				$risultato["status"] = "ok";
				$risultato["msg"] = $msg;
			}
		}
	} else {
		$risultato["status"] = "ko";
		$risultato["msg"] = "Non puoi creare un nuovo post poiché il tuo livello di rispettabilità è inferiore a -1" . $cid->error;
	}
	return $risultato;
}

function leggiCommenti($cid, $IDamico)
{
	$commenti = array();
	$popup = array();
	$risultato = array("status" => "ok", "msg" => "", "commenti" => "");

	if ($cid == null || $cid->connect_errno) {
		$risultato["status"] = "ko";
		if (!is_null($cid))
			$risultato["msg"] = "errore nella connessione al db " . $cid->connect_error;
		else
			$risultato["msg"] = "errore nella connessione al db ";
		return $risultato;
	}

	if ($cid->connect_errno) {
		$risultato["status"] = "ko";
		$risultato["msg"] = "errore nella connessione al db " . $cid->connect_error;
		return $risultato;
	}
	$sql = "SELECT UtenteMessaggio, Data FROM Messaggio WHERE ID = '$IDamico'";
	$res = $cid->query($sql);
	$row = $res->fetch_assoc();

	$sql2 = "SELECT UtenteCommento, Data, Testo, id, popup, datapopup FROM commento WHERE EmailMessaggio='{$row['UtenteMessaggio']}' AND DataMessaggio='{$row['Data']}';";

	$res2 = $cid->query($sql2);
	if ($res2 == null) {
		$risultato["status"] = "ko";
		$risultato["msg"] = "errore nella esecuzione della interrogazione " . $cid->error;
		return $risultato;
	}
	while ($row2 = $res2->fetch_assoc()) {
		$commenti[] = array(
			'Amico' => $row2['UtenteCommento'],
			'Testo' => $row2['Testo'],
			'Data' => $row2['Data'],
			'id_comment' => $row2['id'],
			'popup' => $row2['popup'],
			'datapopup' => $row2['datapopup']
		);
	}
	$risultato["commenti"] = $commenti;
	return $risultato;
}

function stampaCommenti($cid, $commenti, $id)
{
    echo "<div class=\"table-responsive\">
			<table class=\"table text-center\" id=\"comment-list-container-$id\">
                  <tr>
                      <th class=\"text-center\">Amico</th>
                      <th class=\"text-center\">Testo</th>
                      <th class=\"text-center\">Data</th>
                      <th class=\"text-center\">PopUp</th>
                      <th class=\"text-center\">Vota</th>
                      <th class=\"text-center\">Elimina</th>
                  </tr>";
    
    foreach ($commenti as $commento) {
        $utente = $commento["Amico"];
        echo "<tr>
                  <td>{$commento['Amico']}</td>
                  <td>{$commento['Testo']}</td>
                  <td>{$commento['Data']}</td>
                  <td>{$commento['popup']} {$commento['datapopup']}</td>";
                
				  if ($utente != $_SESSION["email"]) {
					echo "<td>
                      <div id=\"comment\">
                          <button type=\"button\" class=\"btn btn-primary\" id='add_vote' data-toggle=\"modal\" data-target=\"#exampleModal\" onclick=\"openModal({$commento['id_comment']}, $id)\">
                              Vota il commento
                          </button>
                      </div>
                  </td>";
				  } else {
					echo "<td></td>";
				 }
                  
				if ($utente == $_SESSION["email"]) {
					echo "<td>
							<div id=\"comment\">
								<form method='POST' action='../backend/deleteComment.php'>
									<button type='submit' class=\"btn btn-danger\" name='elimina' id='delete_comment' value='{$commento['id_comment']}'>Elimina</button>
								</form>
							</div>
						</td>";
				} else {
					echo "<td></td>";
				}
			echo "</tr>";
		}

    echo "</table>";
    echo "</div>";
}

function cancellaCommento($cid, $login, $idcommento)
{
	$risultato = array("status" => "ok", "msg" => "", "contenuto" => "");

	if ($cid == null || $cid->connect_errno) {
		$risultato["status"] = "ko";
		if (!is_null($cid))
			$risultato["msg"] = "errore nella connessione al db " . $cid->connect_error;
		else
			$risultato["msg"] = "errore nella connessione al db ";
		return $risultato;
	}

	$sql = "DELETE FROM commento WHERE (UtenteCommento = '$login' AND ID = '$idcommento')";

	$res = $cid->query($sql);

	if ($res == null) {
		$risultato["msg"] = "Problema nella cancellazione di un commento nel database: $cid->errno: $cid->error()<br/>";
		$risultato["status"] = "ko";
	} else if ($res) {
		$risultato["msg"] = "L'operazione di cancellazione del commento si &egrave; conclusa con successo";
		$risultato["status"] = "ok";
	}
	return $risultato;
}

function cancellaMessaggio($cid, $login, $idmessaggio)
{
	$risultato = array("status" => "ok", "msg" => "", "contenuto" => "");

	if ($cid == null || $cid->connect_errno) {
		$risultato["status"] = "ko";
		if (!is_null($cid))
			$risultato["msg"] = "errore nella connessione al db " . $cid->connect_error;
		else
			$risultato["msg"] = "errore nella connessione al db ";
		return $risultato;
	}

	$sql = "DELETE FROM messaggio WHERE ID = '$idmessaggio'";

	$res = $cid->query($sql);

	if ($res == null) {
		$risultato["msg"] = "Problema nella cancellazione di un post nel database: $cid->errno: $cid->error()<br/>";
		$risultato["status"] = "ko";
	} else if ($res) {
		$risultato["msg"] = "L'operazione di cancellazione del post si &egrave; conclusa con successo";
		$risultato["status"] = "ok";
	}
	return $risultato;
}

?>