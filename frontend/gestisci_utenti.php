<?php 
session_start();
if (!isset($_SESSION["tipo"])) {
    $risultato = array("status" => "ko", "msg" => "");
    $risultato["status"] = "ko";
    $risultato["msg"] = "Devi prima eseguire l'accesso!";
    header("location:../index.php?status=ko&msg=". urlencode($risultato["msg"]));
    return $risultato;
} else {
	$nome = "gestisci";
}
?>

<!DOCTYPE html>
<html lang="en">
	<?php  require "../common/header.php";?>

    <body class="d-flex flex-column h-100">
        <main class="flex-shrink-0">
			<!-- Navigation-->
			<?php  require "../common/navbar.php";

				if (isset($_GET["status"]))
					{
						if ($_GET["status"] == "ko")
						{
							echo "<div class='alert alert-warning'>\n";
							echo $_GET["msg"];
							echo "</div>";
						} else {
                            echo "<div class='alert alert-success'>\n";
							echo $_GET["msg"];
							echo "</div>";
                        }
					}

				include_once "../common/connection.php";
				include_once "../common/funzioni.php";

				$ris=leggiUtenti($cid);
				if ($ris["status"]=='ko')	
					header('location: ../gestisci_utenti.php?status=ko&msg='. urlencode($ris["msg"]));
				// Leggi il contenuto del file JSON
				$configFile = '../json/config.json';
				$configData = file_get_contents($configFile);

				// Decodifica il contenuto JSON in un array associativo
				$configArray = json_decode($configData, true);

				// Recupera la data dell'ultima esecuzione
				$ultimaEsecuzione = $configArray['ultima_esecuzione'];
				stampaUtenti($cid, $ris['contenuto'], $ultimaEsecuzione);

				?>
		</main>

		<!-- Footer-->
		<?php  require "../common/footer.php";?>
	</body>
</html>

