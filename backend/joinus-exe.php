<?php
session_start();
include_once "../common/connection.php";
include_once "../common/funzioni.php";

if(isset($_GET["Email"], $_GET["Password"], $_GET["Nome"], $_GET["Cognome"], $_GET["OrientamentoSessuale"], $_GET["Citta"], $_GET["Provincia"], $_GET["Compleanno"], $_GET["LuogoDiNascita"], $_GET["Stato"], $_GET["hobby"], $_GET["condizioni"])) {
	$login = $_GET["Email"];
	$pwd = $_GET["Password"];
	$name = $_GET["Nome"];
	$cognome = $_GET["Cognome"];
	$cellulare = $_GET["Cellulare"];
	$orientamento = $_GET["OrientamentoSessuale"];
	$citta = $_GET["Citta"];
	$provincia = $_GET["Provincia"];
	$compleanno = $_GET["Compleanno"];
	$luogoDiNascita = $_GET["LuogoDiNascita"];
	$stato = $_GET["Stato"];
	$livelloDiRispettabilita = 5;
	$tipo = 'registrato';
	$hobby = json_decode($_GET["hobby"], true);
	$condizioni = $_GET["condizioni"];

	$risultato = array("status" => "ok", "msg" => "", "contenuto" => "");

	if ($cid == null || $cid->connect_errno) {
		$risultato["status"] = "ko";
		if (!is_null($cid))
			$risultato["msg"] = "errore nella connessione al db " . $cid->connect_error;
		else
			$risultato["msg"] = "errore nella connessione al db ";
		return $risultato;
	}

	$msg = "";
	$errore = false;

	$login = trim($login);
	$pwd = trim($pwd);
	if (empty($login) || empty($pwd)) {
		$errore = true;
		$msg = "Email e Password sono obbligatori, specificarli\n";
	}
	if (!empty($login) && (strlen($login) <= 3 || strpos($login, '@') == FALSE)) {
		$errore = true;
		$msg .= "La mail deve contenere almeno tre caratteri e la chiocciola\n";

	}
	if (!empty($pwd) && strlen($pwd) < 3) {
		$errore = true;
		$msg .= "La password deve contenere pi&ugrave di 2 caratteri\n";

	}
	if (!empty($name) && strlen($name) < 3) {
		$errore = true;
		$msg .= "Il nome deve contenere pi&ugrave di 2 caratteri\n";

	}
	if (!empty($cognome) && strlen($cognome) < 3) {
		$errore = true;
		$msg .= "Il cognome deve contenere pi&ugrave di 2 caratteri\n";

	}
	if ($condizioni == "false") {
		$errore = true;
		$msg .= "Le condizioni devono essere accettate\n";
	}

	$res = leggiUtenti($cid);

	if ($res["status"] == 'ko') {
		$errore = true;
		$msg .= "Problemi nella lettura dal database";

	} else {
		$nuovo_utente = $res["contenuto"];

		if (isset($nuovo_utente[$login])) {
			$errore = true;
			$msg .= "La email $login specificata è già usata\n";
		

		}
	}
	if (!$errore) {
		$name = (!empty($name)) ? $name : NULL;
		$cognome = (!empty($cognome)) ? $cognome : NULL;
		$compleanno = (!empty($compleanno)) ? $compleanno : NULL;
		$luogoDiNascita = (!empty($luogoDiNascita)) ? $luogoDiNascita : NULL;
		$cellulare = (!empty($cellulare)) ? $cellulare : NULL;
		$citta = (!empty($citta)) ? $citta : NULL;
		$provincia = (!empty($provincia)) ? $provincia : NULL;
		$stato = (!empty($stato)) ? $stato : NULL;

		$values = array(
			'Email' => $login,
			'Password' => $pwd,
			'Nome' => $name,
			'Cognome' => $cognome,
			'Compleanno' => $compleanno,
			'LuogoDiNascita' => $luogoDiNascita,
			'OrientamentoSessuale' => $orientamento,
			'Cellulare' => $cellulare,
			'NomeCitta' => $citta,
			'ProvinciaCitta' => $provincia,
			'livelloDiRispettabilita' => $livelloDiRispettabilita,
			'tipo' => $tipo,
			'Stato' => $stato
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

		// Crea la query completa
		$sql = "INSERT INTO utente ($columns) VALUES ($valuesString)";

		// Esegue la query
		$res = $cid->query($sql);

		if ($res == 1) {
			$risultato["msg"] = "L'operazione di creazione account si è conclusa con successo, procedi con l'accesso";
			$risultato["status"] = "ok";
			//exit();
		} else {
			$risultato["status"] = "ko";
			$risultato["msg"] = "L'operazione di creazione account è fallita, riprovare";
		}
		//echo "$hobby";
		//$hobby = json_decode($_GET["hobby"], true);

		foreach ($hobby as $hob) {
			$sql = "INSERT INTO possiede(HobbyUtente,TipoHobby) VALUES('$login', '$hob')";
			$res = $cid->query($sql);
			if ($res == 1) {
				$risultato["msg"] = "L'operazione di creazione account si è conclusa con successo, procedi con l'accesso";
				$risultato["status"] = "ok";
			} else {
				$risultato["status"] = "ko";
				$risultato["msg"] = "L'operazione di creazione account è fallita, riprovare";
			}
		}
	} else {
		$risultato["status"] = "ko";
		$risultato["msg"] = $msg;
	}
	echo json_encode($risultato);
} else {
	// Se non sono presenti tutti i parametri richiesti, restituisci un messaggio di errore
	echo json_encode(array("status" => "ko", "msg" => "Parametri mancanti"));
}