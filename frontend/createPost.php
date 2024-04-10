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
<head>
    <script src="../js/myScript.js"></script>
</head>
<head>
    <script src="../js/createPost.js"></script>
</head>

<body class="d-flex flex-column">
    <main class="flex-shrink-0">
        <!-- Navigation-->
        <?php require "../common/navbar.php"; ?>
        <!-- Page content-->
        <section class="py-5">
            <div class="container px-5">

                <?php if (isset($_GET["status"])) {
                    if ($_GET["status"] == "ko") {
                        echo "<div class='alert alert-warning'>\n";
                        echo $_GET["msg"];
                        echo "</div>";
                    } else {
                        echo "<div class='alert alert-success'>\n";
                        echo $_GET["msg"];
                        echo "</div>";
                    }
                }
                ?>

                <!-- Contact form-->
                <div class="bg-light rounded-4 py-5 px-4 px-md-5">
                    <div class="text-center mb-7">
                        <div class="feature bg-primary bg-gradient-primary-to-secondary text-white rounded-3 mb-3"><i
                                class="bi bi-person-circle"></i></div>
                        <h1 class="fw-bolder">Crea il tuo post</h1>
                        <p class="lead fw-normal text-muted mb-0">Lascia che i tuoi amici ti conoscano di più!</p>
                    </div>
                    <div class="row gx-5 justify-content-center">
                        <div class="col-lg-8 col-xl-5">
                            <!-- * * * * * * * * * * * * * * *-->
                            <!-- * * SB Forms Contact Form * *-->
                            <!-- * * * * * * * * * * * * * * *-->
                            <!-- This form is pre-integrated with SB Forms.-->
                            <!-- To make this form functional, sign up at-->
                            <!-- https://startbootstrap.com/solution/contact-forms-->
                            <!-- to get an API token!-->
                            <form id="form" data-sb-form-api-token="API_TOKEN" method="POST"
                                action="../backend/createPost-exe.php" enctype="multipart/form-data">
                                <!-- Email address input-->
                                <label for="Tipo">Seleziona il tipo di post:</label>
                                <select class="form-control" id="Tipo" name="Tipo" onchange="toggleFields()">
                                    <option value="">Nessuna selezione</option>
                                    <option value="foto">Foto</option>
                                    <option value="testo">Testo</option>
                                </select>
                                <div id="Descrizione" style="display:none;">
                                    <label for="Descrizione">Descrizione (non più di 50 caratteri!):</label>
                                    <textarea class="form-control" name="Descrizione" id="Descrizione"></textarea>
                                </div>

                                <div id="Contenuto" style="display:none;">
                                    <label for="Contenuto">Contenuto (non più di 100 caratteri!):</label>
                                    <textarea class="form-control" name="Contenuto" id="Contenuto"></textarea>
                                </div>
                                
                                <!-- City input-->
                                <div class="row" id= "Geo" style="display:none;">

                                    <div class="form-group row">
                                        <div><label for="inputStato" class="col-md-1 col-form-label">Stato:</label>
                                        </div>
                                        <div class="col-md-4">
                                            <select class="form-control" id="stato" name="Stato">
                                                <option value="nessuna" selected></option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="inputProvincia"
                                                class="col-md-1 col-form-label">Provincia:</label>
                                        </div>
                                        <div class="col-md-4">
                                            <select class="form-control" id="prov" name="Provincia">
                                                <option value="nessuna" selected></option>
                                            </select>
                                        </div>
                                        <div><label for="inputCitta" class="col-md-1 col-form-label">Citta:</label>
                                        </div>
                                        <div class="col-md-4">
                                            <select class="form-control" id="citt" name="Citta">
                                                <option value="nessuna" selected></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div id="Nessuna" style="display:none;">
                                </div>

                                <div id="Immagine" style="display:none;">
                                    <label for="Immagine">Immagine:</label>
                                    <input type="file" name="Immagine" id="Immagine"> <!--bottone "Scegli File-->
                                </div>


                                <tr>
                                    <td colspan="2" align="center">
                                </tr>
                                <p> </p>
                                <!--Submit Button-->
                                <div class="d-grid"><button class="btn btn-primary btn-lg" id="submitButton"
                                        type="submit">Crea post</button></div>
                                <p> </p>
                                <div class="d-grid"><button class="btn btn-primary btn-lg" id="cancelButton"
                                        type="reset">Cancella</button></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- Footer-->
    <?php require "../common/footer.php";
    ?>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <!-- * *                               SB Forms JS                               * *-->
    <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="../js/legaEventi.js"></script>
</body>

</html>