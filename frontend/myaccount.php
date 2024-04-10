<!-- vedo il mio account con i miei amici e i miei post -->
<?php
session_start();
if (!isset($_SESSION["tipo"])) {
    $risultato = array("status" => "ko", "msg" => "");
    $risultato["status"] = "ko";
    $risultato["msg"] = "Devi prima eseguire l'accesso!";
    header("location:../index.php?status=ko&msg=". urlencode($risultato["msg"]));
    return $risultato;
} else if ($_SESSION["tipo"] == "amministratore") {
    $nome = "messages_admin";
} else {
    $nome = "messages";
}
?>

<!DOCTYPE html>
<html lang="en">
	<?php  require "../common/header.php";?>
    
    <body class="d-flex flex-column h-100">
        <main class="flex-shrink-0">
			<!-- Navigation-->
			<?php  require "../common/navbar.php";

                include_once "../common/connection.php";
                include_once "../common/funzioni.php"; ?>
                <div class="profile-container">

                    <!-- Informazioni utente -->
                    <?php if (isset($_GET["status"]))
                        {
                            if ($_GET["status"] == "ok")
                            {
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
                    $res = readMyPosts($cid);
                    $post=$res["contenuto"];

                ?>
            <form   name="inserimento" action="../backend/homepage-exe.php" method="GET">
            </form>
		</main>
        
        <!-- Footer-->
		<?php  require "../common/footer.php";?>
	</body>
</html>

