<?php
$nome = "joinus";
?>

<!DOCTYPE html>
<html lang="en">
<?php require "../common/header.php"; ?>

<head>
    <script src="../js/myScript.js"></script>
</head>

<body class="d-flex flex-column">
    <main class="flex-shrink-0">
        <!-- Navigation-->
        <?php require "../common/navbar.php";
        ?>
        <!-- Page content-->
        <section class="py-5">
            <div class="container px-5">

                <?php if (isset($_GET["status"])) {
                    if ($_GET["status"] == "ko") {
                        echo "<div class='alert alert-warning'>\n";
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
                        <h1 class="fw-bolder">Unisciti a noi</h1>
                        <p class="lead fw-normal text-muted mb-0">Crea il tuo account!</p>
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
                                action="../backend/joinus-exe.php">
                                <!-- Email address input-->
                                <tr>
                                    <td>Email:<div class="form mb-3"><input class="form-control" id="text" type="text"
                                                name="Email" placeholder="nome@esempio.com"
                                                data-sb-validations="required" value=""></td>
                                </tr>
                                <p> </p>
                                <!-- Password input-->
                                <tr>
                                    <td>Password: <div class="form mb-3"><input class="form-control" id="password"
                                                type="password" name="Password"
                                                placeholder="Inserisci la tua password..."
                                                data-sb-validations="required" value=""></td>
                                </tr>
                                <p> </p>
                                <!-- Name input-->
                                <tr>
                                    <td>Nome: <div class="form mb-3"><input class="form-control" id="nome" type="text"
                                                name="Nome" placeholder="Marco" data-sb-validations="nome" value="">
                                    </td>
                                </tr>
                                <p> </p>
                                <!-- Surname input-->
                                <tr>
                                    <td>Cognome: <div class="form mb-3"><input class="form-control" id="cognome"
                                                type="text" name="Cognome" placeholder="Rossi"
                                                data-sb-validations="cognome" value=""></td>
                                </tr>
                                <p> </p>
                                <!-- Phone number input-->
                                <tr>
                                    <td>Cellulare: <div class="form mb-3"><input class="form-control" id="phone"
                                                type="tel" name="Cellulare" placeholder="(+39) 123-456-7890"
                                                data-sb-validations="phone" value="" /></td>
                                </tr>
                                <p> </p>
                                <!-- Birthday input-->
                                <tr>
                                    <td>Compleanno: <div class="form mb-3">
                                            <input type="date" class="form-control" placeholder="28/07/89"
                                                name="Compleanno" id='bday' value="">
                                    </td>
                                </tr>
                                <p> </p>
                                <!-- Birth place input-->
                                <tr>
                                    <td>Luogo di Nascita: <div class="form mb-3"><input class="form-control"
                                                id="LuogoDiNascita" type="text" name="LuogoDiNascita"
                                                placeholder="Milano" data-sb-validations="luogonascita" value=""></td>
                                </tr>
                                <p> </p>
                                <!-- City input-->
                                <div class="row">

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

                        </div>

                        <!-- Sexual orientation input-->
                        <tr>
                            <td>Orientamento sessuale: <div class="form mb-3" id='os'>
                                    <input type="radio" name="OrientamentoSessuale" value="etero">Etero</input><br />
                                    <input type="radio" name="OrientamentoSessuale" value="gay">Gay</input><br />
                                    <input type="radio" name="OrientamentoSessuale" value="binary">Binary</input><br />
                                    <input type="radio" name="OrientamentoSessuale" value="trans">Trans</input><br />
                            </td>
                        </tr>
                        <p> </p>
                        <!-- Hobby input-->
                        <tr>
                            <td>Hobby: <div class="form mb-3" id='hobby'>

                                    <input type="checkbox" name="hobby[]" value="Mangiare">Mangiare</input><br />
                                    <input type="checkbox" name="hobby[]" value="Ascoltare Musica">Ascoltare
                                    Musica</input><br />
                                    <input type="checkbox" name="hobby[]" value="Cucinare">Cucinare</input><br />
                                    <input type="checkbox" name="hobby[]" value="Danza">Danza</input><br />
                                    <input type="checkbox" name="hobby[]" value="Guardare Serie Tv">Guardare Serie
                                    Tv</input><br />
                                    <input type="checkbox" name="hobby[]"
                                        value="Giardinaggio">Giardinaggio</input><br />
                                    <input type="checkbox" name="hobby[]" value="Sport">Sport</input><br />

                            </td>
                        </tr>
                        <p> </p>
                        <!-- Condizioni di utilizzo input-->
                        <tr>
                            <td>Condizioni di utilizzo:</td>
                            <table>
                                <tr>
                                    <td>bla bla bla bla bla bla bla bla bla bla bla bla
                                        bla bla bla bla bla bla bla bla bla bla bla bla
                                        bla bla bla bla bla bla bla bla bla bla bla bla </td>
                                </tr>
                            </table>
                            <input type="checkbox" name="condizioni" value="ok" id="condizioni">Accetto</input><br />
                        </tr>

                        <tr>
                            <td colspan="2" align="center">
                        </tr>
                        <p> </p>
                        <script>
                            function create_account() {
                                let utente = document.getElementById("text").value;
                                let password = document.getElementById("password").value;
                                let nome = document.getElementById("nome").value;
                                let cognome = document.getElementById("cognome").value;
                                let phone = document.getElementById("phone").value;
                                let bday = document.getElementById("bday").value;
                                let LuogoDiNascita = document.getElementById("LuogoDiNascita").value;
                                let stato = document.getElementById("stato").value;
                                let prov = document.getElementById("prov").value;
                                let citt = document.getElementById("citt").value;
                                let os = document.getElementById("os").value;
                                //Array.from trasforma nodelist restituita da querySelectorAll in array JS
                                //map per mappare valore hobby selezionato
                                let hobbies = Array.from(document.querySelectorAll('input[name="hobby[]"]:checked')).map(hobby => hobby.value);
                                let hobbiesJSON = JSON.stringify(hobbies);
                                let condizioni = document.getElementById("condizioni").checked;

                                let xhr = new XMLHttpRequest();
                                let params = "Email=" + utente + "&Password=" + password + "&Nome=" + nome + "&Cognome=" + cognome + "&Cellulare="
                                    + phone + "&Compleanno=" + bday + "&LuogoDiNascita=" + LuogoDiNascita + "&Citta=" + citt + "&Provincia=" + prov + "&Stato=" + stato +
                                    "&OrientamentoSessuale=" + os + "&hobby=" + hobbiesJSON + "&condizioni=" + condizioni;

                                xhr.open('GET', '../backend/joinus-exe.php?' + params, true);
                                xhr.onreadystatechange = function () {
                                    if (xhr.readyState == 4 && xhr.status == 200) {
                                        let result = JSON.parse(xhr.responseText);
                                        if (result.status === 'ok') {
                                            window.location.href = 'loginmodificato.php?status=ok&success=1&msg=' + result.msg;
                                        } else {
                                            // Stampa il messaggio di errore
                                            document.getElementById("error-message").textContent = result.msg;
                                            document.getElementById("error-message").style.display = "block"; //problema style?
                                            document.getElementById("correct-message").style.display = "none";
                                        }
                                    }
                                };
                                xhr.send();
                            }
                        </script>
                        <!-- Submit Button-->
                        <div class="d-grid"><button class="btn btn-primary btn-lg" id="submitButton" type="button"
                                onclick="create_account()">Crea
                                account</button></div>
                        <p> </p>
                        <div class="d-grid"><button class="btn btn-primary btn-lg" id="cancelButton"
                                type="reset">Cancella</button></div>
                        <div id='error-message' class='alert alert-warning' style='display: none;'></div>
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
    <!-- Core theme JS-->
    <script src="../js/myScript.js"></script>
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