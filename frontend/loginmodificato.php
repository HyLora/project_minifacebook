<?php
session_start();
$nome = "login";
?>

<!DOCTYPE html>
<html lang="en">
<?php require "../common/header.php"; ?>
<link href="../css/styles.css" rel="stylesheet" />

<body class="d-flex flex-column">
    <main class="flex-shrink-0">
        <!-- Navigation-->
        <?php require "../common/navbar.php"; ?>

        <!-- Page content-->
        <section class="py-5">
            <div class="container px-5">

                <?php 
                    if (isset($_GET["status"])) {
                        if (isset($_GET["success"]) && $_GET["success"] == 1 && $_GET["status"] == "ok") {
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
            <div id="correct-message" class="correct-message" style="display: none;"></div>

                <!-- Contact form-->
                <div class="bg-light rounded-4 py-5 px-4 px-md-5">
                    <div class="text-center mb-7">
                        <div class="feature bg-primary bg-gradient-primary-to-secondary text-white rounded-3 mb-3"><i
                                class="bi bi-balloon-heart"></i></div>
                        <h1 class="fw-bolder">Accedi</h1>
                        <p class="lead fw-normal text-muted mb-0">Make friends!</p>
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

                            <form id="contactForm" data-sb-form-api-token="API_TOKEN" method="POST"
                                action="../backend/login-exe.php">
                                <!-- Email address input-->
                                <tr>
                                    <td>Email: <div class="form mb-3"><input class="form-control" id="email"
                                                type="email" name="email" placeholder="nome@esempio.com"
                                                data-sb-validations="required,email" value=""></td>
                                </tr>
                                <tr>
                                    <p> </p>
                                    <td>Password: <div class="form mb-3"><input class="form-control" id="password"
                                                type="password" name="password"
                                                placeholder="Inserisci la tua password..."
                                                data-sb-validations="required" value=""></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center">
                                </tr>
                                <p> </p>
                                <!-- Submit Button-->
                                <div class="d-grid"><button class="btn btn-primary btn-lg" id="submitButton"
                                        type="submit">Accedi</button></div>
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
    <?php require "../common/footer.php"; ?>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <!-- * *                               SB Forms JS                               * *-->
    <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>

</html>