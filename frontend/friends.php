<!-- vedo i miei amici e le richieste di amicizia-->
<?php
session_start();
if (!isset($_SESSION["tipo"])) {
    $risultato = array("status" => "ko", "msg" => "");
    $risultato["status"] = "ko";
    $risultato["msg"] = "Devi prima eseguire l'accesso!";
    header("location:../index.php?status=ko&msg=". urlencode($risultato["msg"]));
    return $risultato;
} else if ($_SESSION["tipo"] == "amministratore") {
	$nome = "friends_admin";
} else {
	$nome = "friends";
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

				$utente = $_SESSION["email"];
				$ris=leggiAmici($cid, $utente);
				if ($ris["status"]=='ko' && $_SESSION["tipo"]=='amministratore')	
					header('location: ../homepage_admin.php?status=ko&msg='. urlencode($ris["msg"]));
				else if ($ris["status"]=='ko' && $_SESSION["tipo"]=='registrato')
				{
					header('location: ../homepage.php?status=ko&msg='. urlencode($ris["msg"]));
				}
				stampaAmici($ris["contenuto"]);

				$ris=leggiRichieste($cid, $utente);
				echo '<p></p>'; 
				if ($ris["status"]=='ko' && $_SESSION["tipo"]=='amministratore')	
					header('location: ../homepage_admin.php?status=ko&msg='. urlencode($ris["msg"]));
				else if ($ris["status"]=='ko' && $_SESSION["tipo"]=='registrato') {
					header('location: ../homepage.php?status=ko&msg='. urlencode($ris["msg"]));
				}
				stampaRichieste($ris["contenuto"]);
				?>
		</main>

		<!-- Footer-->
		<?php  require "../common/footer.php";?>
	</body>
</html>