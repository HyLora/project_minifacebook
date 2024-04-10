<?php
session_start();
if (!isset($_SESSION["tipo"])) {
    $risultato = array("status" => "ko", "msg" => "");
    $risultato["status"] = "ko";
    $risultato["msg"] = "Devi prima eseguire l'accesso!";
    header("location:../index.php?status=ko&msg=". urlencode($risultato["msg"]));
    return $risultato;
} else if ($_SESSION["tipo"] == "amministratore") {
	$nome = "find_admin";
} else {
	$nome = "find";
}
?>
<!DOCTYPE html>
<html lang="en">
<?php  require "../common/header.php";?>

<head>
    <script src="../js/myScript.js"></script>
</head>

    <body class="d-flex flex-column">
        <main class="flex-shrink-0">
            <!-- Navigation-->
            <?php require "../common/navbar.php";
                    
                    if (isset($_GET["status"])) {
                        if ($_GET["status"] == "ko") {
                            echo "<div class='alert alert-warning'>\n";
                            echo $_GET["msg"];
                            echo "</div>";
                        }
                    }
                    
                    include_once "../common/connection.php";
                    include_once "../common/funzioni.php";
            ?>

            <!-- Page content-->
            <section class="py-5">
                <div class="container px-5">

                    <!-- Contact form-->
                    <div class="bg-light rounded-4 py-5 px-4 px-md-5">
                        <div class="text-center mb-7">
                            <div class="feature bg-primary bg-gradient-primary-to-secondary text-white rounded-3 mb-3"><i class="bi bi-person-circle"></i></div>
                            <h1 class="fw-bolder">Find your friends!</h1>
                            <p class="lead fw-normal text-muted mb-0">Puoi effettuare una ricerca inserendo nessuno o tanti parametri a tua scelta tra quelli proposti!</p> <!--Search by-->
                        </div>
                        <div class="row gx-5 justify-content-center">
                            <div class="col-lg-8 col-xl-5">
                                <!-- to get an API token!-->
                                <form id="form" method="POST" action="../backend/find_friends-exe.php">
                                    <tr>
                                        <td>Email:<div class="form mb-3"><input class="form-control" id="email" type = "text" name = "email" placeholder = "nome@esempio.com" value=""></td>
                                    </tr>
                                    <p>    </p>
                                    <!-- Name input-->
                                    <tr>
                                        <td>Nome: <div class="form mb-3"><input class="form-control" id="nome" type = "text" name = "nome" placeholder = "Marco" value=""></td>
                                    </tr>
                                    <p>    </p>
                                    <!-- Surname input-->
                                    <tr>
                                        <td>Cognome: <div class="form mb-3"><input class="form-control" id="cognome" type = "text" name = "cognome" placeholder = "Rossi" value=""></td>
                                    </tr>
                                    <p>    </p>
                                    <!-- Birth place input-->
                                    <tr>
                                        <td>Luogo di Nascita:  <div class="form mb-3"><input class="form-control" id="luogoNascita" type = "text" name = "luogoNascita" placeholder = "Milano" value=""></td>
                                    </tr>
                                    <p>    </p>
                                    <!-- Birth place input-->
                                    <!-- City input-->
                                <div class="row">

                                    <div class="form-group row">
                                        <div>Per favore, immetti sia Stato, che Provincia, che Città (facoltativo)</div>
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
                                            <select class="form-control" id="citt"  name="Citta">
                                                <option value="nessuna" selected></option>
                                            </select>
                                        </div>
                                    </div>
                                    </div>
                                    <p>    </p>
                                    <!-- Sexual orientation input-->
                                    <tr>
                                        <td>Orientamento sessuale: <div class="form mb-3">
                                            <input type="radio" name="sex" value="etero"
                                            
                                            >Etero</input><br/>
                                            <input type="radio" name="sex" value="gay"
                                            
                                            >Gay</input><br/>
                                            <input type="radio" name="sex" value="binary"
                                            
                                            >Binary</input><br/>
                                            <input type="radio" name="sex" value="trans"
                                            
                                            >Trans</input><br/>
                                            <input type="radio" name="sex" value="" <?php echo "checked"; ?>>Nessuna selezione</input><br/>
                                        </td>
                                    </tr>
                                    <p>    </p>
                                    <!-- Hobby input-->
                                    <tr>
                                        <td>Hobby: <div class="form mb-3">
                                    
                                            <input type="radio" name="hobby" value="Mangiare"
                                            
                                            >Mangiare</input><br/>
                                            <input type="radio" name="hobby" value="Ascoltare Musica"
                                            
                                            >Ascoltare Musica</input><br/>
                                            <input type="radio" name="hobby" value="Cucinare"
                                            
                                            >Cucinare</input><br/>
                                            <input type="radio" name="hobby" value="Danza"
                                            
                                            >Danza</input><br/>
                                            <input type="radio" name="hobby" value="Guardare Serie Tv"
                                            
                                            >Guardare Serie Tv</input><br/>
                                            <input type="radio" name="hobby" value="Giardinaggio"
                                            
                                            >Giardinaggio</input><br/>
                                            <input type="radio" name="hobby" value="Sport"
                                            
                                            >Sport</input><br/>
                                            <input type="radio" name="hobby" value="" <?php echo "checked"; ?>>Nessuna selezione</input><br/>
                                            
                                        </td>
                                    </tr>
                           
                                    <tr>
                                    <td colspan="2" align="center"></tr>
                                    <p>    </p>
                                    <div class="d-grid"><button class="btn btn-primary btn-lg" id="submitButton" type="submit">Search</button></div>
                                    <p>    </p>
                                    <div class="d-grid"><button class="btn btn-primary btn-lg" id="submitButton" type="reset">Cancella</button></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <form   name="inserimento" action="../backend/find_friends-exe.php" method="POST"></form>
        </main>
         <!-- Footer-->
         <?php require "../common/footer.php";?>
         
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="../js/myScript.js"></script>        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <!-- * *                               SB Forms JS                               * *-->
        <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="../js/legaEventi.js"></script>
    </body>
</html>